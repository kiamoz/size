/*
	programmer: Freescript.ir
	
*/

var sys={
	activepage:0,
	msg:function(msg,err){
		if(msg==''){
			sys._msg_div.css('visibility:hidden');
		}else{
			sys._msg_div.innerHTML='<center><font'+(err?' class="err"':'')+'>'+msg+'</font></center>';
			sys._msg_div.css('visibility:visible');
		};
	},
	
	server:{
		date:{y:0,m:0,d:0}
	},
	
	title:function(title){
		sys._title_div.innerHTML=title;
		if(title==''){
			sys._title_div.css('display:none');
		}else{
			sys._title_div.css('display:block');
		};
	},
	
	open_first:function(pageobj){
		var i;				
		nxml.stop();
		for(i in sys._open_pageobjs){
			if(sys._open_pageobjs[i].rightmentlink.className=='selected_first') sys._open_pageobjs[i].rightmentlink.className='';
		};
		pageobj.rightmentlink.className='selected_first';
		pageobj.open(1,sys.open);
	},

	open:function(pageobj,success){
		var i;
		if(success){
			sys.msg('');
			
			for(i in sys._open_pageobjs){
				sys._open_pageobjs[i].body.css('display:none');
				sys._open_pageobjs[i].rightmentlink.className='';
			};
			for(i in sys._open_subpageobjs) sys._open_subpageobjs[i].body.css('display:none');
			
			pageobj.body.css('display:block');
			pageobj.rightmentlink.className='selected';
			sys.activepage=pageobj;
		}else{
			for(i in sys._open_pageobjs){
				if(sys._open_pageobjs[i].rightmentlink.className=='selected_first') sys._open_pageobjs[i].rightmentlink.className='';
			};
		}
	},
	
	api:function (apiname,params,func){
		params.api=apiname.toLowerCase();
		nxml.get('api.php',params,function(result){
			if(result['FALSELOGININFO']=='OK'){
				sys.logout();
				sys.logininfo.msg('شما وارد نشده اید.',1);
			}else{
				if(func) func(result);
			};
			if(sys.api_update_base_data) sys.api_update_base_data(result);
		},true);
	},
	
	logininfo:{body:0,_msg_div:0,panel:0,
		msg:function(msg,err){
			if(msg==''){
				sys.logininfo._msg_div.css('visibility:hidden');
			}else{
				sys.logininfo._msg_div.innerHTML='<center><font'+(err?' class="err"':'')+'>'+msg+'</font></center>';
				sys.logininfo._msg_div.css('visibility:visible');
			};
		}
	},
	
	login:function(checksession){
		var params;
		
		if(checksession){
			sys.logininfo.msg('در حال دریافت اطلاعات ...');
			params={
				api:'checkuserpass',
				_checksession:1
			};
		}else{
			sys.logininfo.msg('در حال بررسی مجوز ورود ...');
			params={
				api:'checkuserpass',
				_username:sys.logininfo.body.username.value,
				_password:sys.logininfo.body.password.value
			};
		};
		
		nxml.get('api.php',params,function(result){
			switch(result['status']){
				case 'OK':
					var i;
					i=result['date'].split(',');
					sys.server.date.y=i[0];
					sys.server.date.m=i[1];
					sys.server.date.d=i[2];
					
					for(i in sys._open_pageobjs) if(sys._open_pageobjs[i].reload) sys._open_pageobjs[i].reload();
					for(i in sys._open_subpageobjs) if(sys._open_subpageobjs[i].reload) sys._open_subpageobjs[i].reload();
					
					for(i in sys._open_pageobjs){
						sys._open_pageobjs[i].open(1,function(pageobj,success){
							if(success){
								sys.logininfo.body.css('display:none');
								sys.open(pageobj,1);
								sys.logininfo.panel.css('display:block');
							}else{
								sys.logininfo.msg('با عرض پوزش سامانه قادر به بارگذاری صفحات نیست. لطفا بعدا تلاش نمایید.',1);
							};						
						});
						break;
					};
					$('panelpasswordchecktable').css('display:table');
					break;
				case 'NO':
					sys.logininfo.msg('نام و یا نام کاربری خود را اشتباه وارد کرده اید.',1);
					break;
				case 'NOCRE':
					sys.logininfo.msg('اطلاعات شما در حال بررسی است. در حال حاضر اجازه ورود ندارید.',1);
					break;
				case 'REJ':
					sys.logininfo.msg('در خواست شما برای ایجاد فروشگاه توسط مدیر سایت زد شده است.',1);
					break;
				case 'DIS':
					sys.logininfo.msg('فروشگاه شما توسط مدیر غیر فعال شده است.',1);
					break;
				case 'NSESSION':
					sys.logininfo.msg('خوش آمدید، شما وارد نشده اید.',0);
					$('panelpasswordchecktable').css('display:table');
					break;
				default:
					sys.logininfo.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
					break;
			};
		},false);
	},
	
	logout:function(){
		sys.logininfo.msg('در حال ارسال درخواست خروج ...');
		
		nxml.get('api.php',{api:'logout'},function(result){
			var i;
			switch(result['status']){
				case 'OK':
					sys.logininfo.body.username.value='';
					sys.logininfo.body.password.value='';
					
					sys.logininfo.msg('خروج با موفقیت انجام شد.');
					
					sys.logininfo.body.css('display:block');
					sys.logininfo.panel.css('display:none');
					break;
				case 'NO':
					sys.logininfo.msg('عملیات خروج دچار مشکل شده است.',1);
					break;
				default:
					sys.logininfo.msg('پاسخ مناسبی از سوی سرور دریافت نشد.',1);
					break;
			};
		},false);
	},
	
	init:function(){
		var i,j,id,obj,tags,tag,topmenu;
		
		sys.logininfo.body=$('panelpasswordcheck');
		sys.logininfo._msg_div=$('panelpasswordcheckmsg');
		sys.logininfo.panel=$('panelbodytablesparent');
		
		sys._loading_div=$('panelleftcolumnloadingdiv');
		sys._msg_div=$('panelmsgtable');
		sys._title_div=$('panelleftcolumntitle');
		sys._pages_forms_parent=$('panelleftcolumnbody');
		
		sys._open_pageobjs={};
		sys._open_subpageobjs={};
		tags=sys._pages_forms_parent.getbytag('form');
		tag=$('panelrightmenus');
		topmenu=$('panelheaderlinks');
		for(i=tags.length-1;i>=0;i--){
			if(id=tags[i].id.match(/^pagef_([^>]+)$/i)){
				id=id[1];
				eval('obj=p'+id+';');
				j=tag.addchild('a');
				j.onclick=function(){sys.open_first(this.pageobj)};
				obj.rightmentlink=j;
				j.innerHTML=obj.title;
				j.pageobj=obj;
				if(obj.showontopbar) topmenu.appendChild(j);
				sys._open_pageobjs[id]=obj;
			}else if(id=tags[i].id.match(/^pagesub_([^>]+)$/i)){
				id=id[1];
				eval('obj=p'+id+';');
				sys._open_subpageobjs[id]=obj;
			};
			if(obj.init) obj.init();
		};		
		sys.login(true);
	}
};






