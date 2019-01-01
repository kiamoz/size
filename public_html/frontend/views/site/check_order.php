<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<style>
    
    h1{
        padding-top: 150px;
        font-size: 80px;
        font-family: tahoma;
        text-align: center;
    }
    p{
        font-size: 60px;
        text-align: center;
        direction: rtl;
        font-family: tahoma;
        margin-bottom: 100px;
    }
    
    .area{
        width: 100%;
        background: #CCC;
    }
    
</style>

<?php if($order_obj->status == 2){ ?>
<div class="area">
    <h1>سفارش شما با وضعیت پرداخت در محل ثبت شده است  </h1>
    <p>شماره سفارش جهت پیگیری های بعدی : <?=  $order_obj->id ?></p>
</div>
<?php }else if($order_obj->status == 1){ ?>

<script>window.location.href = "http://size.ir/site/payment_req?id=<?=  $order_obj->id ?>";</script>

<?php } ?>
<?php
exit();
?>