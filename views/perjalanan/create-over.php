<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Perjalanan */

$this->title = Yii::t('app', 'Tuntutan Perjalanan Luar Negeri');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perjalanan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perjalanan-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form-over', [
        'model' => $model,
        //'model_luar_details' => $model_luar_details,
    ]) ?>

</div>
