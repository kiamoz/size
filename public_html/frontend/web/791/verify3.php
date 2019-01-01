<?php
error_reporting(0);
date_default_timezone_set('Asia/Tehran');


if (isset($_GET['checkid']) && $_GET['checkid'] != '') {
    session_start();
    if ($_SESSION['logedin'] == 'true') {
        $date_format = "y/m/d | G:i:s";

        require_once ('lib/nusoap.php');
        require_once ('mellat_funcs.php');
        include($_SERVER['DOCUMENT_ROOT'] . "../config.php");

        connect2();
        ?>
        <div style="margin: auto;text-align: right;direction: rtl;font-size: 16px;background: #baf2ba99;padding: 10px;">
            <?php
            check_setle($_GET['checkid']);
            ?>
        </div>
        <?php
    }
}

function verify() {

    $cath["filename"];
    $date_format = "y/m/d | G:i:s";

    require_once ('lib/nusoap.php');
    require_once ('mellat_funcs.php');
    include($_SERVER['DOCUMENT_ROOT'] . "../config.php");

    connect2();

    $sucmsg = '<br><label>شماره تراکنش را یادداشت نمایید.</label>';
    $downmsg = '<div class="errfooter fa fa-check">
                                  <label>در صورت بروز هرگونه مشکل، از طریق فرم تماس با ما اطلاع دهید.</label>
                                  </div>';

    $payedmsg = '<div class="footer fa fa-check">
                                  <label>در صورت بروز هرگونه مشکل، از طریق فرم تماس با ما اطلاع دهید.</label>
                                  ' . $sucmsg . '
                                  </div>';
    // echo "X3";
    if (isset($_GET['bank_name']) && $_GET['bank_name'] == 'mellat' && isset($_GET["aum"]) && $_GET["aum"] != '') {
        //echo "X4";
        $RefId = mysql_real_escape_string($_POST["RefId"]);
        //  print_r($_POST);
        $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
        $result2 = mysql_query($sql);
        if ($result2 && mysql_num_rows($result2) > 0) {
            // echo "X5";
            $cath = mysql_fetch_array($result2);
            if ($cath['sts'] == 2) {//setteled 
                // echo epay_errors('1205').'</br>';
            } else {
                //echo "X6";

                $servername = "localhost";
                $username = username;
                $password = password;

                // Create connection
                $conn = new mysqli($servername, $username, $password, database);

                $t = bpVerifyRequest();
                //echo $t;


                $sql = sprintf("SELECT * FROM  bank_transaction  where id = " . $cath["filename"]);

                $result = $conn->query($sql);
                //echo("Error description: " . mysqli_error($conn));



                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $_table_name = $row["table_name"];
                        $order_id = $row["order_id"];



                        if ($t == 17) {

$sql_t = "UPDATE   bank_transaction  SET   status  = 15 WHERE  id = " . $cath["filename"];
                            $conn->query($sql_t);

                            $sql = "UPDATE   `" . $_table_name . "`  SET   pay_status  = 15 WHERE  id = " . $order_id;
                            if ($conn->query($sql) === TRUE) {
                                echo "<script type='text/javascript'>  window.location='http://" . yourdomain . "/site/tracking?id=" . $cath["filename"] . "'; </script>";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }


                            
                            //return 17; 
                        }

                        //17 انصراف
                        // 0 بی خطا



                        $f = ""; 
                        if ($t == 0) {
                            $f = bpSettleRequest($RefId);
                            
                            
                             $sql_t = "UPDATE   bank_transaction  SET   status  = 1 WHERE  id = " . $cath["filename"];
                            $conn->query($sql_t);
                            $sql = "UPDATE   `" . $_table_name . "`  SET   pay_status  = 1 WHERE  id = " . $order_id;
                            if ($conn->query($sql) === TRUE) {
                                echo "<script type='text/javascript'>  window.location='http://" . yourdomain . "/site/tracking?id=" . $cath["filename"] . "'; </script>";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }

                           
                            //return 0;

                            $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
                            $result2 = mysql_query($sql);
                            if (!$result2 || mysql_num_rows($result2) == 0)
                                return 1201;
                            if ($result2 && mysql_num_rows($result2) > 0) {


                                $cath = mysql_fetch_array($result2);

                                $orderId = $cath["id"];
                                $saleOrderId = $cath["id"];
                                $saleReferenceId = $cath["refid"];
                                $Amount = $cath["prc"];

                                $sts = $cath["sts"];
                                $cname = $cath['cname'];
                                $email = $cath["email"];
                                $down_num = $cath["down_num"];
                            }

                            // echo "X88";


                            $servername = "localhost";
                            $username = "zirkhak_zirkhak";
                            $password = "^blackoMa&UM";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password);

                            // Check connection

                            if ($conn->query($sql) === TRUE) {
                                //    echo "New record created successfully";
                                //header("Location: http://havijoori.com/frontend/web/index.php?r=site%2Ftracking");
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }



                            //header('Location: http://www.havijoori.com');
                            if ($result2 && mysql_num_rows($result2) > 0 && ($sts == 1 || $sts == 2) && $down_num < 10) {
                                echo $massage;
                                $error1 = '';
                                send_pay_msg($email, $cname, $saleReferenceId);
                                echo $error1 . $payedmsg . '</div>';
                            }
                        } else {

                            $sql2 = "UPDATE downloader SET ercod='" . $t . "',modified='" .
                                    date($date_format) . "' WHERE token='" . $RefId . "' ";
                            mysql_query($sql2);
                            mysql_free_result($result2);
                            mysql_close($db);

                            echo "خطا: " . epay_errors($t) . $downmsg . '</br><a href="http://' . yourdomain . '>بازگشتبه سایت </a>';
                            echo '<br>';
                            echo "سفارشات شما در صفحه ی حساب کاربری قابل مشاهده هستند ";
                            echo $cath["filename"];
                            $sql = "UPDATE  `zirkhakee.zirkhak`.`ads` SET  `status` = 1 WHERE  `ads`.`id` = " . $cath["filename"];
                            $result = mysql_query($sql);
                        }
                    }
                }

                echo "X2";
            }//end need verify
        }//new if 
    }//end mellat
    else {
        echo "X11";
        echo '<i style="color:red" class="fa fa-exclamation-circle fa-2x" ></i>';
        echo 'عملیات پرداخت متوقف شد.</br>';
    }

    echo "X";
}

