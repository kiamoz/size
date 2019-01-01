<?php

use yii\helpers\Url;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

$this->title = 'انتخاب روش پرداخت';
?>
<section  class="product-single ">
    <div class="container" style="padding-top: 50px;">

        <section class="main-blog vc-main-blog">
            <div class="container">
                <h1>
                    <?= $this->title ?>
                </h1>

            <div class="col-md-10 direction_rtl mb20">

                <?php $form = ActiveForm::begin(['action' => ['site/tracking']]); ?>
                <?php
                    $paymentS = common\models\PaymentMethod::find()->all();
                    foreach ($paymentS as $payment) {
                        ?>
                        <div class="lh mtb10" > 
                            <input value="<?=$payment->id ?>" name="payment" type="radio" class="paymethod" checked="check" > 
                            <span> <?=$payment->name ?> </span>  
                        </div> 
                    <?php } ?> 
                <table style=" width: 100%;direction: rtl;">
                    <tr>
                        <td>جمع کل  قابل پرداخت: </td>
                        <td style="text-align: left;">
                            <?php
                            echo '<b>' . $order . '</b>' . 'ریال ';
                            ?></td>
                    </tr>
                </table>

            </div>
            <div class="col-md-12 mt20">
                <a href="<?php echo Url::to(['site/tracking']) ?>">  


                    <button class="btn btn-default" type="submit">پرداخت  

                        <i class="fa fa-caret-left"></i>
                    </button> 
                </a>

            </div>


            <?php ActiveForm::end(); ?>


        <!-- Modal content-->
      
              

        </section>
    </div>
    
</section>
        