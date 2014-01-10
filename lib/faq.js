// JavaScript Document
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function IsClicked(LName){
	var activeLayer = document.getElementById(LName);
	if (document.layers){
		if(activeLayer.style.visibility == "hidden"){
			MM_showHideLayers(LName,'','show');
			activeLayer.style.display = "block";
		}
		else{
			MM_showHideLayers(LName,'','hide');
			activeLayer.style.display = "none";
		}
		
	}
	else{
		if(activeLayer.style.visibility == "hidden"){
			activeLayer.style.visibility= "visible";
			activeLayer.style.display = "block";
		}
		else{
			activeLayer.style.visibility = "hidden";
			activeLayer.style.display = "none";
		}
	}
}

function TabClicked(IName, TLayer, imgNum){
	var activeImage = document.getElementById(IName);
	var tabsLayer = document.getElementById(TLayer);
	var layerName = "";
	var imageName = "";
	if (document.layers){
		for(i=0; i<=4; i++){
			layerName = "tab"+i;
			document.getElementById(layerName).style.visibility = "hidden";
			document.getElementById(layerName).style.display = "none";
			imageName = document.getElementById("MTab"+i);
			imageName.src = "images/y_tab"+i+".gif";
		}
		
		if(tabsLayer.style.visibility == "hidden"){
			MM_showHideLayers(TLayer,'','show');
			tabsLayer.style.display = "block";
			activeImage.src = "images/g_tab"+imgNum+".gif";
		}

	}
	else{
		for(i=0; i<=4; i++){
			layerName = "tab"+i;
			document.getElementById(layerName).style.visibility = "hidden";
			document.getElementById(layerName).style.display = "none";
			imageName = document.getElementById("MTab"+i);
			imageName.src = "images/y_tab"+i+".gif";
		}
		
		if(tabsLayer.style.visibility == "hidden"){
			tabsLayer.style.visibility= "visible";
			tabsLayer.style.display = "block";
			activeImage.src = "images/g_tab"+imgNum+".gif";
		}

	}
}

