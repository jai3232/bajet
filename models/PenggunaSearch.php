<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pengguna;

/**
 * PenggunaSearch represents the model behind the search form of `app\models\Pengguna`.
 */
class PenggunaSearch extends Pengguna
{
    /**
     * @inheritdoc
     */
    public $jabatan, $unit;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama', 'no_kp', 'password', 'id_jabatan', 'id_unit', 'emel', 'level', 'jenis', 'aktif', 'date'], 'safe'],
            [['jabatan', 'unit'], 'safe'],
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
        $query = Pengguna::find()->joinWith(['jabatan', 'unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['id_jabatan'] = [
            'asc' => ['jabatan.jabatan' => SORT_ASC],
            'desc' => ['jabatan.jabatan' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['id_unit'] = [
            'asc' => ['unit.unit' => SORT_ASC],
            'desc' => ['unit.unit' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'no_kp', $this->no_kp])
            ->andFilterWhere(['like', 'password', $this->password])
            //->andFilterWhere(['like', 'id_jabatan', $this->id_jabatan])
            ->andFilterWhere(['like', 'jabatan.jabatan', $this->jabatan])
            //->andFilterWhere(['like', 'id_unit', $this->id_unit])
            ->andFilterWhere(['like', 'unit.unit', $this->unit])
            ->andFilterWhere(['like', 'emel', $this->emel])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'aktif', $this->aktif]);

        if(!isset($params['sort']))
            $query->orderby(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
