<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\User;
use common\models\location;
use yii\widgets\ActiveForm;
?>
<section  class="product-single ">
    <div class="container" style="padding-top: 50px;">

        <section class="main-blog vc-main-blog">
            <div class="container">
                <div class="row">

                    <div class=" col-lg-12 mb20 stepbanner">
                        <div class="col-md-3 colorcc"><img src="/s4.png">پرداخت</div>
                        <div class="col-md-3 colorcc"><img src="/s3.png">روش ارسال</div>
                        <div class="col-md-3 colororange"><img src="/s2_a.png">کنترل آدرس</div>
                        <div class="col-md-3 colorcc"><img src="/s1.png">بازبینی سبد خرید</div>
                    </div>
                    

                </div>
                <br>
            </div>
        </section>
        <section class="account-content">
            <div class="account-content-wrapper">
                <div class="container">
                    <div class="row">

                        <?php $form = ActiveForm::begin(['action' => ['site/address']]); ?>
                        <div class="account-content-inner">
                            <div id="customer-account">
                                <div id="customer_orders">
                                    <div class="mb20 col-lg-6 codediv adressdiv col-lg-offset-3">
                                        <?php if ($msg) {
                                            ?>
                                            <div class="rdirection alert alert-info">
                                                <label class="font-size-13"> <?php echo $msg; ?></label>
                                            </div>
                                        <?php } ?>
                                        <div class="rdirection alert alert-info">
                                            <?php //$addresss=\common\models\User::findOne(Yii::$app->user->identity->id); 
                                            ?>
                                            <label class="font-size-13"> </label>
                                            <label><?php //echo $addresss->address;             ?></label>
                                            <label class="font-size-13">آدرس سفارش خود را وارد کنید</label>
                                        </div>
                                        <?php
                                        $usr_address = \common\models\ProductAddress::find()->where('user_id=' . Yii::$app->user->identity->id)->all();
                                        foreach ($usr_address as $usr_address1) {
                                            $data_add[$usr_address1->id] = $usr_address1->address;
                                        }
                                        
                                       

                                        $data_add[-2] = 'اضافه کردن آدرس جدید';


                                        echo $form->field($order, 'address_id')->widget(Select2::classname(), [
                                            'data' => $data_add,
                                           
                                           
                                            'options' => ['placeholder' => 'یک آدرس انتخاب کنید'],
                                        ]);
                                        
                                        ?>           



                                    </div>
                                    <?php if ($open_address === TRUE) { ?>
                                        <style>
                                            #newadd{ display:  block !important;}
                                        </style>
                                    <?php } ?>
                                    <div class="mb20 col-lg-6 col-lg-offset-3" id="newadd">
                                        <?php
                                        $_state = \common\models\State::find()->all();
                                        $data = array();
                                        foreach ($_state as $state) {
                                            $data[$state->id] = $state->name;
                                        }

                                        echo $form->field($address_object, 'state_id')->widget(Select2::classname(), [
                                            'data' => $data,
                                            'options' => ['placeholder' => 'یک استان انتخاب کنید'],
                                        ]);
                                        ?>
                                        <!--                                                                                                                            /*************** location js-->
                                        <br>
                                        <?php
                                        if ($address_object->city_id)
                                            $arr[$address_object->city_id] = location::findOne($address_object->city_id)->name;

                                        echo $form->field($address_object, 'city_id')->widget(Select2::classname(), [


                                            'data' => $arr,
                                            'options' => ['placeholder' => 'یک شهر انتخاب کنید'],
                                        ]);
                                        ?>
                                        <br>

                                        <label>آدرس جدید را در کادر زیر وارد کنید : </label>
                                        
                                        
                                        
                                         
<?php
                                        
                                        echo $form->field($address_object, 'name_and_fam')->textInput(array('placeholder' => 'لطفا به زبان فارسی پر شود'));
                                        echo $form->field($address_object, 'address')->textInput(array('placeholder' => 'لطفا به زبان فارسی پر شود'));
                                        echo $form->field($address_object, 'cell_number');
                                        echo $form->field($address_object, 'postal_code');
                                        echo $form->field($address_object, 'description')->textInput(array('placeholder' => 'لطفا به زبان فارسی پر شود'));
                                        ?>   </div>
                                    
                                </div>
                            </div>
                            <div class="mb20 col-lg-12 mt20">

                                <div class="form-group">
                    <?= Html::submitButton('مرحله بعدی', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                                <?php ActiveForm::end(); ?>


                                </a>
                            </div>
                        </div>
                    </div>
               
     
                
                   </div>

        </section>
    </div>
    
</section>
        
   