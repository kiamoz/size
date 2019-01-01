<?php
error_reporting(0);
date_default_timezone_set('Asia/Tehran');
//include("./php/config.php");

$page_title="آسان پرداخت پِت مِت";
if(isset($_GET['tracking']))
{
    $page_title='پیگیری پرداخت';
}
elseif (isset($_GET["verify"]))
    $page_title='وضعیت پرداخت';

?>

<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN' 'http://www.w3.org/TR/html4/frameset.dtd'>
<html itemscope="" itemtype="http://schema.org/WebPage" dir="rtl" lang="fa">



<head>
<title><?php echo $page_title; ?></title>
<meta content="width=device-width, maximum-scale=1" name="viewport">
<meta content="fa" http-equiv="content-language">
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link href="css/font-awesome.css" rel="stylesheet">
<link type="text/css" href="css/style.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="js/funcs.js"></script>

</head>
<style>

</style>
<body>
<div class="main">
<div class="rss_block" style="font-family: google;font-size: 13pt;width:auto;line-height: 18px;margin-top: 3px;padding: 10px 0px 5px;">
<a href="/" title="صفحه اصلی" style=""><span style="color:crimson"><?php echo $page_title ?></span></a>
<span style="float: right;"><a href="./"><i class="fa fa-home fa-2x" style="font-size: 30px;margin-top: -7px;margin-left: -20px;color: #9b1c26;"></i></a></span>       
</div>

<?php

    if (isset($_GET["verify"]))
        {
      
            require_once ("verify3.php");
             verify();
            
            
        }
    else if(isset($_GET['tracking']))
    {
        require_once ("request3.php");
        tracking();
    }         
    else 
    {
        require_once ("request3.php");
        request(22);
    } 
   

?>
    
</div>
</html>