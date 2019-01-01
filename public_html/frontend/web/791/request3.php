<?php
error_reporting(0);
date_default_timezone_set('Asia/Tehran');

if (isset($_POST['id']) && isset($_POST['submit']))
    request();
if (isset($_POST['tracking']))
    track();

function check_referer() {
    $allowedDomains = array(yourdomain, 'www.' . yourdomain);
    $referer = $_SERVER['HTTP_REFERER'];
    $domain = parse_url($referer);
    if (in_array($domain['host'], $allowedDomains)) {//only from allow domains    
        return 1;
    }//end only from allowed domain
    else
        return 0;
}

//end check_referer


if (isset($_GET['checkst']) && $_GET['checkst'] != '') {
    $date_format = "y/m/d | G:i:s";
    require_once ('lib/nusoap.php');
    require_once ('mellat_funcs.php');
    connect2();
    $settle_sts = check_setle($_GET['checkst']);
    echo $settle_sts;
}

function tracking() {
    $java_action = 'action="javascript:tracking()" enctype="multipart/form-data"';
    ?>
    <div style="text-align: right;">
        <div class="fname" style="font-family: google;font-size: 14px;"><label for="lname">مشخصات خود را وارد کنید:</label></div><p>
        <form <?php echo $java_action; ?> method="post" style="margin-bottom: 5px;">
            <div class="margin-bottom" style="width: 300px;direction: rtl;">
                <div class="input-group margin-bottom-sm" onmouseover="formcss('track');" onmouseout="formcss('track');">
                    <span class="input-group-addon" style="padding: 0px 10px;"><i id="track" class="fa fa-info fa-fw" style="font-size: 22px;"></i></span>
                    <input id="tracking" class="form-control" onfocus="tooltip.show('شماره تراکنش');" onmouseout="tooltip.hide();" placeholder="شماره تراکنش" name="cname" type="text">
                </div>
                <div class="input-group margin-bottom-sm" onmouseover="formcss('email');" onmouseout="formcss('email');">
                    <span class="input-group-addon" style="padding: 0px 11px 0px 12px;"><i id="email" class="fa fa-envelope-o fa-fw" style="font-size: 20px;"></i></span>
                    <input id="downemail" class="form-control" onfocus="tooltip.show('ایمیل وارد شده در هنگام خرید');" onmouseout="tooltip.hide();" placeholder="email@example.com" name="email" type="email">
                </div>
                <div class="input-group" onmouseover="formcss('mobile');" onmouseout="formcss('mobile');">
                    <span class="input-group-addon" style="padding: 0px 2px 0px 5px;"><i id="mobile" class="fa fa-mobile fa-fw" style="font-size: 32px;"></i></span>
                    <input id="downmob" class="form-control" onfocus="tooltip.show('شماره موبایل وارد شده در هنگام خرید');" onmouseout="tooltip.hide();" placeholder="موبایل" name="mobile" type="text">
                </div>      
                <button class="btn" type="submit" style="margin-top:3px;font-size: 17px;width:auto;" name="submit">
                    <a style="font-size: 14px;font-family: google;"><i id="downsts" style="color: white; font-size: 18px; margin: 0px 5px;" class="fa fa-chevron-circle-right"></i>پیگیری</a>
                </button>
                <div id="downresult"></div>
            </div>
        </form>
    </div>

    <?php
}

function track() {
    // include($_SERVER['DOCUMENT_ROOT']."../config.php");
    include("./php/config.php");
    $dbhost = hostname;
    $dbuser = username;
    $dbpass = password;
    $dbname = database;

    if (isset($_POST['submit']) && $_POST['email'] != '' &&
            $_POST['mobile'] != '' && isset($_POST['tracking'])) {
        try {

            $connection = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass);
            $connection->exec('set names latin1');
            $connection->exec('SET CHARACTER SET latin1');
            $connection->exec('SET CHARACTER_SET_CONNECTION=latin1');

            $prepared = $connection->prepare('select id,prc,prdid,refid,sts from downloader where refid=? and email=? and mobile=? ');


            $refid = $_POST['tracking'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];

            $bind = array($refid, $email, $mobile);
            $prepared->execute($bind);
            $data = $prepared->fetchAll(PDO::FETCH_ASSOC);


            //show data array in output
            foreach ($data as $row) {
                if ($row['sts'] == 4 or $row['sts'] == 2)
                    echo '<i class="fa fa-check fa-2x" style="color:green"></i>' . 'پرداخت موفق، شماره سفارش:' . $row['id'] . '</br>';
                echo 'مبلغ: ' . $row['prc'] . ' ریال' . '</br>';
                echo 'شماره پیگیری: ' . $row['refid'] . '</br>';
            }
        } catch (PDOException $e) {
            //error text info
            echo $e . getMessage();
            //error array
            // print_r($e.errorInfo());
        }
    }
}

