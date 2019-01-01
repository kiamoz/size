<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Price;
use common\models\Order;
use common\models\Item;
use common\models\ItemHasOrder;
use common\models\User;
use common\models\Product;
use yii\helpers\Url;

$site_base = dirname(dirname(dirname(dirname(__FILE__))));
$order_id = $has_id;
$total = 0;
$items = Item::find()->where('order_id=' . $_GET['order_id'])->all();
$order = Order::findOne($order_id);
$total+= $ship->price;
$total_weight = 0;
?>

<?php
$width = 0;
if ($_GET['flag'] == 1) {
    $width = 500;
} else {
    $width = 314;
}
?> 
<style>
    body{
        margin: 0px;
    }
</style>

<div style=" width: <?php echo $width; ?>px">
    <div class="area-title bdr">

    </div>
    <div class="table-area" style="border: 1px solid #333;direction: rtl;">
        <div class="table-responsive">
            <table class="table table-bordered text-center" style=" width:<?php echo $width; ?>px">
                <thead>
                    <tr style=" text-align: center">
                        <td colspan="4" style="font-family: tahoma">آکواریوم و پت شاپ آکوآ
                            <br>
                            <label>22210786</label>
                        </td>

                    </tr>
                    <tr style=" text-align: center" >


                        <td style="padding: 5px;font-family: tahoma;font-size: 12px;">زمان سفارش :<?php
                            $order_p = Order::findOne($_GET['order_id']);
                            echo \common\models\Post::arabic_w2e($order_p->date_farsi);
                            ?> </td>
                        <td colspan="3" style="text-align: left;padding: 5px;font-family: tahoma;font-size: 12px;"> شماره فاکتور :<?php echo \common\models\Post::arabic_w2e($order_p->id); ?> </td>

                    </tr>
                    <tr style=" text-align: center" >


                        <td style="padding: 5px;font-family: tahoma;font-size: 12px;">
                            <?php
                            $_user = User::findOne($order_p->user_id);
                            ?> 
                            نام و نام خانوادگی : <?php echo \common\models\Post::arabic_w2e($_user->name_and_fam); ?>
                        </td>
                        <td colspan="3" style="text-align: left;padding: 5px;font-family: tahoma;font-size: 12px;">
                            شماره همراه :<?php echo \common\models\Post::arabic_w2e($_user->cell_number); ?> 
                        </td>

                    </tr>



                    <tr class="c-head">

                        <th style="padding: 5px;border: 1px solid #333;font-size: 12px;font-family: tahoma;width: 30%;">نام محصول</th>
                        <th style="padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 12px;">تعداد</th>
                        <th style="padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 12px;">قیمت</th>

                        <th style="padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 12px;">مجموع</th>

                    </tr>
                </thead>
                <?php
                foreach ($items as $item) {
                    $total_weight += (Product::findOne($item->product_id)->weight) * $item->qty;

                    $price = (Product::get_last_price($item->product_id));
                    if ($item->variant_id) {
                        $variant_pice = \common\models\Variant::findOne($item->variant_id);
                        $total += (($variant_pice->price) * $item->qty);
                    } else {
                        $total += (Product::get_last_price($item->product_id) * $item->qty);
                    }
                    $variat_items = \common\models\Variant::findOne($item->variant_id);
                    ?>
                    <tr>

                        <td style="width: 42%;padding: 5px;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-name">
                            <?PHP echo Product::getName($item->product_id) ?>
                            <br>
                            <?php
                            if ($item->variant_id) {
                                $i = 0;
                                $variant_name = \common\models\OptionHasVariant::find()
                                        ->where('variant_id=' . $item->variant_id)
                                        ->all();
                                foreach ($variant_name as $variant_names) {
                                    $i++;
                                    $v_o = common\models\OptionValue::findOne($variant_names->option_id);

                                    echo '<small';
                                    if ($i == 1) {

                                        echo' class="first_s"';
                                    }
                                    echo'>' . $v_o->name . ' ' . '</small>';
                                }
                            }
                            ?>

                        </td>
                        <td style="width: 10%;padding: 5px;text-align: center;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-qty">
                            <?php echo common\models\Post::arabic_w2e($item->qty); ?>
                        </td>
                        <td style="text-align: center;padding: 5px;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-price">  
                            <?PHP
                            $pr = Product::get_last_price($item->product_id);
                            if ($item->variant_id) {
                                echo common\models\Post::arabic_w2e(number_format($variat_items->price));
                            } else {
                                if ($pr) {
                                    echo common\models\Post::arabic_w2e(number_format($pr));
                                }
                            }
                            ?> 


                        </td>

                        <td style="text-align: center;padding: 5px;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-price"> 
                            <?php
                            if ($item->variant_id) {
                                echo common\models\Post::arabic_w2e(number_format(($variat_items->price) * $item->qty));
                            } else {
                                $_p1 = Product::get_last_price($item->product_id) * $item->qty;
                                if ($_p1 > 0) {
                                    echo common\models\Post::arabic_w2e(number_format($_p1));
                                }
                            }
                            ?> 
                    </tr>
                <?php } ?>
                <tfoot>
                    <tr class="summary bgorgm">

                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px;" class="total-action" colspan="4">
                            <label>  ارزش افزوده : </label>
                            <span class="total" style="float: left;"> 0 درصد</span>                                                         
                        </td>



                    </tr>
                    <tr class="summary bgorgm">

                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px;" class="total-action" colspan="4">
                            <label>   تخفیف : </label>
                            <span class="total" style="float: left;"> 
                                <?php
                                if ($order_p->off_type == 0) {
                                    if ($order_p->off_price) {
                                        echo common\models\Post::arabic_w2e($order_p->off_price) . "درصد";
                                    } else {
                                        echo "0 تومان  ";
                                    }
                                    ?>

                                    <?php
                                } else {
                                    if ($order_p->off_price) {
                                        echo common\models\Post::arabic_w2e($order_p->off_price) . "تومان";
                                    } else {
                                        echo "0 تومان  ";
                                    }
                                }
                                ?>

                            </span>                                                         
                        </td>



                    </tr>
                    <tr class="summary bgorgm">

                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px;" class="total-action" colspan="4">
                            <label>  جمع قابل پرداخت : </label>
                            <span class="total" style="float: left;">
                                <?php
                                if ($order_p->off > 0) {
                                    echo Product::arabic_w2e(number_format($order_p->off));
                                } else {
                                    echo Product::arabic_w2e(number_format($order_p->amount));
                                }
                                ?>  
                                تومان</span>                                                         
                        </td>



                    </tr>
                    <tr class="summary bgorgm">


                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px; text-align: center" class="total-action" colspan="5">

                            <label>خرید آنلاین https://shahrpet.com </label>
                        </td>


                    </tr>

                </tfoot>
            </table>

        </div>
    </div>
</div>




<script>
    window.print();
</script>
<?php exit();
?>