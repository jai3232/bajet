<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-group">
    <?= Html::beginForm()?>
        <div class="form-group">
            <label>Harga Nilai LO</label>
            <?= Html::textInput('nilai_lo', null, ['class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <label>No LO</label>
            <?= Html::textInput('no_lo', null, ['class' => 'form-control']) ?>
        </div>

        <?= Html::button('Press me!', ['class' => 'teaser']) ?>
    <?= Html::endForm() ?>s
</div>

<?php
$this->registerJs('
   
');

$this->registerCss('
    
');
?>
sddds