function request() {

    $date_format = "y/m/d | G:i:s";
    // include($_SERVER['DOCUMENT_ROOT']."../config.php");
    include("./php/config.php");


    require_once ('lib/nusoap.php');
    require_once ('mellat_funcs.php');
    connect2();

    if (isset($_POST['submit']) && $_POST['cname'] != '' && $_POST['email'] != '' &&
            $_POST['mobile'] != '' && isset($_POST['prc']) && $_POST['prc'] != '' && ctype_digit($_POST['prc'])) {//&& check_referer())
        $cname = mysql_real_escape_string($_POST['cname']);
        $amount = mysql_real_escape_string($_POST['prc']);
        $Description = mysql_real_escape_string($_POST['desc']);
        $Email = mysql_real_escape_string($_POST['email']);
        if (strcasecmp(substr($Email, 0, 4), 'www.') == 0)
            $Email = substr($Email, 4);

        $Mobile = mysql_real_escape_string($_POST['mobile']);
        $payment = mysql_real_escape_string($_POST['payment']);

        if ($payment == 'mellat') {
            $user_id = "-1";
            $amount = intval($amount);
            $email = $Email;
            $mobile = $Mobile;
            $callbackURL = terminal_call_back;
            $terminal_id = terminal_id;
            $user = terminal_user_name;
            $pass = terminal_password;
            $payerId = 0;
            $additionalData = $cname . "جهت :" . $Description . " مبلغ:" . $amount;

            $sql = "INSERT INTO downloader(id, filename, prc, token, refid,gateway, cname, prdid, email, mobile, ip, created, modified, down_num,ercod, sts) VALUES('0', '" .
                    $Description . "', '" . $amount . "', '0','0','ML', '" . $cname .
                    "', '" . $prdid . "','" . $Email . "','" . $Mobile . "','" . $_SERVER["REMOTE_ADDR"] . "','" . date($date_format) .
                    "' ,'" . date($date_format) . "','0','3','3')";
            $result2 = mysql_query($sql);
            $saved = $result2;
            $newid = mysql_insert_id();

            $newid = rand(10, 10000);
            $orderId = $newid;
            $namespace = 'http://interfaces.core.sw.bps.com/';
            $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

            // Check for an error
            $err = $client->getError();
            if ($err) {
                echo 'خطای اتصال به بانک...';
                desc_form(gate_status);
                die();
            }

            $parameters = array(
                'terminalId' => $terminal_id,
                'userName' => $user,
                'userPassword' => $pass,
                'orderId' => $orderId,
                'amount' => $amount . '0',
                'localDate' => date("Ymd"),
                'localTime' => date("Gi"),
                'additionalData' => $additionalData,
                'callBackUrl' => $callbackURL . '&bank_name=mellat&aum=' . sha1(salt . $orderId . salt),
                'payerId' => $payerId);
            $result = $client->call('bpPayRequest', $parameters, $namespace);

            // Check for a fault
            if ($client->fault) {
                echo 'مشکل در ارتباط با بانک...';
                desc_form(gate_status);
                die();
            } else {
                // Check for errors

                $resultStr = $result;

                $err = $client->getError();
                if ($err) {
                    // Display the error
                    echo 'خطای دریافت اطلاعات از بانک...';
                    desc_form(gate_status);
                    die();
                } else {
                    // Display the result
                    $error = split(",", $result);
                    if (sizeof($error) != 2)
                        $t = $error;
                    else {
                        if ($error[0] != "0")
                            $t = $error;
                        if ($saved)
                            $t = $error;
                        else
                            $t = array(1200, 0);
                    }

                    if ($t[0] == "0") {//mellat returned pay token
                        $RefId = $t[1];

                        $sql2 = "UPDATE downloader SET token='" . $RefId . "',modified='" .
                                date($date_format) . "' where id='" . $orderId . "' ";
                        mysql_query($sql2);
                        mysql_free_result($result2);
                        mysql_close($db);


                        $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
                        $result2 = mysql_query($sql);

                        if ($result2 && mysql_num_rows($result2) > 0) {
                            $cath = mysql_fetch_array($result2);
                            if ($cath["sts"] == "1") {
                                $Description = $cath["filename"];
                                $amount = $cath["prc"];
                                $Email = $cath["email"];
                                $Mobile = $cath["mobile"];
                            }
                        }


                        $PayPath = "https://bpm.shaparak.ir/pgwchannel/startpay.mellat";
                        mellat_verify($Description, $amount, $Email, $Mobile, $PayPath, $RefId, 'img/pay.jpg');
                    } else { //melat dont returned pay token
                        $err_cod = $t[0];
                        if ($err_cod == 0 || $t[0] == '')
                            $err_cod = '3';

                        $sql2 = "UPDATE downloader SET ercod='" . $err_cod . "',modified='" .
                                date($date_format) . "' where id='" . $orderId . "' ";
                        mysql_query($sql2);
                        mysql_free_result($result2);
                        mysql_close($db);

                        echo 'خطا: ' . epay_errors($t[0]) . '</div>';
                        desc_form(gate_status);
                    }
                }// end Display the result
            }// end Check for errors                          
        }//end mellat
        else {//no gate
            desc_form(gate_status);
        }
    } else { //dargahi entekhab nashode
        desc_form(gate_status);
    } //end form nages
}

