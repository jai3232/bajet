<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Syarikat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Syarikat'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syarikat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Kemaskini'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Padam'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Pasti padam item ini??'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'tarikh_daftar',
            'pkk',
            'kelas_F1',
            'kelas_F2',
            'kelas_F3',
            'kelas_F4',
            'kelas_F5',
            'kelas_F6',
            'kelas_F7',
            'kew',
            'tarikh_luput_kew',
            'kod_kepala0',
            'kod_kepala1',
            'kod_kepala2',
            'terima',
            'cidb',
            'pkk_elektrik',
            'kepala_sub_kepala',
            'kod_cukai',
            'tarikh_jadi',
            'tarikh_kemaskini',
            'user',
        ],
    ]) ?>

</div>
