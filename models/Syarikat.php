<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "syarikat".
 *
 * @property int $id
 * @property string $kod
 * @property string $nama_syarikat
 * @property string $alamat
 * @property string $nama_pengurus
 * @property string $no_telefon
 * @property string $no_faks
 * @property string $emel
 * @property string $cawangan_bank
 * @property string $no_akaun
 * @property string $no_rujukan
 * @property string $tarikh_daftar
 * @property string $pkk
 * @property string $kelas_F1
 * @property string $kelas_F2
 * @property string $kelas_F3
 * @property string $kelas_F4
 * @property string $kelas_F5
 * @property string $kelas_F6
 * @property string $kelas_F7
 * @property string $kew
 * @property string $tarikh_luput_kew
 * @property string $kod_kepala0
 * @property string $kod_kepala1
 * @property string $kod_kepala2
 * @property int $terima
 * @property string $cidb
 * @property string $pkk_elektrik
 * @property string $kepala_sub_kepala
 * @property string $kod_cukai GST, SST
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 * @property int $user
 */
class Syarikat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'syarikat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod', 'nama_syarikat', 'alamat', 'nama_pengurus', 'no_telefon', 'cawangan_bank', 'no_akaun', 'no_rujukan', 'tarikh_daftar', 'user'], 'required'],
            [['alamat'], 'string'],
            [['tarikh_daftar', 'tarikh_luput_kew', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['terima', 'user'], 'integer'],
            [['kod'], 'string', 'max' => 6],
            [['nama_syarikat'], 'string', 'max' => 200],
            [['nama_pengurus', 'emel', 'cawangan_bank', 'kod_kepala0', 'kod_kepala1', 'kod_kepala2'], 'string', 'max' => 100],
            [['no_telefon'], 'string', 'max' => 30],
            [['no_faks', 'no_akaun'], 'string', 'max' => 20],
            [['no_rujukan', 'pkk', 'kelas_F2', 'kelas_F3', 'kelas_F4', 'kelas_F5', 'kelas_F6', 'kelas_F7', 'kew', 'pkk_elektrik', 'kepala_sub_kepala', 'kod_cukai'], 'string', 'max' => 50],
            [['kelas_F1'], 'string', 'max' => 11],
            [['cidb'], 'string', 'max' => 25],
            ['emel', 'email'],
            [['kod'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kod' => Yii::t('app', 'Kod'),
            'nama_syarikat' => Yii::t('app', 'Nama Syarikat'),
            'alamat' => Yii::t('app', 'Alamat'),
            'nama_pengurus' => Yii::t('app', 'Nama Pengurus'),
            'no_telefon' => Yii::t('app', 'No Telefon'),
            'no_faks' => Yii::t('app', 'No Faks'),
            'emel' => Yii::t('app', 'Emel'),
            'cawangan_bank' => Yii::t('app', 'Cawangan Bank'),
            'no_akaun' => Yii::t('app', 'No Akaun'),
            'no_rujukan' => Yii::t('app', 'No Rujukan'),
            'tarikh_daftar' => Yii::t('app', 'Tarikh Daftar'),
            'pkk' => Yii::t('app', 'Pkk'),
            'kelas_F1' => Yii::t('app', 'Kelas  F1'),
            'kelas_F2' => Yii::t('app', 'Kelas  F2'),
            'kelas_F3' => Yii::t('app', 'Kelas  F3'),
            'kelas_F4' => Yii::t('app', 'Kelas  F4'),
            'kelas_F5' => Yii::t('app', 'Kelas  F5'),
            'kelas_F6' => Yii::t('app', 'Kelas  F6'),
            'kelas_F7' => Yii::t('app', 'Kelas  F7'),
            'kew' => Yii::t('app', 'Kew'),
            'tarikh_luput_kew' => Yii::t('app', 'Tarikh Luput Kew'),
            'kod_kepala0' => Yii::t('app', 'Kod Kepala0'),
            'kod_kepala1' => Yii::t('app', 'Kod Kepala1'),
            'kod_kepala2' => Yii::t('app', 'Kod Kepala2'),
            'terima' => Yii::t('app', 'Terima'),
            'cidb' => Yii::t('app', 'Cidb'),
            'pkk_elektrik' => Yii::t('app', 'Pkk Elektrik'),
            'kepala_sub_kepala' => Yii::t('app', 'Kepala Sub Kepala'),
            'kod_cukai' => Yii::t('app', 'Kod Cukai'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
            'tarikh_kemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
            'user' => Yii::t('app', 'User'),
        ];
    }
}
