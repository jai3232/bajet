<?php

use yii\helpers\Html;
use app\models\Jabatan;

$id_jabatan_personal = Yii::$app->user->identity->id_jabatan;


/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */

$this->title = 'Tambah Unjuran Jabatan/Bahagian '.Jabatan::findOne(['id' => $id_jabatan_personal])->jabatan;
$this->params['breadcrumbs'][] = ['label' => 'Unjuran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unjuran-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
