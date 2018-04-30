<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Os;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Waran */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$currentYear = date("Y"); 
//$yearList = ['' => ''];
for($i = $currentYear - 1; $i < $currentYear + 3; $i++) {
    $yearList[$i] = $i; 
}
?>

<div class="waran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_waran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_waran')->widget(yii\jui\DatePicker::class, [
        'language' => 'ms',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'readOnly' => true],
    ]) 
    ?>

    <?= $form->field($model, 'status_waran')->radioList([0 => 'Asal' , 1 => 'Tambah', 2 => 'Tarik'], ['class' => 'status_waran']); ?>

    <?= $form->field($model, 'tahun')->dropDownList($yearList, ['prompt' => '- Sila Pilih -', 'options' => [ $model->isNewRecord ? ($currentYear) : $model->tahun => ['selected' => true]]]) ?>

    <?php //= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Os::find()->select(['os', 'CONCAT(os, \' \' , butiran) AS butiran'])->all(), 'os', 'butiran'),
            'language' => 'ms',
            'options' => ['placeholder' => '- Sila Pilih -'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('OS');
    ?>

    <?= $form->field($model, 'jumlah_waran')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 3]) ?>

    <?php //= $form->field($model, 'tarikh')->textInput() ?>

    <?= $form->field($model, 'user')->hiddenInput(['maxlength' => true, 'value' => Yii::$app->user->identity->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'id' => 'simpan_waran']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('
    $("[name=\"Waran[status_waran]\"]").click(function(){
        var jumlah_waran = $("#waran-jumlah_waran").val() / 1;
        if($(this).val()/1 == 2) {
            if(jumlah_waran >= 0)
                $("#waran-jumlah_waran").val(0 - jumlah_waran);
        }
        else {
            if(jumlah_waran < 0)
                $("#waran-jumlah_waran").val(0 - jumlah_waran);
        }

    });

    $("#simpan_waran").click(function(){
        //$("[name=\"Waran[status_waran]\"]").trigger("click");
        var jumlah_waran = $("#waran-jumlah_waran").val() / 1;
        if($("[name=\"Waran[status_waran]\"]:checked").val()/1 == 2) {
            if(jumlah_waran >= 0)
                $("#waran-jumlah_waran").val(0 - jumlah_waran);
        }
        else {
            if(jumlah_waran < 0)
                $("#waran-jumlah_waran").val(0 - jumlah_waran);
        }
    });
');

?>