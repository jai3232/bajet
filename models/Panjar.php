<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "panjar".
 *
 * @property int $id
 * @property int $id_perolehan
 * @property int $sambungan
 * @property double $jumlah_panjar
 * @property string $tujuan
 * @property string $nama_pemohon
 * @property string $jawatan
 * @property string $tarikh_jadi
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
            [['id_perolehan', 'sambungan', 'jumlah_panjar', 'tujuan', 'nama_pemohon', 'jawatan'], 'required'],
            [['id_perolehan', 'sambungan'], 'integer'],
            [['jumlah_panjar'], 'number'],
            [['tujuan'], 'string'],
            [['tarikh_jadi'], 'safe'],
            [['nama_pemohon'], 'string', 'max' => 50],
            [['jawatan'], 'string', 'max' => 10],
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
            'nama_pemohon' => Yii::t('app', 'Nama Pemohon'),
            'jawatan' => Yii::t('app', 'Jawatan'),
            'tarikh_jadi' => Yii::t('app', 'Tarikh Jadi'),
        ];
    }
}
