<?php

namespace app\models;

use app\models\Pengguna;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $nama;
    public $login;
    public $no_kp;
    public $id_jabatan;
    public $id_unit;
    public $emel;
    public $level;
    public $jenis;
    public $aktif;
    public $photo;
    public $date;
    public $user;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = Pengguna::findOne($id);
        if(count($user) > 0)
            return new static($user);
        else
            return null;

        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = Pengguna::findOne(['no_kp' => $username]);
        
        if(count($user) > 0)
            return new static($user);
        else
            return null;
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }

        // return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    // This function to limit the access level of logged in user
    public static function accessLevel($accessArray)
    {   //if(!isset(\Yii::$app->user->isGuest))
        //    return Yii::$app->getController()->redirect(['site/logout']);
        $access_level = explode(',', \Yii::$app->user->identity->level);
        if(count(array_intersect($access_level, $accessArray)) > 0)
            return true;
        return false;
    }
}
