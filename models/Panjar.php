<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "panjar".
 *
 * @property int $id
 * @property int $id_perolehan
 * @property string $sambungan
 * @property double $jumlah_panjar
 * @property string $tujuan
 * @property string $jawatan
 * @property string $tarikh_jadi
 *
 * @property Perolehan $perolehan
 */
class Panjar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'panjar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perolehan', 'sambungan', 'jumlah_panjar', 'tujuan', 'jawatan'], 'required'],
            [['id_perolehan'], 'integer'],
            [['jumlah_panjar'], 'number'],
            [['tujuan'], 'string'],
            [['tarikh_jadi'], 'safe'],
            [['sambungan', 'jawatan'], 'string', 'max' => 10],
            [['id_perolehan'], 'exist', 'skipOnError' => true, 'targetClass' => Perolehan::className(), 'targetAttribute' => ['id_perolehan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_perolehan' => Yii::t('app', 'Id Perolehan'),
            'sambungan' => Yii::t('app', 'Sambungan'),
            'jumlah_panjar' => Yii::t('app', 'Jumlah Panjar'),
            'tujuan' => Yii::t('app', 'Tujuan'),
            'jawatan' => Yii::t('app', 'Jawatan'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerolehan()
    {
        return $this->hasOne(Perolehan::className(), ['id' => 'id_perolehan']);
    }
}
