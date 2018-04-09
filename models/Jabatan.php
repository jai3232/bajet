<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jabatan".
 *
 * @property int $id
 * @property string $jabatan
 * @property string $ringkasan
 *
 * @property Unit[] $units
 */
class Jabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan'], 'required'],
            [['jabatan'], 'string', 'max' => 50],
            [['ringkasan'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jabatan' => 'Jabatan',
            'ringkasan' => 'Ringkasan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::className(), ['jabatan' => 'id']);
    }
}
