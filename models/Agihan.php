<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agihan".
 *
 * @property int $id
 * @property string $os
 * @property double $agihan_jabatan
 * @property double $baki
 * @property string $tahun
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 * @property int $user
 */
class Agihan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agihan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['os', 'agihan_jabatan', 'baki', 'tahun', 'user'], 'required'],
            [['agihan_jabatan', 'baki'], 'number'],
            [['tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['user'], 'integer'],
            [['os'], 'string', 'max' => 16],
            [['tahun'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'os' => 'Os',
            'agihan_jabatan' => 'Agihan Jabatan',
            'baki' => 'Baki',
            'tahun' => 'Tahun',
            'tarikh_jadi' => 'Tarikh Jadi',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
            'user' => 'User',
        ];
    }
}
