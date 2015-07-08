<?php

/**
 * Creates DB dump.
 *
 * Usage:
 * <pre>
 *      Yii::import('ext.yii-database-dumper.SDatabaseDumper');
 *      $dumper = new SDatabaseDumper;
 *      // Get path to backup file
 *      $file = Yii::getPathOfAlias('webroot.protected.backups').DIRECTORY_SEPARATOR.'dump_'.date('Y-m-d_H_i_s').'.sql';
 *
 *      // Gzip dump
 *      if(function_exists('gzencode'))
 *          file_put_contents($file.'.gz', gzencode($dumper->getDump()));
 *      else
 *          file_put_contents($file, $dumper->getDump());
 * </pre>
 */
class SDatabaseDumper
{
    private $db;
    private $option;

    function __construct($db, $option)
    {
        $this->db = $db;
        $this->option = $option;
    }

    /**
     * Dump all tables
     * @return string sql structure and data
     */
    public function getDump()
    {
        $dbname  = explode('=', Yii::app()->db->connectionString);
        $dbname = $dbname[2];

        ob_start();
        echo 'SET FOREIGN_KEY_CHECKS = 0;' . PHP_EOL;
        echo 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'.PHP_EOL;
        echo 'SET time_zone = "+07:00";'.PHP_EOL;
        echo "
--
-- Database: `$dbname`
--".PHP_EOL;

        if(isset($this->option['drop_database']) && $this->option['drop_database']) {
            echo "DROP DATABASE `$dbname`;".PHP_EOL;
        }

        if(isset($this->option['create_database']) && $this->option['create_database']) {
            echo "CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;".PHP_EOL;
            echo "USE `$dbname`;".PHP_EOL;
        }

        foreach ($this->getTables() as $key => $val)
            $this->dumpTable($key);
        echo 'SET FOREIGN_KEY_CHECKS = 1;' . PHP_EOL;
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    /**
     * Create table dump
     * @param $tableName
     * @return mixed
     */
    public function dumpTable($tableName)
    {
        $pdo = $this->db->getPdoInstance();

        echo '
--
-- Structure for table `' . $tableName . '`
--
' . PHP_EOL;
        echo 'DROP TABLE IF EXISTS ' . $this->db->quoteTableName($tableName) . ';' . PHP_EOL;

        $q = $this->db->createCommand('SHOW CREATE TABLE ' . $this->db->quoteTableName($tableName) . ';')->queryRow();
        echo $q['Create Table'] . ';' . PHP_EOL . PHP_EOL;

        $rows = $this->db->createCommand('SELECT * FROM ' . $this->db->quoteTableName($tableName) . ';')->queryAll();

        if(isset($this->option['truncate_table']) && $this->option['truncate_table']) {
            echo "
--
-- Truncate table before insert `administrator`
--" . PHP_EOL;

            echo "TRUNCATE TABLE `$tableName`;" . PHP_EOL;
        }

        if (empty($rows))
            return;

        echo '
--
-- Data for table `' . $tableName . '`
--
' . PHP_EOL;

        $attrs = array_map(array($this->db, 'quoteColumnName'), array_keys($rows[0]));
        echo 'INSERT INTO ' . $this->db->quoteTableName($tableName) . '' . " (", implode(', ', $attrs), ') VALUES' . PHP_EOL;
        $i = 0;
        $rowsCount = count($rows);
        foreach ($rows AS $row) {
            // Process row
            foreach ($row AS $key => $value) {
                if ($value === null)
                    $row[$key] = 'NULL';
                else
                    $row[$key] = $pdo->quote($value);
            }

            echo " (", implode(', ', $row), ')';
            if ($i < $rowsCount - 1)
                echo ',';
            else
                echo ';';
            echo PHP_EOL;
            $i++;
        }
        echo PHP_EOL;
        echo PHP_EOL;
    }

    /**
     * Get mysql tables list
     * @return array
     */
    public function getTables()
    {
        return $this->db->getSchema()->getTables();
    }
}
