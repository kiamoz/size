var epay_jscript={
	form:0,
	submitbtn:0,
	submitcost:0,
	core:0,
	pageroot:'epay/',
	
	initpayform:function(frm,filters,beforesubmit){
		var i;
		
		frm=document.getElementById(frm);
		epay_jscript.form=frm;
		if(filters) for(i in filters) epay_jscript.checkvalue(frm[i],epay_jscript.input_regs[filters[i]]);
		
		if(!frm.cost){
			epay_jscript.alert('خطای برنامه نویسی: فیلد cost در اعضای فرم یافت نشد.');
			return false;
		};
		
		epay_jscript.submitcost=frm.cost;
		epay_jscript.checkvalue(epay_jscript.submitcost,epay_jscript.input_regs['long']);
		
		for(i=0;i<frm.elements.length;i++) if(frm.elements[i].type=='submit'){
			epay_jscript.submitbtn=frm.elements[i];
			epay_jscript.submitbtn.___def_value=epay_jscript.submitbtn.value;
			break;
		};
			
		epay_jscript.core=epay_jscript.ajax.newlib();
		
		frm._p_beforesubmit=beforesubmit;
		frm.onsubmit=function(){
			var i,frm,params;
			frm=this;
			
			if(frm._p_beforesubmit) if(!frm._p_beforesubmit(this)) return false;
			
			if(!epay_jscript.submitcost.inputreg.ok()||epay_jscript.submitcost.value<1000){
				epay_jscript.alert('مبلغ وارد شده معتبر نمی باشد.');
				return false;
			};
			
			params={};
			for(i=0;i<frm.elements.length;i++){
				if(frm.elements[i].inputreg) if(!frm.elements[i].inputreg.ok()){
					epay_jscript.alert('اطلاعات وارد شده در فرم نامعتبر است. لطفا اطلاعات را اصلاح فرمایید.');
					return false;
				};
				
				if(frm.elements[i].name) params[frm.elements[i].name]=frm.elements[i].value;
			};
			
			epay_jscript.core.params=params;
			
			epay_jscript.form_msg('در حال ارسال اطلاعات ...');
			
			epay_jscript.core.get(epay_jscript.pageroot+'send.php',function(result){
				switch(result.substr(0,7)){
					case 'Message':
						epay_jscript.alert(result.substr(8));
						epay_jscript.form_msg('');
						break;
					case 'SendURL':
						epay_jscript.form_msg('در حال انتقال به سایت بانک ...');
						eval('epay_jscript.ajax.sendto'+result.substr(7)+';');
						break;
					default:
						alert(result);
						epay_jscript.alert('پاسخ مناسبی از سرور دریافت نشد.');
						epay_jscript.form_msg('');
						break;
				};
				
				
			});
			
			return false;
		};
		
	},
	
	form_msg:function(msg){
		var i,en,frm;
		frm=epay_jscript.form;	
		
		en=msg?true:false;
		
		for(i=0;i<frm.elements.length;i++) frm.elements[i].disabled=en;
		
		if(en){
			if(epay_jscript.submitbtn) epay_jscript.submitbtn.value=msg;
		}else{
			if(epay_jscript.submitbtn) epay_jscript.submitbtn.value=epay_jscript.submitbtn.___def_value;
		};
			
	},
	
	input_regs:{
		every:{
			reg:/^[^<>]*$/i,
			maxlength:100,
			onkeyup:function(obj,ok){
				if(!obj.__def_className) obj.__def_className=obj.className;
				obj.className=ok?obj.__def_className:(obj.__def_className+' error');
			}
		},
		mail:{key:'[a-z][A-Z][0-9]._@',
			reg:/^([\w\._]+@[\w\._]+\.[\w_]+)?$/i,
			maxlength:100,
			onkeyup:function(obj,ok){
				if(!obj.__def_className) obj.__def_className=obj.className;
				obj.className=ok?obj.__def_className:(obj.__def_className+' error');
			}
		},
		code:{key:'[0-9]-+\\/',
			reg:/^([0-9\+-\/\\]+)?$/,
			maxlength:50,
			onkeyup:function(obj,ok){
				if(!obj.__def_className) obj.__def_className=obj.className;
				obj.className=ok?obj.__def_className:(obj.__def_className+' error');
			}
		},
		long:{key:'[0-9]',
			reg:/^([0-9]+)?$/,
			maxlength:30,
			onkeyup:function(obj,ok){
				if(!obj.__def_className) obj.__def_className=obj.className;
				obj.className=ok?obj.__def_className:(obj.__def_className+' error');
			}
		}
	},	
	
	alert:function(msg){alert('\u202b'+msg.toString().replace(/\n/g,'\n\u202b'))},
	confirm:function(msg){return window._confirm('\u202b'+msg.toString().replace(/\n/g,'\n\u202b'))},
	
	intval:function(num,def){
		if(!num) return 0;
		num=num.toString();
		if(!num.match(/\d+/)) return def?def:0;
		num=num.replace(/^0/g,'');
		if(num=='') return 0;
		return parseFloat(num);
	},
	
	copyobj:function(array){
		newarray={};
		for(var i in array){
			newarray[i]=array[i];
		};
		return newarray;
	},

	checkvalue:function(obj,reg){
		reg=epay_jscript.copyobj(reg);
		if(reg.key) reg.key=reg.key.replace('[a-z]','abcdefghijklmnopqrstuvwxyz').replace('[A-Z]','‫ABCDEFGHIJKLMNOPQRSTUVWXYZ').replace('[0-9]','‫0123456789');
		obj.inputreg=reg;
		if(reg.key){
			obj.onkeypress=function(event){
				var key,isok=false;
				try{
					key=window.event.keyCode
				}catch(err){
					try{
						key=event.which
					}catch(err){
						return true
					};
				};
				if(',8,0,9,13,118,99,120,86,88,67,122,120,99,118,121,97,'.indexOf(','+key+',')>-1) isok=true;
				isok=(obj.inputreg.key.indexOf(String.fromCharCode(key))>-1)?true:isok;
				if(obj.inputreg.onkeypress) obj.inputreg.onkeypress(obj,key,isok);
				return isok;
			};
		};
		if(reg.min||reg.max||reg.reg||reg.maxlength||reg.onkeyup){
			obj.inputreg.ok=function(){
				var istrue=true,num=epay_jscript.intval(obj.value),isnum=!!obj.value.match(/^\d*$/),reg=obj.inputreg;
				if(reg.min) istrue=!!(istrue&&(reg.min<=num)&&isnum);
				if(reg.max) istrue=!!(istrue&&(reg.max>=num)&&isnum);
				if(reg.reg) istrue=!!(istrue&&!!(obj.value.match(reg.reg)));
				istrue=!!istrue;
				obj.inputreg.isok=istrue;
				if(reg.onkeyup) reg.onkeyup(obj,istrue);
				if(obj.inputreg.change) obj.inputreg.change(obj,istrue);
				return istrue;
			};
			if(reg.maxlength){
				obj.setAttribute('maxlength',reg.maxlength);
				obj.setAttribute('maxLength',reg.maxlength);
			};
			obj.onkeyup=function(){
				obj.inputreg.ok();
			};				
		};
		if(obj.inputreg.change) obj.onchange=function(){obj.inputreg.change(this,this.inputreg.ok())};
		obj.inputreg.ok();
	},

	ajax:{
		core:0,
		newlib:function(){
			return {
				core:new this.core(),
				endfunc:0,
				params:{},
				_params:'',
				busy:false,
				get:function(url,endfunc){
					var ajax=this,mkstrparams;
					ajax.busy=true;
					ajax.endfunc=endfunc;
					ajax.core.onreadystatechange=function(){};
					ajax.core.abort();
					ajax.core.open('POST',url,true);
					ajax.core.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					ajax.core.setRequestHeader("Accept","text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5");
					ajax.core.setRequestHeader("X-Requested-With", "XMLHttpRequest");
					ajax.core.setRequestHeader("UserAgent", "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50215)");
					ajax.core.setRequestHeader("Accept-Charset", "utf-8, unicode-1-1;q=0.8");
					ajax.core.setRequestHeader("cache-request-directive", "no-cache");
					ajax.core.setRequestHeader("cache-response-directive", "no-cache");
					ajax.core.onreadystatechange=function(){
						if(ajax.busy&&ajax.core.readyState==4){
							ajax.busy=false;
							if(ajax.endfunc) ajax.endfunc(ajax.core.responseText);
						};
					};
					
					mkstrparams=function(params,name){
						var param,str='',paramname;
						name=(typeof name=='undefined')?'':name;
						for(param in params){
							paramname=((name=='')?param:(name+'['+param+']'));
							if(typeof params[param]=='object'){
								str+='&'+mkstrparams(params[param],paramname);
							}else{
								str+='&'+encodeURIComponent(paramname)+'='+encodeURIComponent(params[param]);
							};
						};
						return str.substr(1);
					};
					
					ajax._params=mkstrparams(ajax.params);
					
					setTimeout(function(){ajax.core.send(ajax._params)},10);
				},
				stop:function(){
					var ajax=this;
					ajax.core.onreadystatechange=function(){};
					ajax.core.abort();
				}
			};
			
		},
		sendto:function(url,method,params){
			if(!params&&!method){
				window.location=url;
				return true;
			};
			var form,param,object;
			form=document.createElement('form');
			form.style.display='none';
			form.setAttribute('method',method);
			form.setAttribute('action',url);
			
			for(param in params){
				object=document.createElement('input');              
				object.setAttribute('name',param);
				object.setAttribute('value',params[param]);
				form.appendChild(object);
			};
			
			document.body.appendChild(form);         
			form.submit();
		}
	},
	
	init:function(){
		
		epay_jscript.ie={};
		epay_jscript.ie.is=!!window.navigator.userAgent.match(/MSIE/gi)&&!window.navigator.userAgent.match(/opera/gi);
		if(epay_jscript.ie.is) epay_jscript.ie.version=epay_jscript.intval(window.navigator.userAgent.match(/MSIE\s*([\d\.]*)/i)[1]);
		
		
		epay_jscript.ajax.core=window.XMLHttpRequest?window.XMLHttpRequest:function(){
		try{return new ActiveXObject((epay_jscript.ie.version<6)?"MSXML2.XMLHTTP.5.0":"Microsoft.XMLHTTP")}catch(e){
		try{return new ActiveXObject("Microsoft.XMLHTTP")}catch(e){
		try{return new ActiveXObject("Msxml2.XMLHTTP")}catch(e){
		try{return new ActiveXObject("Msxml2.XMLHTTP.6.0")}catch(e){
		try{return new ActiveXObject("MSXML2.XMLHTTP.3.0")}catch(e){
			alert('مرور گر شما فناوری اجاکس را پشتیبانی نمی کند. لطفا از مرورگر دیگری استفاده کنید.');
		}}}}}};
		
	}
};

epay_jscript.init();