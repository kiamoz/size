jQuery(function ($) {


    $(document).ready(function () {
        
        
        
        
        
$('.sp-wrap').smoothproducts();
        

        $('#product_x').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            },
            rtl: true,

        });
    });

    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function () {
        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function (e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });

    }).on('mouseout', function () {
        $(this).parent().children('li.star').each(function (e) {
            $(this).removeClass('hover');
        });
    });



    $(".mega_menu").mouseover(function () {
        $(this).find('> ul').css('display', 'block');
    })
            .mouseout(function () {
                $(this).find('> ul').css('display', 'none');
            });



    /* 2. Action to perform on click */
    $('#stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }

        // JUST RESPONSE (Not needed)
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        var msg = "";


        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        //alert(ratingValue)
        var proid = $('#varpid').val();
        var rate = ratingValue;
        var r = '';
        switch (ratingValue) {
            case 1:
                r = 'خیلی ضعیف';
                break;
            case 2:
                r = '  ضعیف ';
                break;
            case 3:
                r = 'متوسط ';
                break;
            case 4:
                r = ' خوب ';
                break;
            case 5:
                r = ' خیلی خوب ';
                break;
            default:
                r = ' خیلی خوب  ';
        }
        if (getCookie("product_id" + proid) == null) {
            $.ajax({
                type: 'GET',
                url: '/site/rating?ratee=' + rate + '&pid=' + proid,
                crossDomain: true,
                success: function (output) {
                    if (output.flag == 1) {
                        document.cookie = "product_id" + proid + "=1; expires=Thu, 18 Dec 2022 12:00:00 UTC;";
                        var msg = "";
                        if (ratingValue > 1) {
                            msg = "متشکریم ! شما امتیاز " + r + "داده اید .  ";
                        } else {
                            msg = " متشکریم ! شما امتیاز " + r + " داده اید . برای جلب رضایت  شما تلاش می کنیم ";
                        }
                        responseMessage(msg);
                    } else {
                        msg = 'خطایی رخ داده است . لطفا دوباره تلاش کنید'
                        responseMessage(msg);
                    }
                },
                error: function (xhr, status, error) {


                    //alert(error);
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });


        } else {
            msg = 'شما قبلا به این محصول امتیاز داده اید   '
            responseMessage(msg);
        }

    });


    function responseMessage(msg) {

        $('.success-box').fadeIn(200);
        $('.success-box').css('opacity', '1');
        $('.success-box').html("<small class='note_s'>" + msg + "</small>");
    }
    function getCookie(name) {

        var nameEQ = name + "=";
        //alert(document.cookie);
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(nameEQ) != -1)
                return c.substring(nameEQ.length, c.length);
        }

        return null;
    }



