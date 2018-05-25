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
 *
 * @property Perolehan $perolehan
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
            [['email'], 'string', 'max' => 30],
            [['id_perolehan'], 'exist', 'skipOnError' => true, 'targetClass' => Perolehan::className(), 'targetAttribute' => ['id_perolehan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_perolehan' => 'Id Perolehan',
            'pembekal' => 'Pembekal',
            'nama_pembekal' => 'Nama Pembekal',
            'id_syarikat' => 'Id Syarikat',
            'utama' => 'Utama',
            'no_telefon' => 'No Telefon',
            'email' => 'Email',
            'harga' => 'Harga',
            'tarikh_jadi' => 'Tarikh Jadi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerolehan()
    {
        return $this->hasOne(Perolehan::className(), ['id' => 'id_perolehan']);
    }
}
