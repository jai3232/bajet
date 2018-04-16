<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pengguna".
 *
 * @property int $id
 * @property string $nama
 * @property string $no_kp
 * @property string $password
 * @property int $id_jabatan
 * @property int $id_unit
 * @property string $emel
 * @property int $level
 * @property int $aktif
 * @property string $date
 */
class Pengguna extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $password_ulang;

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
            [['nama', 'password', 'id_jabatan', 'emel'], 'required'],
            [['id_jabatan', 'id_unit', 'level', 'aktif'], 'integer'],
            [['date'], 'safe'],
            [['nama'], 'string', 'max' => 100],
            [['no_kp'], 'string', 'max' => 12],
            [['password'], 'string', 'min' => 6, 'max' => 32],
            [['password_ulang'], 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => true, 'message'=>"Katalaluan tidak sama"],
            [['emel'], 'string', 'max' => 50],
            [['emel'], 'email'], 
            [['no_kp', 'emel'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama'),
            'no_kp' => Yii::t('app', 'No Kp'),
            'password' => Yii::t('app', 'Password'),
            'id_jabatan' => Yii::t('app', 'Id Jabatan'),
            'id_unit' => Yii::t('app', 'Id Unit'),
            'emel' => Yii::t('app', 'Emel'),
            'level' => Yii::t('app', 'Level'),
            'aktif' => Yii::t('app', 'Aktif'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    public function getJabatan()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'id_jabatan']);
    }

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'id_unit']);
    }

    public function getLevel0()
    {
        return $this->hasOne(KumpulanPengguna::className(), ['id' => 'level']);
    }
}
