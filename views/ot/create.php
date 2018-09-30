<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ot */

$this->title = Yii::t('app', 'Borang Tuntutan OT');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ot-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
