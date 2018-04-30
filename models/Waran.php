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
 * @property string $tarikh
 * @property string $user
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
            [['tarikh_waran', 'tarikh'], 'safe'],
            [['status_waran'], 'integer'],
            [['jumlah_waran'], 'number'],
            [['catatan'], 'string'],
            [['no_waran'], 'string', 'max' => 15],
            [['tahun'], 'string', 'max' => 4],
            [['os'], 'string', 'max' => 16],
            [['user'], 'string', 'max' => 30],
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
            'tarikh' => 'Tarikh',
            'user' => 'User',
        ];
    }
}
