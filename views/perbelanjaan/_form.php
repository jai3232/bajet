<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Perbelanjaan */
/* @var $form yii\widgets\ActiveForm */

$months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogo', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];

Modal::begin([
    'header' => '<h3 id="modal-header">Senarai Unjuran</h3>',
    'id' => 'modal',
    'clientOptions' => ['backdrop' => 'static'],
    'size' => 'modal-lg',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>',
]);

echo '<div id="modalContent"></div>';
Modal::end();
?>

<div class="form-group">
    <button id="pilih-unjuran" class="btn btn-primary">Pilih Unjuran</button>
</div>
<div id="unjuran_info" style="display: none;">
    <div class="form-group">
        <label>Kod Unjuran: <span id="kod-unjuran"></span></label>
    </div>
    <div class="form-group">
        <label>OS: <span id="os"></span></label>
    </div>
    <div class="form-group">
        <label>Butiran: <span id="butiran"></span></label>
    </div>
    <div class="form-group">
        <label>Jumlah Unjuran: <span id="jumlah-unjuran"></span></label>
    </div>
    <div class="form-group">
        <label>Baki: <span id="baki"></span></label>
    </div>
    <div class="form-group">
        <label>Unjuran Jabatan: <span id="jabatan"></span></label>
    </div>

</div>

<div class="perbelanjaan-form" style="display: none;">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'bulan')->dropDownList($months, ['prompt' => '-Sila Pilih-']) ?>

    <?= $form->field($model, 'butiran')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'jumlah_bayaran')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?php // $form->field($model, 'tarikh_jadi')->textInput() ?>

    <?php // $form->field($model, 'tarikh_kemaskini')->textInput() ?>

    <?php //= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'data-confirm' => 'Simpan data ini?']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs('

    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['perbelanjaan/unjuran-list']).'");
        //$("#modal-header").html("Penukaran Kod A");
        return false;
    });

');

?>
