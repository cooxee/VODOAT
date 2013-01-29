$(document).ready(init);

function init(){
    $('a').click(function(event){
        var ajax = $(this).attr('is_ajax');
	var action = $(this).attr('class');
        if(ajax == 'yes' && action == 'edit_user'){
	    event.preventDefault();
            var link = ($(this).attr('href'));
	    var h = link.split('/');
	    
	    getedituser(h[h.length-1]);
        }else{
            //return false;
        }
    });
    $("#adduser").click(function() {
        //now doing a ajaxcall to get the adduser form and putting it in the modal
        getadduser();
    });
    
//    $(".edituser").click(function(event){
//	alert(event);
//	event.preventDefault();
//	var user = $(this).attr('href');
//	alert(user);
//        //now doing a ajaxcall to get the adduser form and putting it in the modal
//        getedituser();
//    });
    
    $.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd'
	});
    $('.dp').datepicker();
    
    $( "#modal" ).dialog({
         resizable: false,
        modal: true,
        autoOpen: false,
        show: "blind",
        title: 'Add New User',
        hide: "explode",
        width:600,
        height:600});
}

function aftercall(){
    $('.dp').datepicker();
    $('form').submit(function() {
	var ajax = $(this).attr('is_ajax');
	if(ajax=='yes'){
	    //alert ("hi");
	    var error		= " ";
	    var tag_id 		= $('#tag_id').val();
	    var wnumber 	= $('#wnumber').val();
	    var start_time 	= $('#start_time').val();
	    var end_time	= $('#end_time').val();
	    //alert(tag_id);
	    if(!isInt(tag_id)){
		error += "Tag Id Should be number<br>";
		//alert(error);
	    }
	    var reg =  "[w|w][0-9]{7}$";
	    var dtArray = wnumber.match(reg);
	    if(dtArray == null){
		error += "Invalid Wnumber<br>";
	    }
	//    if(!isDate(start_time) && !isDate(end_time)){
	//	error += "Invalid Date<br>";
	//    }
	    
	    if(error.length>2){
		$('#jerror').css('color', 'red');
		$('#jerror').css('font-size', '.9em');
		$('#jerror').css('text-align', 'left');
		$('#jerror').css('left-margin', '10px'); 
		$('#jerror').html(error);
		
		return false;
	    }else{
		return true;
	    }
	}else{
	    return true;
	}
    });
 
}


function getadduser(){
    var url = document.URL;
    var all = url.split("/");
    var last = all[(all.length-1)];
    if(last =="index"){
	var gooto= 'add_user';
    }else{
	var gooto = 'admin_controller/add_user';
    }
    //alert(url);
    $.ajax({
        type: "GET",
        url: gooto,
        success: function(data) {
        $('#modalcont').html(data);
            //alert("lado");
            aftercall();
            $('#modal').dialog('open');
            
        }
    }); 
}

function getedituser(num){
    //alert(num);
    var url = document.URL;
    var all = url.split("/");
    var last = all[(all.length-1)];
    if(last =="index"){
	var gooto= 'edit_user/';
    }else{
	var gooto = 'admin_controller/edit_user/';
    }
    gooto = gooto + num;
    
    //alert(gooto);
    $.ajax({
        type: "GET",
        url: gooto,
        success: function(data) {
        $('#modalcont').html(data);
            //alert("lado");
            aftercall();
            $('#modal').dialog('open');
            
        }
    }); 
}



function isDate(txtDate)
{
  var currVal = txtDate;
  if(currVal == '')
    return false;
  
  //Declare Regex  
  var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
  var dtArray = currVal.match(rxDatePattern); // is format OK?

  if (dtArray == null)
     return false;
 
  //Checks for mm/dd/yyyy format.
  dtMonth = dtArray[1];
  dtDay= dtArray[3];
  dtYear = dtArray[5];

  if (dtMonth < 1 || dtMonth > 12)
      return false;
  else if (dtDay < 1 || dtDay> 31)
      return false;
  else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
      return false;
  else if (dtMonth == 2)
  {
     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
     if (dtDay> 29 || (dtDay ==29 && !isleap))
          return false;
  }
  return true;
}

function isInt(n) {
   return n % 1 === 0;
}