<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Waran */

$this->title = 'Create Waran';
$this->params['breadcrumbs'][] = ['label' => 'Warans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="waran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
