<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penceramah_details".
 *
 * @property int $id
 * @property int $id_penceramah
 * @property string $nama_ceramah
 * @property string $tarikh
 * @property double $tempoh
 * @property double $jumlah
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
            [['id_penceramah', 'nama_ceramah', 'tarikh', 'tempoh'], 'required'],
            [['id_penceramah'], 'integer'],
            [['tarikh'], 'safe'],
            [['tempoh', 'jumlah'], 'number'],
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
            'id_penceramah' => Yii::t('app', 'Id Penceramah'),
            'nama_ceramah' => Yii::t('app', 'Nama Ceramah'),
            'tarikh' => Yii::t('app', 'Tarikh'),
            'tempoh' => Yii::t('app', 'Tempoh'),
            'jumlah' => Yii::t('app', 'Jumlah'),
        ];
    }
}
