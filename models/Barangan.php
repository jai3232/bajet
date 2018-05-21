<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barangan".
 *
 * @property int $id
 * @property int $id_perolehan
 * @property string $justifikasi
 * @property int $kuantiti
 * @property string $tarikh_jadi
 */
class Barangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perolehan'], 'required'],
            [['id_perolehan', 'kuantiti'], 'integer'],
            [['justifikasi'], 'string'],
            [['tarikh_jadi'], 'safe'],
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
            'justifikasi' => Yii::t('app', 'Justifikasi'),
            'kuantiti' => Yii::t('app', 'Kuantiti'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
        ];
    }
}
