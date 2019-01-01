<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Category;
?>
<script src="images/ckeditor/ckeditor.js"></script>
<div class="category-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
 <?= $form->field($model, 'menu_show')->radioList(array('1' => 'نمایش در منو', '0' => 'عدم نمایش در منو')); ?>

        <?PHP
        $b = Category::find()->all();
        $date = array();
        foreach ($b as $Category) {
            $data[$Category->id] = $Category->name;
        }

       echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['placeholder' => ' گروه بندی'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
        ?>
        
          <?= $form->field($model, 'temp_img')->fileInput(['id' => 'file_id']) ?>
        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    متن
                </h3>

                <textarea name="Category[body]" id="editor1" ><?= $model->body ?></textarea>

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
