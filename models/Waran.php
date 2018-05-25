<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "waran".
 *
 * @property int $id
 * @property string $no_waran
 * @property string $tarikh_waran
 * @property int $status_waran
 * @property string $tahun
 * @property string $os
 * @property double $jumlah_waran
 * @property string $catatan
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 * @property int $user
 */
class Waran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'waran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_waran', 'tarikh_waran', 'tahun', 'os', 'jumlah_waran', 'user'], 'required'],
            [['tarikh_waran', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['status_waran', 'user'], 'integer'],
            [['jumlah_waran'], 'number'],
            [['catatan'], 'string'],
            [['no_waran'], 'string', 'max' => 15],
            [['tahun'], 'string', 'max' => 4],
            [['os'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_waran' => 'No Waran',
            'tarikh_waran' => 'Tarikh Waran',
            'status_waran' => 'Status Waran',
            'tahun' => 'Tahun',
            'os' => 'OS',
            'jumlah_waran' => 'Jumlah Waran',
            'catatan' => 'Catatan',
            'tarikh_jadi' => 'Tarikh Jadi',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
            'user' => 'User',
        ];
    }
}
