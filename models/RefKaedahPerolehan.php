<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kaedah_perolehan".
 *
 * @property int $id
 * @property string $kaedah
 */
class RefKaedahPerolehan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_kaedah_perolehan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kaedah'], 'required'],
            [['kaedah'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kaedah' => Yii::t('app', 'Kaedah'),
        ];
    }
}
