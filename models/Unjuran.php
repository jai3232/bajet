<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unjuran".
 *
 * @property int $id
 * @property string $kod_id
 * @property string $os
 * @property string $ol
 * @property int $id_jabatan
 * @property int $id_unit
 * @property string $butiran
 * @property int $kuantiti
 * @property string $kod
 * @property double $jumlah_unjuran
 * @property string $kongsi
 * @property int $public
 * @property string $tahun
 * @property string $catatan
 * @property int $status
 * @property int $sah
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 * @property int $user
 *
 * @property Ot[] $ots
 * @property Penceramah[] $penceramahs
 * @property Perbelanjaan[] $perbelanjaans
 * @property Perjalanan[] $perjalanans
 * @property Perolehan[] $perolehans
 */
class Unjuran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unjuran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_id', 'os', 'id_jabatan', 'butiran', 'kod', 'jumlah_unjuran', 'tahun'], 'required'],
            [['id_jabatan', 'id_unit', 'kuantiti', 'public', 'status', 'sah', 'user'], 'integer'],
            [['butiran', 'catatan'], 'string'],
            [['jumlah_unjuran'], 'number'],
            [['tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['kod_id'], 'string', 'max' => 10],
            [['os'], 'string', 'max' => 16],
            [['ol'], 'string', 'max' => 50],
            [['kod'], 'string', 'max' => 1],
            //[['kongsi'], 'string', 'max' => 30],
            [['tahun'], 'string', 'max' => 4],
            [['kod_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kod_id' => Yii::t('app', 'Kod ID'),
            'os' => Yii::t('app', 'Os'),
            'ol' => Yii::t('app', 'Ol'),
            'id_jabatan' => Yii::t('app', 'Id Jabatan'),
            'id_unit' => Yii::t('app', 'Id Unit'),
            'butiran' => Yii::t('app', 'Butiran'),
            'kuantiti' => Yii::t('app', 'Kuantiti'),
            'kod' => Yii::t('app', 'Kod'),
            'jumlah_unjuran' => Yii::t('app', 'Jumlah Unjuran'),
            'kongsi' => Yii::t('app', 'Kongsi'),
            'public' => Yii::t('app', 'Public'),
            'tahun' => Yii::t('app', 'Tahun'),
            'catatan' => Yii::t('app', 'Catatan'),
            'status' => Yii::t('app', 'Status'),
            'sah' => Yii::t('app', 'Sah'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
            'tarikh_kemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
            'user' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function bakiUnjuran($kod_unjuran)
    {
        $perolehan = Perolehan::find()->where(['kod_unjuran' => $kod_unjuran])->sum('nilai_perolehan');
        $perbelanjaan = Perbelanjaan::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_bayaran');
        $ot = Ot::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_kew');
        $penceramah = Penceramah::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_kew');
        $perjalanan = Perjalanan::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_kew');
        $unjuran = self::find()->where(['kod_id' => $kod_unjuran])->sum('jumlah_unjuran');

        return $unjuran - ($perolehan + $perbelanjaan + $ot + $penceramah + $perjalanan);
    }
    
    public function getOts()
    {
        return $this->hasMany(Ot::className(), ['kod_unjuran' => 'kod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenceramahs()
    {
        return $this->hasMany(Penceramah::className(), ['kod_unjuran' => 'kod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerbelanjaans()
    {
        return $this->hasMany(Perbelanjaan::className(), ['kod_unjuran' => 'kod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerjalanans()
    {
        return $this->hasMany(Perjalanan::className(), ['kod_unjuran' => 'kod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerolehans()
    {
        return $this->hasMany(Perolehan::className(), ['kod_unjuran' => 'kod_id']);
    }

        public function getJabatan()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'id_jabatan']);
    }

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'id_unit']);
    }
}
