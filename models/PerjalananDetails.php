<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perjalanan_details".
 *
 * @property int $id
 * @property int $id_perjalanan
 * @property string $tarikh
 * @property string $bertolak
 * @property string $sampai
 * @property string $tujuan
 * @property int $jarak
 * @property double $kos
 *
 * @property Perjalanan $perjalanan
 */
class PerjalananDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perjalanan_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perjalanan', 'tarikh', 'bertolak', 'sampai', 'tujuan'], 'required'],
            [['id_perjalanan', 'jarak'], 'integer'],
            [['tarikh', 'bertolak', 'sampai'], 'safe'],
            [['tujuan'], 'string'],
            [['kos'], 'number'],
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
            'tarikh' => Yii::t('app', 'Tarikh'),
            'bertolak' => Yii::t('app', 'Bertolak'),
            'sampai' => Yii::t('app', 'Sampai'),
            'tujuan' => Yii::t('app', 'Tujuan'),
            'jarak' => Yii::t('app', 'Jarak'),
            'kos' => Yii::t('app', 'Kos'),
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
