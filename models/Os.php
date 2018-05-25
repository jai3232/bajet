<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "os".
 *
 * @property int $id
 * @property string $os
 * @property string $butiran
 */
class Os extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['os'], 'required'],
            [['os'], 'string', 'max' => 20],
            [['butiran'], 'string', 'max' => 100],
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
            'butiran' => 'Butiran',
        ];
    }
}
