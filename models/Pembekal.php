<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembekal".
 *
 * @property int $id
 * @property int $id_perolehan
 * @property string $pembekal
 * @property string $nama_pembekal
 * @property int $id_syarikat
 * @property int $utama
 * @property string $no_telefon
 * @property string $email
 * @property double $harga
 * @property string $tarikh_jadi
 */
class Pembekal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembekal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perolehan', 'pembekal', 'harga'], 'required'],
            [['id_perolehan', 'id_syarikat', 'utama'], 'integer'],
            [['pembekal'], 'string'],
            [['harga'], 'number'],
            [['tarikh_jadi'], 'safe'],
            [['nama_pembekal'], 'string', 'max' => 100],
            [['no_telefon'], 'string', 'max' => 12],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_perolehan' => Yii::t('app', 'Id Perolehan'),
            'pembekal' => Yii::t('app', 'Pembekal'),
            'nama_pembekal' => Yii::t('app', 'Nama Pembekal'),
            'id_syarikat' => Yii::t('app', 'Id Syarikat'),
            'utama' => Yii::t('app', 'Utama'),
            'no_telefon' => Yii::t('app', 'No Telefon'),
            'email' => Yii::t('app', 'Email'),
            'harga' => Yii::t('app', 'Harga'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
        ];
    }
}
