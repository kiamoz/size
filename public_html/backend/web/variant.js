window.option_value_name_array;
window.option_id;
window.option_name;
window.counter2;
window.option_name_label;
var counter=0; var n = "";

function Makeselect(counter){
n="";
var sel = $('<select name="option_value_'+option_name+'[]" class="select2s" multiple="multiple"  id="makevariant'+counter+'" >').appendTo('#layout');
    for(i=0;i<counter2;i++){
    n += "<option value='"+option_id[i]+"'>"+ option_value_name_array[i] +"</option>";
    } 
       
sel.select2({
  tags: true,
  placeholder:option_name_label,
  createTag: function (params) {
    return {
      id: "#"+params.term,
      text: params.term,
      newOption: true
    }
  }
})
sel.append(n); 
sel.trigger("change"); 

allsel = $('.select2-container--default');
allsel.removeClass();
allsel.addClass('select2 select2-container select2-container--krajee');


}

$("#makevariant").click(function(){
  
    counter++;
    Makeselect(counter);
     
});



$('#w2').on('select2:select', function (evt) {
    var option_name_id=(evt.params.data.id);
    
    var that=$(this);
    $.ajax({
        type: 'GET',
        url : 'index.php?r=product/getoptionvalue&optionnameid='+option_name_id,
            
        crossDomain: true,
        success: function(output) { 
            
          
            counter2=output['counter'];
            option_value_name_array=output['optionv_name'];
            that.attr('name','option_name'+'['+output['option_name']+']');
            option_name=output['option_name'];
            option_id=output['optionv_id'];
            console.log(option_id);
            option_name_label=output['option_name_label'];
        },  
        error: function(xhr, status, error) {


},
        contentType:'application/json; charset=utf-8',
        dataType: 'json'
        });
    
    
});  


  
$(".clicker").click(function(){
   
    console.log("clicker...");
    var that=$(this);
    console.log($(this).parent().find('.variant_qty').val());
    console.log($(this).parent().find('.variant_price').val());
    console.log($(this).parent().find('.variant_barcode').val());
    console.log($(this).parent().find('.variant_barcode_text').val());
    console.log($(this).parent().find('.variant_orderr').val());
    console.log($(this).parent().parent().find('.option_v_name').html());
    
    variantt = [
            ($(this).parent().find('.variant_qty').val()),
            ($(this).parent().find('.purchase_price').val()),
            ($(this).parent().find('.sales_price').val()),
            ($(this).parent().find('.variant_barcode').val()), 
            ($(this).parent().find('.variant_barcode_text').val()),
            ($(this).parent().find('.variant_orderr').val()),
              ];
              
            v_name=($(this).parent().parent().find('.option_v_name').html());  
            v_product_id=($('#product_idv').val());
            console.log('index.php?r=product/savevariant&option_v_name='+v_name+'&variant_data='+variantt+'&v_productid='+v_product_id);
    $.ajax({
        type: 'GET',
        url : 'index.php?r=product/savevariant&option_v_name='+v_name+'&variant_data='+variantt+'&v_productid='+v_product_id,
            
        crossDomain: true,
        success: function(output) {
            
             console.log(output);
             if((output.flag)==8){
              alert("بارکد تکراری است")
          }
          if((output.flag)==1){
               that.html('ذخیره شد');
               that.css( "background-color","#5cb85c");
               that.css( "color","white");
               setTimeout(function(){
                that.css( "opacity","0.5");
                that.css( "pointer-events","none");
                that.css( "transition","0.3s ease-in-out");
                that.parent().find('.editit').css( "opacity","1");
                that.parent().find('.editit').css( "pointer-events","auto");
                that.parent().find('.editit').attr( "href","index.php?r=variant%2Fupdate&id="+output.variant_id);
                that.parent().find('.editit').attr("target","_blank")
              }, 500);
          }else{
              alert(output.err);
              // alert('خطایی رخ داده است . اطلاعات ذخیره نشده اند')
          }
          
            
        },  
        error: function(xhr, status, error) {
alert('خطایی رخ داده است');
},
        contentType:'application/json; charset=utf-8',
        dataType: 'json'
        });
    });            
              