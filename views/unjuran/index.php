<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Jabatan;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UnjuranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$currentYear = date("Y"); 
$yearList = ['' => ''];
for($i = $currentYear - 5; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}
$kodList = ['' => 'ABCD', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'];

if(!isset($_GET['UnjuranSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['UnjuranSearch']['tahun'];

//print_r(Yii::$app->request->get('UnjuranSearch')['tahun']);

$this->title = 'Unjuran Jabatan/Bahagian ' . (isset($_GET['id']) ? Jabatan::findOne(Yii::$app->user->identity->id_jabatan)->jabatan : '') 
                          . ' '.$selectedYear;;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unjuran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Unjuran', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'kod_id',
            [
                'label' => 'OS',
                'attribute' => 'os',
            ],
            [
                'label' => 'OL',
                'attribute' => 'ol',
            ],
            [
                'label' => 'Jabatan',
                'attribute' => 'id_jabatan',
                'value' => 'jabatan.jabatan',
                'visible' => Yii::$app->user->identity->accessLevel([1, 3, 4, 5]),
                'filter' => Html::textInput('UnjuranSearch[jabatan]', $searchModel->jabatan, ['class' => 'form-control']),
            ],
            [
                'label' => 'Unit',
                'attribute' => 'id_unit',
                'value' => 'unit.unit',
                'filter' => Html::textInput('UnjuranSearch[unit]', $searchModel->unit, ['class' => 'form-control']),
            ],
            'butiran:ntext',
            //'kuantiti',
            [
                'attribute' => 'kod',
                'filter' => Html::dropDownList('UnjuranSearch[kod]', $searchModel->kod , $kodList, ['class' => 'form-control'])
            ],
            // [
            //     'attribute' => 'jumlah_unjuran',
            //     // 'label' => 'Jumlah <br/> Unjuran',
            //     // 'format' => 'raw',
            //     // 'encodeLabel' => false,
            //     'contentOptions' => ['class' => 'text-right'],
            //     'value' => function($model) {
            //         return number_format($model->jumlah_unjuran);  
            //     } 
            // ],
            // //'kongsi',
            // 'public',
            [
                'attribute' => 'tahun',
                'filter' => Html::dropDownList('UnjuranSearch[tahun]', $searchModel->tahun, $yearList, ['class' => 'form-control'])
            ],
            'catatan:ntext',
            //'status',
            [
                'label' => 'Sah',
                'attribute' => 'sah',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::checkbox('sah', !$model->sah ? false : true);
                }
            ],
            //'tarikh_jadi',
            //'tarikh_kemaskini',
            //'user',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Tindakan',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Padam rekod ini?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
