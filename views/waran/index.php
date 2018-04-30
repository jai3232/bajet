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
        use kartik\export\ExportMenu;


        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
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
            ],
            'os',
            [
                'attribute' => 'jumlah_waran',
            ],
            'catatan:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ];

        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showConfirmAlert' => false,
            'showColumnSelector' => false,
            'enableFormatter' => true,
            'filename' => 'Waran'.$selectedYear,
            'target' => ExportMenu::TARGET_SELF,
            'exportConfig' => [
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_HTML => false,
                //ExportMenu::FORMAT_CSV => true,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_EXCEL_X => [
                    'label' => "Excel",
                    // 'icon' => true ? 'file-excel-o' : 'floppy-remove',
                    'iconOptions' => ['class' => 'text-success'],
                    // 'linkOptions' => [],
                    'options' => ['title' => "Microsoft Excel"],
                    //'message' => null,
                    'alertMsg' => "Fail Excel akan diproses untuk muatturun.",
                    'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'extension' => 'xls',
                    'writer' => 'Excel2007',
                ],
            ],
        ]);
    ?>

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
