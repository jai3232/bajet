<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'OS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah OS', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'OS',
                'attribute' => 'os'
            ],
            'butiran',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
