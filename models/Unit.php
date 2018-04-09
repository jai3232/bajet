<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property int $jabatan
 * @property string $unit
 *
 * @property Jabatan $jabatan0
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan', 'unit'], 'required'],
            [['jabatan'], 'integer'],
            [['unit'], 'string', 'max' => 30],
            [['unit'], 'unique'],
            [['jabatan'], 'exist', 'skipOnError' => true, 'targetClass' => Jabatan::className(), 'targetAttribute' => ['jabatan' => 'id']],
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
            'unit' => 'Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatan0()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'jabatan']);
    }
}
