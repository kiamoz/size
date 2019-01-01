<?php

use yii\widgets\ActiveForm;
?>
<div id="sb-site" style="min-height: 1409px;">
    <div class="page-wrapper">
        <div id="page-content-wrapper">
            <div id="page-content">

                <div class="container">

                    <div class="row mailbox-wrapper">

                        <div class="col-md-8">





                            <div class="example-box-wrapper">

                                <div class="tab-content">



                                    <div class="tab-pane pad0A fade active in" id="tab-example-4">
                                        <div class="content-box">
                                            <?php
                                            $form = ActiveForm::begin([
                                                        'method' => 'post',
                                                        'action' => ['site/editprofile'],
                                                        'options' => [
                                                            'class' => 'form-horizontal pad15L pad15R bordered-row'
                                                        ]
                                            ]);
                                            ?>


                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" value="<?php echo $user->name_and_fam; ?>" name="User[name_and_fam]">
                                                </div>
                                                <label class="col-sm-3 control-label">نام و نام خانوادگی: </label>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" value="<?php echo $user->email; ?>" name="User[email]">
                                                </div>
                                                <label class="col-sm-3 control-label">آدرس ایمیل : </label>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" value="<?php echo $user->username; ?>" name="User[username]">
                                                </div>
                                                <label class="col-sm-3 control-label">حساب کاربری : </label>

                                            </div>
                                            
                                            <div class="form-group">
                                                <small>در صورت تمایل به تغییر رمز عبور از کادر زیر را پر کنید </small>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="User[password]">
                                                </div>
                                                
                                                <label class="col-sm-3 control-label">رمز عبور : </label>

                                            </div>


                                            <div class="button-pane mrg20T">
                                                <button class="btn btn-info" type="submit">ذخیره</button>

                                            </div>
                                            <?php ActiveForm::end(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>