//end verify()

function send_pay_msg($email, $cname, $refid) {
    $output = 1;
    if ($email && check_email_address_verify($email)) {
        if ($cname && $email) {

            $admin_msg = '';
            $mail_body = '';
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            if ($email) {
                $admin_msg = 'پرداخت';
                $mail_body = '<html>
        
        <body>
        
        <div style="border:1px solid #D0D6D6;border-radius:5px;color:#333;height:300px;font-size:11pt;background-color:#F0F0F0;background-repeat:repeat; font-family:tahoma;text-align:justify;direction:rtl;" >
        <div style="float:right;font-size:9pt;padding:5px;">
        
        <br><p></p><a>' . $cname . ' گرامی</a><br><a>با تشکر از خرید شما، </a>
        <a color="#CC0000">شماره تراکنش شما: ' . $refid . ' می باشد.</a><br>
        <a> در صورت بروز هرگونه مشکل، از طریق</a>
        <a href="http://' . www . havijoori . com . '">فرم تماس با ما </a><a>مشکل خود را پیگیری نمایید.</a>
        </div></div>
        </body>
        
        </html>';
            }

            mail(adminemail, $admin_msg, "<html>" . $email . " | " . date($date_format) .
                    " | " . $_SERVER["REMOTE_ADDR"] . "<p></html>", $headers, '');
            mail($email, "پرداخت", $mail_body, $headers, '');
        }
    }
}

//end send_pay_msg()

function check_email_address_verify($email) {
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

// end check_email_address_verify()
?>  