<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SyarikatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Syarikat');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syarikat-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Tambah Syarikat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="output" style="overflow-x: auto">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'kod',
            'nama_syarikat',
            'alamat:ntext',
            'nama_pengurus',
            'no_telefon',
            'no_faks',
            'emel:email',
            'cawangan_bank:ntext',
            'no_akaun:ntext',
            'no_rujukan',
            [
                'attribute' => 'tarikh_daftar',
                'format' => ['date', 'php:d-m-Y']
            ],
            'pkk',
            'kelas_F1',
            'kelas_F2',
            'kelas_F3',
            'kelas_F4',
            'kelas_F5',
            'kelas_F6',
            'kelas_F7',
            'kew',
            [
                'attribute' => 'tarikh_luput_kew',
                'format' => ['date', 'php:d-m-Y']
            ],
            'kod_kepala0',
            'kod_kepala1',
            'kod_kepala2',
            'terima',
            'cidb',
            'pkk_elektrik',
            'kepala_sub_kepala',
            'kod_cukai',
            //'tarikh_jadi',
            //'tarikh_kemaskini',
            //'user',

        ],
    ]); ?>
    </div>
</div>
