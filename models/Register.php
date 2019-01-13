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
class Register extends \yii\db\ActiveRecord
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
            [['nama', 'password', 'password_ulang', 'id_jabatan', 'id_unit', 'emel', 'no_kp', 'captcha'], 'required'],
            [['id_jabatan', 'id_unit', 'level', 'aktif'], 'integer'],
            [['date'], 'safe'],
            [['nama'], 'string', 'max' => 100],
            [['no_kp'], 'string', 'max' => 12],
            [['password'], 'string', 'min' => 6, 'max' => 32],
            [['password_ulang'], 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Katalaluan tidak sama"],
            [['emel'], 'string', 'max' => 50],
            [['level'], 'string', 'max' => 3],
            [['aktif'], 'string', 'max' => 1],
            [['emel'], 'email'],  
            ['captcha', 'captcha'],
            [['no_kp', 'emel'], 'unique'],
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
            'id_jabatan' => 'Jabatan',
            'id_unit' => 'Unit',
            'emel' => 'Emel',
            'aktif' => 'Aktif',
            'date' => 'Date',
        ];
    }
}
