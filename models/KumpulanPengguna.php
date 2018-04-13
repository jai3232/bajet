<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kumpulan_pengguna".
 *
 * @property int $id
 * @property string $nama
 * @property string $butiran
 */
class KumpulanPengguna extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kumpulan_pengguna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'butiran'], 'required'],
            [['nama'], 'string', 'max' => 10],
            [['butiran'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama'),
            'butiran' => Yii::t('app', 'Butiran'),
        ];
    }
}
