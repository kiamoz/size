<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'ورود اعضا';
$this->params['breadcrumbs'][] = $this->title;
?>


<section  class="product-single ">
    <div class="container" style="padding-top: 50px;">

        <section class="main-blog vc-main-blog">
            <div class="container">

                <h1><?= Html::encode($this->title) ?></h1>




                <div class="col-lg-5" style="float: right;">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('نام کاربری') ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('گذرواژه ') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox()->label('فراموشی ') ?>

                    <div style="color:#999;margin:1em 0;display: none;">
                        If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    </div>
                   
                    <div class="form-group row">
                       <div class="clearfix"></div>
                        <div class="col-md-6">
                             
                            <div class="wc-proceed-to-checkout">

                                <a href="<?= Url::to(['/site/signup']) ?>" class=" button alt ">
                                    عضویت</a>
                            </div>
                        </div>
                     
                          <div class="col-md-6">
                               
                            <?= Html::submitButton('ورود', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                </div>


                <?php ActiveForm::end(); ?>

            </div>

    </div>

</section>
</div>


</section>

