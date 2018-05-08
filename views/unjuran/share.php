<?php
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;	
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Jabatan;
use kartik\select2\Select2;
?>

<div class="kod-a-form">

    <?php $form = ActiveForm::begin(['id' => 'kongsi']); ?>

    <?= $form->field($model, 'kongsi')->widget(Select2::classname(), [
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
        ])->label('Jabatan');
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success', 'id' => 'simpan-kongsi', 'data-confirm' => 'Simpan Data Ini?']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$this->registerJs('

    $("form#kongsi").on("submit", function() {
        var form = $(this);
        // alert($("#kongsi-jabatan").val());
        // return false;
        $.post(form.attr("action"), form.serialize())
            .done(function(data){
                alert(data);
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