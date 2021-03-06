<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => '1',
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if (Yii::app()->user->IsGuest) {
            $this->forward(
                $_SERVER['SERVER_NAME'] == Yii::app()->params['CMS_DOMAIN']
                ? 'site/adminlogin'
                : 'site/MemberLogin'
            );
        }
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionAdminLogin()
    {
        $model = new AdminLoginModel();
        $model->scenario = 'captchaRequired';

        if (!Yii::app()->user->IsGuest) $this->forward('site/index');

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->adminLogin())
                $this->redirect(Yii::app()->user->returnUrl);
        }

        // display the login form
        $this->layout = "login";
        $this->render('login', array('model' => $model));
    }

    public function actionMemberLogin()
    {
        $model = new MemberLoginModel();

        if (!Yii::app()->user->IsGuest) $this->forward('site/index');

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->memberLogin())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->layout = "login";
        $this->render('memberlogin', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}