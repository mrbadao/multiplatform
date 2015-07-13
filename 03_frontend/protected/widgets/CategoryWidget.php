<?php

class CategoryWidget extends CLinkPager {


    public function init() {

    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
       $this->render('global_Category_menu');
    }
}
