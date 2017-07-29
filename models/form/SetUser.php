<?php

namespace app\models\form;

use Yii;
use app\models\User;
use yii\base\Model;

class SetUser extends Model
{
	const SCENARIO_ADD = 'add';
	const SCENARIO_EDIT = 'edit';

	public $id;
	public $username;
	public $isNewRecord = true;
	public $email;
	public $status;
	public $password;
	public $retypePassword;
	public $created_at;
	public $updated_at;

	/**
	 * SetUser constructor.
	 * @param User $user
	 * @param array $config
	 */
	public function __construct($user, $config = []) {

		$this->_user = $user;

		$this->isNewRecord = $user->isNewRecord;

		$this->setAttributes($user->getAttributes());

		//$this->username = $user->username;

		parent::__construct($config);
	}

	/**
	 * @var User
	 */
	private $_user = null;

	public function rules()
	{
		return [
			['username', 'filter', 'filter' => 'trim'],
			['username', 'required'],
			['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Пользователь под таким логином уже существует.', 'on' => self::SCENARIO_ADD],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Этот адрес электронной почты уже занят.', 'on' => self::SCENARIO_ADD],

			// password is validated by validatePassword()
			['password', 'required', 'on' => self::SCENARIO_ADD],
			['password', 'filter', 'filter' => 'trim'],
			['password', 'string', 'min' => 6],

			['retypePassword', 'required', 'on' => self::SCENARIO_ADD],
			['retypePassword', 'filter', 'filter' => 'trim'],
			['retypePassword', 'compare', 'compareAttribute' => 'password'],

			[['created_at', 'updated_at'], 'safe']
		];
	}

	public function validatePassword()
	{
		$user = User::findByUsername($this->username);

		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError('password', 'Логин и / или пароль введены не верно.');
		}
	}

	public function attributeLabels()
	{
		return [
			'username' => 'Логин',
			'password' => 'Пароль',
			'retypePassword' => 'Подтвердить',
			'email' => 'Почта',
			'status' => 'Статус',
			'created_at' => 'Зарегистрирован',
			'updated_at' => 'Последние изменения'
		];
	}

	public function set()
	{
		if($this->validate()){
			$this->_user->email = $this->email;
			if($this->isNewRecord){
				$this->_user->username = $this->username;
				$this->_user->setPassword($this->password);
				$this->_user->generateAuthKey();
			}else{
				if(!empty($this->password)){
					$this->_user->setPassword($this->password);
				}
			}
			return $this->_user->save();
		}
		return false;
	}

	public function save()
	{

	}
}