<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ot_details".
 *
 * @property int $id
 * @property int $id_ot
 * @property string $tarikh
 * @property string $hari
 * @property string $kod_hari
 * @property int $kod_waktu
 * @property int $waktu_pejabat
 * @property string $ot_mula
 * @property string $ot_akhir
 * @property double $jam_layak
 * @property int $rujukan
 * @property string $butiran
 * @property string $date
 *
 * @property Ot $ot
 */
class OtDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ot_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ot', 'tarikh', 'hari', 'kod_hari', 'kod_waktu', 'waktu_pejabat', 'ot_mula', 'ot_akhir', 'jam_layak'], 'required'],
            [['id_ot', 'kod_waktu', 'waktu_pejabat', 'rujukan'], 'integer'],
            [['tarikh', 'ot_mula', 'ot_akhir', 'date'], 'safe'],
            [['jam_layak'], 'number'],
            [['butiran'], 'string'],
            [['hari'], 'string', 'max' => 6],
            [['kod_hari'], 'string', 'max' => 1],
            [['id_ot'], 'exist', 'skipOnError' => true, 'targetClass' => Ot::className(), 'targetAttribute' => ['id_ot' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_ot' => Yii::t('app', 'Id Ot'),
            'tarikh' => Yii::t('app', 'Tarikh'),
            'hari' => Yii::t('app', 'Hari'),
            'kod_hari' => Yii::t('app', 'Kod Hari'),
            'kod_waktu' => Yii::t('app', 'Kod Waktu'),
            'waktu_pejabat' => Yii::t('app', 'Waktu Pejabat'),
            'ot_mula' => Yii::t('app', 'Ot Mula'),
            'ot_akhir' => Yii::t('app', 'Ot Akhir'),
            'jam_layak' => Yii::t('app', 'Jam Layak'),
            'rujukan' => Yii::t('app', 'Rujukan'),
            'butiran' => Yii::t('app', 'Butiran'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOt()
    {
        return $this->hasOne(Ot::className(), ['id' => 'id_ot']);
    }
}
