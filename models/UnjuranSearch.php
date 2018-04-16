<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Unjuran;

/**
 * UnjuranSearch represents the model behind the search form of `app\models\Unjuran`.
 */
class UnjuranSearch extends Unjuran
{
    /**
     * @inheritdoc
     */
    public $jabatan, $unit;

    public function rules()
    {
        return [
            [['id', 'kuantiti', 'public', 'status', 'user'], 'integer'],
            [['kod_id', 'os', 'ol', 'butiran', 'kod', 'kongsi', 'tahun', 'catatan', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['jumlah_unjuran'], 'number'],
            [['jabatan', 'unit', 'id_jabatan', 'id_unit'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Unjuran::find()->joinWith(['jabatan', 'unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['id_jabatan'] = [
            'asc' => ['jabatan.jabatan' => SORT_ASC],
            'desc' => ['jabatan.jabatan' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['id_unit'] = [
            'asc' => ['unit.unit' => SORT_ASC],
            'desc' => ['unit.unit' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->tahun = isset($this->tahun) ? $this->tahun : date("Y");

        if(!Yii::$app->user->identity->accessLevel([1, 3, 4, 5]))
            $this->id_jabatan = Yii::$app->user->identity->id_jabatan;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'unjuran.id_jabatan' => $this->id_jabatan,
            //'id_unit' => $this->id_unit,
            'kuantiti' => $this->kuantiti,
            'jumlah_unjuran' => $this->jumlah_unjuran,
            'public' => $this->public,
            'status' => $this->status,
            //'sah' => $this->sah, // to enable filter, put sah in function rules
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
            'user' => $this->user,
        ]);

        $query->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'ol', $this->ol])
            ->andFilterWhere(['like', 'jabatan.jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'unit.unit', $this->unit])
            ->andFilterWhere(['like', 'butiran', $this->butiran])
            ->andFilterWhere(['like', 'kod', $this->kod])
            ->andFilterWhere(['like', 'kongsi', $this->kongsi])
            ->andFilterWhere(['like', 'tahun', $this->tahun])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
