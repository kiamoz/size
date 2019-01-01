<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use kartik\select2\Select2;
use dosamigos\fileupload\FileUploadUI;
use kartik\file\FileInput;
use yii\helpers\Url;
use common\models\Post;
use common\models\PostHasCategory;

?>
<script src="images/ckeditor/ckeditor.js"></script>


<div class="movie-form panel col-md-4 dir_r">

    <div class=" panel-body">
        <hr>
        <small>دسته بندی</small>
        <?php $form = ActiveForm::begin(); ?>
        <?PHP
       
      


        if ($_GET['id']) {

            $m = common\models\PostHasCategory::find()
                    ->where('post_id=' . $_GET['id'])
                    ->all();
            $arr_select = array();

            foreach ($m as $list) {

                $arr_select[] = $list->category_id;
            }
        }

        echo Select2::widget([
            'name' => 'Post[cats]',
            'data' => $data,
            'options' => ['placeholder' => 'دسته بندی', 'multiple' => true],
            'value' => $arr_select, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
        ?>


        <br><br>



        <hr>
        <small>برچسب ها </small>

        <?PHP
        $t = common\models\Tag::find()->all();
        $data_t = array();
        foreach ($t as $tag) {
            $data_t[$tag->id] = $tag->name;
        }

        if ($_GET['id']) {

            $p_t = common\models\PostHasTag::find()
                    ->where('post_id=' . $_GET['id'])
                    ->all();
            $_t_arr_select = array();

            foreach ($p_t as $_t_list) {

                $_t_arr_select[] = $_t_list->tag_id;
            }
        }

        echo Select2::widget([
            'name' => 'Post[tags]',
            'data' => $data_t,
            'options' => ['placeholder' => 'برچسب', 'multiple' => true],
            'value' => $_t_arr_select, // initial value
            'pluginOptions' => [
                'tags' => true,
//                'maximumInputLength' => 10
            ],
        ]);
        ?>
        <hr>
      







        <?php if (strlen($model->thumb_nail)>2) {
            ?>
            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->thumb_nail; ?>" width="150" >
            <br><br>
            <input type="checkbox" name="clear_img" value="1"> حذف تصویر
        <?php }else{ echo '<small>بدون تصویر</small>' ;} ?>
        <?= $form->field($model, 'file')->fileInput(['id' => 'file_id']) ?>
        <hr>
        <br>
        <?php if (strlen($model->video)>2) {
            ?>
            <video width="320" height="240" controls>
                <source src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->video; ?>" type="video/mp4">

            </video>
            <br><br>
            <input type="checkbox" name="clear_video" value=""> حذف ویدئو
        <?php }else{ echo '<small>بدون ویدئو</small>' ;} ?>
        <?= $form->field($model, 'video_file')->fileInput(['id' => 'file_id']) ?>

    </div>
</div>
<div class="movie-form panel col-md-8 dir_r">

    <div class=" panel-body">

        <?PHP
        $p = Post::find()->limit(1)->orderBy(['id' => SORT_DESC,])->all();
        foreach ($p as $post_x) {
            $last_id = $post_x->id;
            $last_id++;
        }
        $model->id = $last_id;
        ?>


        <?= $form->field($model, 'title')->textInput(['maxlength' => 1000]) ?>



        <?= $form->field($model, 'link')->textInput(['maxlength' => 500]) ?>

        <?= $form->field($model, 'menu_show')->radioList(array('1' => 'نمایش در منو', '0' => 'عدم نمایش در منو')); ?>

        <small> ویدئو </small>
        <br>
        <label class="switch">
            <?php if ($model->is_video == 1) { ?>
                <input type="checkbox" checked name="Post[is_video]">
            <?php } else { ?>
                <input type="checkbox" name="Post[is_video]">
            <?php } ?>
            <span class="slider round"></span>
        </label>
        <br>
        
        <small> گزارش تصویری(گالری) </small>
        <br>
        <label class="switch">
            <?php if ($model->is_gallery == 1) { ?>
                <input type="checkbox" checked name="Post[is_gallery]">
            <?php } else { ?>
                <input type="checkbox" name="Post[is_gallery]">
            <?php } ?>
            <span class="slider round"></span>
        </label>
        <br>

        <br>


        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    خلاصه متن
                </h3>

                <textarea name="Post[summery]" id="editor1" ><?= $model->summery ?></textarea>

            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <h3 class="title-hero">
                    متن
                </h3>

                <textarea name="Post[body]" id="editor2" ><?= $model->body ?></textarea>

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
        extraPlugins: 'lineutils,widget', //,image2
            height: '200px',
            toolbar: [
                {name: 'document', items: ['Source']},
                //{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                //{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
                //{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
                //'HiddenField' ] },
                //'/',
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                        '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','LL','SuperButton','RR', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'insert', items: ['Image', 'L', 'C', 'R']},
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                {name: 'colors', items: ['TextColor', 'BGColor']},
                        //{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
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
<script>
    editor = CKEDITOR.replace('editor2', {
         extraPlugins: 'lineutils,widget', //,image2
            height: '600px',
            toolbar: [
                {name: 'document', items: ['Source']},
                //{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                //{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
                //{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
                //'HiddenField' ] },
                //'/',
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                        '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','LL','SuperButton','RR', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'insert', items: ['Image', 'L', 'C', 'R']},
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                {name: 'colors', items: ['TextColor', 'BGColor']},
                        //{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
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