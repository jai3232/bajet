<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konfigurasi".
 *
 * @property int $id
 * @property string $nama_agensi
 * @property string $alamat1
 * @property string $alamat2
 * @property int $poskod
 * @property string $bandar
 * @property string $negeri
 * @property string $no_telefon
 * @property string $no_faks
 * @property string $emel
 * @property string $lesen
 * @property string $sistem_ip 
 * @property string $subnet_mask 
 * @property string $gateway 
 * @property string $smtp
 * @property int $port
 * @property string $username 
 * @property string $password 
 * @property string $enkripsi 
 * @property int $papar_logo
 * @property string $logo
 */
class Konfigurasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $file;

    public static function tableName()
    {
        return 'konfigurasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'emel', 'lesen', 'sistem_ip', 'subnet_mask', 'gateway'], 'required'],
            [['id', 'poskod', 'port', 'papar_logo'], 'integer'],
            [['lesen'], 'string'],
            [['nama_agensi', 'alamat1', 'alamat2'], 'string', 'max' => 200],
            [['bandar', 'emel', 'smtp', 'username', 'logo'], 'string', 'max' => 50],
            [['negeri'], 'string', 'max' => 30],
            [['no_telefon', 'no_faks'], 'string', 'max' => 15],
            [['sistem_ip', 'subnet_mask', 'gateway'], 'ip'],
            [['subnet_mask'], 'ip', 'subnet' => null],
            ['emel', 'email'],
            [['sistem_ip', 'subnet_mask', 'gateway'], 'string', 'max' => 16],
            [['password'], 'string', 'max' => 100],
            [['enkripsi'], 'string', 'max' => 10],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama_agensi' => Yii::t('app', 'Nama Agensi'),
            'alamat1' => Yii::t('app', 'Alamat1'),
            'alamat2' => Yii::t('app', 'Alamat2'),
            'poskod' => Yii::t('app', 'Poskod'),
            'bandar' => Yii::t('app', 'Bandar'),
            'negeri' => Yii::t('app', 'Negeri'),
            'no_telefon' => Yii::t('app', 'No Telefon'),
            'no_faks' => Yii::t('app', 'No Faks'),
            'emel' => Yii::t('app', 'Emel'),
            'lesen' => Yii::t('app', 'Lesen'),
            'sistem_ip' => Yii::t('app', 'Sistem Ip'), 
            'subnet_mask' => Yii::t('app', 'Subnet Mask'), 
            'gateway' => Yii::t('app', 'Gateway'), 
            'smtp' => Yii::t('app', 'Smtp'),
            'port' => Yii::t('app', 'Port'),
            'username' => Yii::t('app', 'Username'), 
            'password' => Yii::t('app', 'Password'), 
            'enkripsi' => Yii::t('app', 'Enkripsi'), 
            'papar_logo' => Yii::t('app', 'Papar Logo'),
            'logo' => Yii::t('app', 'Logo'),
        ];
    }

    public function getConfig($item)
    {
        return self::findOne(1)->attributes[$item];
    }
}
