<?php

use yii\helpers\url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
?>
<script src="images/ckeditor/ckeditor.js"></script>

<div class="person-form panel col-md-8 col-md-push-4 col-xs-12 dir_r">
    <div class=" panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'family')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'twitter')->textInput(['maxlength' => 300]) ?>
          <hr>
        
        
        <?= $form->field($model, 'birth_year')->textInput(['maxlength' => true]) ?>

         <hr>
        <small> ماه تولد</small>
        <?PHP
        $data_item_month = ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
        

        echo Select2::widget([
            'name' => 'Person[birth_month]',
            'data' => $data_item_month,
            'options' => ['placeholder' => 'ماه تولد'],
            'value' => $model->birth_month, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
        ?>
         <hr>
        <?= $form->field($model, 'birth_day')->textInput(['maxlength' => true]) ?>
        <hr>
        <small> کشور محل تولد</small>

        <?PHP
        $data_item_4 = common\models\Country::find()->all();
        $data_4 = array();
        foreach ($data_item_4 as $data_items_4) {
            $data_4[$data_items_4->id] = $data_items_4->name;
        }

        echo Select2::widget([
            'name' => 'Person[birth_country_id]',
            'data' => $data_4,
            'options' => ['placeholder' => 'کشور محل تولد'],
            'value' => $model->birth_country_id, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
        ?>
        
         <hr>
        <small> شهر محل تولد</small>

        <?PHP
        $data_item_3 = common\models\Location::find()->all();
        $data_3 = array();
        foreach ($data_item_3 as $data_items_3) {
            $data_3[$data_items_3->id] = $data_items_3->name;
        }

        echo Select2::widget([
            'name' => 'Person[birth_place_id]',
            'data' => $data_3,
            'options' => ['placeholder' => 'شهر محل تولد'],
            'value' => $model->birth_place_id, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
        ?>
        
        
          <hr>
        <small> شغل ها</small>
        <?PHP
        $data_item_5= common\models\PersonType::find()->all();
        $data_5 = array();
        foreach ($data_item_5 as $data_items_5) {
            $data_5[$data_items_5->id] = $data_items_5->title;
        }
        if($model->id){
             
         $person_has_ty = common\models\PersonHasType::find()
                 ->where('person_id='.$model->id)
                 ->all();   
         foreach($person_has_ty as $pty){
           $arr_selected_5[] = $pty->type_id;
         }    
         }
            

        echo Select2::widget([
            'name' => 'Person[type]', 
            'data' => $data_5,
            'options' => ['placeholder' => ' شغل ', 'multiple' => true],
            'value' => $arr_selected_5, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],  
        ]); 
        ?>
        
        
        
        

        <?= $form->field($model, 'image_file')->fileInput(['id' => 'file_id']) ?>
        <?php if ($model->image) { ?>
            <br>
            <input type="checkbox" value="1" name="delete_movie_image">حذف عکس
            <br>
            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->image; ?>" style=" width: 50px ; height: 50px">
        <?php } ?>

        <br><br>
        
        
        <?= $form->field($model, 'cover_file')->fileInput(['id' => 'file_id']) ?>
        <?php if ($model->cover) { ?>
            <br>
            <input type="checkbox" value="1" name="delete_person_cover">حذف cover
            <br>
            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->cover; ?>" style=" width: 50px ; height: 50px">
        <?php } ?>
        <br><br>
        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    بیوگرافی
                </h3>

                <textarea name="Person[biography]" id="editor1" ><?= $model->biography ?></textarea>

            </div>
        </div>
        <small>( با - جدا کنید)</small>
        <?= $form->field($model, 'contact')->textarea(['rows' => 3]) ?>
        
        
        
        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    جوایز
                </h3>

                <textarea name="Person[awards]" id="editor2" ><?= $model->awards ?></textarea>

            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    سایت ها
                </h3>

                <textarea name="Person[sites]" id="editor3" ><?= $model->sites ?></textarea>

            </div>
        </div>
        

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

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



    /* editor.ui.addButton('C', {
     label: "CENTER",
     command: 'mySimpleCommand',
     icon: 'http://24news.ir/img/Center-icon.png'
     }); */



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



    /* editor.ui.addButton('C', {
     label: "CENTER",
     command: 'mySimpleCommand',
     icon: 'http://24news.ir/img/Center-icon.png'
     }); */



</script>
<script>
    editor = CKEDITOR.replace('editor3', {
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



    /* editor.ui.addButton('C', {
     label: "CENTER",
     command: 'mySimpleCommand',
     icon: 'http://24news.ir/img/Center-icon.png'
     }); */



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
        };
        window.open('http://film-news.ir/frontend/web/kcfinder/browse.php?type=images&dir=images/public',
                'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
                );
    }
</script>