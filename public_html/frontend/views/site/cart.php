<?php

use yii\helpers\Html;
use yii\web\View;
use common\models\Price;
use common\models\ProductOrder;
use common\models\Item;
use common\models\Product;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Post;
$this->title = 'سبد خرید ';
$site_base = dirname(dirname(dirname(dirname(__FILE__))));
?>


<section  class="product-single ">
    <div class="container" style="padding-top: 50px;">

        <section class="main-blog vc-main-blog">
            <div class="container">

            <?php if ($order_items) { ?>

                <div class="col-md-12">
                    <table id="cart">

                        <thead>
                            <tr class="bgorange">
                                <th class="image text-left"> محصول</th>
                                <th class="price">قیمت واحد</th>
                                <th class="qty">تعداد</th>
                                <th class="total">جمع</th>
                                <th class="remove"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order_items as $item) {
                                $total_weight += (Product::findOne($item->product_id)->weight) * $item->qty;
                                $total+=(Product::get_price($item->product_id,FALSE,FALSE) * $item->qty);
                                ?>
                                <tr class="deletetr bgorglight">
                                    <td class="title">
                                        <ul class="list-inline">
                                            <li class="image">
                                                <a href="<?= Url::to(['product/view', 'id' => $item->product_id]) ?>">
                                                    <img src="<?PHP echo common\models\Post::resize_img($site_base . '/backend/web/' . Product::findOne($item->product_id)->image, 100, 100, "_banner" . $item->product_id); ?>" alt="<?= $item->product->name ?>">
                                                </a>
                                            </li>
                                            <li class="link">
                                                <a href="<?= Url::to(['product/view', 'id' => $item->product_id]) ?>">
                                                    <p><?= $item->product->name ?></p>

                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="price"><span class="money "><?= Product::get_price($item->product_id); ?>  </span>

                                    </td>

                                    <td class="qty">
                                        <div class="quantity-wrapper">
                                            <div class="wrapper">
                                                <input type="hidden" class="pricee" value="<?= Product::get_price($item->product_id); ?>">
                                                <input type="hidden" class="itemid" value="<?php echo $item->id ?>"> 
                                                <label class="inc" item_id="<?php echo $item->id ?>">+</label>
                                                <input type="text" size="4"  name="updates[]" value="<?= $item->qty ?>" class="qtyy tc item-quantity custom_number bgorgm " min="0">
                                                <label class="dec" item_id="<?php echo $item->id ?>">-</label>
                                            </div>
                                            <!--End wrapper-->
                                        </div>
                                        <!--End quantily wrapper-->
                                    </td>
                                    <td class="total title-1"><span class="money monn " data-currency-usd=""><?= (Product::get_price($item->product_id,FALSE,FALSE) * $item->qty); ?></span><span>ریال</span></td>
                                    <td class="">
                                        
                                        <a class="cart removee" data-product_id="<?php echo $item->id ?>">

                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>	
                        </tbody>
                        <tfoot>
                            <tr class="summary bgorgm">
                                <td class="total-action" colspan="3">
                                    <label> جمع قابل پرداخت </label>

                                </td>
                                <td class="price bgorgm" colspan="3">
                                    <span class="total">
                                        <strong>
                                            <span class="money">
                                                <?= Post::arabic_w2e(number_format($total)) ?> 
                                            </span> 
                                            <span>ریال</span>
                                        </strong>
                                    </span>
                                </td>

                            </tr>
                        </tfoot>
                    </table>
                    <div class="mb20 col-lg-12" style="margin-top: 10px;">
                        <a href="<?php echo Url::to(['site/index']) ?>">
                            <button class="btn btn-default">ادامه ی خرید</button>
                        </a>

                        <a href="<?php
                        if (Yii::$app->user->isGuest) {
                            echo Url::to(['site/login', 'CRT' => 1]);
                        } else {
                            echo Url::to(['site/address']);
                        }
                        ?>">    

                            <button class="btn btn-default">مرحله بعد</button>
                        </a>

                    </div>
                </div>

            <?php } else { ?>
                <div class=" col-md-12 alert alert-danger">
                    <p>سبد خالی است</p>
                </div>
            <?php } ?>
  </div>

        </section>
    </div>
    

</section>
                                    


