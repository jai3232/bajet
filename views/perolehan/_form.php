<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Unit;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

    Modal::begin([
        'header' => '<h3 id="modal-header">Senarai Unjuran</h3>',
        'id' => 'modal',
        'clientOptions' => ['backdrop' => 'static'],
        'size' => 'modal-lg',
        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>',
    ]);

    echo '<div id="modalContent"></div>';
    Modal::end();
    $id_pengguna = Yii::$app->user->identity->id;

?>
<div class="form-group">
    <button id="pilih-unjuran" class="btn btn-primary">Pilih Unjuran</button>
</div>

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

<div class="perolehan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'id_jabatan')->textInput()->label('Unjuran Dari Jabatan') ?>

    <?= $form->field($model, 'id_jabatan_asal')->hiddenInput(['value' => Yii::$app->user->identity->id_jabatan])->label(false) ?>  

    <?= $form->field($model, 'id_unit')->dropdownList(ArrayHelper::map(Unit::find()
                                    ->where([
                                        'id_jabatan' => Yii::$app->user->identity->id_jabatan])->all(), 
                                        'id', 'unit'), [
                                                            'prompt' => '- Sila Pilih -'

                                                    ])->label('Unit')
    ?>

    <?= $form->field($model, 'jenis_perolehan')->dropdownList(ArrayHelper::map(RefJenisPerolehan::find()->all(), 
                                                                                'id', 'jenis'), [
                                                                                                'prompt' => '- Sila Pilih -'

                                                                                               ]) 

    ?>

    <?= $form->field($model, 'kaedah_pembayaran')->dropdownList(ArrayHelper::map(RefKaedahPerolehan::find()->all(), 
                                                                                'id', 'kaedah'), [
                                                                                                'prompt' => '- Sila Pilih -'

                                                                                               ])
    ?>

    <?= $form->field($model, 'kontrak_pusat')->checkbox(['value' => 1, 'label' => 'Kontrak Pusat']) ?>

    <?php //= $form->field($model, 'id_syarikat')->textInput() ?>

    <?php //= $form->field($model, 'status')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_lulus1')->textInput() ?>

    <?php //= $form->field($model, 'catatan1')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'lulus_perolehan')->textInput() ?>

    <?php //= $form->field($model, 'status_kewangan')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_lulus2')->textInput() ?>

    <?php //= $form->field($model, 'nolo')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'tarikhlo')->textInput() ?>

    <?php //= $form->field($model, 'novoucher')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'tarikh_voucher')->textInput() ?>

    <?php //= $form->field($model, 'nilai_perolehan')->textInput() ?>

    <?php //= $form->field($model, 'catatan2')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'tarikh_jadi')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

    <?php //= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('
    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['perolehan/unjuran-list']).'");
        //$("#modal-header").html("Penukaran Kod A");
        return false;
    });
')
?>
