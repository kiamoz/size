<?php
/**
 * @author www.echargeu.ir
 * @email: echargeu@gmail.com
 * @copyright 2016
 */

include("config.php");
connect2();

$sql= "\n"
    . "\n"
    . "CREATE TABLE IF NOT EXISTS `downloader` (\n"
  . " `id` int(11) NOT NULL AUTO_INCREMENT,\n"
  . " `filename` text NOT NULL,\n"
  . " `prc` int(11) NOT NULL,\n"
  . " `token` text NOT NULL,\n"
  . " `refid` varchar(100) NOT NULL,\n"
  . " `gateway` varchar(10) NOT NULL,\n"
  . " `cname` varchar(200) NOT NULL,\n"
  . " `prdid` int(12) NOT NULL,\n"
  . " `email` varchar(100) NOT NULL,\n"
  . " `mobile` varchar(15) NOT NULL,\n"
  . " `ip` varchar(20) NOT NULL,\n"
  . " `created` varchar(20) NOT NULL,\n"
  . " `modified` varchar(20) NOT NULL,\n"
  . " `down_num` int(11) NOT NULL,\n"
  . " `ercod` int(11) NOT NULL,\n"
  . " `sts` int(11) NOT NULL,\n"
  . " PRIMARY KEY (`id`)\n"
  . ") ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$result = mysql_query($sql);
echo $result;
if($result==1) echo 'جدول 1 ایجاد شد'."<br>";
else echo 'جدول 1 ایجاد نشد'."<br>";

?>