<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$currentYear = date("Y"); 
for($i = $currentYear - 5; $i < $currentYear + 2; $i++) {
    $yearList[$i] = $i; 

if(!isset($_GET['WaranSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['WaranSearch']['tahun'];
}

$this->title = 'Senarai Waran '.$selectedYear;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="waran-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Waran', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php

    use phpnt\exportFile\ExportFile;
/* @var $searchModel \common\models\GeoCitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// минимальные настройки
echo ExportFile::widget([
        'model'             => 'app\models\WaranSearch',   // путь к модели
        //'searchAttribute'  => $searchModel,                    // фильтр
        'queryParams'       => Yii::$app->request->queryParams,

    'getAll'            => true, 
]) ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'no_waran',
            'tarikh_waran',
            [
                'attribute' => 'status_waran',
                'value' => function($model) {
                    $status = [0 => 'Asal' , 1 => 'Tambah', 2 => 'Tarik'];
                    return $status[$model->status_waran];
                },
                'filter' => [0 => 'Asal' , 1 => 'Tambah', 2 => 'Tarik'],
            ],
            [
                'attribute' => 'tahun',
                //'filter' => $yearList,
                'filter' => Html::dropDownList('WaranSearch[tahun]', $searchModel->tahun, $yearList, ['class' => 'form-control']),
            ],
            'os',
            [
                'attribute' => 'jumlah_waran',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_waran, 2);
                }
            ],
            'catatan:ntext',
            //'tarikh',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
