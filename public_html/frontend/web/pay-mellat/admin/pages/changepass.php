<style>
	#pagef_changepass .searchtable{
		width:100%;	
		margin:0px;
		border:0px;
	}
	
	#pagef_changepass .searchtable .useactbtn{
		text-align:right;
	}
	
	#pagef_changepass .searchtable .useactbtn button{
		width:80px;
	}
		
	#pagef_changepass .searchtable input{
		height:auto;
		border:1px solid #CCC;
		padding:2px 5px 3px 5px;
	}
	
	#pagef_changepass .searchtable select{
		border:1px solid #CCC;
	}
	
	#pagef_changepass .useactbtn button{
		width:70px;
	}
	

</style>

<form id="pagef_changepass" style="display:none" onsubmit="return false">

	<table class="tableA searchtable" align="center" width="200px" cellpadding="0px" cellspacing="0px" border="0px">
      <tr class="tableAhead">
      	<td class="sreachtitles useactbtn" colspan="2"><button type="button" onclick="pchangepass.savepass()">تغییر رمز عبور</button></td>
      </tr>
      <tr class="tableAroweven">
      	<td width="150px">نام کاربری قدیمی</td>
      	<td width="90%"><input class="txt" type="text" name="olduser" size="40" style="direction:ltr!important;text-align:left" /></td>
      </tr>
      <tr class="tableArowodd">
      	<td width="150px">رمز عبور قدیمی</td>
      	<td width="90%"><input class="txt" type="password" name="oldpass" size="40" style="direction:ltr!important;text-align:left" /></td>
      </tr>
      <tr class="tableAroweven">
      	<td colspan="2">&nbsp;</td>
      </tr>
      <tr class="tableArowodd">
      	<td width="150px">نام کاربری جدید</td>
      	<td width="90%"><input class="txt" type="text" name="newuser" size="40" style="direction:ltr!important;text-align:left" /></td>
      </tr>
      <tr class="tableAroweven">
      	<td width="150px">رمز عبور جدید</td>
      	<td width="90%"><input class="txt" type="password" name="newpass" size="40" style="direction:ltr!important;text-align:left" /></td>
      </tr>
      <tr class="tableArowodd">
      	<td width="150px">تکرار رمز عبور جدید</td>
      	<td width="90%"><input class="txt" type="password" name="npassre" size="40" style="direction:ltr!important;text-align:left" /></td>
      </tr>
      
	</table>


</form>


<script>
var pchangepass={
	title:'تغییر رمز عبور',
	body:$('pagef_changepass'),
	
	
	savepass:function(){
		sys.msg('در حال ارسال اطلاعات ...');
		
		var frm=pchangepass.body;
		
		if(frm.olduser.value.length<1){
			sys.msg('لطفا نام کاربری قدیمی را وارد کنید.',1);
			return false;
		};
		
		if(frm.oldpass.value.length<1){
			sys.msg('لطفا رمز عبور قدیمی را وارد کنید.',1);
			return false;
		};
		
		if(frm.newuser.value.length<4){
			sys.msg('طول نام کاربری جدید بسیار کوتاه است.',1);
			return false;
		};
		
		if(frm.newpass.value.length<5){
			sys.msg('طول رمز عبور جدید بسیار کوتاه است.',1);
			return false;
		};
		
		if(frm.newpass.value!=frm.npassre.value){
			sys.msg('رمز عبور جدید و قدیمی مطابقت ندارند.',1);
			return false;
		};
		
		var params={
			'olduser':frm.olduser.value,
			'oldpass':frm.oldpass.value,
			'newuser':frm.newuser.value,
			'newpass':frm.newpass.value,
			'npassre':frm.npassre.value
		};
		
		sys.api('changepass',params,function(result){
			if(result['result']=='OK'){
				sys.msg('رمز عبور و نام کاربری با موفقیت تغییر یافت.',0);
				frm.olduser.value='';
				frm.oldpass.value='';
				frm.newuser.value='';
				frm.newpass.value='';
				frm.npassre.value='';
			}else if(result['result']){
				sys.msg(result['result'].substr(3),result['result'].substr(0,3)!='OK,');
			}else{
				sys.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
			};
		});
	},
		
	reload:function(){
		pchangepass.body.olduser.value='';
		pchangepass.body.oldpass.value='';
		pchangepass.body.newuser.value='';
		pchangepass.body.newpass.value='';
		pchangepass.body.npassre.value='';
	},
	
	open:function(update,open_done){
		sys.title('در این قسمت می توانید نام کاربری و رمز عبور را همزمان تغییر دهید');
		open_done(pchangepass,1);
	}

};

</script>