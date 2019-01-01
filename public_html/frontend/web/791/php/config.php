<?php
/**
 * @author www.echargeu.ir
 * @email: echargeu@gmail.com
 * @copyright 2016
 * Version 3.0
 */
//=======================================================================
//                     تنظیمات سایت                                     |
//                                                                      |
//----------------------------------------------------------------------|
error_reporting(0);
/**/define('hostname','localhost');				   	  		          /*|
//          نام کاربری دیتابیس                  		              /*|
/**/define('username','iransize_shop');						   	  	          /*|
//            رمز ورود دیتابیس                 		                  /*|
/**/define('password','userP#23#');									          /*|
//                 نام دیتابیس 		   			                      /*|
/**/define('database','iransize_shop');
//           لینک صفحه اصلی پرداخت
define("main_url","http://".$_SERVER['SERVER_NAME']."/frontend/web/791/");
define("yourdomain", $_SERVER['SERVER_NAME']);
//         نام و نام کاربری مدیر
define("adminuser", "admin");
define("adminpass", "1234");
define("adminsts", "1");
define("adminemail", "email@mail.com");

//=======================================================================
//                  تنظیمات درگاه پرداخت                              /*|

define("salt", "#$8r7vKfd2kxf%^%^#jJrE*xGxJ^*slk#@");
//Mellat Epay
define("terminal_id", "3633310");
define("terminal_user_name", "mkjnh2136");
define("terminal_password", "36999615");
define("terminal_call_back", main_url.'/index.php?verify');
define("date_format","y/m/d | G:i:s");
define("gate_status", "1");

//----------------------------------------------------------------------| 
   connect2();
//=======================================================================

//=======================================================================
/**/function connect2($host=hostname,$username=username,$password=password,$database=database){				  /*|
/**/
        $dbhost = $host;
        $dbuser = $username;
        $dbpass = $password;
        $dbname = $database;
        $db = @mysql_pconnect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        if (!$db) {
            echo "خطایی رخ داده است...";
            exit;
        }
/**/}																 /*|
//=======================================================================
*/
?>