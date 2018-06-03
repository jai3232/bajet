<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perbelanjaan;
use app\models\Pengguna;

/**
 * PerbelanjaanSearch represents the model behind the search form of `app\models\Perbelanjaan`.
 */
class PerbelanjaanSearch extends Perbelanjaan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bulan'], 'integer'],
            [['kod_id', 'kod_unjuran', 'butiran', 'tarikh_jadi', 'tarikh_kemaskini', 'user'], 'safe'],
            [['jumlah_bayaran'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Perbelanjaan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id'=>SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(!isset($this->bulan))
            $this->bulan = date('m');

        // grid filtering conditions

        if(isset($this->tarikh_jadi) && $this->tarikh_jadi != '')
            $query->andFilterWhere(['Date(tarikh_jadi)' => Yii::$app->formatter->asDate($this->tarikh_jadi, 'Y-MM-dd')]);
            // $query->andFilterWhere(['Date(perolehan.tarikh_jadi)' => Yii::$app->formatter->asDate($this->tarikh_jadi, 'Y-MM-dd')]);

        $query->andFilterWhere([
            'id' => $this->id,
            'bulan' => $this->bulan,
            'jumlah_bayaran' => $this->jumlah_bayaran,
            // 'Date(tarikh_jadi)' => Yii::$app->formatter->asDate($this->tarikh_jadi, 'Y-MM-dd')    ,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
            'user' => Pengguna::find()->where(['like', 'nama', '%'.$this->user.'%', false])->one()->id,
        ]);

        $query->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'kod_unjuran', $this->kod_unjuran])
            ->andFilterWhere(['like', 'butiran', $this->butiran]);

        return $dataProvider;
    }
}
