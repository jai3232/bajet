<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\Pengguna;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerbelanjaanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$currentYear = date("Y"); 
$currentMonth = date("m");
$yearList = ['' => ''];
for($i = $currentYear - 5; $i < $currentYear + 1; $i++) {
    $yearList[$i] = $i; 
}
$months = [
            '' => '',
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogo', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];

if(!isset($_GET['PerbelanjaanSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['PerbelanjaanSearch']['tahun'];

if(!isset($_GET['PerbelanjaanSearch']['bulan']))
    $selectedMonth = $currentMonth;
else
    $selectedMonth =  $_GET['PerbelanjaanSearch']['bulan'];

Modal::begin([
    'header' => '<h3 id="modal-header">Tambah Perbelanjaan</h3>',
    'id' => 'modal',
    'clientOptions' => ['backdrop' => 'static'],
    'size' => '',
    'footer' => '<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>',
]);

echo '<div id="modalContent">'.yii\jui\DatePicker::widget(['name' => 'attributeName']).'</div>';
Modal::end();

Pjax::begin();
$this->title = Yii::t('app', 'Perbelanjaan Lain').' '.$months[$selectedMonth].' '.$selectedYear;;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perbelanjaan-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <div class="form-group">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'id' => 'perbelanjaan_form',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]); ?>
            <div class="col-xs-4 form-inline">
                <label>Tahun </label>
                <?= Html::dropDownList('PerbelanjaanSearch[tahun]', $selectedYear, $yearList, 
                        ['class' => 'form-control', 'onchange' => '$("#perbelanjaan_form").submit()']) 
                ?>
                <label>Bulan</label>
                <?= Html::dropDownList('PerbelanjaanSearch[bulan]', $selectedMonth, $months, 
                    ['class' => 'form-control', 'onchange' => '$("#perbelanjaan_form").submit()']) 
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Create Perbelanjaan'), ['create'], ['class' => 'btn btn-success', 'id' => 'tambah_perbelanjaan']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kod_id',
            'kod_unjuran',
            'butiran:ntext',
            [
                'label' => 'Jumlah Bayaran',
                'attribute' => 'jumlah_bayaran',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_bayaran, 2);
                }
            ],
            [
                'label' => 'Bayaran Untuk',
                //'attribute' => 'bulan',
                'value' => function($model) {
                    $months = [
                        '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
                        '07' => 'Jul', '08' => 'Ogo', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
                    ];
                    return $months[$model->bulan];
                },
                //'filter' => $months,
            ],
            [
                'label' => 'Tarikh Data',
                'attribute' => 'tarikh_jadi',
                'value' => function($model) {
                    return yii::$app->formatter->asDate($model->tarikh_jadi);
                },                
            ],
            //'tarikh_kemaskini',
            [
                'label' => 'Dikemaskini oleh',
                'attribute' => 'user',
                'value' => function($model) {
                    return Pengguna::findOne($model->user)->nama;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
    $this->registerJs('
        $("select option[value=\"\"]").append("Semua");
        $("select[name*=tahun] > option:first").hide();

        $(document).on("pjax:success", function() {
            $("select option[value=\"\"]").append("Semua");
            $("select[name*=tahun] > option:first").hide();
        });
    ');

?>
