<?php

	if(@ob_start('ob_gzhandler'))	header("Content-Encoding: gzip");
	$ExpireTime = 1000000;
	header('Cache-Control: max-age=' . $ExpireTime); // must-revalidate
	header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ExpireTime).' GMT');
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>:: Payment :: Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fa" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="../public.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<body>
<div class="window"> 

   <form id="panelpasswordcheck" onsubmit="sys.login();return false" action="index.php" method="post">  
   	<div id="panelpasswordcheckmsg">
         <center>
         <font>در حال دریافت اطلاعات ...</font>
         </center>
      </div>
      <center>
      <table id="panelpasswordchecktable" align="center" cellpadding="0px" cellspacing="0px" border="0px">
      	<tr>
         	<td colspan="2" class="panelpasswordchecktitle">فرم ورود به بخش مدیریت</td>
         </tr>
      	<tr>
         	<td>نام کاربری مدیر:</td>
         	<td><input type="text" name="username" /></td>
         </tr>
      	<tr>
         	<td>رمز عبور:</td>
         	<td><input type="password" name="password" /></td>
         </tr>
      	<tr>
         	<td colspan="2"><button type="submit" name="loginbutton">ورود</button></td>
         </tr>
		</table>
      </center>
   </form>

   <div id="panelbodytablesparent" style="display:none"> 
      <table class="panelbodytable" cellpadding="0px" cellspacing="0px" border="0px">
         <tr>
            <td class="panelheader" colspan="2">
               <table width="100%" cellpadding="0px" cellspacing="0px" border="0px"><tr>
                  <td>خوش آمدید</td>
                  <td id="panelheaderlinks"><a onclick="sys.logout()">خروج</a></td>
               </tr></table>
            </td>
         </tr>
         <tr>
            <td class="panelheaderlogo">&nbsp;
               
            </td>
            <td id="panelmsgtable">
               <center>
               <font>در حال بارگذاری</font>
               </center>
            </td>
         </tr>
         <tr>
            <td class="panelrightmenu" valign="top">
               <div id="panelrightmenus"></div>
            </td>
            <td class="panelleftcol" valign="top">
               <form id="panelleftcolumntitle">
                  در حال دریافت اطلاعات ...
               </form>         	
               <div id="panelleftcolumnbody">
                 <?php
                     							
							
                     require_once('pages/changepass.php');
                     require_once('pages/buys.php');
                     require_once('pages/buys_moreinfo.php');
							
                  ?>            
               </div>         	
            </td>
         </tr>   
         <tr>
            <td>&nbsp;
               
            </td>
            <td class="panelfooter">&nbsp;
               
            </td>
         </tr>
      </table>
      <script>sys.init();</script>
	</div>  
 
</div>
</body>
</html>
<?php
	@ob_end_flush();
?>