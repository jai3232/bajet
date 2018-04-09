<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pengguna".
 *
 * @property int $id
 * @property string $nama
 * @property string $login
 * @property string $no_kp
 * @property string $password
 * @property string $password_ulang
 * @property string $jabatan
 * @property string $unit
 * @property string $emel
 * @property int $level
 * @property string $jenis
 * @property int $aktif
 * @property string $date
 */
class Pengguna extends \yii\db\ActiveRecord
{
    public $password_ulang;
    public $captcha;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pengguna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'password', 'password_ulang', 'jabatan', 'emel', 'captcha'], 'required'],
            [['date'], 'safe'],
            [['nama'], 'string', 'max' => 100],
            [['no_kp'], 'string', 'max' => 12],
            [['password'], 'string', 'min' => 6, 'max' => 32],
            [['password_ulang'], 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],

            [['jabatan'], 'string', 'max' => 5],
            [['unit', 'emel'], 'string', 'max' => 50],
            [['level'], 'string', 'max' => 4],
            [['aktif'], 'string', 'max' => 1],
            [['emel'], 'email'],  
            ['captcha', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'no_kp' => 'No Kp',
            'password' => 'Password',
            'password_ulang' => 'Ulang Password',
            'jabatan' => 'Jabatan',
            'unit' => 'Unit',
            'emel' => 'Emel',
            'aktif' => 'Aktif',
            'date' => 'Date',
        ];
    }
}