/////////////// end of rating

    function add_to_cart(product_id, qty, that) {
        console.log(product_id);
        $.ajax({
            type: 'GET',
            url: '/site/add_to_card_ajax?product_id=' + product_id + '&qty=' + qty,
            crossDomain: true,
            success: function (output) {

                if (output.flag == 1) {

                    $('.cart-items-count').html(output.count);
                    that.html("مشاهده سبد خرید" + ' ' + '<i class="ec ec-shopping-bag"></i>');
                    var protocol = window.location.protocol.replace(/:/g, '');

                    that.attr('href', protocol + "://" + window.location.hostname + '/site/card');



                    setTimeout(function () {

                        console.log("click done...");
                        $(".removee").click(function () {
                            console.log("rrrr");
                            remove_btn_cartx($(this));
                        });

                        that.parent().find('.ezafe').show();
                    }, 2001);

                }

            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    }

    $(".add_to_card_ajax_avis").one("click", function (e) {

        e.preventDefault();
        that = $(this);
        var product_id = $(this).attr('data-id');
        var qty = 1;
        add_to_cart(product_id, qty, that);


    });


    function do_remove_item(_this) {
        console.log("_functioin click");
        var itemidd = _this.parent().find('.itemidd').val();

        //alert(itemidd);
        that = _this;
        $.ajax({
            type: 'GET',
            url: '/site/remove2?itemm=' + itemidd,
            crossDomain: true,
            success: function (output) {


                that.parent().parent().remove();
                $('i.glyphicon.glyphicon-shopping-cart.icon-white.flipX-icon.xs-icon').attr('data-count', output.count);
                $('.cartx').html(output.carthtml);


                $(".removeitem").click(function () {
                    console.log("_inner click");
                    do_remove_item($(this));

                });



            },
            error: function (xhr, status, error) {


                // alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    }






    $(".removeitem").click(function () {
        console.log("_first click");
        do_remove_item($(this));
    });


    $('#userr-state,#productaddress-state_id').on('select2:select', function (evt) {


        // اضافه کردن به select2 city
        console.log("hi1");


        var sid = evt.params.data.id; // id اون استانی که انتخاب شده
//alert(sid);

        $.ajax({
            type: 'GET',
            url: '/site/state?id=' + sid, // آیدی رو می فرسته به این اکشن تا اسم شهرارو پیدا کنه

            crossDomain: true,
            success: function (output) { // اضافه کردن اسم شهر ها به  select2 دوم با شرط sateid



                //console.log(output);
                n = "";

                $.each(output, function (key, value) {

                    n += "<option value='" + key + "'>" + value + "</option>";
                });




                $('#productaddress-city_id').find('option').remove();
                $('#productaddress-city_id').append(n);


            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    });
    $('#userr2-state').on('select2:select', function (evt) {


        // اضافه کردن به select2 city



        var sid = evt.params.data.id; // id اون استانی که انتخاب شده
//alert(sid);

        $.ajax({
            type: 'GET',
            url: '/site/state?id=' + sid, // آیدی رو می فرسته به این اکشن تا اسم شهرارو پیدا کنه

            crossDomain: true,
            success: function (output) { // اضافه کردن اسم شهر ها به  select2 دوم با شرط sateid



                // console.log(output);
                n = "";

                $.each(output, function (key, value) {

                    n += "<option value='" + key + "'>" + value + "</option>";
                });




                $('#userr2-location').find('option').remove();
                $('#userr2-location').append(n);


            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    });



    window.jaamm;


    $(document).ready(function () {

        if ($('.shipping_radio').is(':checked')) {


            change_ship_price($('input[name=shipping_radio]:checked').val());


        }
        if ($('.paymethod').is(':checked')) {

            $(".paymentsubmit").css("opacity", "1");
            $(".paymentsubmit").css("transition-duration", "1s");
            $(".paymentsubmit").css("pointer-events", "auto");

        }


    });
    function change_ship_price(shipm) {

        $.ajax({
            type: 'GET',
            url: '/site/ersal?shipmethod=' + shipm,
            crossDomain: true,
            success: function (output) {

                if (output.flag > 0) {
                    $(".sabtt").css("opacity", "1");
                    $(".sabtt").css("transition-duration", "1s");
                    $(".sabtt").css("pointer-events", "auto");
                } else {
                    // alert("سفارش شما دچار مشکل شده است لطفا از تمام مرورگر های خود خارج شوید و مجدد سعی نمایید ");
                }

                $('.disnone').css({"visibility": " visisble"});

            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    }





    $(".onn").click(function () {
        $('.cart-buttons').css({"pointer-events": " auto", "opacity": "1", "transition": "opacity 1s ease-out"});
        $('#shipping-calculator').css({"pointer-events": " auto", "opacity": "1", "transition": "opacity 1s ease-out"});
        $('.lock').css({"pointer-events": " none", "opacity": "0.7", "transition": "opacity 1s ease-out"});

    });


    function remove_btn_cartx(_this) {


        var itemid = _this.attr('data-product_id');
        //console.log(itemid);

        that = _this;
        $.ajax({
            type: 'GET',
            url: '/site/remove?item=' + itemid,
            crossDomain: true,
            success: function (output) {

                that.parent().parent().remove();
                $('.cart-items-count').html( output.count);
                
                location.reload();
                

            },
            error: function (xhr, status, error) {
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    }
//***********************************************

    $(".removee").click(function () {

        remove_btn_cartx($(this));

    });


/*
    $(".removcart").click(function () {
        var itemid = $(this).attr('data-product_id');

        $.ajax({
            type: 'GET',
            url: '/site/remove?item=' + itemid,
            crossDomain: true,
            success: function (output) {


                that.parent().parent().remove();
                $('i.glyphicon.glyphicon-shopping-cart.icon-white.flipX-icon.xs-icon').attr('data-count', output.count);
                $('.cartx').html(output.carthtml);
                update_total_();

            },
            error: function (xhr, status, error) {
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    }); */


    $(".removew").click(function () {
        //alert('***');

        var itemidw = $(this).parent().find('.itemidw').val();

        // alert(itemidw);
        that = $(this);
        $.ajax({
            type: 'GET',
            url: '/site/removew?item=' + itemidw,
            crossDomain: true,
            success: function (output) {


                that.parent().parent().parent().parent().remove();


            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    });

//*******************************************************************
    $('#productorder-address_id').on('select2:select', function (evt) {
        
        console.log("g");
        var addid = (evt.params.data.id);

        $('#addressid').val(addid);
        if (addid == -2) {
            $('#newadd').css({"display": " block"});

        } else {
            $('#newadd').css({"display": " none"});
        }

    });

    $(".sabtadd").click(function () {

        var adid = $('#usr_add option:selected').val();
        var usridadd = $('#useridadd').val();
        var orderid = $('#orderidadd').val();
        var adresstextt = $('#addd').val();
        var descr = $('#descaddress').val();
        var city = globalVar;
//console.log(adid);
//console.log(usridadd);
//console.log(orderid);
//console.log(adresstextt);
//alert(adid);
        $.ajax({
            type: 'GET',
            url: '/site/addressajax?userid=' + usridadd + '&addid=' + adid + '&orderid=' + orderid + '&addresstext=' + adresstextt + '&description=' + descr + '&cityy=' + city,
            crossDomain: true,
            success: function (output) {
                console.log('مشکلی در سیستم رخ داده است . لطفا مجددا امتحان کنید');

            },
            error: function (xhr, status, error) {


                console.log('مشکلی در سیستم رخ داده است . لطفا مجددا امتحان کنید');
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    });



    $(".sabtt").click(function () {



        var usrpay = $('#useridpay').val();
        var orderid = $('#orderidpay').val();
        var hazineersal = $('#hazinehamlpay').html();
        var hazinepardakht = $('#jamekol').html();
//alert(hazineersal);
//alert(hazinepardakht);

        $.ajax({
            type: 'GET',
            url: '/site/addhazine?userid=' + usrpay + '&orderid=' + orderid + '&orderid=' + orderid + '&hazineersal=' + hazineersal + '&hazinepardakht=' + jaamm,
            crossDomain: true,
            success: function (output) {

                console.log(output.arr_log);

            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });

    });





    $(document).ready(function () {
        //window.pay = 0;
        window.shipmet = 0;
//    if ((pay == 0)) {
//        $(".paymentsubmit").css("opacity", "0.5");
//        $(".paymentsubmit").css("pointer-events", "none")
//    }

        if ((shipmet == 0)) {
            $(".sabtt").css("opacity", "0.5");
            $(".sabtt").css("pointer-events", "none")
        }

    });
    window.kart = 0;
    $(".paymethod").change(function () {
        pay = ($(this).val());
        if (pay != 0) {
            $(".paymentsubmit").css("opacity", "1");
            $(".paymentsubmit").css("transition-duration", "1s");
            $(".paymentsubmit").css("pointer-events", "auto")
            $(".mainpage").css("opacity", "0");
            $(".mainpage").css("transition-duration", "1s");
            $(".mainpage").css("pointer-events", "none");
            kart = 0;
        }
        if (pay == 4) {

            $('#myModall').modal('show');
            kart = 2;

        }
        // var mablaq=$('#mablaq').html();

//   if(pay==1){
//
//    window.location = "http://havijoori.com/frontend/web/791?id="+mablaq;
//      
//   }
    });


    $("#sabtbtn").click(function () {

        var fish = $('#fish').val();

        $.ajax({
            type: 'GET',
            url: '/site/flashersubmit?ffish=' + fish + '&orddid=' + flashordid,
            crossDomain: true,
            success: function (output) {

                location.reload();
            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });


    });


    function update_total_() {
        var ord = $('#ordid').val();

        $.ajax({
            type: 'GET',
            url: '/site/updatetotal?orderid=' + ord,
            crossDomain: true,
            success: function (output) {


                $('.total_amount').html(output.total)
            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    }


    window.arr_select = [];

    $("[name$='custom_var_radio']").on('click', function () { // برچسب ها با نام کاستوم ور هستند که داخلشون اسپن هست
        //هر اسپنی که انتخاب شه کلاس سلکتد ور می گیره و ایدیش لاگ می شه

        window.arr_select = [];
        //*
        // اگر یک اسپن دیگه انتخاب شد کلاس سلکتد ور از اسپن قبلی حذف بشه
        $("[name$='custom_var_radio']").each(function (index) {
            $(this).find('span').removeClass('selected_var');

        });
        $("[name$='custom_var_radio']").each(function (index) {
            $(this).removeClass('selected_label');

        });
        //*




        $(this).find('span').addClass('selected_var');
        $(this).addClass('selected_label');

        arr_select.push($(this).find('span').attr('id'));

        $("[name$='custom_var']").each(function (index) {

            console.log($(this).val() + '**');
            arr_select.push($(this).val());
        });

        console.log("_____");
        // call_ajax(1000,arr_select);
    });



    $("[name$='custom_var']").on('select2:select', function (evt) {

        window.arr_select = [];

        arr_select.push($('.selected_var').attr('id'));


        $("[name$='custom_var']").each(function (index) {

            console.log($(this).val() + '**');
            arr_select.push($(this).val());
        });









        console.log($('.selected_var').attr('id') + " Select2 ");


        selected_label = $('.selected_var').attr('id');

        console.log("_____");

        //call_ajax(1000,arr_select);

    });



    window.pid;
    window.p_img;

    $(document).ready(function () {
        p_img = ($('.variant_image').attr('src'))
    });


    $("[name$='custom_var']").on('select2:select', function (evt) {
        var_ar_s = (evt.params.data.id);
        call_variant_show(var_ar_s);

    });




    $(".circle").click(function () {

        var_ar_l = $(this).attr('id');
        call_variant_show(var_ar_l);


    });

    $(document).ready(function () {


        if ($('#has_variant').val() == 1) {

            $variant_type = $('#variant_type').val();

            if ($variant_type == 0) { //select2
                var_ar_s = $("[name$='custom_var']").val();
                call_variant_show(var_ar_s);
            } else {
                var_ar_l = $(".selected_var").attr('id');
                call_variant_show(var_ar_l);
            }
        }
    });





    function call_variant_show(var_ar) {

        console.log("call_variant_show");

        pid = $('#varpid').val();
        console.log('/product/variantshow?product_id=' + pid + '&arr=' + var_ar);
        $.ajax({
            type: 'GET',
            url: '/product/variantshow?product_id=' + pid + '&arr=' + var_ar,
            crossDomain: true,
            success: function (output) {
                variant_idd = output.id;
                //alert(output.total);
                if (((output.avl) == 0)) {
                    $('.var_avl').html('ناموجود');
                    $('#qty_card').attr('max', 0);
                    $('#qty_card').attr('min', 0);
                    $('#qty_card').attr('value', 0);

                    $('.x_btn').html('به زودی');
                    $('.x_btn').removeClass('add_to_card_ajax');

                } else {
                    $('.x_btn').html('افزودن به سبد خرید ');
                    $('.x_btn').addClass('add_to_card_ajax');



                    $(".add_to_card_ajax").unbind('click');

                    $(".add_to_card_ajax").click(function () {
                        console.log('*');
                        that = $(this);
                        var product_id = $(this).parent().find('.product_id').val();

                        var qty = $(this).parent().find('#qty_card').val();

                        add_to_cart(product_id, qty, that, variant_idd);


                    });



                    $('.var_avl').html('موجود');
                    //$('#qty_card').attr('max', output.avl2);
                }

                if (((output.total) == '٠') || ((output.total) == '0')) {
                    $('.var_price').html(output.total);
                    $(".add_to_card_ajax").css("pointer-events", "none");
                } else {

                    $('.var_price').html(output.total);
                    $(".add_to_card_ajax").css("pointer-events", "auto");
                }

                $('.variant_image').attr('src', 'http://iransize.com/backend/web/' + output.image);
                $('.zoom').attr('href', 'http://iransize.com/backend/web/' + output.image);

//            $('.zoomLens').css('background-image', 'url(http://iransize.com/backend/web/' + output.image + ')');
//            if (!output.image) {
//                $('.variant_image').attr('src', p_img)
//            }
            },
            error: function (xhr, status, error) {


                //alert(error);
            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    }


    $('#mc-embedded-subscribe-c').on('click', function () {
        var news_mail = $('#mce-EMAIL-c').val();

        if (news_mail.length > 2) {
            $.ajax({
                type: 'GET',
                url: '/site/newsletter?email_add=' + news_mail,
                crossDomain: true,
                success: function (output) {
                    if (output.flag == 1) {
                        $('#notification_container_c').addClass("alert alert-success");
                        $("#notification_container_c").css("transition-duration", "1s");
                        $('#notification_container_c').html("آدرس ایمیل شما با موفقیت ثبت شد");

                        setTimeout(function () {
                            $('#notification_container_c').html("");
                            $('#notification_container_c').removeClass("alert-success");
                        }, 3000);

                    } else if (output.flag == 2) {
                        $('#notification_container_c').addClass("alert alert-danger");
                        $("#notification_container_c").css("transition-duration", "1s");
                        $('#notification_container_c').html("این آدرس ایمیل قبلا ثبت شده است");
                        setTimeout(function () {
                            $('#notification_container_c').html("");
                            $('#notification_container_c').removeClass("alert-danger");
                        }, 3000);
                    }
                },
                error: function (xhr, status, error) {


                    //alert(error);
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });
        } else {
            $('#notification_container_c').addClass("alert alert-danger");
            $("#notification_container_c").css("transition-duration", "1s");
            $('#notification_container_c').html("لطفا آدرس ایمیل خود را وارد کنید");
            setTimeout(function () {
                $('#notification_container_c').html("");
                $('#notification_container_c').removeClass("alert-danger");
            }, 3000);

        }
    });



    $(document).ready(function () {


        if ($('.shipping_radio').is(':checked')) {


            var shipm = $('input[name=shipping_radio]:checked').val();
            console.log('/site/ersal?shipmethod=' + shipm);
            $.ajax({
                type: 'GET',
                url: '/site/ersal?shipmethod=' + shipm,
                crossDomain: true,
                success: function (output) {


                    $('#hazinehamlpay').html(output.hazine_haml);
                    $('#jamekol').html(output.total_price);
                    $('#order_price').html(output.order_price);

                },
                error: function (xhr, status, error) {

                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });
        }

    });
    $(".shipping_radio").change(function () {

        var shipm = ($(this).val());
        $.ajax({
            type: 'GET',
            url: '/site/ersal?shipmethod=' + shipm,
            crossDomain: true,
            success: function (output) {
                $('#hazinehamlpay').html(output.hazine_haml);
                $('#jamekol').html(output.total_price);
                $('#order_price').html(output.order_off);
            },
            error: function (xhr, status, error) {

            },
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    });




    $(".removeitem").click(function () {
        console.log("_first click");
        do_remove_item($(this));
    });

    $(document).ready(function () {

        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function () {
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function (e) {
                if (e < onStar) {
                    $(this).addClass('hover');
                } else {
                    $(this).removeClass('hover');
                }
            });

        }).on('mouseout', function () {
            $(this).parent().children('li.star').each(function (e) {
                $(this).removeClass('hover');
            });
        });






    });
    /* 2. Action to perform on click */
    $('#stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }

        // JUST RESPONSE (Not needed)
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        var msg = "";


        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        //alert(ratingValue)
        var proid = $('#varpid').val();
        var rate = ratingValue;
        var r = '';
        switch (ratingValue) {
            case 1:
                r = 'خیلی ضعیف';
                break;
            case 2:
                r = '  ضعیف ';
                break;
            case 3:
                r = 'متوسط ';
                break;
            case 4:
                r = ' خوب ';
                break;
            case 5:
                r = ' خیلی خوب ';
                break;
            default:
                r = ' خیلی خوب  ';
        }
        if (getCookie("product_id" + proid) == null) {
            $.ajax({
                type: 'GET',
                url: '/site/rating?ratee=' + rate + '&pid=' + proid,
                crossDomain: true,
                success: function (output) {
                    if (output.flag == 1) {
                        document.cookie = "product_id" + proid + "=1; expires=Thu, 18 Dec 2022 12:00:00 UTC;";
                        var msg = "";
                        if (ratingValue > 1) {
                            msg = "متشکریم ! شما امتیاز " + r + "داده اید .  ";
                        } else {
                            msg = " متشکریم ! شما امتیاز " + r + " داده اید . برای جلب رضایت  شما تلاش می کنیم ";
                        }
                        responseMessage(msg);
                    } else {
                        msg = 'خطایی رخ داده است . لطفا دوباره تلاش کنید'
                        responseMessage(msg);
                    }
                },
                error: function (xhr, status, error) {


                    //alert(error);
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });


        } else {
            msg = 'شما قبلا به این محصول امتیاز داده اید   '
            responseMessage(msg);
        }

    });


    function responseMessage(msg) {

        $('.success-box').fadeIn(200);
        $('.success-box').css('opacity', '1');
        $('.success-box').html("<small class='note_s'>" + msg + "</small>");
    }
    function getCookie(name) {

        var nameEQ = name + "=";
        //alert(document.cookie);
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(nameEQ) != -1)
                return c.substring(nameEQ.length, c.length);
        }

        return null;
    }
    
      $(".inc").click(function () {
         
  
   increase_qty(($(this).attr('item_id')),1);
    
});
   
      $(".dec").click(function () {
         
  
   increase_qty(($(this).attr('item_id')),-1);
    
});



function increase_qty(item_id,add) {
    

    $.ajax({
        type: 'GET',
        url: '/item/add_item?item_id=' + item_id + '&add='+ add ,
        crossDomain: true,
        success: function (output) {
          
           if(output.flag==1){
               location.reload();
           }

        },
        error: function (xhr, status, error) {


            alert(error);
        },
        contentType: 'application/json; charset=utf-8',
        dataType: 'json'
    });
}
      
});


