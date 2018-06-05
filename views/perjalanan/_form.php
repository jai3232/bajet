<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use app\models\Unit;

/* @var $this yii\web\View */
/* @var $model app\models\Perjalanan */
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

echo Dialog::widget();

$months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogo', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];
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


<div class="perjalanan-form">

    <div class="first">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bahagian')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($model, 'bahagian_asal')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_jabatan])->label(false) ?>

        <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true])->label('No. KP tanpa (-)') ?>

        <div class="row">
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'bulan')->dropDownList($months, 
                        [
                            'prompt' => '- Sila Pilih -',
                            'options' => [date("m") => ['selected' => true]],
                        ]) ?>                
            </div>
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'tahun')->textInput(['maxlength' => true, 'value' => date("Y")]) ?>        
            </div>
        </div>

        <?= $form->field($model, 'unit')->dropDownList(ArrayHelper::map(Unit::find()->where(['id_jabatan' => yii::$app->user->identity->id_jabatan])->all(), 'id', 'unit'),['prompt' => '- Sila Pilih -']) ?>

    </div>

    <div class="second">
        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        
        <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'no_gaji')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'gaji_asas')->textInput() ?>

        <?= $form->field($model, 'elaun')->textInput() ?>

        <?= $form->field($model, 'elaun_mangku')->textInput() ?>

        <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cawangan_bank')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'akaun_bank')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'model_kereta')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'no_plate')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cc')->textInput() ?>

        <?= $form->field($model, 'kelas_tuntutan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat_pejabat')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat_rumah')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'jumlah_jarak')->textInput() ?>

        <?= $form->field($model, 'jarak_telah_dituntut')->textInput() ?>

        <?= $form->field($model, 'kali_makan')->textInput() ?>

        <?= $form->field($model, 'kali_makan_sabah')->textInput() ?>

        <?= $form->field($model, 'kali_harian')->textInput() ?>

        <?= $form->field($model, 'kali_harian_sabah')->textInput() ?>

        <?= $form->field($model, 'kali_elaun_luar')->textInput() ?>

        <?= $form->field($model, 'elaun_makan')->textInput() ?>

        <?= $form->field($model, 'elaun_makan_sabah')->textInput() ?>

        <?= $form->field($model, 'elaun_harian')->textInput() ?>

        <?= $form->field($model, 'elaun_harian_sabah')->textInput() ?>

        <?= $form->field($model, 'elaun_luar')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_makan')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_makan_sabah')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_harian')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_harian_sabah')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_luar')->textInput() ?>

        <?= $form->field($model, 'kali_hotel')->textInput() ?>

        <?= $form->field($model, 'kali_hotel2')->textInput() ?>

        <?= $form->field($model, 'kali_hotel3')->textInput() ?>

        <?= $form->field($model, 'kali_hotel4')->textInput() ?>

        <?= $form->field($model, 'kali_hotel5')->textInput() ?>

        <?= $form->field($model, 'kali_hotel6')->textInput() ?>

        <?= $form->field($model, 'kali_lojing')->textInput() ?>

        <?= $form->field($model, 'hotel')->textInput() ?>

        <?= $form->field($model, 'hotel2')->textInput() ?>

        <?= $form->field($model, 'hotel3')->textInput() ?>

        <?= $form->field($model, 'hotel4')->textInput() ?>

        <?= $form->field($model, 'hotel5')->textInput() ?>

        <?= $form->field($model, 'hotel6')->textInput() ?>

        <?= $form->field($model, 'cukai')->textInput() ?>

        <?= $form->field($model, 'lojing')->textInput() ?>

        <?= $form->field($model, 'teksi')->textInput() ?>

        <?= $form->field($model, 'resit_teksi')->textInput() ?>

        <?= $form->field($model, 'bas')->textInput() ?>

        <?= $form->field($model, 'resit_bas')->textInput() ?>

        <?= $form->field($model, 'keretapi')->textInput() ?>

        <?= $form->field($model, 'resit_keretapi')->textInput() ?>

        <?= $form->field($model, 'terbang')->textInput() ?>

        <?= $form->field($model, 'resit_terbang')->textInput() ?>

        <?= $form->field($model, 'feri')->textInput() ?>

        <?= $form->field($model, 'resit_feri')->textInput() ?>

        <?= $form->field($model, 'lain')->textInput() ?>

        <?= $form->field($model, 'resit_lain')->textInput() ?>

        <?= $form->field($model, 'tol')->textInput() ?>

        <?= $form->field($model, 'resit_tol')->textInput() ?>

        <?= $form->field($model, 'no_tg')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pakir')->textInput() ?>

        <?= $form->field($model, 'resit_pakir')->textInput() ?>

        <?= $form->field($model, 'dobi')->textInput() ?>

        <?= $form->field($model, 'resit_dobi')->textInput() ?>

        <?= $form->field($model, 'pos')->textInput() ?>

        <?= $form->field($model, 'resit_pos')->textInput() ?>

        <?= $form->field($model, 'telefon')->textInput() ?>

        <?= $form->field($model, 'resit_telefon')->textInput() ?>

        <?= $form->field($model, 'tukaran')->textInput() ?>

        <?= $form->field($model, 'resit_tukaran')->textInput() ?>

        <?= $form->field($model, 'pendahuluan')->textInput() ?>

        <?= $form->field($model, 'tuntutan_lain')->textInput() ?>

        <?= $form->field($model, 'jumlah_tuntutan')->textInput() ?>

        <?= $form->field($model, 'jumlah_kew')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'cetak')->textInput() ?>

        <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'user')->textInput() ?>

        <?= $form->field($model, 'tarikh_jadi')->textInput() ?>

        <?= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php

$this->registerJs('
    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['perjalanan/unjuran-list']).'");
        //$("#modal-header").html("Penukaran Kod A");
        return false;
    });
');

?>