
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Product;
use yii\helpers\url;
use kartik\select2\Select2; 
use common\models\Optionn;

?>
<style>
    span.option_v_name{
    display: inline-block;
    direction: rtl;
    text-align: right;
    }
    input.variant_qty {
    width: 50px;
}
</style>
<?php 

function generate_combinations(array $data, array &$all = array(), array $group = array(), $value = null, $i = 0)
{
    $keys = array_keys($data);
    if (isset($value) === true) {
        array_push($group, $value);
    }

    if ($i >= count($data)) {
        array_push($all, $group);
    } else {
        $currentKey     = $keys[$i];
        $currentElement = $data[$currentKey];
        foreach ($currentElement as $val) {
            generate_combinations($data, $all, $group, $val, $i + 1);
        }
    }

    return $all;
}

    $data = array();
    
    foreach ( $array_option_value_name as $key => $val ){
         $array=  array();
       //echo $key .'<br>';
        if ( is_array($val) && count($val) )
    {
        foreach ( $val as $k => $v ) {
            array_push($array,$v);
            //echo $k . ': ' . $v.'<br>';
            //echo $v.' ';
        }//end foreach
        array_push($data,$array);
    } //end if
    
    } //end foreach
    
//    ********************
    
    $j;
    $combos = generate_combinations($data);
//    echo '<pre>';
//    print_r($combos);
//    
//    echo '</pre>';
    
    
    foreach ( $combos as $key => $val ){
         $array=  array();
       //echo $key .'<br>';
        if ( is_array($val) && count($val) )
    {   
            
            echo '<div class="variant">';
             echo '<span class="option_v_name">';
        foreach ( $val as $k => $v ) {
            
          $str= substr($v,0,1); 
          
          if($str=="#"){
              echo substr($v,1).','; 
          }else{
               echo $v.',';
          }
           
            
        }//end foreach
        echo '</span> ';
        echo '<div>'
        . '<input class="variant_qty" type="number" placeholder="تعداد" min="0">'
        
        . '<input class="variant_price purchase_price" type="text" placeholder="قیمت خرید">'
        . '<input class="variant_price sales_price" type="text" placeholder="قیمت فروش">'
        . '<input class="variant_barcode" type="text" placeholder="بارکد">'
        . '<input class="variant_barcode_text" type="text" placeholder="متن بارکد">'         
        . '<input class="variant_orderr" type="text" placeholder="ترتیب نمایش ">'
        . '<button class="btn btn-success clicker">ذخیره</button> '
        . '<a class="editit btn btn-info" style="opacity:.3">ویرایش</a>'
        . '</div><br>';
      
    } //end if
    echo '</div>';
    }
   
      
    ?>
<input value="<?php echo ($_POST['product_id']); ?>" type="hidden" name="product_id" id="product_idv">