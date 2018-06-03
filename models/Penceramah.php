<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penceramah".
 *
 * @property int $id
 * @property string $kod_unjuran
 * @property string $kod_id
 * @property string $os
 * @property int $jenis_penceramah
 * @property int $nilai_kumpulan
 * @property int $tugas
 * @property string $nama
 * @property string $bahagian
 * @property string $bahagian_asal
 * @property string $unit
 * @property string $no_kp
 * @property string $jawatan
 * @property int $kelayakan
 * @property double $gaji
 * @property string $jabatan
 * @property string $alamat_jabatan
 * @property string $no_hp
 * @property string $email
 * @property int $bulan
 * @property int $tahun
 * @property string $bank
 * @property string $akaun_bank
 * @property double $jumlah_tuntutan
 * @property double $jumlah_kew
 * @property int $status
 * @property string $catatan
 * @property string $user
 * @property string $date
 *
 * @property Unjuran $kodUnjuran
 */
class Penceramah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penceramah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_unjuran', 'kod_id', 'os', 'nama', 'bahagian', 'unit', 'no_kp', 'alamat_jabatan', 'no_hp', 'bulan', 'tahun', 'bank', 'akaun_bank', 'jumlah_tuntutan', 'catatan', 'user'], 'required'],
            [['jenis_penceramah', 'nilai_kumpulan', 'tugas', 'kelayakan', 'bulan', 'tahun', 'status'], 'integer'],
            [['gaji', 'jumlah_tuntutan', 'jumlah_kew'], 'number'],
            [['catatan'], 'string'],
            [['date'], 'safe'],
            [['kod_unjuran', 'kod_id'], 'string', 'max' => 10],
            [['os'], 'string', 'max' => 16],
            [['nama', 'user'], 'string', 'max' => 100],
            [['bahagian', 'bahagian_asal'], 'string', 'max' => 3],
            [['unit', 'email'], 'string', 'max' => 50],
            [['no_kp', 'no_hp'], 'string', 'max' => 12],
            [['jawatan', 'jabatan', 'bank'], 'string', 'max' => 25],
            [['alamat_jabatan'], 'string', 'max' => 125],
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
            'jenis_penceramah' => Yii::t('app', 'Jenis Penceramah'),
            'nilai_kumpulan' => Yii::t('app', 'Nilai Kumpulan'),
            'tugas' => Yii::t('app', 'Tugas'),
            'nama' => Yii::t('app', 'Nama'),
            'bahagian' => Yii::t('app', 'Bahagian'),
            'bahagian_asal' => Yii::t('app', 'Bahagian Asal'),
            'unit' => Yii::t('app', 'Unit'),
            'no_kp' => Yii::t('app', 'No Kp'),
            'jawatan' => Yii::t('app', 'Jawatan'),
            'kelayakan' => Yii::t('app', 'Kelayakan'),
            'gaji' => Yii::t('app', 'Gaji'),
            'jabatan' => Yii::t('app', 'Jabatan'),
            'alamat_jabatan' => Yii::t('app', 'Alamat Jabatan'),
            'no_hp' => Yii::t('app', 'No Hp'),
            'email' => Yii::t('app', 'Email'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'bank' => Yii::t('app', 'Bank'),
            'akaun_bank' => Yii::t('app', 'Akaun Bank'),
            'jumlah_tuntutan' => Yii::t('app', 'Jumlah Tuntutan'),
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
