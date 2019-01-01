<?php

use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

$this->title = 'انتخاب روش ارسال';
?>

<section  class="product-single ">
    <div class="container" style="padding-top: 50px;">
        <?php
        if ($ship_m) {
            ?>
            <section class="main-blog vc-main-blog">
                <div class="container">


                    <div class="col-md-10 direction_rtl" style="float: right; margin: 10px;    text-align: right;">
                        <?php $form = ActiveForm::begin(['action' => ['site/payment']]); ?>
                        <?php
                        $i = 0;


                        foreach ($ship_m as $ship_method) {
                            $i++;
                            ?>
                            <div class="lh mtb10" > 
                                <input <?php
                                if ($i == 1) {
                                    echo 'checked';
                                }
                                ?> value="<?php echo $ship_method->shippingMethod->id; ?>" name="shipping_radio" type="radio" class="shipping_radio" > 
                                <span><?php echo $ship_method->shippingMethod->name; ?></span>  
                            </div> 
                        <?php } ?>



                    </div>

                    <table id="calc_send" class="table-striped" >
                        <tr >
                            <td><h3 class="inlinedis lineheight5"> مبلغ سفارش :   </h3> </td>
                            <td><label id="order_price" class="inlinedis lineheight5"></label>     </td>
                        </tr>

                        <tr >
                            <td><h3 class="inlinedis lineheight5"> هزینه حمل و نقل :   </h3></td>
                            <td><label id="hazinehamlpay" class="inlinedis lineheight5"></label>  </td>
                        </tr>
                        <tr >
                            <td><h3 class="inlinedis lineheight5"> قابل پرداخت :   </h3></td>
                            <td><label id="jamekol" class="inlinedis lineheight5"></label>  </td>
                        </tr>
                  


                    </table>


                    <div class="mb20 col-lg-12 mt20" style="margin-top: 10px;">


                       
                            <button type="submit" class="btn btn-default">ث۲۲۲بت و مرحله بعد<i class="fa fa-caret-left"></i></button>
                       
                      
                        <?php ActiveForm::end(); ?>


                    </div>


                </div>

            </section>
            <?php
        } else {
            echo '  <div class="alert alert-danger">
     برای شهر انتخابی شما ، روش ارسالی در نظر گرفته نشده است. لطفا با پشتیبانی تماس بگیرید
  </div>';
        }
        ?>   
    </div>

</section>
