<style>
	#pagesub_buys_moreinfo .showmoreinfo{
		width:100%;	
		margin:0px;
		border:0px;
	}
	
	#pagesub_buys_moreinfo .tableAhead{
		text-align:right;	
	}
	
	#pagesub_buys_moreinfo .tableAhead button{
		height:25px;
		padding:0px 0px 2px 0px;
		margin:1px;
	}
	
	#pagesub_buys_moreinfo .rowhead{
		width:150px;	
	}

</style>

<form id="pagesub_buys_moreinfo" style="display:none" onsubmit="return false">

   <div id="pagesub_buys_moreinfo_tableshow"></div>

</form>


<script>

var pbuys_moreinfo={
	title:'مشاهده اطلاعات کامل خرید',
	body:$('pagesub_buys_moreinfo'),
	table:$('pagesub_buys_moreinfo_tableshow'),
	payid:0,
	
	printtable:function(result){
		var paytb,HTML,i,j,reqstatus,obj,noempty,addrow,addrow_num,showgraph;
		
		noempty=function(text){return (text==''?'&nbsp;':(text));};
		
		if(lib.isun(result['table'])){
			sys.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
			obj=[];
		}else{
			paytb=nxml.table(result['table']);
			if(paytb.length<1){
				sys.msg('پرداختی با مشخصات مورد نظر یافت نشد.',1);
				obj=[];
			}else{
				obj=paytb[0];
				sys.title('اطلاعات کامل پرداخت با کد <b>'+lib.format(11,paytb[0])+'</b>');		
			};
		};
		
		obj={'payid':obj[0],'bank':obj[1],'cost':obj[2],'datenum':obj[3],'orderid':obj[4],'refid':obj[5],'paystatus':obj[6],'dataobj':obj[7]};
		

		
		j={'started':'&nbsp;',
			'payed':'<button onclick="pbuys.doreq(\''+obj.payid+'\',\'pay_settle\')" type="button" style="width:60px">واریز</button>',
			'done':'&nbsp;'
		};
		obj.payact=(j[obj.paystatus]?j[obj.paystatus]:'');
		
		HTML='<table class="tableA" width="100%" cellpadding="0px" cellspacing="1px" border="0px"><tr class="tableAhead"><td colspan="3">'
				+'<button onclick="pbuys_moreinfo.goback()" type="button" style="width:60px">بازگشت</button>'+obj.payact;
				
				
		HTML+='</td></tr>';
		
		if(paytb.length<1){
			HTML+='<tr class="tableAroweven"><td colspan="3" style="padding:20px;text-align:center">اطلاعاتی برای نمایش وجود ندارد</td></tr>';
		}else{
						
			addrow_num=0;
			addrow=function(addrow_name,addrow_value,style,group){
				HTML+='<tr class="tableArow'+(addrow_num++%2==0?'even':'odd')+'">'+
						(group?('<td rowspan="'+group.rowspan+'" width="100px" align="center" valign="middle" bgcolor="'+group.bgc+'">'+group.text+'</td>'):'')+
						'<td class="rowhead">'+addrow_name+':</td><td'+(style?(' style="'+style+'"'):'')+'>'+noempty(addrow_value)+'</td></tr>';
			};
			
			addrow('کد خرید',lib.format(11,obj.payid),'',{text:'اطلاعات پرداخت',rowspan:7,bgc:'#D0FFFF'});
			
			j=pbuys.banksname;
			obj.bankname=(j[obj.bank]?j[obj.bank]:'ناشناخته');
			addrow('نام بانک',obj.bankname);
			
			addrow('مبلغ',Math.num3(intval(obj.cost))+' ریال');
			
			j=obj.datenum;
			if(j.length<14){
				j='فرمت ناشناخته';
			}else{
				j=j.substr(0,4)+'/'+j.substr(4,2)+'/'+j.substr(6,2)+' '+j.substr(8,2)+':'+j.substr(10,2)+':'+j.substr(12,2);
			};
			obj.date=j;
			addrow('زمان واریز پول',obj.date,'direction:ltr!important;text-align:right;');
			
			addrow('کد تراکنش (OrderID)',obj.orderid);
			addrow('رسید دیجیتالی (ReferenceId)',obj.refid);
			
			j={'started':'پرداخت آغاز شده است اما (هنوز) به فرجام نرسیده است.',
				'payed':'پول از حساب مشتری کسر شده است اما به حساب شما واریز نشده است. برای واریز پول بر روی دکمه بالای صفحه کلیک کنید.',
				'done':'مراحل پرداخت با موفقیت به پایان رسیده است.'
			};
			j=j[obj.paystatus]?j[obj.paystatus]:'ناشناخته';
			addrow('وضعیت پرداخت',j);
			
			showgraph=function(ar){
				if(typeof ar!='object') return ar.replace(/\n/g,'<br />');
				var i,j,obj,htm;
				htm='<table class="tableA" width="100%" cellpadding="0px" cellspacing="1px" border="0px">';
				j=0;
				for(i in ar){
					htm+='<tr class="tableArow'+(j++%2==0?'even':'odd')+'"><td style="width:100px">'+showgraph(i)+'</td><td>'+showgraph(ar[i])+'</td></tr>';
				};
				htm+='</table>';
				return htm;
			};
			
			try{
				eval('obj.dataobj_obj='+obj.dataobj);
			}catch(e){
				obj.dataobj_obj='سامانه قدرت نمایش آرایه ذخیره شده را ندارید';
			}
			obj.dataobj_html=showgraph(obj.dataobj_obj);

			HTML+='<tr class="tableAroweven">'+
					'<td width="100px" align="center" valign="middle" bgcolor="#E0FFFF">آرایه ذخیره شده</td>'+
					'<td colspan="2" style="padding:20px;background:#ede">'+noempty(obj.dataobj_html)+'</td></tr>';
					
			
		};
		
		HTML+='</table>';
		pbuys_moreinfo.table.innerHTML=HTML;
		sys.msg('');
	},
	
	doreq:function(payid,done){
		sys.msg('در حال ارسال اطلاعات ...');
		
		var params={
			'payid':payid,
			'reqaction':done
		};
		
		sys.api('buys_moreinfo',params,function(result){
			pbuys_moreinfo.printtable(result);
			if(result['result']){
				sys.msg(result['result'].substr(3),result['result'].substr(0,3)!='OK,');
			}else{
				sys.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
			};
		});
	},
	
	update:function(payid,finished){
		if(lib.isun(payid)) payid=pbuys_moreinfo.payid;
		pbuys_moreinfo.payid=payid;
		
		sys.msg('در حال دریافت اطلاعات');
		
		sys.api('buys_moreinfo',{'payid':payid},function(result){
			pbuys_moreinfo.printtable(result);
			if(finished) finished(result);
		});
	},
	
	open:function(buyid){
		pbuys_moreinfo.update(buyid,function(){
			pbuys.body.css('display:none');
			pbuys_moreinfo.body.css('display:block');
		});
	},
	
	goback:function(){
		sys.msg('');
		pbuys_moreinfo.body.css('display:none');
		pbuys.printtitle();
		pbuys.body.css('display:block');
	}
	
};

</script>