<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Penceramah */

$this->title = Yii::t('app', 'Borang Tuntutan Penceramah');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penceramah'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penceramah-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
