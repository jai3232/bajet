<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label text-left'],
        ],
    ]); ?>

        <?= $form->field($model, 'login')->textInput(['autofocus' => true])->label('Login / No. KP') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Html::a('Daftar', Url::to(['site/register']),['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                <?= Html::a('Lupa Katalaluan', Url::to(['site/forget']), ['class' => 'btn btn-warning']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
<!-- <div style="height: 80px; text-align: right;">
    <div style="font-size: 1.2em; width: 85%; color: red; margin-left: 0;">Powered by:</div>
    <div>
        <img src="images/stellaris5.png" width="280" height="70">
    </div>
</div> -->

<?php

$this->registerCss('
    body {
        margin: 0;
        padding: 0;
        background: url("images/background.jpg"); 
        background-size: 100%; 
    }
    .navbar{
        display: none;
    }
    .header-login {
        height: 150px;
        background: black;
        width: 100%;
        margin-top: -29px;
    }
    #logo {
          background: url("images/bajet-logo3.png");
          background-position: 10px 18px;
          width: 547px;
          height: 155px;
          margin: 10px;
    }
    .control-label {
        color: orange;
    }
    input.form-control {
        background: black;
        border: 1px solid red;
        color: #eee;
    }
    .site-login {
        text-align: center;
        width: 300px;
        margin: auto;
    }
    .form-horizontal .control-label{
        text-align: left;
    }
    .col-lg-8 {
        text-align: left;
    }
    .col-lg-12 {
        text-align: center;
    }
    .col-lg-12 input {

        margin: auto;
    }
    #stellaris {
        width: 301px;
        height: 100px;
        background: url("images/stellaris3.png");
        background-size: 100%;
        position: absolute;
        bottom: -10px;
        right: 0px;
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }
    #text-stellaris {
        color: red;
        font-style: italic;
        font-weight: bold;
        margin-left: 20px;
        margin-top: 5px;
    }

    footer.footer {
        background: orange !important;
        font-weight: bold;
    }
');
?>
