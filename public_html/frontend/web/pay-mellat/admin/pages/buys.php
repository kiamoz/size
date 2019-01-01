<style>
	#pagef_buys .searchtable{
		width:100%;	
		margin:0px;
		border:0px;
	}
	
	#pagef_buys .searchtable .useactbtn{
		text-align:right;
	}
	
	#pagef_buys .searchtable .useactbtn button{
		width:80px;
	}
		
	#pagef_buys .searchtable input{
		border:1px solid #CCC;
	}
	
	#pagef_buys .searchtable select{
		border:1px solid #CCC;
	}
	
	#pagef_buys .useactbtn button{
		width:60px;
	}
</style>

<form id="pagef_buys" style="display:none" onsubmit="return false">

	<table class="tableA searchtable" align="center" width="200px" cellpadding="0px" cellspacing="0px" border="0px">
      <tr class="tableAroweven">
      	<td class="sreachtitles" width="40px">به دنبال:</td>
   		<td width="150px"><input type="text" name="buys_fldstr" size="20" /></td>
      	<td class="sreachtitles" width="40px">از تاریخ:</td>
   		<td width="180px">
         	<div style="width:170px">
               روز <input type="text" name="fdate_d" style="width:18px" maxlength="2" /> 
               ماه <input type="text" name="fdate_m" style="width:18px" maxlength="2" />
               سال <input type="text" name="fdate_y" style="width:36px" maxlength="4" />
				</div>
         </td>
      	<td class="sreachtitles" style="width:40px">تا تاریخ:</td>
   		<td width="200px">
         	<div style="width:170px">
               روز <input type="text" name="tdate_d" style="width:18px" maxlength="2" />
               ماه <input type="text" name="tdate_m" style="width:18px" maxlength="2" />
               سال <input type="text" name="tdate_y" style="width:36px" maxlength="4" />
				</div>
         </td>
   		<td class="sreachtitles" width="90px">فیلتر درخواست ها:</td>
   		<td width="100px">
         	<select name="requeststatus" style="width:150px">
            	<option value="all">همه پرداخت ها</option>
            	<option value="done">پرداخت های موفق</option>
            	<option value="payed">پرداخت های واریز نشده</option>
            	<option value="alldo">همه فعالیت ها</option>
        	</select>
         </td>
   		<td align="right" class="useactbtn"><button onclick="pbuys.update(1,1)" type="button">نمایش نتیجه</button></td>
      </tr>
	</table>

   <div id="pagef_buys_tableshow"></div>

</form>