//end request()

function mellat_verify($Description, $Amount, $Email, $Mobile, $payurl, $paytoken, $payimg) {
    ?>

    <div class="rss_block" style="font-family: google;font-size: 13pt;width:auto;
         line-height: 18px;margin-top: -3px;padding: 10px;"> 


        <div class="fname">
            <label for="lname"> برای رفتن به صفحه بانک اینجا کلیک کنید</div></div>

    <form id="ffff7" action="<?php echo $payurl ?>" method="post" id="TransactionAddForm" style="text-align: center;">
        <input type="hidden" name="RefId" value="<?php echo $paytoken ?>"/>
        <input type="image" src="<?php echo $payimg ?>" 
               style="margin: 3px 0px; border: 1px solid; border-radius: 5px;width: 165px; height: 75px;"/></div>
    </form><label class="fa fa-check" style="border: 1px solid green; padding: 3px;
                  border-radius: 4px;font-size: 14px; color: green;">پس از پرداخت شماره پیگیری را یادداشت نمایید.</label>


    </form>




    <?php
}

//end mellat_verify()

function desc_form($status) {

    $prd_order = 'خرید';
    $pay_kay = 'ادامه عملیات پرداخت';
    $java_action = 'action="javascript:downloader()" enctype="multipart/form-data"';
    if ($status == 0) {
        //$pay_display = 'none';
    }
    //echo database;
    ?>

    <div id="downresult" style="display:none2 ;">
        <div class="imagepr" style="">       
            <img style="max-width:200px;border-radius: 3px;
                 border: 2px solid rgba(237, 230, 230, 0.98);box-shadow: 0px 1px 2px rgba(30, 30, 30, 0.3);padding: 15px 0px;" src="img/mellat.png"/><p>
                <a style="text-decoration: none; float: left; background: rgb(222, 222, 222) none repeat scroll 0% 0%; border: 1px solid rgb(170, 170, 170); color: gray;" class="btn" href="?tracking">پیگیری پرداخت</a>
        </div>
        <div id="cover"></div>



        <div  class="fname" style="font-family: google;font-size: 14px;text-align: right;"><label for="lname">مشخصات خود را *****وارد کنید:</label></div><p>
        <form id="fffr" <?php echo $java_action; ?> method="post" style="text-align: right;">
            <div class="margin-bottom" style="width: 300px;direction: rtl;">
                <div class="input-group margin-bottom-sm" onmouseover="formcss('cname');" onmouseout="formcss('cname');">
                    <span class="input-group-addon" style="padding: 0px 10px;"><i id="cname" class="fa fa-user fa-fw" style="font-size: 22px;"></i></span>
                    <input value="شهر پت" id="downname" class="form-control" onfocus="tooltip.show('نام و نام خانوادگی');" onmouseout="tooltip.hide();" placeholder="نام و نام خانوادگی" name="cname" type="text">
                </div>
                <div class="input-group margin-bottom-sm" onmouseover="formcss('email');" onmouseout="formcss('email');">
                    <span class="input-group-addon" style="padding: 0px 11px 0px 12px;"><i id="email" class="fa fa-envelope-o fa-fw" style="font-size: 20px;"></i></span>
                    <input value="info@zirkhakee.com" id="downemail" class="form-control" onfocus="tooltip.show('ایمیل معتبر وارد کنید');" onmouseout="tooltip.hide();" placeholder="email@example.com" name="email" type="email">
                </div>
                <div class="input-group" onmouseover="formcss('mobile');" onmouseout="formcss('mobile');">
                    <span class="input-group-addon" style="padding: 0px 2px 0px 5px;"><i id="mobile" class="fa fa-mobile fa-fw" style="font-size: 32px;"></i></span>
                    <input value="09129999954" id="downmob" class="form-control" onfocus="tooltip.show('شماره موبایل');" onmouseout="tooltip.hide();" placeholder="موبایل" name="mobile" style="width: 90%;" type="number" maxlength="11">
                </div>
                <div class="input-group margin-bottom-sm" onmouseover="formcss('desc');" onmouseout="formcss('desc');">
                    <span class="input-group-addon" style="padding: 0px 10px;"><i id="desc" class="fa fa-info fa-fw" style="font-size: 22px;"></i></span>
                    <input value="<?php echo $_GET["id"] ?> "  id="paydesc" class="form-control" onfocus="tooltip.show('علت پرداخت');" onmouseout="tooltip.hide();" placeholder="علت پرداخت" name="cname" type="text">

                </div><?php
    $servername = "localhost";
    $username = username;
    $password = password;

// Create connection
    $conn = new mysqli($servername, $username, $password, database);


    $sql = sprintf("SELECT * FROM  bank_transaction  where id = " . $_GET['id']);
    $sql_t = "UPDATE   bank_transaction  SET   status  = 2 WHERE  id = " . $_GET['id'];
    $conn->query($sql_t);





    echo "XRT";


    $am = 0;
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {


            $_table_name = $row["table_name"];
            $order_id = $row["order_id"];

            //echo $order_id;`order`

            $sql_price = sprintf("SELECT * FROM `" . $_table_name . "` where id = " . $order_id);

            $sql_t2 = "UPDATE   `" . $_table_name . "`  SET   pay_status = 2 WHERE  id = " . $order_id;
            //echo "<br>".$sql_t2."<br>";
            $conn->query($sql_t2);

            $conn->query($sql_t);


            $result_price = $conn->query($sql_price);
            if ($result_price->num_rows > 0) {
                while ($row = $result_price->fetch_assoc()) {
                    $am = floor($row["price"]);
                }
            }
        }
    }


    //exit();
    //$am = $am / 10;
    $conn->close();
    ?>
                <div class="input-group" onmouseover="formcss('prc');" onmouseout="formcss('prc');">
                    <span class="input-group-addon" style="padding: 0px 10px 0px 10px;"><i id="prc" class="fa fa-money fa-fw" style="font-size: 22px;"></i></span>
                    <input value="<?= $am ?>"id="payprc" class="form-control" onfocus="tooltip.show('مبلغ به تومان وارد شود');" onmouseout="tooltip.hide();" placeholder="مبلغ (تومان)" name="mobile" style="width: 90%;" type="number" min="100">
                </div>                        
                <div class="input-group" onmouseover="formcss('gway');" onmouseout="formcss('gway');" style="width: 100%">
                    <span class="input-group-addon" style="padding: 0px 6px;width: 36px;">
                        <img id="gateimg" src="<?php if ($status != 0) echo'img/mellat_favicon.ico'; ?>" style="height: 20px; width: 20px;font-size: 9px; font-family: google;" alt="" class=""/>          
                    </span>

                    <select id="downpay" onmouseover="tooltip.show('امکان پرداخت با کلیه کارتهای بانکی');" onmouseout="tooltip.hide();" style="height: 35px;width: 100%;border-radius: 0px;" class="form-control" name="payment">

                <?php
                if ($pay_display != 'none') {
                    $gname = 'درگاه بانک ملت';
                    $gate_onclick = 'onclick="$(' . "'#gateimg'" . ').attr(' . "'src'" . ',' . "'img/mellat_favicon.ico'" . ')"';
                    echo'<option ' . $gate_onclick . ' value="mellat">' . $gname . '</option>';
                } else if ($pay_display == 'none') {
                    echo'<option value="disabled">غیرفعال</option>';
                }
                ?>
                    </select>
                </div>       


                <input type="submit" />

            </div>
        </form>
        <script>

            var myVar = setInterval(myTimer, 1000);

            function myTimer() {
                document.getElementById("fffr").submit();
                clearInterval(myVar);
            }
        </script>

        <div style="overflow: hidden; border-top: 1px solid grey; margin:10px auto; border-bottom: 1px solid grey;">
            <img alt="خرید آنلاین مطمئن" title="خرید آنلاین مطمئن" src="img/footer.jpg" style="width: 100%;"/></br>
        </div>   
    </div>               
    <?php
}

//end desc_form()
?>
      