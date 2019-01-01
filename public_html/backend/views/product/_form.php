<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\AttGroup;
use common\models\UploadForm;
use common\models\Category;
use common\models\ProductCategory;
use common\models\ProductHasCategory;
use common\models\ProductCategoryHasCategory;
use common\models\ProductHasAttGroup;
use kartik\file\FileInput;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;
use common\models\Price;
use yii\web\JsExpression;
use kartik\date\DatePicker;

$_http = "http://";
?>
<script src="images/ckeditor/ckeditor.js"></script>
<style>
    .select2-results__option,.select2-selection__choice{
        text-align: right;
        direction: rtl;
    }
    #product-gallery{
        display: none;
    }
</style>

<div class="product-form panel">

    <?php
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])
    ?>

    <div class="col-lg-6 panel-body">

        <?PHP
        $b = ProductCategory::find()->all();
        $date2 = array();
        foreach ($b as $ProductCategory) {

            $ret = "";
            $daste = ProductCategoryHasCategory::find()->where('category=' . $ProductCategory->id)->all();

            foreach ($daste as $cats) {
                $ret .= ProductCategory::findOne($cats->parent_category)->name . " ";
            }

            $data2[$ProductCategory->id] = $ProductCategory->name . "(" . $ret . ")";
        }

        if ($model->id) {

            $m = ProductHasCategory::find()
                    ->with('product')
                    ->where('product_id=' . $model->id)
                    ->all();
            $arr_select = array();
//echo count($m);
            foreach ($m as $list) {

                $arr_select[] = $list->product_category;
            }
        }



        echo Html::activeLabel($model, 'attrc');


        echo Select2::widget([
            'name' => 'Product[attrc]',
            'data' => $data2,
            'options' => ['placeholder' => 'دسته بندی', 'multiple' => true],
            'value' => $arr_select, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);



        echo Html::error($model, 'attrc');
        ?>
        
        <br>
        <hr>
        <br>
        <div class="col-md-6">
        <?= $form->field($model, 'img1')->fileInput(['id' => 'imgInp']) ?>
        <small>حذف تصویر : </small>
        <br>
        <label class="switch">

            <input type="checkbox" name="clearimg">

            <span class="slider round"></span>
        </label>
        <br>
        <?php if (strlen($model->image) > 2) { ?>
            <img id="imgInp_"  src="<?php echo $_http . $_SERVER['SERVER_NAME'] . '/backend/web/' . $model->image; ?>" alt="تصویر " width="200"/>

        <?php } else { ?>
            <img id="imgInp_" src="img/no_image.png" alt="تصویر اصلی" width="200"/>
        <?php } ?>
            </div>
        <div class="col-md-6">
        
        <?= $form->field($model, 'file')->fileInput(['id' => 'imgInp1']) ?>
        <small>حذف تصویر دوم : </small>
        <br>
        <label class="switch">

            <input type="checkbox" name="clearimg2">

            <span class="slider round"></span>
        </label>
        <br>
        <?php if (strlen($model->image_2) > 2) { ?>
            <img id="imgInp1_"  src="<?php echo $_http . $_SERVER['SERVER_NAME'] . '/backend/web/' . $model->image_2; ?>" alt="تصویر " width="200"/>

        <?php } else { ?>
            <img id="imgInp1_" src="img/no_image.png" alt="تصویر اصلی" width="200"/>
        <?php } ?>
            </div>
        

        
        <div class="clearfix"></div>
        <br><hr><br>
        <?PHP
        $b = common\models\ProductAttGroup::find()->all();
        $data = array();
        foreach ($b as $AttGroup) {
            $data[$AttGroup->id] = $AttGroup->name;
        }
        ?>
     <?php  echo FileInput::widget([
    'name' => 'file[]',
    'options'=>[
	'multiple'=>true
],
    'pluginOptions' => [
	'uploadUrl' => Url::to(['upload']),
	'uploadExtraData' => [
	    'insert_id' => $last_id,
	    ],
	 'maxFileCount' => 2
	],
    
    ]);
?>

        <br>
        <hr>
        <br>

        <div class="col-lg-12">
            <div id="gallery-box">

                


                <?php
                $m = explode("\n", $model->gallery);
                $items_arr = array();
                foreach ($m as $imgx) {
                    //echo "*".$imgx;
                    if ($imgx == "") {
                        continue;
                    }
                    ?>
                    <div  class="file-preview-frame file-preview-success " id="uploaded-1494563246882" data-fileindex="-1" data-template="image"><div class="kv-file-content">
                            <img src="<?= $imgx ?>" class="kv-preview-data file-preview-image"  style="width:auto;height:160px; ">
                        </div><div class="file-thumbnail-footer">

                            <div class="file-actions ">
                                <div class="file-footer-buttons">
                                    <button type="button" class="kv-file-remove btn btn-xs btn-default removex" title="<?= $imgx ?>"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                                </div></div></div></div>

                <?php } ?>

            </div>



        </div>
    </div>


    <div class="col-lg-6 panel-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'order_show')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'english_name')->textInput(['maxlength' => true]) ?> 
         <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?> 
           <?= $form->field($model, 'qty')->radioList(array('1' => ' موجود ', '0' => '  ناموجود ')); ?>
        

 <?= $form->field($model, 'extera_info')->textInput(['maxlength' => true]) ?>
        <?PHP
        if ($model->id) {

          
            $price->selling_rate = $model->pricef->selling_rate;
            
            $price->buying_rate = $model->pricef->buying_rate;
            
            ?>

        <?php }
        ?>

        <div class="clearfix"> </div>
        
        <?= $form->field($price, 'selling_rate')->textInput(['maxlength' => true]) ?>
          <?= $form->field($price, 'buying_rate')->textInput() ?>
      
        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    چکیده
                </h3>

                <textarea name="Product[summery]" id="editor1" ><?= $model->summery ?></textarea>

            </div>
        </div>


        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    توضیحات
                </h3>

                <textarea name="Product[body]" id="editor2" ><?= $model->body ?></textarea>

            </div>
        </div>





       




    </div>


    <div class="clearfix"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'gallery')->textarea(['rows' => 6]) ?>

    <?php ActiveForm::end(); ?>





