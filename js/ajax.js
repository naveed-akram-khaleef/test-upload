// JavaScript Document
/* ---------------------------- */
/* XMLHTTPRequest Enable */
/* ---------------------------- */
function createObject() {
	var request_type;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
		request_type = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_type = new XMLHttpRequest();
	}
	return request_type;
}

var http = createObject();

var nocache = 0;
function insertOrder(vidID, catID, vidName, vidPrice) {
	// Required: verify that all fileds is not empty. Use encodeURI() to solve some issues about character encoding.
	//document.getElementById('amount').value = vidPrice;
	document.BuyForm.amount.value = vidPrice;
	document.getElementById('desc').value = vidName;
	// Set te random number to add to URL request
	nocache = Math.random();
	// Pass the login variables like URL variable
	http.open('get', 'ajax_request.php?option=1&vid='+vidID+'&cid='+catID+'&nocache = '+nocache);
	http.onreadystatechange = getInsertOrder;
	http.send(null);
}

function getInsertOrder() {
	if(http.readyState == 4){ 
		var response = http.responseText;
		var pageData = response.split("||&&");
		// else if login is ok show a message: "Site added+ site URL".
		if(pageData[0]==1){
			document.getElementById('cartId').value = pageData[1];
			document.getElementById('MC_orderID').value = pageData[1];
			document.BuyForm.submit();
		}
		else{
			//document.getElementById('showMSG').innerHTML = pageData[1];
			//document.getElementById('showMSG').style.visibility = "visible";
			//document.getElementById('showMSG').style.display = "block";
			window.location = "video_viewed.php?op=2";
		}
	}
}

function insertOrder2(vidID, catID, vidName, vidPrice) {
	// Required: verify that all fileds is not empty. Use encodeURI() to solve some issues about character encoding.
	//document.getElementById('amount').value = vidPrice;
	document.BuyFormPaypal.amount.value = vidPrice;
	document.getElementById('item_number').value = vidID;
	document.getElementById('item_name').value = vidName;
	// Set te random number to add to URL request
	nocache = Math.random();
	// Pass the login variables like URL variable
	http.open('get', 'ajax_request.php?option=1&vid='+vidID+'&cid='+catID+'&nocache = '+nocache);
	http.onreadystatechange = getInsertOrder2;
	http.send(null);
}

function getInsertOrder2() {
	if(http.readyState == 4){ 
		var response = http.responseText;
		var pageData = response.split("||&&");
		// else if login is ok show a message: "Site added+ site URL".
		if(pageData[0]==1){
			//alert("Submit Form");
			document.getElementById('invoice').value = pageData[1];
			document.BuyFormPaypal.submit();
		}
		else{
			//document.getElementById('showMSG').innerHTML = pageData[1];
			//document.getElementById('showMSG').style.visibility = "visible";
			//document.getElementById('showMSG').style.display = "block";
			window.location = "video_viewed.php?op=2";
		}
	}
}

function payNow(ordID, vidPrice, vidName) {
	document.getElementById('cartId').value = ordID;
	document.getElementById('MC_orderID').value = ordID;
	document.getElementById('amount').value = vidPrice;
	document.getElementById('desc').value = vidName;
	document.BuyForm.submit();
}

function payNowPaypal(ordID, vidPrice, vidID, vidName) {
	document.getElementById('invoice').value = ordID;
	document.BuyFormPaypal.amount.value = vidPrice;
	document.getElementById('item_number').value = vidID;
	document.getElementById('item_name').value = vidName;
	document.BuyFormPaypal.submit();
}
// END :: Right Column Fares Section
