<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perjalanan".
 *
 * @property int $id
 * @property string $kod_unjuran
 * @property string $kod_id
 * @property int $id_jabatan
 * @property int $id_jabatan_asal
 * @property int $id_unit
 * @property string $nama
 * @property string $no_kp
 * @property string $no_hp
 * @property string $email
 * @property string $bulan
 * @property string $tahun
 * @property string $jawatan
 * @property string $no_gaji
 * @property double $gaji_asas
 * @property double $elaun
 * @property double $elaun_mangku
 * @property string $bank
 * @property string $cawangan_bank
 * @property string $akaun_bank
 * @property string $model_kereta
 * @property string $no_plate
 * @property int $cc
 * @property string $kelas_tuntutan
 * @property string $alamat_pejabat
 * @property string $alamat_rumah
 * @property int $jumlah_jarak
 * @property int $jarak_telah_dituntut
 * @property int $kali_makan
 * @property int $kali_makan_sabah
 * @property int $kali_harian
 * @property int $kali_harian_sabah
 * @property int $kali_elaun_luar
 * @property double $elaun_makan
 * @property double $elaun_makan_sabah
 * @property double $elaun_harian
 * @property double $elaun_harian_sabah
 * @property double $elaun_luar
 * @property double $peratus_elaun_makan
 * @property double $peratus_elaun_makan_sabah
 * @property double $peratus_elaun_harian
 * @property double $peratus_elaun_harian_sabah
 * @property double $peratus_elaun_luar
 * @property int $kali_hotel
 * @property int $kali_hotel2
 * @property int $kali_hotel3
 * @property int $kali_hotel4
 * @property int $kali_hotel5
 * @property int $kali_hotel6
 * @property int $kali_lojing
 * @property double $hotel
 * @property double $hotel2
 * @property double $hotel3
 * @property double $hotel4
 * @property double $hotel5
 * @property double $hotel6
 * @property double $cukai
 * @property double $lojing
 * @property double $teksi
 * @property int $resit_teksi
 * @property double $bas
 * @property int $resit_bas
 * @property double $keretapi
 * @property int $resit_keretapi
 * @property double $terbang
 * @property int $resit_terbang
 * @property double $feri
 * @property int $resit_feri
 * @property double $lain
 * @property int $resit_lain
 * @property double $tol
 * @property int $resit_tol
 * @property string $no_tg
 * @property double $pakir
 * @property int $resit_pakir
 * @property double $dobi
 * @property int $resit_dobi
 * @property double $pos
 * @property int $resit_pos
 * @property double $telefon
 * @property int $resit_telefon
 * @property double $tukaran
 * @property int $resit_tukaran
 * @property double $pendahuluan
 * @property int $tuntutan_lain
 * @property double $jumlah_tuntutan
 * @property double $jumlah_kew
 * @property int $status
 * @property int $cetak
 * @property string $catatan
 * @property int $user
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 *
 * @property Unjuran $kodUnjuran
 * @property PerjalananDetails[] $perjalananDetails
 * @property PerjalananHotel[] $perjalananHotels
 */
class Perjalanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perjalanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_unjuran', 'kod_id', 'id_jabatan', 'id_unit', 'nama', 'no_kp', 'no_hp', 'bulan', 'tahun', 'jawatan', 'no_gaji', 'gaji_asas', 'elaun', 'elaun_mangku', 'bank', 'cawangan_bank', 'akaun_bank', 'model_kereta', 'no_plate', 'cc', 'kelas_tuntutan', 'alamat_pejabat', 'alamat_rumah', 'jumlah_jarak', 'hotel6', 'jumlah_tuntutan', 'user', 'tarikh_kemaskini'], 'required'],
            [['id_jabatan', 'id_jabatan_asal', 'id_unit', 'cc', 'jumlah_jarak', 'jarak_telah_dituntut', 'kali_makan', 'kali_makan_sabah', 'kali_harian', 'kali_harian_sabah', 'kali_elaun_luar', 'kali_hotel', 'kali_hotel2', 'kali_hotel3', 'kali_hotel4', 'kali_hotel5', 'kali_hotel6', 'kali_lojing', 'resit_teksi', 'resit_bas', 'resit_keretapi', 'resit_terbang', 'resit_feri', 'resit_lain', 'resit_tol', 'resit_pakir', 'resit_dobi', 'resit_pos', 'resit_telefon', 'resit_tukaran', 'tuntutan_lain', 'status', 'cetak', 'user'], 'integer'],
            [['gaji_asas', 'elaun', 'elaun_mangku', 'elaun_makan', 'elaun_makan_sabah', 'elaun_harian', 'elaun_harian_sabah', 'elaun_luar', 'peratus_elaun_makan', 'peratus_elaun_makan_sabah', 'peratus_elaun_harian', 'peratus_elaun_harian_sabah', 'peratus_elaun_luar', 'hotel', 'hotel2', 'hotel3', 'hotel4', 'hotel5', 'hotel6', 'cukai', 'lojing', 'teksi', 'bas', 'keretapi', 'terbang', 'feri', 'lain', 'tol', 'pakir', 'dobi', 'pos', 'telefon', 'tukaran', 'pendahuluan', 'jumlah_tuntutan', 'jumlah_kew'], 'number'],
            [['catatan'], 'string'],
            [['tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['kod_unjuran', 'kod_id', 'no_tg'], 'string', 'max' => 10],
            [['nama', 'email'], 'string', 'max' => 100],
            [['no_kp', 'no_hp'], 'string', 'max' => 12],
            [['bulan'], 'string', 'max' => 2],
            [['tahun'], 'string', 'max' => 4],
            [['jawatan', 'model_kereta'], 'string', 'max' => 25],
            [['no_gaji', 'no_plate'], 'string', 'max' => 15],
            [['bank', 'cawangan_bank'], 'string', 'max' => 50],
            [['akaun_bank'], 'string', 'max' => 20],
            [['kelas_tuntutan'], 'string', 'max' => 1],
            [['alamat_pejabat', 'alamat_rumah'], 'string', 'max' => 150],
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
            'id_jabatan' => Yii::t('app', 'Id Jabatan'),
            'id_jabatan_asal' => Yii::t('app', 'Id Jabatan Asal'),
            'id_unit' => Yii::t('app', 'Id Unit'),
            'nama' => Yii::t('app', 'Nama'),
            'no_kp' => Yii::t('app', 'No Kp'),
            'no_hp' => Yii::t('app', 'No Hp'),
            'email' => Yii::t('app', 'Email'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'jawatan' => Yii::t('app', 'Jawatan'),
            'no_gaji' => Yii::t('app', 'No Gaji'),
            'gaji_asas' => Yii::t('app', 'Gaji Asas'),
            'elaun' => Yii::t('app', 'Elaun'),
            'elaun_mangku' => Yii::t('app', 'Elaun Mangku'),
            'bank' => Yii::t('app', 'Bank'),
            'cawangan_bank' => Yii::t('app', 'Cawangan Bank'),
            'akaun_bank' => Yii::t('app', 'Akaun Bank'),
            'model_kereta' => Yii::t('app', 'Model Kereta'),
            'no_plate' => Yii::t('app', 'No Plate'),
            'cc' => Yii::t('app', 'Cc'),
            'kelas_tuntutan' => Yii::t('app', 'Kelas Tuntutan'),
            'alamat_pejabat' => Yii::t('app', 'Alamat Pejabat'),
            'alamat_rumah' => Yii::t('app', 'Alamat Rumah'),
            'jumlah_jarak' => Yii::t('app', 'Jumlah Jarak'),
            'jarak_telah_dituntut' => Yii::t('app', 'Jarak Telah Dituntut'),
            'kali_makan' => Yii::t('app', 'Kali Makan'),
            'kali_makan_sabah' => Yii::t('app', 'Kali Makan Sabah'),
            'kali_harian' => Yii::t('app', 'Kali Harian'),
            'kali_harian_sabah' => Yii::t('app', 'Kali Harian Sabah'),
            'kali_elaun_luar' => Yii::t('app', 'Kali Elaun Luar'),
            'elaun_makan' => Yii::t('app', 'Elaun Makan'),
            'elaun_makan_sabah' => Yii::t('app', 'Elaun Makan Sabah'),
            'elaun_harian' => Yii::t('app', 'Elaun Harian'),
            'elaun_harian_sabah' => Yii::t('app', 'Elaun Harian Sabah'),
            'elaun_luar' => Yii::t('app', 'Elaun Luar'),
            'peratus_elaun_makan' => Yii::t('app', 'Peratus Elaun Makan'),
            'peratus_elaun_makan_sabah' => Yii::t('app', 'Peratus Elaun Makan Sabah'),
            'peratus_elaun_harian' => Yii::t('app', 'Peratus Elaun Harian'),
            'peratus_elaun_harian_sabah' => Yii::t('app', 'Peratus Elaun Harian Sabah'),
            'peratus_elaun_luar' => Yii::t('app', 'Peratus Elaun Luar'),
            'kali_hotel' => Yii::t('app', 'Kali Hotel'),
            'kali_hotel2' => Yii::t('app', 'Kali Hotel2'),
            'kali_hotel3' => Yii::t('app', 'Kali Hotel3'),
            'kali_hotel4' => Yii::t('app', 'Kali Hotel4'),
            'kali_hotel5' => Yii::t('app', 'Kali Hotel5'),
            'kali_hotel6' => Yii::t('app', 'Kali Hotel6'),
            'kali_lojing' => Yii::t('app', 'Kali Lojing'),
            'hotel' => Yii::t('app', 'Hotel'),
            'hotel2' => Yii::t('app', 'Hotel2'),
            'hotel3' => Yii::t('app', 'Hotel3'),
            'hotel4' => Yii::t('app', 'Hotel4'),
            'hotel5' => Yii::t('app', 'Hotel5'),
            'hotel6' => Yii::t('app', 'Hotel6'),
            'cukai' => Yii::t('app', 'Cukai'),
            'lojing' => Yii::t('app', 'Lojing'),
            'teksi' => Yii::t('app', 'Teksi'),
            'resit_teksi' => Yii::t('app', 'Resit Teksi'),
            'bas' => Yii::t('app', 'Bas'),
            'resit_bas' => Yii::t('app', 'Resit Bas'),
            'keretapi' => Yii::t('app', 'Keretapi'),
            'resit_keretapi' => Yii::t('app', 'Resit Keretapi'),
            'terbang' => Yii::t('app', 'Terbang'),
            'resit_terbang' => Yii::t('app', 'Resit Terbang'),
            'feri' => Yii::t('app', 'Feri'),
            'resit_feri' => Yii::t('app', 'Resit Feri'),
            'lain' => Yii::t('app', 'Lain'),
            'resit_lain' => Yii::t('app', 'Resit Lain'),
            'tol' => Yii::t('app', 'Tol'),
            'resit_tol' => Yii::t('app', 'Resit Tol'),
            'no_tg' => Yii::t('app', 'No Tg'),
            'pakir' => Yii::t('app', 'Pakir'),
            'resit_pakir' => Yii::t('app', 'Resit Pakir'),
            'dobi' => Yii::t('app', 'Dobi'),
            'resit_dobi' => Yii::t('app', 'Resit Dobi'),
            'pos' => Yii::t('app', 'Pos'),
            'resit_pos' => Yii::t('app', 'Resit Pos'),
            'telefon' => Yii::t('app', 'Telefon'),
            'resit_telefon' => Yii::t('app', 'Resit Telefon'),
            'tukaran' => Yii::t('app', 'Tukaran'),
            'resit_tukaran' => Yii::t('app', 'Resit Tukaran'),
            'pendahuluan' => Yii::t('app', 'Pendahuluan'),
            'tuntutan_lain' => Yii::t('app', 'Tuntutan Lain'),
            'jumlah_tuntutan' => Yii::t('app', 'Jumlah Tuntutan'),
            'jumlah_kew' => Yii::t('app', 'Jumlah Kew'),
            'status' => Yii::t('app', 'Status'),
            'cetak' => Yii::t('app', 'Cetak'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerjalananDetails()
    {
        return $this->hasMany(PerjalananDetails::className(), ['id_perjalanan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerjalananHotels()
    {
        return $this->hasMany(PerjalananHotel::className(), ['id_perjalanan' => 'id']);
    }
}
