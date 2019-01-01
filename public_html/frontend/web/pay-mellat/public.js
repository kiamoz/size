var doc={
	site:{
		domain:'http://pay.inasrabadi.ir',
		iscached:true
	},
	
	ie:{
		is:false,version:0,
		stylesheet:{
			initiehover:function(obj){
				obj.onmouseover=function(){
					var obj=this.className;
					obj=obj.replace(/\s*\makeiehover\s*/,' ');
					this.className=obj+' makeiehover';
				};
				
				obj.onmouseout=function(){
					var obj=this.className;
					obj=obj.replace(/\s*\makeiehover\s*/,' ');
					this.className=obj;
				};
				
				obj.style.behavior=null;
			},
			initStyleSheet:function(styleSheet){
				if(!doc.ie.is) return false;
				var cssText=styleSheet.cssText;
				cssText=cssText.replace(/([^{}\n\r]+) onlyie([\d_-]*)\s*({[^{}]*})/ig,function(a,b,c,d){
					var istrue=false,ver=c.replace(/_/g,'.').split('-');
					if(c==''){
						istrue=true;
					}else{
						for(var i=0;i<ver.length;i+=1){
							if(ver[i]==doc.ie.version){
								istrue=true;
								break;
							};
						};
					};
					if(!istrue) return '';
					return (b+d);
				});

				cssText=cssText.replace(/opacity\s*:\s*([\d\.]+)/ig,function(a,b){
					return ("filter:progid:DXImageTransform.Microsoft.Alpha(opacity="+b*100+")");
				});
			
				if(doc.ie.version<8){
					cssText=cssText.replace(/([^{}\n\r]+):hover([^{}]*)/ig,function(a,b,c){
						return (b+'{behavior:expression(doc.ie.stylesheet.initiehover(this));}'+b+'.makeiehover '+c);
					});
				};
								
				styleSheet.cssText=cssText;
			},
			initAll:function(){
				for(var i=0;i<document.styleSheets.length;i+=1){
					this.initStyleSheet(document.styleSheets[i]);
				};
			}
		}
	},
	
	css:{
		getopacity:function(obj){return obj.style.opacity?obj.style.opacity:1},setopacity:0,
		normal:function(style){
			return style.toLowerCase().replace(/-\w/g,function(u){return u.replace("-","").toUpperCase()})
		},
		_set:function(obj,style,value){
			style=this.normal(style);
			switch(style){
				case "opacity":this.setopacity(obj,value);return;
				case "display":if(value=='table'&&doc.ie.is&&doc.ie.version<8) value='block';break;
			};
			if(obj.style[style]!=value) obj.style[style]=value;								  
		},
		set:function(obj,style,value){
			style=style.replace(/(\s*;\s*)/gi,";").replace(/(\s*:\s*)/gi,":");
			if(value){
				this._set(obj,style,value);	
			}else{
				var s=style.split(";"),i,e;
				for(i=0;i<s.length;i++){
					e=s[i].split(":");
					if(e.length<2){
						this._set(obj,style,'');
					}else{
						this._set(obj,e[0],e[1]);
					};
				};
			};
			return obj;
		},
		get:function(obj,style){
			style=this.normal(style);
			switch(style){
				case "opacity":return this.getopacity(obj);
			}
			return obj.style[style];
		}
	},
	
	get:{
		bytag:function(obj,tagName){
			if(tagName=='*'){
				return obj.all?obj.all:obj.getElementsByTagName('*');
			}else{
				return obj.getElementsByTagName(tagName);
			}
		},
		byid:function(obj,id){
			var i,objs=doc.get.bytag(obj,'*');
			for(i=0;i<objs.length;i++){
				if(objs[i].id==id) return objs[i];
			};
			return false;
		},
		byclass:function(obj,classn){
			var i,objs=doc.get.bytag(obj,'*');
			classn=classn.toLowerCase();
			for(i=0;i<objs.length;i++){
				if(objs[i].className.toLowerCase()==classn) return objs[i];
			};
			return false;
		},
		where:function(obj,attr,value){
			var i,objs=doc.get.bytag(obj,'*');
			for(i=0;i<objs.length;i++){
				if(objs[i].getAttribute(attr)==value) return objs[i];
			};
			return false;
		},
		first:function(obj,tag){
			var objs=this.bytag(obj,tag);
			return objs?objs[0]:false;
		},
		end:function(obj,tag){
			var objs=this.bytag(obj,tag);
			return objs?objs[objs.length-1]:false;
		}
	},
	
	object:{
		checkvalue:function(obj,reg){
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
					var istrue=true,num=intval(obj.value),isnum=!!obj.value.match(/^\d*$/),reg=obj.inputreg;
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
		addchild:function(obj,childtag,pos){
			var child=((typeof childtag)=="object")?childtag:document.createElement(childtag);
			if((typeof pos)=="object"){
				obj.insertBefore(child,pos);
			}else if(pos==0){
				var firstobj=obj.getfirst('*');
				if(firstobj){
					obj.insertBefore(child,firstobj);
				}else{
					obj.appendChild(child);
				};
			}else{
				if(pos) child.css(pos);
				obj.appendChild(child);
			};
			return child;
		},
		addevent:function(obj,event,func){
			var e=event.match(/(on)?(.*)/)[2],f=(typeof func=="string")?Function(func):func;
			if(this.addEventListener){
				this.addEventListener(e,f,false);
			}else{
				this["on"+e]=f;
			}
			return obj;
		}
	},
	
	slowfor:function(rtime,rprogfunc,rendfunc,dontrun){
		var slowf={
			starttime:0,
			time:rtime,
			progfunc:rprogfunc,
			endfunc:rendfunc,
			timerid:0,
			
			runfunction:function(forobj){
				var ntime=new Date().getTime();
				if(forobj.time>ntime-forobj.starttime){
					forobj.progfunc((ntime-forobj.starttime)/(forobj.time));
				}else{
					clearInterval(forobj.timerid);
					forobj.timerid=0;
					forobj.progfunc(1);
					forobj.endfunc();
				};
			},
			
			run:function(){
				this.starttime=new Date().getTime();
				var forobj=this;
				this.timerid=setInterval(function(){forobj.runfunction(forobj)},1);
			},
			
			stop:function(){
				clearInterval(this.timerid);
				this.timerid=0;
				this.endfunc();
			}			
			
		};
		if(!dontrun) slowf.run();
		return slowf;		
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
				
		window.intval=function(num,def){
			if(!num) return 0;
			num=num.toString();
			if(!num.match(/\d+/)) return def?def:0;
			num=num.replace(/^0/g,'');
			if(num=='') return 0;
			return parseFloat(num);
		};
		
		Math.num3=function(num){
			var num3,i;
			num=intval(num);
			num=num.toString();
			num3=num.substr(0,num.length%3);
			for(i=num.length%3;i<=num.length-3;i+=3){
				num3+=','+num.substr(i,3);
			};
			if(num.length%3==0) num3=num3.substr(1);
			return num3;
		};
		
		doc.ie.is=!!window.navigator.userAgent.match(/MSIE/gi)&&!window.navigator.userAgent.match(/opera/gi);
		if(doc.ie.is) doc.ie.version=intval(window.navigator.userAgent.match(/MSIE\s*([\d\.]*)/i)[1]);
		
		window._alert=window.alert;
		window.alert=function(msg){
			window._alert('\u202b'+msg.toString().replace(/\n/g,'\n\u202b'));	
		};

		window._confirm=window.confirm;
		window.confirm=function(msg){
			return window._confirm('\u202b'+msg.toString().replace(/\n/g,'\n\u202b'));	
		};
		
		doc.ajax.core=window.XMLHttpRequest?window.XMLHttpRequest:function(){
		try{return new ActiveXObject((doc.ie.version<6)?"MSXML2.XMLHTTP.5.0":"Microsoft.XMLHTTP")}catch(e){
		try{return new ActiveXObject("Microsoft.XMLHTTP")}catch(e){
		try{return new ActiveXObject("Msxml2.XMLHTTP")}catch(e){
		try{return new ActiveXObject("Msxml2.XMLHTTP.6.0")}catch(e){
		try{return new ActiveXObject("MSXML2.XMLHTTP.3.0")}catch(e){
			alert('مرور گر شما فناوری اجاکس را پشتیبانی نمی کند. لطفا از مرورگر دیگری استفاده کنید.');
		}}}}}};
		
		
		if(doc.ie.is){
			doc.ie.stylesheet.initAll();
			if(doc.ie.version<6){
				doc.css.setopacity=function(obj,v){if(obj.style.opacity==v) return true;obj.style.filter="alpha(opacity="+v*100+")";obj.style.opacity=v};
			}else{
				doc.css.setopacity=function(obj,v){
					if(obj.style.opacity==v)return true;
					if(obj.style.opacity){obj.filters.item("DXImageTransform.Microsoft.Alpha").opacity=v*100}
					else{obj.style.filter="progid:DXImageTransform.Microsoft.Alpha(opacity="+v*100+")"};
					obj.style.opacity=v;
				};
			};
		}else{
			doc.css.setopacity=function(obj,v){if(obj.style.opacity==v)return true;obj.style.opacity=v};
		};
		
		doc.site.iscached=!window.location.toString().match(RegExp('^(https?:\\/?\\/?)?[^\\/]*'+doc.site.domain.replace(/\./g,'\\.'),'ig'));				
	}
};

var $=function(id){
	var obj=((typeof id)=="object")?(id):(document.getElementById(id));
	if(!obj) return false;
	if(obj.getbytag) return obj;
	obj.getbytag=function(tag){return doc.get.bytag(obj,tag)};
	obj.getfirst=function(tag){return $(doc.get.first(obj,tag))};
	obj.getend=function(tag){return $(doc.get.end(obj,tag))};
	obj.getbyid=function(id){return $(doc.get.byid(obj,id))};
	obj.getbyclass=function(classn){return $(doc.get.byclass(obj,classn))};
	obj.getwhere=function(attr,value){return $(doc.get.where(obj,attr,value))};
	obj.css=function(style,value){doc.css.set(obj,style,value);return obj};
	obj.gcss=function(style){doc.css.get(obj,style)};
	obj.setfilter=function(filters){doc.object.checkvalue(obj,filters);return obj};
	obj.addchild=function(childtag,pos){return $(doc.object.addchild(obj,childtag,pos))};
	obj.addevent=function(event,func){doc.object.addevent(obj,event,func);return obj};
	return obj;
};

doc.init();



///// new xml //////////////////

var nxml={
	core:doc.ajax.newlib(),
	regs:{
		block:/<#([^#><]+)#>([^#]*)<\/#\1+#>/,
		tag:'#',tagreg:/#/g,rtag:'<<!TAGS!>>',rtagreg:/<<!TAGS!>>/g,
		line:'\r',linereg:/\r/g,rline:'<<!LINES!>>',rlinereg:/<<!LINES!>>/g,
		obj:'~',objreg:/~/g,robj:'<<!OBJS!>>',robjreg:/<<!OBJS!>>/g
	},
	table:function(data){
		if(data=='') return [];
		var i,j,rows=data.split(nxml.regs.line);
		for(i=0;i<rows.length;i++){
			rows[i]=rows[i]
				.replace(nxml.regs.rlinereg,nxml.regs.line)
				.split(nxml.regs.obj);
			for(j=0;j<rows[i].length;j++){
				rows[i][j]=rows[i][j].replace(nxml.regs.robjreg,nxml.regs.obj);
			};
		};
		return rows;
	},
	get:function(url,parameters,endfunction,stopifbusy){
		if(this.core.busy&&stopifbusy){
			alert('لطفا صبر کنید تا عملیات قبلی به پایان برسد.');
			return false;
		};
				
		this.core.params=parameters;
		
		this.core.get(url,function(txtDoc){
			var data={},txtdata=txtDoc,match;
			
			//_alert(txtDoc);
			var count=0;
			
			while(match=txtdata.match(nxml.regs.block)){
				txtdata=txtdata.replace(match[0],'');
				data[match[1]]=match[2].replace(nxml.regs.rtagreg,nxml.regs.tag);
				count+=1;
			};
			
			//if(count==0) _alert(txtDoc);
			
			if(data['js']) eval(data['js']);
			
			if(endfunction) endfunction(data);
		});
		return true;
	},
	stop:function(){
		this.core.stop();
	}
	
};





var lib={
	isun:function(obj){
		return ((typeof obj).toLowerCase()=='undefined');
	},
	format:function(zeronum,num){
		var zeroformat='00000000000000000000';
		num=intval(num);
		num=num.toString();
		return (zeroformat.substr(0,zeronum>num.length?zeronum-num.length:0)+''+num);
	},
	nl2br:function(text){
		return text.replace(/[\r\n]+/g,'<br />');
	},
	fdate:function(year,month,day,roundup){
		var y,m,d,daymax;
		y=intval(year);
		m=intval(month);
		d=intval(day);
		
		if(y<1000) y=1000;
		if(y>9999) y=9999;
		if(m==0) m=roundup?12:1;
		if(m<1) m=1;
		if(m>12) m=12;
		daymax=m>6?30:31;
		if(d==0) d=roundup?daymax:1;
		if(d<1) d=1;
		if(d>daymax) d=daymax;
		
		y=lib.format(4,y);
		m=lib.format(2,m);
		d=lib.format(2,d);
		
		return (y+'/'+m+'/'+d);
	},
	copy:function(array){
		newarray={};
		for(var i in array){
			newarray[i]=array[i];
		};
		return newarray;
	},
	bytesToSize:function(bytes){
		 var sizes=['Bytes','KB','MB','GB','TB'];
		 if (bytes==0) return '0 Byte';
		 var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		 return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}
};