<script>
var pbuys={
	title:'پرداخت ها',
	body:$('pagef_buys'),
	table:$('pagef_buys_tableshow'),
	data:{},
	
	banksname:{
		'mellat':'ملت',
		'parsian':'پارسیان',
		'sepah':'سپه',
		'melli':'ملی',
		'saman':'سامان',
		'tejarat':'تجارت',
		'maskan':'مسکن',
		'enbank':'اقتصاد نوین',
		'saderat':'صادرات',
		'pasargad':'پاسارگاد',
		'sina':'سینا',
		'day':'دی',
		'ansar':'انصار',
		'post':'پست بانک',
		'sarmayeh':'سرمایه',
		'city':'شهر'
	},
	
	printtable:function(result){
		var paytb,HTML,i,j,k,reqstatus,actbtn,kalatype,obj,pinfo,noempty;
		
		noempty=function(text){return (text==''?'&nbsp;':(text));};
		
		if(lib.isun(result['table'])){
			sys.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
			paytb=[];
		}else{
			paytb=nxml.table(result['table']);
		};
		pinfo=result['info']?nxml.table(result['info'])[0]:[1,1,0,10];
		pinfo={pagecount:pinfo[0],pagenum:pinfo[1],rowcount:pinfo[2],rpp:pinfo[3]};
		HTML='<table class="tableA" width="100%" cellpadding="0px" cellspacing="1px" border="0px"><tr class="tableAhead">'+
			'<td style="width:50px">ردیف</td>'+
			//'<td style="width:70px">بانک</td>'+
			'<td style="width:90px">مبلغ (ریال)</td>'+
			'<td style="width:120px">زمان</td>'+
			'<td style="width:120px">رسید دیجیتالی</td>'+
			'<td>نام پرداخت کننده</td>'+
			'<td style="width:250px">پست الکترونیکی</td>'+
			'<td style="width:130px">شماره تماس</td>'+
			'<td style="width:60px">جزئیات</td>'+
			'<td style="width:40px">وضعیت</td>'+
			'<td style="width:60px">واریز</td>'+
			'</tr>';
		
		if(paytb.length<1) HTML+='<tr class="tableAroweven"><td colspan="40" style="padding:20px;text-align:center">موردی برای نمایش وجود ندارد</td></tr>';
		
		for(i=0;i<paytb.length;i++){
			obj=paytb[i];
			
			obj={
				'payid':obj[0],'bank':obj[1],'cost':obj[2],'datenum':obj[3],'orderid':obj[4],'refid':obj[5],'paystatus':obj[6],'username':obj[7],'email':obj[8],'tel':obj[9]
			};
			
			j=obj.datenum;
			if(j.length<14){
				j='فرمت ناشناخته';
			}else{
				j=j.substr(0,4)+'/'+j.substr(4,2)+'/'+j.substr(6,2)+' '+j.substr(8,2)+':'+j.substr(10,2)+':'+j.substr(12,2);
			};
			obj.date=j;
			
			j=pbuys.banksname;
			obj.bankname=(j[obj.bank]?j[obj.bank]:'ناشناخته');
			
			j={'started':'<a class="wait" title="پرداخت آغاز شده است اما (هنوز) به فرجام نرسیده است"></a>',
				'payed':'<a class="error" title="پول از حساب مشتری کسر شده است اما به حساب شما واریز نشده است"></a>',
				'done':'<a class="success" title="مراحل پرداخت با موفقیت به پایان رسیده است"></a>'
			};
			obj.paytext=(j[obj.paystatus]?j[obj.paystatus]:'ناشناخته');
						
			j={'started':'&nbsp;',
				'payed':'<button onclick="pbuys.doreq(\''+obj.payid+'\',\'pay_settle\')" type="button">واریز</button>',
				'done':'&nbsp;'
			};
			obj.payact=(j[obj.paystatus]?j[obj.paystatus]:'ناشناخته');
			


			
			HTML+='<tr class="tableArow'+(i%2==0?'even':'odd')+'">'+
			'<td>'+noempty(i+(pinfo.pagenum-1)*pinfo.rpp+1)+'</td>'+
			//'<td style="text-align:center!important">'+noempty(obj.bankname)+'</td>'+
			'<td style="text-align:right!important;direction:ltr;">'+noempty(Math.num3(obj.cost))+'</td>'+
			'<td style="text-align:center!important;direction:ltr;">'+noempty(obj.date)+'</td>'+
			'<td>'+noempty(obj.refid)+'</td>'+
			'<td>'+noempty(obj.username?obj.username:'<i style="color:#CCC">این فیلد وارد نشده است</i>')+'</td>'+
			'<td style="text-align:left!important;direction:ltr;">'+noempty(obj.email?obj.email:'<i style="color:#CCC">این فیلد وارد نشده است</i>')+'</td>'+
			'<td style="text-align:left!important;direction:ltr;">'+noempty(obj.tel?obj.tel:'<i style="color:#CCC">این فیلد وارد نشده است</i>')+'</td>'+
			'<td class="useactbtn"><button onclick="pbuys_moreinfo.open(\''+obj.payid+'\')" type="button">مشاهده</button></td>'+
			'<td style="text-align:center!important;direction:ltr;" class="usedivimg">'+noempty(obj.paytext)+'</td>'+
			'<td class="usedivimg useactbtn">'+noempty(obj.payact)+'</td></tr>';
		};
		HTML+='<tr class="tableAfooter tableApagenum"><td colspan="13">';
		for(i=1;i<=pinfo.pagecount;i++){
			if(i<=5||Math.abs(i-pinfo.pagenum)<3||i+5>pinfo.pagecount){
				if(i==pinfo.pagenum){
					HTML+='<button disabled="disabled">'+i+'</button>';
				}else{
					HTML+='<button onclick="pbuys.update('+i+')">'+i+'</button>';
				};
				j=0;
			}else{
				if(j==0) HTML+=' ... ';
				j=1;
			};
		};
		if(pinfo.pagecount<1) HTML+='<button disabled="disabled">1</button>';
		HTML+='</td></tr></table>';
			
		pbuys.table.innerHTML=HTML;
		if(!lib.isun(result['table'])) sys.msg('');
		pbuys.printtitle();
	},
	
	printtitle:function(){
		var HTML,i,obj;
		HTML='';
		if(pbuys.data.find!=''){
			switch(pbuys.data.searchstatus){
				case 'shopid':
					HTML+='به دنبال فروشگاه با شماره <b>'+intval(pbuys.data.find)+'</b> ';
					break;
				case 'kalaname':
					HTML+='به دنبال کالا با نام <b>'+pbuys.data.find.replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</b> ';
					break;
				default:
					HTML+='به دنبال کلمه <b>'+pbuys.data.find.replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</b> ';
					break;
			};
		};
		if(pbuys.data.requeststatus!='all'){
			HTML+='با فیلتر <b>';
			obj=pbuys.body.requeststatus.options;
			for(i=0;i<obj.length;i++){
				if(obj[i].value==pbuys.data.requeststatus){
					HTML+=obj[i].innerHTML;
					break;
				};
			};
			HTML+='</b> ';
		};
		if(intval(pbuys.data.fdate_y)>1300)	HTML+='از تاریخ '+lib.fdate(pbuys.data.fdate_y,pbuys.data.fdate_m,pbuys.data.fdate_d,0);
		if(intval(pbuys.data.tdate_y)>1300)	HTML+='تا تاریخ '+lib.fdate(pbuys.data.tdate_y,pbuys.data.tdate_m,pbuys.data.tdate_d,1);
		if(HTML=='') HTML='همه موارد';
		HTML='نتیجه جستجو '+HTML;
		sys.title(HTML);
	},
	
	doreq:function(payid,done){
		sys.msg('در حال ارسال اطلاعات ...');
		
		var params=pbuys.data;
		params.payid=payid;
		params.reqaction=done;
		
		sys.api('buys',params,function(result){
			pbuys.printtable(result);
			if(result['result']){
				sys.msg(result['result'].substr(3),result['result'].substr(0,3)!='OK,');
			}else{
				sys.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
			};
		});
	},
	
	update:function(pageno,search,finished){
		var frm;
		
		sys.msg('در حال دریافت اطلاعات');
		
		if(search){
			frm=pbuys.body;
			pbuys.data={
				pagenum:1,
				find:frm.buys_fldstr.value,
				requeststatus:frm.requeststatus.value,
				
				fdate_d:intval(frm.fdate_d.value),
				fdate_m:intval(frm.fdate_m.value),
				fdate_y:intval(frm.fdate_y.value),
				tdate_d:intval(frm.tdate_d.value),
				tdate_m:intval(frm.tdate_m.value),
				tdate_y:intval(frm.tdate_y.value)
			};
		}else{
			pbuys.data.pagenum=pageno?pageno:1;
		};
		
		sys.api('buys',pbuys.data,function(result){
			pbuys.printtable(result);
			if(finished) finished(result);
		});
	},
	
	reload:function(){
		var frm,func;
		frm=pbuys.body;
				
		func=function(event){
			var key;
			try{key=window.event.keyCode}catch(err){try{key=event.which}catch(err){return true}};
			if(key==13) pbuys.update(1,1);
			return true;
		};

		frm.buys_fldstr.onkeypress=func;
		frm.fdate_d.onkeypress=func;
		frm.fdate_m.onkeypress=func;
		frm.fdate_y.onkeypress=func;
		frm.tdate_d.onkeypress=func;
		frm.tdate_m.onkeypress=func;
		frm.tdate_y.onkeypress=func;
		frm.requeststatus.onkeypress=func;
		
		
		frm.requeststatus.selectedIndex=0;
		pbuys.data={
			pagenum:1,
			find:'',
			requeststatus:frm.requeststatus.value,
			
			fdate_d:0,
			fdate_m:0,
			fdate_y:0,
			tdate_d:0,
			tdate_m:0,
			tdate_y:0
		};
	},
	
	open:function(update,open_done){
		pbuys.update(1,0,function(result){
			open_done(pbuys,!lib.isun(result['table']));
		});
	}

};

</script>