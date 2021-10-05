<?php
/**
 * The followings are the available columns in table {{user}}:
 * @var integer $id
 * @var string $username
 * @var string $password
 * @var string $email
 * @var string $activkey
 * @var string $oid_provider
 * @var integer $create_time
 * @var integer $last_visit_time
 * @var integer $role
 * @var integer $status
 * @var string $first_name
 * @var string $last_name
 * @var string $avatar
 */

class User extends ActiveRecord
{

    // service values
    private static $_user;
    public $rememberMe = true;
    public $verifyCode;
    public $verifyPassword;
    public $password_new;
    public $verifyPassword_new;
    public $checkexists_id;

    // default values
    public $role = self::ROLE_USER;
    public $status = self::STATUS_NOACTIVE;

    public $avatar_tmp;
    public $files_config = array(
        'avatar' => array(
            'path' => '/content/upload/user/avatar/', 'type' => 'image', 'time_dir' => false,
            'rule' => array('types' => 'jpg,jpeg,png,gif', 'maxSize' => 10, 'required' => false),
            'tmbs' => array(
                array('name' => 'big', 'w' => 800, 'h' => 800, 'param' => self::RESIZE),
                array('name' => 'mid', 'w' => 200, 'h' => 200, 'param' => self::RESIZE),
                array('name' => 'sml', 'w' => 100, 'h' => 100, 'param' => self::RESIZE),
            )),
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{user}}';
    }


    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            // base
            array('password, email, activkey, first_name, last_name, avatar,
                username, oid_provider, phone, company', 'length', 'max' => 255,),
            array('create_time, last_visit_time, role, status, location, city_id', 'numerical', 'integerOnly' => true),
            array('email', 'email'),
            array('first_name, last_name, second_name','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
            array('age, sex, city_txt, id, b_year, b_month, b_day, about', 'safe'),
            //array('username', 'match', 'pattern' => '/^[A-Za-z0-9_@.]+$/u','message' => Yii::t('user',"Incorrect symbols (A-z or 0-9 or @ or dot).")),

            // login
            array('username, password', 'required', 'on' => 'login','message'=>Y::t('Не указано: {attribute}',0)),
            array('password', 'antiguessing', 'on' => 'login'),
            array('password', 'authenticate', 'on' => 'login'),
            // oidlogin
            array('password', 'authenticate', 'auto' => true, 'on' => 'oidlogin'),

            // registration
            array('username', 'unique', 'message' => Yii::t('user',"This user's name already exists."), 'on' => 'registration'),
            array('email', 'unique', 'message' => Yii::t('user',"This user's email address already exists."), 'on' => 'registration'),
            array('username', 'length', 'max' => 100, 'min' => 4, 'message' => Yii::t('user',"Incorrect login/email (minimal length 4 symbols)."), 'on' => 'registration'),
            array('password', 'length', 'max' => 100, 'min' => 6, 'message' => Yii::t('user',"Incorrect password (minimal length 4 symbols)."), 'on' => 'registration'),
            array('verifyCode', 'captcha', 'allowEmpty' => !UserModule::doCaptcha('registration')),
            // simple reg
            array('username, password, first_name', 'required', 'on' => 'registration'),
            array('username', 'email', 'on' => 'registration'),
            // full reg
            //array('username, password, email, verifyPassword', 'required', 'on'=>'registration'),
            //array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('user',"Retype Password is incorrect."), 'on'=>'registration'),

            // change
            array('password_new, verifyPassword_new', 'safe', 'on' => 'change'),
            array('verifyPassword_new', 'compare', 'compareAttribute'=>'password_new', 'message' => Yii::t('user',"Retype Password is incorrect."), 'on'=>'change'),
            array('password_new', 'length', 'max' => 100, 'min' => 6, 'message' => Yii::t('user',"Incorrect password (minimal length 4 symbols)."), 'on' => 'change'),

            // recovery
            array('username', 'required', 'on' => 'recovery'),
            array('username', 'checkexists', 'on' => 'recovery'),

            // changePassword
            array('password, verifyPassword', 'required', 'on' => 'changePassword'),
            array('password', 'length', 'max' => 100, 'min' => 6, 'message' => Yii::t('user',"Incorrect password (minimal length 4 symbols)."), 'on' => 'changePassword'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user',"Retype Password is incorrect."), 'on' => 'changePassword'),

            // adminManage
            array('username, password', 'required', 'on' => 'adminManage'),
            array('username', 'unique', 'message' => Yii::t('user',"This user's name already exists."), 'on' => 'adminManage'),

            // changeBase
            array('username', 'unique', 'on' => 'changeBase'),
            array('password', 'safe', 'on' => 'changeBase'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user',"Retype Password is incorrect."), 'on' => 'changeBase'),

            // userEdit
            array('first_name', 'required', 'on' => 'userEdit'),
        ));
    }

    public function relations()
    {
        return array(
            'profile' => array(self::HAS_ONE, 'UserProfile', 'user_id'),

            'country' => array(self::BELONGS_TO, 'LocationCountry', 'country_id'),
            'oblast' => array(self::BELONGS_TO, 'LocationOblast', 'oblast_id'),
            'raion' => array(self::BELONGS_TO, 'LocationRaion', 'raion_id'),
            'city' => array(self::BELONGS_TO, 'LocationCity', 'city_id'),

        );
    }

    public function scopes()
    {
        return array(
            'active' => array('condition' => 'status=' . self::STATUS_ACTIVE),
            'notactvie' => array('condition' => 'status=' . self::STATUS_NOACTIVE),
            'banned' => array('condition' => 'status=' . self::STATUS_BANED),
            'admin' => array('condition' => 'role>' . self::ROLE_USER),
            'visor' => array('condition' => 'role=' . self::ROLE_VISOR),
        );
    }

    public function attributeLabels()
    {
        return array(
            'username' => Y::t("Почта"),
            'password' => Y::t("Пароль"),
            'verifyPassword' => Y::t("Повтор пароля"),
            'password_new' => Y::t('Новый пароль'),
            'verifyPassword_new' => Y::t('Повторите новый пароль'),
            'email' => Y::t('Доп. почта'),
            'verifyCode' => Y::t("Проверочный код"),
            'id' => Y::t("Id"),
            'activkey' => Y::t("Ключ активации"),
            'create_time' => Y::t("Дата регистрации"),
            'last_visit_time' => Y::t("Последний вход"),
            'role' => Y::t("Роль"),
            'status' => Y::t("Статус"),
            'avatar_tmp' => Y::t("Фото"),
            'rememberMe' => Y::t("Запомнить меня"),
            'company' => Y::t("Компания"),
            'phone' => Y::t("Телефон"),
            'sex' => Y::t("Пол"),
            'age' => Y::t("Возраст"),
            'b_year' => Y::t("Год рождения"),
            'b_month' => Y::t("Месяц"),
            'b_day' => Y::t("День"),
            'about' => Y::t("О себе"),

            'first_name' => Y::t("Имя"),
            'second_name' => Y::t("Отчество"),
            'last_name' => Y::t("Фамилия"),

            'country_id' => Y::t("Страна"),
            'oblast_id' => Y::t("Область"),
            'raion_id' => Y::t("Район"),
            'city_id' => Y::t("Нас. пункт"),
        );
    }

    public function search()
    {
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName']);

        $criteria = new CDbCriteria;

        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('status', $this->status);

        $criteria->compare('username', '<>dodg');

        if ($this->create_time) {
            $criteria->addBetweenCondition('create_time',
                CDateTimeParser::parse($this->create_time, 'dd.MM.yyyy'),
                CDateTimeParser::parse($this->create_time, 'dd.MM.yyyy') + 60 * 60 * 24
            );
        }
        if ($this->last_visit_time) {
            $criteria->addBetweenCondition('last_visit_time',
                CDateTimeParser::parse($this->last_visit_time, 'dd.MM.yyyy'),
                CDateTimeParser::parse($this->last_visit_time, 'dd.MM.yyyy') + 60 * 60 * 24
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'create_time DESC'
            ),
            'pagination' => array('pageSize' => Config::$data['base']->pageSize)
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->create_time = time();
            $this->activkey = UserModule::encrypting(microtime().$this->password);
            $this->password = UserModule::encrypting($this->password);
        }

        if($this->b_year)
            $this->age = intval(date('Y')) - $this->b_year;

        return parent::beforeSave();
    }

    public static function getUser($id = 0)
    {
        if ($id) return User::model()->findbyPk($id);

        if (Yii::app()->user->isGuest) return false;

        if (!self::$_user)
            self::$_user = User::model()->findByPk(Yii::app()->user->id);

        return self::$_user;
    }


    public function getEmail()
    {
        if (strpos($this->username, "@")) return $this->username;
        else return $this->email;
    }

    const ROLE_USER = 0;
    const ROLE_MANAGER = 2;
    const ROLE_VISOR = 7;
    const ROLE_ROOT = 10;
    public static function roleList()
    {
        return array(
            self::ROLE_USER => 'Пользователь',
            self::ROLE_ROOT => 'Администратор',
            self::ROLE_MANAGER => 'Менеджер',
            self::ROLE_VISOR => 'Супервизор',
        );
    }
    public static function isAdmin(){
        return  (self::getUser()->role > self::ROLE_MANAGER) ? true : false;
    }
    public static function isRoot(){
        return  (self::getUser()->role == self::ROLE_ROOT) ? true : false;
    }
    public static function isManager(){
        return  (self::getUser()->role >= self::ROLE_MANAGER) ? true : false;
    }
    public static function isModerator(){
        return  (self::getUser()->role >= self::ROLE_MANAGER) ? true : false;
    }
    public static function isDevUser()
    {
        return self::getUser()->username=='admin';
    }

    private static $_admins;
    public static function getAdmins() {
        if (!self::$_admins) {
            $admins = User::model()->active()->admin()->findAll();
            $return_name = array();
            foreach ($admins as $admin)
                array_push($return_name,$admin->username);
            self::$_admins = $return_name;
        }
        return self::$_admins;
    }

    private static $_visors ;
    public static function getVisors() {
        if (!self::$_visors) {
            $visors = User::model()->active()->visor()->findAll();
            $return_name = array();
            foreach ($visors as $visor)
                array_push($return_name,$visor->username);
            self::$_visors = $return_name;
        }
        return self::$_visors;
    }

    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) // we only want to authenticate when no input errors
        {
            $identity = new UserIdentity($this->username, $this->password);
            $identity->authenticate($params['auto']);
            switch ($identity->errorCode)
            {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_EMAIL_INVALID:
                    $this->addError("username", Yii::t('user',"Email is incorrect."));
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError("username", Yii::t('user',"Username is incorrect."));
                    break;
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError("status", Yii::t('user',"You account is not activated."));
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    $this->addError("status", Yii::t('user',"You account is blocked."));
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError("password", Yii::t('user',"Password is incorrect."));
                    break;
            }
        }
    }

    public function checkexists($attribute, $params)
    {
        $find = User::model()->findByAttributes(array('email' => $this->username));
        if (!isset($find))
            $find = User::model()->findByAttributes(array('username' => $this->username));

        if ($find) $this->checkexists_id = $find->id;

        if ($find === null)
            if (strpos($this->username, "@"))
                $this->addError("username", Yii::t('user',"Email is incorrect."));
            else $this->addError("username", Yii::t('user',"Username is incorrect."));

    }

    public function antiguessing($attribute, $params)
    {
        $tablePrefix = Y::app()->db->tablePrefix;
        Y::sqlExecute('delete from ' . $tablePrefix . 'user_antiguess where time <' . (time() - 60));
        Y::sqlInsert($tablePrefix . 'user_antiguess', array('login' => $this->username, 'time' => time()));
        $cnt = count(Y::sqlQueryAll('select * from ' . $tablePrefix . 'user_antiguess where login="' . $this->username . '"'));
        if ($cnt >= 5) $this->addError("password", Yii::t('user',"5 unsuccessful attempts, wait a minute to continue."));
    }

    public function roleName()
    {
        $arr = self::roleList();
        return $arr[$this->role];
    }

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANED = -1;

    public static function statusList($val = null)
    {
        $arr = array(
            self::STATUS_NOACTIVE => Yii::t('user','Not active'),
            self::STATUS_ACTIVE => Yii::t('user','Active'),
            self::STATUS_BANED => Yii::t('user','Banned'),
        );
        return isset($val) ? $arr[$val] : $arr;
    }

    public function statusName()
    {
        $arr = self::statisList();
        return $arr[$this->status];
    }

    public function beforeDelete()
    {
        if(!User::isRoot()) return false;

        $profile = UserProfile::model()->find('user_id=' . $this->id);
        if ($profile) $profile->delete();
        return parent::beforeDelete();
    }

    public static function getList($limit = -1)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('username!="dodg"');
        $criteria->limit = $limit;
        return CMap::mergeArray(array('' => ''), CHtml::listData(self::model()->findAll($criteria), 'id', 'last_name'));
    }

    public function getPrintName()
    {
        return ($this->first_name || $this->last_name)
            ? $this->first_name . ' ' . $this->last_name : $this->username;
    }
    public function getFio()
    {
        return $this->last_name.' '.$this->first_name . ' ' . $this->second_name;
    }

    public function getUrl($user_id=0)
    {
        if($user_id==0) $user_id = $this->id;
        return Y::contr()->createUrl('/user/page/view', array('id' => $user_id));
    }

    public static function sexList($val = null)
    {
        $arr = array(
            0 => '',
            1 => Yii::t('user','мужской'),
            2 => Yii::t('user','женский'),
        );
        return isset($val) ? $arr[$val] : $arr;
    }

    public static function yearList($val = null)
    {
        $arr = array(0 => '');
        for( $i=(date('Y')-12); $i>1900; $i-- )
            $arr[$i] =  $i;

        return isset($val) ? $arr[$val] : $arr;
    }

}