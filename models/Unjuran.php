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
 */
class Unjuran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unjuran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['os', 'id_jabatan', 'butiran', 'kod', 'jumlah_unjuran', 'tahun'], 'required'],
            [['id_jabatan', 'id_unit', 'kuantiti', 'public', 'status', 'sah', 'user'], 'integer'],
            [['butiran', 'catatan'], 'string'],
            [['jumlah_unjuran'], 'number'],
            [['tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['kod_id'], 'string', 'max' => 10],
            [['os'], 'string', 'max' => 16],
            [['ol'], 'string', 'max' => 50],
            [['kod'], 'string', 'max' => 1],
            [['kongsi'], 'string', 'max' => 30],
            [['tahun'], 'string', 'max' => 4],
            [['kod_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kod_id' => 'Kod ID',
            'os' => 'Os',
            'ol' => 'Ol',
            'id_jabatan' => 'Id Jabatan',
            'id_unit' => 'Id Unit',
            'butiran' => 'Butiran',
            'kuantiti' => 'Kuantiti',
            'kod' => 'Kod',
            'jumlah_unjuran' => 'Jumlah Unjuran',
            'kongsi' => 'Kongsi',
            'public' => 'Public',
            'tahun' => 'Tahun',
            'catatan' => 'Catatan',
            'status' => 'Status',
            'sah' => 'Sah',
            'tarikh_jadi' => 'Tarikh Jadi',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
            'user' => 'User',
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
}
