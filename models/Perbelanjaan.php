<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perbelanjaan".
 *
 * @property int $id
 * @property string $kod_id
 * @property string $bulan
 * @property string $kod_unjuran
 * @property string $butiran
 * @property double $jumlah_bayaran
 * @property string $tarikh_jadi
 * @property string $tarikh_kemaskini
 * @property int $user
 *
 * @property Unjuran $kodUnjuran
 */
class Perbelanjaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perbelanjaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_id', 'bulan', 'kod_unjuran', 'butiran', 'jumlah_bayaran', 'user'], 'required'],
            [['butiran'], 'string'],
            [['jumlah_bayaran'], 'number'],
            [['tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['user'], 'integer'],
            [['kod_id', 'kod_unjuran'], 'string', 'max' => 10],
            [['bulan'], 'string', 'max' => 2],
            [['kod_id'], 'unique'],
            [['kod_unjuran'], 'exist', 'skipOnError' => true, 'targetClass' => Unjuran::className(), 'targetAttribute' => ['kod_unjuran' => 'kod_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kod_id' => Yii::t('app', 'Kod ID'),
            'bulan' => Yii::t('app', 'Bulan'),
            'kod_unjuran' => Yii::t('app', 'Kod Unjuran'),
            'butiran' => Yii::t('app', 'Butiran'),
            'jumlah_bayaran' => Yii::t('app', 'Jumlah Bayaran'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
            'tarikh_kemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
            'user' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodUnjuran()
    {
        return $this->hasOne(Unjuran::className(), ['kod_id' => 'kod_unjuran']);
    }
}