</div>


<script>
    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $("#" + input.id + "_").attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp,#imgInp1").change(function () {

        readURL(this);
    });
</script>
<script>
    editor = CKEDITOR.replace('editor1', {
        extraPlugins: 'lineutils,widget,image2',
        height: '200px',
        toolbar: [
            {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
            {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
            {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
            {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
            '/',
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
            '/',
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']},
            {name: 'others', items: ['-']},
            {name: 'about', items: ['About']}
        ]


                // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });



    editor.addCommand("mySimpleCommand", {
        exec: function (edt) {
            // alert("X");


            var start_element = edt.getSelection().getStartElement().getOuterHtml();
            em = start_element.slice(0, 4);

            if (em == "<img") {
                editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
            }

        }
    });







</script>    
<script type="text/javascript">
    function openKCFinder(div) {
        window.KCFinder = {
            callBack: function (url) {
                // alert(url);
                $('#fimage').val(url);
                window.KCFinder = null;
                div.innerHTML = '<div style="margin:5px">Loading...</div>';
                var img = new Image();
                img.src = url;
                img.onload = function () {
                    div.innerHTML = '<img id="img" src="' + url + '" />';
                    var img = document.getElementById('img');
                    var o_w = img.offsetWidth;
                    var o_h = img.offsetHeight;
                    var f_w = div.offsetWidth;
                    var f_h = div.offsetHeight;
                    if ((o_w > f_w) || (o_h > f_h)) {
                        if ((f_w / f_h) > (o_w / o_h))
                            f_w = parseInt((o_w * f_h) / o_h);
                        else if ((f_w / f_h) < (o_w / o_h))
                            f_h = parseInt((o_h * f_w) / o_w);
                        img.style.width = f_w + "px";
                        img.style.height = f_h + "px";
                    } else {
                        f_w = o_w;
                        f_h = o_h;
                    }
                    img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
                    img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
                    img.style.visibility = "visible";
                }
            }
        }
        ;
                window.open($_http.$_SERVER['SERVER_NAME'].'/frontend/web/kcfinder/browse.php?type=images&dir=images/public',
                        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
                        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
                        );
    }
</script>
<script>
    editor = CKEDITOR.replace('editor2', {
        extraPlugins: 'lineutils,widget,image2',
        height: '200px',
        toolbar: [
            {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
            {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
            {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
            {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
            '/',
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
            '/',
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']},
            {name: 'others', items: ['-']},
            {name: 'about', items: ['About']}
        ]


                // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });



    editor.addCommand("mySimpleCommand", {
        exec: function (edt) {
            // alert("X");


            var start_element = edt.getSelection().getStartElement().getOuterHtml();
            em = start_element.slice(0, 4);

            if (em == "<img") {
                editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
            }

        }
    });




</script> 