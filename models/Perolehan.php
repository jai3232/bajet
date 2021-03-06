<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perolehan".
 *
 * @property int $id
 * @property string $kod_id
 * @property string $kod_unjuran
 * @property int $id_jabatan
 * @property int $id_jabatan_asal
 * @property int $id_unit
 * @property int $jenis_perolehan
 * @property int $kaedah_pembayaran
 * @property int $kontrak_pusat
 * @property int $id_syarikat
 * @property int $status Status kelulusan oleh JK Perolehan PPL
 * @property string $tarikh_lulus1
 * @property string $catatan1
 * @property double $nilai_permohonan
 * @property int $status_kewangan
 * @property string $tarikh_lulus2
 * @property string $nolo
 * @property string $tarikhlo
 * @property string $novoucher
 * @property string $tarikh_voucher
 * @property double $nilai_perolehan
 * @property string $catatan2
 * @property string $tahun
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 * @property int $user
 *
 * @property Barangan[] $barangans
 * @property Panjar[] $panjars
 * @property Pembekal[] $pembekals
 * @property Unjuran $kodUnjuran
 */
class Perolehan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perolehan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_id', 'kod_unjuran', 'id_jabatan', 'id_unit', 'jenis_perolehan', 'kaedah_pembayaran', 'tahun', 'user'], 'required'],
            [['id_jabatan', 'id_jabatan_asal', 'id_unit', 'jenis_perolehan', 'kaedah_pembayaran', 'kontrak_pusat', 'id_syarikat', 'status', 'status_kewangan', 'user'], 'integer'],
            [['tarikh_lulus1', 'tarikh_lulus2', 'tarikhlo', 'tarikh_voucher', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['catatan1', 'catatan2'], 'string'],
            [['nilai_permohonan', 'nilai_perolehan'], 'number'],
            [['kod_id', 'kod_unjuran'], 'string', 'max' => 10],
            [['nolo', 'novoucher'], 'string', 'max' => 20],
            [['tahun'], 'string', 'max' => 4],
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
            'kod_id' => Yii::t('app', 'Kod ID'),
            'kod_unjuran' => Yii::t('app', 'Kod Unjuran'),
            'id_jabatan' => Yii::t('app', 'Id Jabatan'),
            'id_jabatan_asal' => Yii::t('app', 'Id Jabatan Asal'),
            'id_unit' => Yii::t('app', 'Id Unit'),
            'jenis_perolehan' => Yii::t('app', 'Jenis Perolehan'),
            'kaedah_pembayaran' => Yii::t('app', 'Kaedah Pembayaran'),
            'kontrak_pusat' => Yii::t('app', 'Kontrak Pusat'),
            'id_syarikat' => Yii::t('app', 'Id Syarikat'),
            'status' => Yii::t('app', 'Status'),
            'tarikh_lulus1' => Yii::t('app', 'Tarikh Lulus1'),
            'catatan1' => Yii::t('app', 'Catatan1'),
            'nilai_permohonan' => Yii::t('app', 'Nilai Permohonan'),
            'status_kewangan' => Yii::t('app', 'Status Kewangan'),
            'tarikh_lulus2' => Yii::t('app', 'Tarikh Lulus2'),
            'nolo' => Yii::t('app', 'Nolo'),
            'tarikhlo' => Yii::t('app', 'Tarikhlo'),
            'novoucher' => Yii::t('app', 'Novoucher'),
            'tarikh_voucher' => Yii::t('app', 'Tarikh Voucher'),
            'nilai_perolehan' => Yii::t('app', 'Nilai Perolehan'),
            'catatan2' => Yii::t('app', 'Catatan2'),
            'tahun' => Yii::t('app', 'Tahun'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
            'tarikh_kemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
            'user' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangans()
    {
        return $this->hasMany(Barangan::className(), ['id_perolehan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanjars()
    {
        return $this->hasMany(Panjar::className(), ['id_perolehan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPembekals()
    {
        return $this->hasMany(Pembekal::className(), ['id_perolehan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodUnjuran()
    {
        return $this->hasOne(Unjuran::className(), ['kod_id' => 'kod_unjuran']);
    }

    public function getJabatan()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'id_jabatan']);
    }

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'id_unit']);
    }

     public function getPengguna()
    {
        return $this->hasOne(Pengguna::className(), ['id' => 'user']);
    }
}