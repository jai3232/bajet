<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penceramah".
 *
 * @property int $id
 * @property string $kod_unjuran
 * @property string $kod_id
 * @property int $jenis_penceramah
 * @property int $nilai_kumpulan
 * @property int $tugas
 * @property string $nama
 * @property int $id_jabatan
 * @property int $id_jabatan_asal
 * @property int $id_unit
 * @property string $no_kp
 * @property string $jawatan
 * @property string $gred_jawatan
 * @property int $taraf_jawatan
 * @property int $kelayakan
 * @property string $no_gaji
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
 * @property string $status
 * @property string $catatan
 * @property int $user
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
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
            [['kod_unjuran', 'kod_id', 'nama', 'id_jabatan', 'id_unit', 'no_kp', 'gred_jawatan', 'taraf_jawatan', 'no_gaji', 'alamat_jabatan', 'no_hp', 'bulan', 'tahun', 'bank', 'akaun_bank', 'jumlah_tuntutan', 'user'], 'required'],
            [['jenis_penceramah', 'nilai_kumpulan', 'tugas', 'id_jabatan', 'id_jabatan_asal', 'id_unit', 'taraf_jawatan', 'kelayakan', 'bulan', 'tahun', 'user'], 'integer'],
            [['gaji', 'jumlah_tuntutan', 'jumlah_kew'], 'number'],
            [['catatan'], 'string'],
            [['tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['kod_unjuran', 'kod_id', 'no_gaji'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 100],
            [['no_kp', 'no_hp'], 'string', 'max' => 12],
            [['jawatan', 'jabatan', 'bank'], 'string', 'max' => 25],
            [['gred_jawatan'], 'string', 'max' => 7],
            [['alamat_jabatan'], 'string', 'max' => 125],
            [['email'], 'string', 'max' => 50], 
            [['akaun_bank'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 1],
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
            'jenis_penceramah' => Yii::t('app', 'Jenis Penceramah'),
            'nilai_kumpulan' => Yii::t('app', 'Nilai Kumpulan'),
            'tugas' => Yii::t('app', 'Tugas'),
            'nama' => Yii::t('app', 'Nama'),
            'id_jabatan' => Yii::t('app', 'Jabatan'),
            'id_jabatan_asal' => Yii::t('app', 'Jabatan Asal'),
            'id_unit' => Yii::t('app', 'Unit'),
            'no_kp' => Yii::t('app', 'No Kp'),
            'jawatan' => Yii::t('app', 'Jawatan'),
            'gred_jawatan' => Yii::t('app', 'Gred Jawatan'),
            'taraf_jawatan' => Yii::t('app', 'Taraf Jawatan'),
            'kelayakan' => Yii::t('app', 'Kelayakan'),
            'no_gaji' => Yii::t('app', 'No Gaji'),
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
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
            'tarikh_kemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
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
