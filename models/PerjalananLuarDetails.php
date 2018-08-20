<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perjalanan_luar_details".
 *
 * @property int $id
 * @property int $id_perjalanan
 * @property string $dari
 * @property string $tarikh_bertolak
 * @property string $waktu_bertolak
 * @property string $destinasi
 * @property string $tarikh_sampai
 * @property string $waktu_sampai
 * @property string $tujuan_lawatan
 * @property int $kali_elaun_makan
 * @property double $elaun_makan
 * @property double $peratus_elaun_makan
 * @property int $kali_elaun_harian
 * @property double $elaun_harian
 * @property double $peratus_elaun_harian
 * @property int $kali_hotel
 * @property double $kos_hotel
 * @property double $cukai_hotel
 * @property int $kali_lojing
 * @property double $lojing
 * @property double $dobi
 * @property int $resit_dobi
 * @property double $pos
 * @property int $resit_pos
 * @property double $telefon
 * @property int $resit_telefon
 * @property double $porterage
 * @property double $cukai_airport
 * @property int $resit_cukai_airport
 * @property double $keraian
 * @property int $resit_keraian
 * @property double $tambang_kenderaan
 * @property int $resit_tambang_kenderaan
 */
class PerjalananLuarDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perjalanan_luar_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perjalanan', 'dari', 'tarikh_bertolak', 'waktu_bertolak', 'destinasi', 'tarikh_sampai', 'waktu_sampai', 'tujuan_lawatan'], 'required'],
            [['id_perjalanan', 'kali_elaun_makan', 'kali_elaun_harian', 'kali_hotel', 'kali_lojing', 'resit_dobi', 'resit_pos', 'resit_telefon', 'resit_cukai_airport', 'resit_keraian', 'resit_tambang_kenderaan'], 'integer'],
            [['tarikh_bertolak', 'waktu_bertolak', 'tarikh_sampai', 'waktu_sampai'], 'safe'],
            [['elaun_makan', 'peratus_elaun_makan', 'elaun_harian', 'peratus_elaun_harian', 'kos_hotel', 'cukai_hotel', 'lojing', 'dobi', 'pos', 'telefon', 'porterage', 'cukai_airport', 'keraian', 'tambang_kenderaan'], 'number'],
            [['dari', 'destinasi'], 'string', 'max' => 50],
            [['tujuan_lawatan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_perjalanan' => Yii::t('app', 'Id Perjalanan'),
            'dari' => Yii::t('app', 'Dari'),
            'tarikh_bertolak' => Yii::t('app', 'Tarikh Bertolak'),
            'waktu_bertolak' => Yii::t('app', 'Waktu Bertolak'),
            'destinasi' => Yii::t('app', 'Destinasi'),
            'tarikh_sampai' => Yii::t('app', 'Tarikh Sampai'),
            'waktu_sampai' => Yii::t('app', 'Waktu Sampai'),
            'tujuan_lawatan' => Yii::t('app', 'Tujuan Lawatan'),
            'kali_elaun_makan' => Yii::t('app', 'Kali Elaun Makan'),
            'elaun_makan' => Yii::t('app', 'Elaun Makan'),
            'peratus_elaun_makan' => Yii::t('app', 'Peratus Elaun Makan'),
            'kali_elaun_harian' => Yii::t('app', 'Kali Elaun Harian'),
            'elaun_harian' => Yii::t('app', 'Elaun Harian'),
            'peratus_elaun_harian' => Yii::t('app', 'Peratus Elaun Harian'),
            'kali_hotel' => Yii::t('app', 'Kali Hotel'),
            'kos_hotel' => Yii::t('app', 'Kos Hotel'),
            'cukai_hotel' => Yii::t('app', 'Cukai Hotel'),
            'kali_lojing' => Yii::t('app', 'Kali Lojing'),
            'lojing' => Yii::t('app', 'Lojing'),
            'dobi' => Yii::t('app', 'Dobi'),
            'resit_dobi' => Yii::t('app', 'Resit Dobi'),
            'pos' => Yii::t('app', 'Pos'),
            'resit_pos' => Yii::t('app', 'Resit Pos'),
            'telefon' => Yii::t('app', 'Telefon'),
            'resit_telefon' => Yii::t('app', 'Resit Telefon'),
            'porterage' => Yii::t('app', 'Porterage'),
            'cukai_airport' => Yii::t('app', 'Cukai Airport'),
            'resit_cukai_airport' => Yii::t('app', 'Resit Cukai Airport'),
            'keraian' => Yii::t('app', 'Keraian'),
            'resit_keraian' => Yii::t('app', 'Resit Keraian'),
            'tambang_kenderaan' => Yii::t('app', 'Tambang Kenderaan'),
            'resit_tambang_kenderaan' => Yii::t('app', 'Resit Tambang Kenderaan'),
        ];
    }
}
