<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perjalanan_hotel".
 *
 * @property int $id
 * @property int $id_perjalanan
 * @property int $kali_hotel
 * @property double $kos_hotel
 *
 * @property Perjalanan $perjalanan
 */
class PerjalananHotel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perjalanan_hotel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perjalanan', 'kali_hotel', 'kos_hotel'], 'required'],
            [['id_perjalanan', 'kali_hotel'], 'integer'],
            [['kos_hotel'], 'number'],
            [['id_perjalanan'], 'exist', 'skipOnError' => true, 'targetClass' => Perjalanan::className(), 'targetAttribute' => ['id_perjalanan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_perjalanan' => Yii::t('app', 'Id Perjalanan'),
            'kali_hotel' => Yii::t('app', 'Kali Hotel'),
            'kos_hotel' => Yii::t('app', 'Kos Hotel'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerjalanan()
    {
        return $this->hasOne(Perjalanan::className(), ['id' => 'id_perjalanan']);
    }
}
