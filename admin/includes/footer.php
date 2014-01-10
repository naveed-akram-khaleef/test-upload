<div id="footer">
   <div class="wrapper">
      <div class="cf ftr_content">
        <p class="fl"><p>Copyrights © Esol Technologies, All Rights Reserved</p></p>
        <a href="javascript:void(0)" class="toTop">Back to top</a>
      </div>
   </div>
</div>
<style>
	.submitButton{ background-color: #FFFFFF; color: #000000; text-shadow:#FFF; border: 1px solid #A2A2A2; border-radius: 4px 4px 4px 4px; font-family: Arial,Helvetica,sans-serif; font-size: 11px; font-weight: bold; padding: 5px 5px 5px 5px; margin: 5px 5px 20px 0px; text-transform:uppercase; }				
	.submitButton:hover{ background-color: #E3E3E3; color: #000000; text-shadow:#FFF; cursor:pointer; }
</style>
<script language="javascript">
var frm = document.getElementById("frm");
function checkRequired(){
	if (frm1.txtcat.value=="" || IsBlank("frm1","txtcat")==false){
		alert("Category Name Required!");
		frm1.txtcat.focus();
		return (false);
	}
	return (true);
}	

function chkRequired(TheForm)	{
	if (Checkbox("frm", 'chkstatus[]') == false){
		alert("You must check atleast one checkbox");
		
		$('.fancyA').hide();
		$('.fancyQ1').show();

		return (false);
	}	
	return (true);
}

function setAll(){
	if(frm.chkAll.checked == true){
		checkAll("frm", "chkstatus[]");
	}
	else{
		clearAll("frm", "chkstatus[]");
	}
}	

function checkAll(TheForm, Field){
	var obj = document.forms[TheForm].elements[Field];
	if(obj.length > 0){
		for(var i=0; i < obj.length; i++){
			obj[i].checked = true;
		}
	}
	else{
		obj.checked = true;
	}
}

function clearAll(TheForm, Field){
	var obj = document.forms[TheForm].elements[Field];
	if(obj.length > 0){
		for(var i=0; i < obj.length; i++){
			obj[i].checked = false;
		}
	}
	else{
		obj.checked = false;
	}
}

function Checkbox(TheForm, Field){
	var obj = document.forms[TheForm].elements[Field];
	var res = false;
	if(obj.length > 0){
		for(var i=0; i < obj.length; i++){
			if(obj[i].checked == true){
				res = true;
			}
		}
	}
	else{
		if(obj.checked == true){
				res = true;
		}
	}
return (res);
}	
</script>
<script src="js/jquery-1.7.2.js" type="text/javascript"></script>
<script src="js/form_validation.js" type="text/javascript"></script>
<script src="js/jquery.filestyle.js" type="text/javascript"></script>
<script language="javascript">
	 $("input[type=file]").filestyle({ 
		 image: "images/choose-file.gif",
		 imageheight : 25,
		 imagewidth : 82,
		 width : 305
	 });
</script>
<script>
	$(document).ready(function(){
		$("#validateFormData").validate({
		});
	});
</script>
