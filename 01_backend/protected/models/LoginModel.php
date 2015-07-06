<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginModel extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
    public $verifyCode;

	private $_identity;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, verifyCode', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new AdminIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect password.');
		}
	}

	/**
	 * Logs in the admin user group using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function adminLogin()
	{
		if($this->_identity===null)
		{
			$this->_identity=new AdminIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}

		if($this->_identity->errorCode===AdminIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*10 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

}