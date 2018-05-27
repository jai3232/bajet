<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perbelanjaan".
 *
 * @property int $id
 * @property string $kod_unjuran
 * @property string $butiran
 * @property string $tarikh_jadi
 */
class Perbelanjaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perbelanjaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_unjuran', 'butiran'], 'required'],
            [['butiran'], 'string'],
            [['tarikh_jadi'], 'safe'],
            [['kod_unjuran'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kod_unjuran' => Yii::t('app', 'Kod Unjuran'),
            'butiran' => Yii::t('app', 'Butiran'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
        ];
    }
}
