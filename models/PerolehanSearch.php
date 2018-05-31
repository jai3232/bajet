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
    public $pembekal, $barangan, $os, $bulan;

    public function rules()
    {
        return [
            [['id', 'id_jabatan', 'id_jabatan_asal', 'id_unit', 'jenis_perolehan', 'kaedah_pembayaran', 'kontrak_pusat', 'id_syarikat', 'status', 'status_kewangan', 'user'], 'integer'],
            [['kod_id', 'kod_unjuran', 'tarikh_lulus1', 'catatan1', 'tarikh_lulus2', 'nolo', 'tarikhlo', 'novoucher', 'tarikh_voucher', 'catatan2', 'tahun', 'tarikh_jadi', 'tarikh_kemaskini', 'barangan', 'pembekal', 'os', 'bulan'], 'safe'],
            [['nilai_permohonan', 'nilai_perolehan'], 'number'],
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
        $user_level = yii::$app->user->identity->level;
        $id_jabatan = yii::$app->user->identity->id_jabatan;

        $query = Perolehan::find();
        // $query->leftJoin('barangan', 'perolehan.id = barangan.id_perolehan')
        //       ->leftJoin('pembekal', 'perolehan.id = pembekal.id_perolehan')
        //       ->leftJoin('panjar', 'perolehan.id = panjar.id_perolehan');
        $query->joinWith('barangans')
              ->joinWith('pembekals')
              ->joinWith('panjars')
              ->joinWith('kodUnjuran');

        $query->where(['perolehan.tahun' => date('Y'), 'id_jabatan_asal' => $id_jabatan]);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id'=>SORT_DESC],
                //'attributes' => ['id', 'pembekal'],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['os'] = [
            'asc' => ['unjuran.os' => SORT_ASC],
            'desc' => ['unjuran.os' => SORT_DESC],
        ];

        $this->tahun = isset($this->tahun) ? $this->tahun : date("Y");

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_jabatan' => $this->id_jabatan,
            'id_jabatan_asal' => $this->id_jabatan_asal,
            'id_unit' => $this->id_unit,
            'jenis_perolehan' => $this->jenis_perolehan,
            'kaedah_pembayaran' => $this->kaedah_pembayaran,
            'kontrak_pusat' => $this->kontrak_pusat,
            'id_syarikat' => $this->id_syarikat,
            'status' => $this->status,
            'tarikh_lulus1' => $this->tarikh_lulus1,
            'nilai_permohonan' => $this->nilai_permohonan,
            'status_kewangan' => $this->status_kewangan,
            'tarikh_lulus2' => $this->tarikh_lulus2,
            'tarikhlo' => $this->tarikhlo,
            'tarikh_voucher' => $this->tarikh_voucher,
            'nilai_perolehan' => $this->nilai_perolehan,
            //!isset($this->tarikh_jadi) ? 'perolehan.tarikh_jadi' : 'Date(perolehan.tarikh_jadi)' => Yii::$app->formatter->asDate($this->tarikh_jadi, 'Y-MM-dd'),
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
            'unjuran.os' => $this->os,
            'user' => $this->user,
        ]);

        if(isset($this->tarikh_jadi) && $this->tarikh_jadi != '')
            $query->andFilterWhere(['Date(perolehan.tarikh_jadi)' => Yii::$app->formatter->asDate($this->tarikh_jadi, 'Y-MM-dd')]);

        $query->andFilterWhere(['like', 'perolehan.kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'kod_unjuran', $this->kod_unjuran])
            ->andFilterWhere(['like', 'barangan.justifikasi', $this->barangan])
            ->andFilterWhere(['like', 'pembekal.pembekal', $this->pembekal])
            ->andFilterWhere(['like', 'catatan1', $this->catatan1])
            ->andFilterWhere(['like', 'nolo', $this->nolo])
            ->andFilterWhere(['like', 'novoucher', $this->novoucher])
            ->andFilterWhere(['like', 'catatan2', $this->catatan2])
            ->andFilterWhere(['like', 'perolehan.tahun', $this->tahun]);

        if(isset($this->bulan)) {
            $query->andFilterWhere(['like', 'tarikh_jadi%', $this->bulan, false]);
        }

        $query->distinct();

        return $dataProvider;
    }
}
