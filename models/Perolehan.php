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
 * @property double $lulus_perolehan
 * @property int $status_kewangan
 * @property string $tarikh_lulus2
 * @property string $nolo
 * @property string $tarikhlo
 * @property string $novoucher
 * @property string $tarikh_voucher
 * @property double $nilai_perolehan
 * @property string $catatan2
 * @property int $tahun
 * @property string $user
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 *
 * @property Barangan[] $barangans
 * @property Pembekal[] $pembekals
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
            [['id_jabatan', 'id_jabatan_asal', 'id_unit', 'jenis_perolehan', 'kaedah_pembayaran', 'kontrak_pusat', 'id_syarikat', 'status', 'status_kewangan', 'tahun'], 'integer'],
            [['tarikh_lulus1', 'tarikh_lulus2', 'tarikhlo', 'tarikh_voucher', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['catatan1', 'catatan2'], 'string'],
            [['lulus_perolehan', 'nilai_perolehan'], 'number'],
            [['kod_id', 'kod_unjuran'], 'string', 'max' => 10],
            [['nolo', 'novoucher'], 'string', 'max' => 20],
            [['user'], 'string', 'max' => 30],
            [['kod_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kod_id' => 'Kod ID',
            'kod_unjuran' => 'Kod Unjuran',
            'id_jabatan' => 'Id Jabatan',
            'id_jabatan_asal' => 'Id Jabatan Asal',
            'id_unit' => 'Id Unit',
            'jenis_perolehan' => 'Jenis Perolehan',
            'kaedah_pembayaran' => 'Kaedah Pembayaran',
            'kontrak_pusat' => 'Kontrak Pusat',
            'id_syarikat' => 'Id Syarikat',
            'status' => 'Status',
            'tarikh_lulus1' => 'Tarikh Lulus1',
            'catatan1' => 'Catatan1',
            'lulus_perolehan' => 'Lulus Perolehan',
            'status_kewangan' => 'Status Kewangan',
            'tarikh_lulus2' => 'Tarikh Lulus2',
            'nolo' => 'Nolo',
            'tarikhlo' => 'Tarikhlo',
            'novoucher' => 'Novoucher',
            'tarikh_voucher' => 'Tarikh Voucher',
            'nilai_perolehan' => 'Nilai Perolehan',
            'catatan2' => 'Catatan2',
            'tahun' => 'Tahun',
            'user' => 'User',
            'tarikh_jadi' => 'Tarikh Jadi',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
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
    public function getPembekals()
    {
        return $this->hasMany(Pembekal::className(), ['id_perolehan' => 'id']);
    }

    public function getJabatan()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'id_jabatan']);
    }
}
