<?php
/**
 * Created by PhpStorm.
 * User: HieuNguyen
 * Date: 7/10/2015
 * Time: 12:57 PM
 */

class Helpers
{
    public static function checkAdministratorRules($adminId = null, $actionId){
        if(!$adminId || !$actionId) return false;
        return AdministratorModuleAccess::model()->findByAttributes(array(
            'administrator_id' => $adminId,
            'muodule_action_id' => $actionId
        )) ? true : false;
    }
}