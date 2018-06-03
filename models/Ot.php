<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ot".
 *
 * @property int $id
 * @property string $kod_unjuran
 * @property string $kod_id
 * @property string $os
 * @property string $bahagian
 * @property string $bahagian_asal
 * @property string $unit
 * @property string $nama
 * @property string $no_kp
 * @property string $no_hp
 * @property string $email
 * @property int $bulan
 * @property int $tahun
 * @property string $gred_jawatan
 * @property int $tanggung_kerja
 * @property string $jawatan
 * @property string $no_gaji
 * @property double $gaji_asas
 * @property double $kadar_sejam
 * @property string $bank
 * @property string $akaun_bank
 * @property double $jumlah_OT
 * @property double $jumlah_kew
 * @property int $status
 * @property string $catatan
 * @property string $user
 * @property string $date
 *
 * @property Unjuran $kodUnjuran
 */
class Ot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_unjuran', 'kod_id', 'os', 'bahagian', 'unit', 'nama', 'no_kp', 'no_hp', 'bulan', 'tahun', 'gred_jawatan', 'jawatan', 'no_gaji', 'gaji_asas', 'kadar_sejam', 'bank', 'akaun_bank', 'catatan', 'user'], 'required'],
            [['bulan', 'tahun', 'tanggung_kerja', 'status'], 'integer'],
            [['gaji_asas', 'kadar_sejam', 'jumlah_OT', 'jumlah_kew'], 'number'],
            [['catatan'], 'string'],
            [['date'], 'safe'],
            [['kod_unjuran', 'kod_id'], 'string', 'max' => 10],
            [['os'], 'string', 'max' => 16],
            [['bahagian', 'bahagian_asal'], 'string', 'max' => 3],
            [['unit', 'bank'], 'string', 'max' => 50],
            [['nama', 'email', 'user'], 'string', 'max' => 100],
            [['no_kp', 'no_hp'], 'string', 'max' => 12],
            [['gred_jawatan', 'jawatan'], 'string', 'max' => 25],
            [['no_gaji'], 'string', 'max' => 15],
            [['akaun_bank'], 'string', 'max' => 20],
            [['kod_id'], 'unique'],
            [['kod_unjuran'], 'exist', 'skipOnError' => true, 'targetClass' => Unjuran::className(), 'targetAttribute' => ['kod_unjuran' => 'kod_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kod_unjuran' => Yii::t('app', 'Kod Unjuran'),
            'kod_id' => Yii::t('app', 'Kod ID'),
            'os' => Yii::t('app', 'Os'),
            'bahagian' => Yii::t('app', 'Bahagian'),
            'bahagian_asal' => Yii::t('app', 'Bahagian Asal'),
            'unit' => Yii::t('app', 'Unit'),
            'nama' => Yii::t('app', 'Nama'),
            'no_kp' => Yii::t('app', 'No Kp'),
            'no_hp' => Yii::t('app', 'No Hp'),
            'email' => Yii::t('app', 'Email'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'gred_jawatan' => Yii::t('app', 'Gred Jawatan'),
            'tanggung_kerja' => Yii::t('app', 'Tanggung Kerja'),
            'jawatan' => Yii::t('app', 'Jawatan'),
            'no_gaji' => Yii::t('app', 'No Gaji'),
            'gaji_asas' => Yii::t('app', 'Gaji Asas'),
            'kadar_sejam' => Yii::t('app', 'Kadar Sejam'),
            'bank' => Yii::t('app', 'Bank'),
            'akaun_bank' => Yii::t('app', 'Akaun Bank'),
            'jumlah_OT' => Yii::t('app', 'Jumlah  Ot'),
            'jumlah_kew' => Yii::t('app', 'Jumlah Kew'),
            'status' => Yii::t('app', 'Status'),
            'catatan' => Yii::t('app', 'Catatan'),
            'user' => Yii::t('app', 'User'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodUnjuran()
    {
        return $this->hasOne(Unjuran::className(), ['kod_id' => 'kod_unjuran']);
    }
}