<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Jabatan;
use app\models\Os;
use app\models\Unjuran;
use app\controllers\UnjuranController;

/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$currentYear = date("Y"); 
$yearList = [];
for($i = $currentYear; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}

?>
<div class="unjuran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os')->dropdownList(ArrayHelper::map(Os::find()->all(), 'os', 'os'), ['prompt' => '- Sila Pilih -'])->label('OS') ?>

    <?= $form->field($model, 'ol')->textInput(['maxlength' => true])->label('OL') ?>

    <?= $form->field($model, 'id_jabatan')->dropdownList(ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'), ['prompt' => '- Sila Pilih -', 'onchange' => '$.get("'.Url::to(['pengguna/unit-list']).'", {id: this.value}, function(data){$("#unjuran-id_unit").html(data); $("#unjuran-id_unit").val('.$model->id_unit.');});'])->label('Jabatan'); ?>

    <?= $form->field($model, 'id_unit')->dropdownList([''])->label('Unit') ?>

    <?= $form->field($model, 'butiran')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'kuantiti')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'kod')->dropdownList(['' => '- Sila Pilih -', 'B' => 'B (Wajib)', 'C' => 'C (Utama)', 'D' => 'D (Kurang Utama)']) ?>

    <?= $form->field($model, 'jumlah_unjuran')->textInput(['type' => 'number']) ?>

    <?php //= $form->field($model, 'kongsi')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'public')->textInput() ?>

    <?= $form->field($model, 'tahun')->dropdownList($yearList,  
                                                    [
                                                        'prompt' => '- Sila Pilih -', 
                                                        'options' => [ $model->isNewRecord ? ($currentYear+1) : $model->tahun => ['selected' => true]]
                                                    ]                                                     
                                                    ) ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 2]) ?>

    <?php //= $form->field($model, 'status')->textInput() ?>

    <?php //= $form->field($model, 'sah')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_jadi')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

    <?php //= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
     $this->registerJs('
        $("#unjuran-id_jabatan").trigger("change");
        ', \yii\web\View::POS_READY);
?>
