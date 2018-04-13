<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Jabatan;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UnjuranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unjuran ' . (isset($_GET['id']) ? Jabatan::findOne(Yii::$app->user->identity->id_jabatan)->jabatan : 'Jabatan');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

$currentYear = date("Y"); 
$yearList = ['' => ''];
for($i = $currentYear - 5; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}
$kodList = ['@' => '', '' => 'ABCD', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'];

?>
<div class="unjuran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
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
            //'id_jabatan',
            [
                'label' => 'Unit',
                'attribute' => 'id_unit',
            ],
            'butiran:ntext',
            //'kuantiti',
            [
                'attribute' => 'kod',
                'filter' => Html::dropDownList('UnjuranSearch[kod]', null , $kodList, ['class' => 'form-control'])
            ],
            [
                'attribute' => 'jumlah_unjuran',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_unjuran);  
                } 
            ],
            //'kongsi',
            'public',
            [
                'attribute' => 'tahun',
                'filter' => Html::dropDownList('UnjuranSearch[tahun]', null , $yearList, ['class' => 'form-control'])
            ],
            'catatan:ntext',
            //'status',
            'sah',
            //'tarikh_jadi',
            //'tarikh_kemaskini',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
