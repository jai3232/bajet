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
 *
 * @property Perolehan $perolehan
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
            [['id_perolehan'], 'exist', 'skipOnError' => true, 'targetClass' => Perolehan::className(), 'targetAttribute' => ['id_perolehan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_perolehan' => 'Id Perolehan',
            'justifikasi' => 'Justifikasi',
            'kuantiti' => 'Kuantiti',
            'tarikh_jadi' => 'Tarikh Jadi',
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
