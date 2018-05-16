<?php
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;	
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Jabatan;
use app\models\Unjuran;
use kartik\select2\Select2;
?>

<div class="kod-a-form">

    <?php $form = ActiveForm::begin(['id' => 'kongsi']); ?>
    <div class="form-group">
    <?= '<label class="control-label">Provinces</label>'; ?>

    <?php echo Select2::widget([
            'name' => 'kongsi-jabatan',
            'id' => 'kongsi-jabatan',
            'data' => ArrayHelper::map(Jabatan::find()->select("id, jabatan")->asArray()->all(), 'id', 'jabatan'),
            'language' => 'ms-MY',
            'options' => ['placeholder' => '- Sila Pilih -', 'multiple' => true, 'id' => 'kongsi-jabatan'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'toggleAllSettings' => [
                'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> Pilih Semua',
                'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> Nyahpilih Semua',
                'selectOptions' => ['class' => 'text-success'],
                'unselectOptions' => ['class' => 'text-danger'],
            ],
        ]);

    ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success', 'id' => 'simpan-kongsi', 'data-confirm' => 'Simpan Data Ini?']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $opt = '';
    $shared_jabatans = explode(',', Unjuran::find()->where(['id' => $_GET['id']])->one()->kongsi);
    $jabatans = ArrayHelper::map(Jabatan::find()->select("id, jabatan")->asArray()->all(), 'id', 'id');
    if(count($shared_jabatans) > 0) {
        foreach ($jabatans as $key => $value) {
            if(in_array($value, $shared_jabatans))
                $opt .= '<option value=\"'.$value.'\" selected>'.Jabatan::findOne($value)->jabatan.'</option>';
            else
                $opt .= '<option value=\"'.$value.'\">'.Jabatan::findOne($value)->jabatan.'</option>';
        }
        
    }
?>


<?php

$this->registerJs('
    $("#kongsi-jabatan").html("'.$opt.'");
    $("form#kongsi").on("submit", function() {
        var form = $(this);
        // alert($("#kongsi-jabatan").val());
        // return false;
        $.post(form.attr("action"), form.serialize())
            .done(function(data){
                if($.trim(data))
                    $.pjax.reload({container: "#unjuran-grid"});
            })
            .fail();

        return false;  
    });
');

?>

<?php $script = <<< JS

// $('form#kodA').on('beforeSubmit', function(){
//     alert("Y");
//     return false;
//     var form = $(this);
//     //alert(form.attr('action'));
//     //return false;
//     $.post(
//         form.attr('action'),
//         form.serialize()
//     )
//         .done(function(data){
//             if($.trim(data) == 1) { // if create success
//                 form.trigger('reset');
//                 $.pjax.reload({container: '#bidangGrid'});
//             }
//             else
//             if($.trim(data) == 2) { // if uddate success
//                 $('#modalContent').html('<h4>Berjaya</h4>');
//                 $.pjax.reload({container: '#bidangGrid'});
//             }
//             else {
//                 alert('error:'+data);
//             }
//         })
//         .fail();
//     return false;
// })


JS;
$this->registerJs($script);