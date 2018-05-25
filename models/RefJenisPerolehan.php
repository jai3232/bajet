<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_jenis_perolehan".
 *
 * @property int $id
 * @property string $jenis
 */
class RefJenisPerolehan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_jenis_perolehan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis'], 'required'],
            [['jenis'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'jenis' => Yii::t('app', 'Jenis'),
        ];
    }
}
