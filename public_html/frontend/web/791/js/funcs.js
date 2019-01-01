jQuery.fn.center = function() {
    _TOP = (($(window).height() - this.outerHeight()) / 2);
    _TOP = (_TOP <= 0) ? 0 : _TOP;
    _LEFT= (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft();
    _LEFT = (_LEFT <= 0) ? 0 : _LEFT;
    this.css({
        top:25 + "%",
        left:_LEFT + "px"
    });
    return this;
}

function preview(id){
    
    $("#cover").fadeToggle("fast", "linear");
    $("#"+id).fadeToggle("slow", "linear");
    $("#"+id).center();  
}

function formcss(id){
    if((document.getElementById(id).style.color)!='green')
    document.getElementById(id).style.color='green';
    else
    document.getElementById(id).style.color='#6495ED';    
}

function check_email_address(email)
{
  var regex = /^([a-zA-Z0-9_.+-]{4,10})+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(regex.test($(email).val()))
     return true;
  else
  {
  $( email ).css( "border", "1px solid red" );    
  $( email ).val("ایمیل صحیح نیست");
  $( email ).focus();
  return false;
  }
}// end check_email_address()

function check_mobile(mobile)
{
  var regex = /^(?:0091|\\+91|0)[7-9][0-9]{9}$/;
  if(regex.test($(mobile).val()))
     return true;
  else
  {
  $( mobile ).css( "border", "1px solid red" );    
  $( mobile ).val("صحیح نیست");
  $( mobile ).focus();
  return false;
  }
}// end check_mobile()

$(document).ready(function(){
$(document).on('keyup', '#payprc', function(event) {
   var v = this.value;
   if($.isNumeric(v) === false) {
        //chop off the last char entered
        this.value = '';//this.value.slice(0,-1);      
   }
   this.value= this.value.replace(/\./g, '');
});

});

function check_prc(prc)
{
  if($.isNumeric($(prc).val()))
     return true;
  else
  {
  $( prc ).css( "border", "1px solid red" );    
  $( prc ).val("صحیح نیست");
  $( prc ).focus();
  return false;
  }
}// end check_mobile()

function fadeup(that){
    if(that=="down"){
        $('#disq_comment').slideToggle('slow');
        $('#cmnt2').attr('class','fa fa-angle-double-up');
        $("#cmnt2").attr('onclick', 'fadeup("up");');
        $("#cmnt1").attr('onclick', 'fadeup("up");');
    }
    else
    {
        $('#disq_comment').slideToggle('slow');
        $('#cmnt2').attr('class','fa fa-angle-double-down');
        $("#cmnt2").attr('onclick', 'fadeup("down");');
        $("#cmnt1").attr('onclick', 'fadeup("down");');
    } 
} 

function downloader() {
    if($('#downname').val()!="" && $('#downemail').val()!="" && check_email_address('#downemail') && $('#downmob').val()!="" && check_mobile("#downmob") && $('#downpay').val()!="" 
    && $('#payprc').val()!="" && $('#paydesc').val()!="" && check_prc('#payprc'))
    {
        var prc1=$('#payprc').val();
        var desc1=$('#paydesc').val();
        var cname1=$('#downname').val();
        var mobile1=$('#downmob').val();
        var email1=$('#downemail').val();
        var payment1=$('#downpay').val();
        var id1='1';
        document.getElementById('downresult').innerHTML ='<div style="margin: 50px 45%; color: rgb(210, 56, 204);font-size: 40px;" class="fa fa-spinner fa-spin fa-3x"></div>';
        var the_data={
                submit: 1,
                prc : prc1,
                desc : desc1,
                cname : cname1,
                email : email1,
                mobile : mobile1,
                payment : payment1,
                id : id1 
            };
            $.post(
                './request3.php',
                the_data,
                function(INFO) {
                    document.getElementById('downresult').innerHTML =INFO;
                    document.getElementById("ffff7").submit();
                }
            );
    }   
    else if($("#downname").val()=="")
    {
       $( "#downname" ).css( "border", "1px solid red" );
       $("#downname").focus();
    }
    else if($("#downemail").val()=="")
    {
       $( "#downemail" ).css( "border", "1px solid red" );
       $("#downemail").focus();
    }
    else if($("#downmob").val()=="")
    {
       $( "#downmob" ).css( "border", "1px solid red" );
       $("#downmob").focus();
    }
    else if($("#paydesc").val()=="")
    {
       $( "#paydesc" ).css( "border", "1px solid red" );
       $("#paydesc").focus();
    }
    else if($("#payprc").val()=="")
    {
       $( "#payprc" ).css( "border", "1px solid red" );
       $("#payprc").focus();
    }             
}

function tracking() {
    if($('#tracking').val()!="" && $('#downemail').val()!="" && check_email_address('#downemail') && $('#downmob').val()!="" && check_mobile("#downmob"))
    {
        var tracking1=$('#tracking').val();
        var mobile1=$('#downmob').val();
        var email1=$('#downemail').val();
        $('#downsts').attr('class','fa fa-spinner fa-spin');
        var the_data={
                submit: 1,
                tracking : tracking1,
                email : email1,
                mobile : mobile1
            };
            $.post(
                './request3.php',
                the_data,
                function(INFO) {
                    document.getElementById('downresult').innerHTML =INFO;
                    $('#downsts').attr('class','fa fa-chevron-circle-right');
                }
            );
    }
    else if($("#tracking").val()=="")
    {
       $( "#tracking" ).css( "border", "1px solid red" );
       $("#tracking").focus();
    }
    else if($("#downemail").val()=="")
    {
       $( "#downemail" ).css( "border", "1px solid red" );
       $("#downemail").focus();
    }
    else if($("#downmob").val()=="")
    {
       $( "#downmob" ).css( "border", "1px solid red" );
       $("#downmob").focus();
    }
}


var tooltip=function(){
	var id = 'tt';
	var top = 6;
	var left = -50;
	var maxw = 300;
	var speed = 10;
	var timer = 20;
	var endalpha = 87;
	var alpha = 0;
	var tt,t,c,b,h;
	var ie = document.all ? true : false;
	return{
		show:function(v,w,etype){
			if(tt == null){
				etype = typeof(etype) != 'undefined' ? etype : 'mouse';
				tt = document.createElement('div');
				tt.setAttribute('id',id);
				t = document.createElement('div');
				t.setAttribute('id',id + 'top');
				c = document.createElement('div');
				c.setAttribute('id',id + 'cont');
				b = document.createElement('div');
				b.setAttribute('id',id + 'bot');
				tt.appendChild(t);
				tt.appendChild(c);
				tt.appendChild(b);
				document.body.appendChild(tt);
				tt.style.opacity = 0;
				tt.style.filter = 'alpha(opacity=0)';
				if(etype=='ondblclick') document.ondblclick = this.pos;
				if(etype=='mouse') document.onmousemove = this.pos;
				
			}
			tt.style.display = 'block';
			c.innerHTML = v;
			tt.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				t.style.display = 'none';
				b.style.display = 'none';
				tt.style.width = tt.offsetWidth;
				t.style.display = 'block';
				b.style.display = 'block';
			}
			if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
			h = parseInt(tt.offsetHeight) + top;
			clearInterval(tt.timer);
			tt.timer = setInterval(function(){tooltip.fade(1)},timer);
		},
		pos:function(e){
			var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
			var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
			tt.style.top = (u - h) + 'px';
			tt.style.left = (l + left) + 'px';
		},
		fade:function(d){
			var a = alpha;
			if((a != endalpha && d == 1) || (a != 0 && d == -1)){
				var i = speed;
				if(endalpha - a < speed && d == 1){
					i = endalpha - a;
				}else if(alpha < speed && d == -1){
					i = a;
				}
				alpha = a + (i * d);
				tt.style.opacity = alpha * .01;
				tt.style.filter = 'alpha(opacity=' + alpha + ')';
			}else{
				clearInterval(tt.timer);
				if(d == -1){tt.style.display = 'none'}
			}
		},
		hide:function(){
			clearInterval(tt.timer);
			tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
		}
	};
}();
