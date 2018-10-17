<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penceramah_details".
 *
 * @property int $id
 * @property string $kod_penceramah
 * @property string $nama_ceramah
 * @property string $tarikh
 * @property int $tempoh
 * @property double $tuntutan
 */
class PenceramahDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penceramah_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_penceramah', 'nama_ceramah', 'tarikh', 'tempoh'], 'required'],
            [['tarikh'], 'safe'],
            [['tempoh'], 'integer'],
            [['tuntutan'], 'number'],
            [['kod_penceramah'], 'string', 'max' => 8],
            [['nama_ceramah'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kod_penceramah' => Yii::t('app', 'Kod Penceramah'),
            'nama_ceramah' => Yii::t('app', 'Nama Ceramah'),
            'tarikh' => Yii::t('app', 'Tarikh'),
            'tempoh' => Yii::t('app', 'Tempoh'),
            'tuntutan' => Yii::t('app', 'Tuntutan'),
        ];
    }
}
