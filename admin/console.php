<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Console</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/animatedcollapse.js">

/***********************************************
* Animated Collapsible DIV v2.4- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/interface.js"></script>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'></script>
<script src='../js/jquery.color-RGBa-patch.js'></script>

<script type="text/javascript">

animatedcollapse.addDiv('scanbox', 'fade=1,height=120px')
animatedcollapse.addDiv('loading', 'fade=1,height=120px')
animatedcollapse.addDiv('listing', 'fade=1,height=120px')
animatedcollapse.addDiv('checkoutbox', 'fade=1,height=120px')
animatedcollapse.addDiv('returnbox', 'fade=1,height=120px')
animatedcollapse.addDiv('nav-two', 'fade=1,height=40px')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state

}

animatedcollapse.init()


var sec=0, txt;

$(document).ready(function() {
    $('input:text:first').focus();
});

$(function() {

    var $el, leftPos, newWidth,
        $mainNav = $("#nav-one");
    
    $mainNav.append("<li id='magic-line'></li>");
    var $magicLine = $("#magic-line");
    
    $magicLine
        .width($(".current_page_item").width())
        .css("left", $(".current_page_item a").position().left)
        .data("origLeft", $magicLine.position().left)
        .data("origWidth", $magicLine.width());


    $("#nav-one li a").hover(function() {
        $el = $(this);
        leftPos = $el.position().left;
        newWidth = $el.parent().width();
        $magicLine.stop().animate({
            left: leftPos,
            width: newWidth
        });
    }, function() {
        $magicLine.stop().animate({
            left: $magicLine.data("origLeft"),
            width: $magicLine.data("origWidth")
        });    
    });
	
	$("#nav-one li a").click(function() {
        $(this).parent().siblings().removeClass("current_page_item");
		$(this).parent().addClass("current_page_item");
        $magicLine
		.width($(".current_page_item").width())
		.css("left", $(".current_page_item a").position().left)
		.data("origLeft", $magicLine.position().left)
		.data("origWidth", $magicLine.width());
	});
});



function submit_scan()
{
	
	document.getElementById("form2").submit();
	
   /* var code=document.getElementById ('scan').value;

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById('scan').value="";
			txt = xmlhttp.responseText;
			
			if (txt.indexOf('success') !== -1)
			{
				$('#listing').fadeOut('slow').load('scan_show_placeholder.php').fadeIn("slow");
			}
			else
			{
				document.getElementById('msg').innerHTML=txt;	
			}
		
		}
	  }
	  
	xmlhttp.open("GET","scan_action.php?q="+code,true);
	xmlhttp.send();
	return true;*/

}	


function del(str)
{
	
	
	
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById('scan').value="";
		$('#listing').fadeOut('slow').load('scan_show_placeholder.php').fadeIn("slow");
		}
	  }
	
	xmlhttp.open("GET","scan_delete.php?id="+str,true);
	xmlhttp.send();

}


function submits()
{
	
	animatedcollapse.show('loading');
	animatedcollapse.hide('listing');
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//document.form1.scan.value="";
			//document.form1.eq.value=xmlhttp.responseText;	
			//animatedcollapse.show('scanbox');
			//("#listing").load("scan_show.php");
			animatedcollapse.hide('loading');
			//animatedcollapse.show('listing');
			$('#listing').fadeOut('slow').load('scan_show_placeholder.php').fadeIn("slow");
		}
	  }
	
	//document.getElementById("form1").submit();
	//document.form1.size.value=num;
	//xmlhttp.open("GET","scan_action.php?q="+num,true);
	//xmlhttp.send();
	document.getElementById("form1").submit();

}

function show_table(str)
{
	animatedcollapse.hide('nav-two');
	
	if (str == 'placeholder')
	{
		$("#listing").load("scan_show_placeholder.php");

		//document.getElementById('listing').style.marginLeft='auto';
	}
	else if (str == 'group')
	{
		$("#listing").load("scan_group.php");

		//document.getElementById('group').classList.add('current_page_item');
		//document.getElementById('listing').style.marginLeft='auto';
	}
	else if (str == 'log')
	{
		$("#listing").load("console_log.php");

	}
	else if (str == 'return')
	{
		$("#listing").load("console_return.php");

	}	
	else if (str == 'status')
	{		
		$("#listing").load("console_status.php");

		//document.getElementById('consolebox').style.width=document.getElementById('showtable').width+'px';
		//document.getElementById('listing').style.marginLeft=-50+'px';
		
	}
	else if (str == 'add')
	{
		$("#listing").load("console_add.php");

		//document.getElementById('group').classList.add('current_page_item');
		//document.getElementById('listing').style.marginLeft='auto';
	}
	else
	{
		$("#listing").load("scan_show.php?t="+str);
		//document.getElementById('listing').style.marginLeft='auto';		
	}	
}

function show_edit()
{
	animatedcollapse.show('nav-two');
	//document.getElementById('nav-two').style.display='block';
}

function edit(str)
{
	$("#listing").load("scan_edit.php?edit="+str);
	//document.getElementById('nav-two').style.display='block';
}

function add(type, label, barcode)
{
	
	//alert(indx+" "+type+" "+label+" "+barcode);
	
	//document.formAdd.action = "console_addAction.php?i="+str;
	
	//document.formAdd.submit();

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$('#listing').fadeOut('slow').load('console_add.php').fadeIn("slow");
		}
	  }
	
	xmlhttp.open("GET","console_addAction.php?t="+type+"&l="+label+"&b="+barcode,true);
	xmlhttp.send();

}


</script>


<link href="../stylesheet.css" rel="stylesheet" type="text/css" />

</head>


<body class="admin_body">


<div id="consolebox">    
	
            <div id="scanbox">
            	<p>Admin Console v.2</p><br />
				<form id="form2" name="form2" action="scan_action.php"><strong>Scan &nbsp;&nbsp;</strong><input name="scan" type="text" id="scan" size="40" value=""/></form>
                <br /><p> <a href="javascript:submit_scan();">Submit</a></p>
            </div>
        
          

<br /><br /><br /><br />

<div class="nav-wrap">
 <ul class="group" id="nav-one">
    <li class="current_page_item"><a href="javascript:show_table('placeholder');">Pending</a></li>
    <li><a href="javascript:show_table('add');">Add</a></li>
    <li><a href="javascript:show_table('return');">Return</a></li>
    <li><a href="javascript:show_table('status');">Status</a></li>
    <li><a href="javascript:show_table('log');">Log</a></li>
    <li><a href="javascript:show_table('group');">Group</a></li>
<!--    <li><a href="#">Add</a></li>-->
    <li><a href="javascript:show_edit();">Edit</a></li>
 </ul>
</div>
<div class="nav-wrap-two">
 <ul class="group" id="nav-two" style="display:none;">
    <li><a href="javascript:edit('status');">Status</a></li>
 </ul>
</div>
<br /><br />
<div id="msg"></div>

<div id="listing"><div id="loading" align="center" style='display:none;'><br /><br /><br /><br />Loading...</div>
  <?php include('scan_show_placeholder.php');?>
</div>

</div>


</body>
</html>
