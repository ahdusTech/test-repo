<?php

/**
 * This is the model class for table "usr_users".
 *
 * The followings are the available columns in table 'usr_users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_plain
 * @property string $password_again
 * @property string $password
 * @property string $email
 * @property string $street
 * @property string $zipcode
 * @property string $city
 * @property string $country
 * @property string $vat_id
 * @property string $phone
 * @property string $company_name
 * @property string $title
 * @property string $firstname
 * @property string $lastname
 * @property string $activation_key
 * @property string $verification_code
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property datetime $last_visit_on
 * @property datetime $password_set_on
 * @property boolean $sms_verification_required
 * @property boolean $email_verified
 * @property boolean $is_active
 * @property boolean $is_disabled
 * @property boolean $terms_agreed
 * @property string $one_time_password_secret
 * @property string $one_time_password_code
 * @property integer $one_time_password_counter
 *
 * The followings are the available model relations:
 * @property UserLoginAttempt[] $userLoginAttempts
 * @property UserProfilePicture[] $userProfilePictures
 * @property UserRemoteIdentity[] $userRemoteIdentities
 * @property UserUsedPassword[] $userUsedPassword
 */
class User extends CActiveRecord
{
    public $password_plain;
    public $password_again;
    public $terms_agreed;
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'usr_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        // password is unsafe on purpose, assign it manually after hashing only if not empty
        return array(
            array('username, email, street, zipcode, city, country, vat_id, phone, firstname, lastname, is_active, is_disabled', 'filter', 'filter' => 'trim'),
            array('verification_code, activation_key, created_on, updated_on, last_visit_on, password_set_on, email_verified', 'filter', 'filter' => 'trim', 'on' => 'search'),
            array('username, email, street, zipcode, city, country, vat_id, phone, firstname, lastname, is_active, is_disabled, company_name', 'default', 'setOnEmpty' => true, 'value' => null),
            array('verification_code, activation_key, created_on, updated_on, last_visit_on, password_set_on, email_verified', 'default', 'setOnEmpty' => true, 'value' => null, 'on' => 'search'),
            array('username, email, city, country, title, firstname, lastname, zipcode, street, terms_agreed, is_active, is_disabled, email_verified, phone', 'required', 'except' => 'search'),
            array('created_on, updated_on, last_visit_on, password_set_on', 'date', 'format' => array('yyyy-MM-dd', 'yyyy-MM-dd HH:mm', 'yyyy-MM-dd HH:mm:ss'), 'on' => 'search'),
            array('password_plain, password_again', 'length', 'max' => 128),
            array('verification_code', 'length', 'max' => 6, 'on' => 'search'),
            array('activation_key', 'length', 'max' => 128, 'on' => 'search'),
            array('is_active, is_disabled, email_verified', 'boolean'),
            array('username, email', 'unique', 'except' => 'search'),
        );
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return array(
            'userLoginAttempts' => array(self::HAS_MANY, 'UserLoginAttempt', 'user_id', 'order' => 'performed_on DESC'),
            'userProfilePictures' => array(self::HAS_MANY, 'UserProfilePicture', 'user_id'),
            'userRemoteIdentities' => array(self::HAS_MANY, 'UserRemoteIdentity', 'user_id'),
            'userUsedPasswords' => array(self::HAS_MANY, 'UserUsedPassword', 'user_id', 'order' => 'set_on DESC'),
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('models', 'ID'),
            'username' => Yii::t('models', 'Benutzername'),
            'password' => Yii::t('models', 'Passwort'),
            'password_plain' => Yii::t('models', 'Passwort'),
            'password_again' => Yii::t('models', 'Passwort (nochmals)'),
            'email' => Yii::t('models', 'Email'),
            'street' => Yii::t('models', 'Strasse / Hausnummer'),
            'zipcode' => Yii::t('models', 'Postleitzahl'),
            'city' => Yii::t('models', 'Ort'),
            'country' => Yii::t('models', 'Land'),
            'vat_id' => Yii::t('models', 'Ust.-ID-Nr.'),
            'phone' => Yii::t('models', 'Mobiltelefon'),
            'company_name' => Yii::t('models', 'Firmenname'),
            'title' => Yii::t('models', 'Anrede'),
            'firstname' => Yii::t('models', 'Vorname'),
            'lastname' => Yii::t('models', 'Nachname'),
            'activation_key' => Yii::t('models', 'Aktivierungsschluessel'),
            'created_on' => Yii::t('models', 'Erstellungszeitpunkt'),
            'updated_on' => Yii::t('models', 'Aktualisierungszeitpunkt'),
            'last_visit_on' => Yii::t('models', 'Letzter Besuch'),
            'password_set_on' => Yii::t('models', 'Aktualisierungszeitpunkt Passwort'),
//            'sms_verification_required' => Yii::t('models', 'Auktionsstart nur mit SMS-Verifikation'),
            'email_verified' => Yii::t('models', 'E-Mail-Adresse verifiziert'),
            'terms_agreed' => Yii::t('models', 'AGB-Zustimmung'),
            'is_active' => Yii::t('models', 'aktiviert?'),
            'is_disabled' => Yii::t('models', 'gesperrt?'),
            'one_time_password_secret' => Yii::t('models', 'One Time Password Secret'),
            'one_time_password_code' => Yii::t('models', 'One Time Password Code'),
            'one_time_password_counter' => Yii::t('models', 'One Time Password Counter'),
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models
     *                             based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        //$criteria->compare('password',$this->password,true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('street', $this->street, true);
        $criteria->compare('zipcode', $this->zipcode, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('vat_id', $this->vat_id, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        //$criteria->compare('activation_key',$this->activation_key,true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('last_visit_on', $this->last_visit_on, true);
        $criteria->compare('password_set_on', $this->password_set_on, true);
        $criteria->compare('sms_verification_required', $this->sms_verification_required);
        $criteria->compare('email_verified', $this->email_verified);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_disabled', $this->is_disabled);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param  string $className active record class name.
     * @return User   the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_on = date('Y-m-d H:i:s');
        } else {
            $this->updated_on = date('Y-m-d H:i:s');
        }

        if(
            parent::beforeSave(
            )
        ) {
            if (
                $this->isNewRecord
            ) {
                $this->password = $this->hashPassword(
                    $this->password_plain
                );
            } else { 
                if (
                    isset(
                        $this->password_plain
                    ) && (
                        $this->password_plain !== ''
                    )
                ) {
                    $this->password = $this->hashPassword(
                        $this->password_plain
                    );
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    protected function beforeValidate(
    ) {
        if (
            $this->password_plain !== $this->password_again
        ) {
            $this->addError(
                'password_again',
                'Passwoerter stimmen nicht ueberein'
            );
        }
        if (
            $this->isNewRecord
        ) {
            if (
                (
                    $this->password_plain === ''
                ) || (
                    $this->password_plain === null
                )
            ) {
                $this->addError(
                    'password_plain',
                    'Passwort darf nicht leer sein'
                );
            }
        }
        return TRUE;
    }

    public function isAttributeRequired(
        $attribute
    ) {
        if (
            (
                'password_plain' === $attribute
            ) || (
                'password_again' === $attribute
            )
        ) {
            if (
                $this->isNewRecord
            ) {
                return TRUE;
            }
        }
        return parent::isAttributeRequired(
            $attribute
        );
    }

    public static function hashPassword($password)
    {
        require Yii::getPathOfAlias('usr.extensions').DIRECTORY_SEPARATOR.'password.php';

        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password)
    {
        require Yii::getPathOfAlias('usr.extensions').DIRECTORY_SEPARATOR.'password.php';

        return $this->password !== null && password_verify($password, $this->password);
    }
}
