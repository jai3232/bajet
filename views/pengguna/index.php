<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\KumpulanPengguna;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PenggunaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pengguna');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengguna-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Tambah Pengguna'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nama',
            'no_kp',
            //'password',
            'jabatan.jabatan',
            'unit.unit',
            'emel',
            [
                'label' => 'Level',
                'attribute' => 'level',
                'format' => 'raw',
                'value' => function($model) {
                        return Html::dropDownList('level', $model->level, ArrayHelper::map(KumpulanPengguna::find()->all(), 'id', 'nama'), ['class' => 'form-control']);
                },
                'filter' => ArrayHelper::map(KumpulanPengguna::find()->all(), 'id', 'nama'),
            ],
            //'jenis',
            [
                'label' => 'Aktif',
                'attribute' => 'aktif',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::checkbox('aktif', !$model->aktif ? false : true, ['class' => 'form-control']);
                },
                'filter' => ['Tidak', 'Aktif']
            ],
            //'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
