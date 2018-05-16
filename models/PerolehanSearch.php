<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perolehan;

/**
 * PerolehanSearch represents the model behind the search form of `app\models\Perolehan`.
 */
class PerolehanSearch extends Perolehan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jabatan', 'jabatan_asal', 'unit', 'jenis_perolehan', 'kaedah_pembayaran', 'kontrak_pusat', 'id_syarikat', 'status', 'status_kewangan', 'user'], 'integer'],
            [['kod_id', 'kod_unjuran', 'tarikh_lulus1', 'catatan1', 'tarikh_lulus2', 'nolo', 'tarikhlo', 'novoucher', 'tarikh_voucher', 'catatan2', 'tahun', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['lulus_perolehan', 'nilai_perolehan'], 'number'],
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
        $query = Perolehan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'jabatan' => $this->jabatan,
            'jabatan_asal' => $this->jabatan_asal,
            'unit' => $this->unit,
            'jenis_perolehan' => $this->jenis_perolehan,
            'kaedah_pembayaran' => $this->kaedah_pembayaran,
            'kontrak_pusat' => $this->kontrak_pusat,
            'id_syarikat' => $this->id_syarikat,
            'status' => $this->status,
            'tarikh_lulus1' => $this->tarikh_lulus1,
            'lulus_perolehan' => $this->lulus_perolehan,
            'status_kewangan' => $this->status_kewangan,
            'tarikh_lulus2' => $this->tarikh_lulus2,
            'tarikhlo' => $this->tarikhlo,
            'tarikh_voucher' => $this->tarikh_voucher,
            'nilai_perolehan' => $this->nilai_perolehan,
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
            'user' => $this->user,
        ]);

        $query->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'kod_unjuran', $this->kod_unjuran])
            ->andFilterWhere(['like', 'catatan1', $this->catatan1])
            ->andFilterWhere(['like', 'nolo', $this->nolo])
            ->andFilterWhere(['like', 'novoucher', $this->novoucher])
            ->andFilterWhere(['like', 'catatan2', $this->catatan2])
            ->andFilterWhere(['like', 'tahun', $this->tahun]);

        return $dataProvider;
    }
}
