<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CRESST Checkout System</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="js/animatedcollapse.js">

/***********************************************
* Animated Collapsible DIV v2.4- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>


<script type="text/javascript">


animatedcollapse.addDiv('namebox', 'fade=1,height=120px')
animatedcollapse.addDiv('checkoutbox', 'fade=1,height=500px')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}

animatedcollapse.init()
//document.getElementById("first").focus();

function next1()
{	
var fname, lname;
	if (document.getElementById("fname").value=="")
	{		
		document.getElementById("errormsg").innerHTML="Please enter your first name";
	}
	else if (document.getElementById("lname").value=="")
	{
		document.getElementById("errormsg").innerHTML="Please enter your last name";
	}
	else
	{
		
		animatedcollapse.hide('namebox');
		animatedcollapse.show('checkoutbox');	
		document.getElementById('mainbox').style.height='520px';
		document.getElementById("errormsg").innerHTML="";
		document.getElementById('sub').style.display='none';
		fname = capitaliseFirstLetter(document.getElementById("fname").value);
		lname = capitaliseFirstLetter(document.getElementById("lname").value);
		document.getElementById("username").innerHTML=fname+" "+lname;
		
		$("#listing").load("user_retrieve.php?f="+document.getElementById('fname').value+"&l="+document.getElementById('lname').value);
		

	}
}


function back1()
{
	animatedcollapse.show('namebox');
	document.getElementById('checkoutbox').style.display='none';
	document.getElementById('mainbox').style.height='300px';
	document.getElementById('listing').style.height='90px';
	document.getElementById('listing').innerHTML='<br /><br /><img src="img/ajax-loader.gif" alt="Loading..." />'
	document.getElementById("errormsg").innerHTML="";
	//document.getElementById('sub').style.display='block';
}


function reset1()
{
	animatedcollapse.show('namebox');
	document.getElementById('checkoutbox').style.display='none';
	document.getElementById("fname").value="";
	document.getElementById("lname").value="";
	document.getElementById('mainbox').style.height='300px';
	document.getElementById('listing').style.height='90px';
	document.getElementById('listing').innerHTML='<br /><br /><img src="img/ajax-loader.gif" alt="Loading..." />'
	document.getElementById("errormsg").innerHTML="";
	//document.getElementById('sub').style.display='none';
}

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function refreshing()
{
	$("#listing").load("user_retrieve.php?f="+document.getElementById('fname').value+"&l="+document.getElementById('lname').value);
}

function checkout()
{
	var str = document.getElementById('listing').textContent;
	
	if (document.getElementById("agreement").checked == false)
	{
		alert("Please agree to the terms");
		//document.getElementById("errormsg").innerHTML="Please agree to the terms";
		//return false;
	}
	else if ( str.indexOf("No Equipment Available. Please Refresh") != -1)
	{
		alert("No Equipment Found. Please Refresh.");
		//document.getElementById("form1").submit();
			
	}
	else
	{
		document.getElementById("form1").submit();			
	}

}



</script>


<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body class="user_body">


<div id="mainbox">



	<form id="form1" name="form1" method="post" action="user_action.php">
   		
        <div id="namebox" class="namebox">
        	<p><img src="img/CRESST_logo.jpg" width="394" height="95" alt="CRESST e-Checkout" /></p>
        <table cellpadding="5" align="center"><tr><td><strong>First Name </strong></td><td><input name="fname" type="text" id="fname" size="40" tabindex="1"/></td></tr>
        <tr><td><strong>Last Name </strong></td><td><input name="lname" type="text" id="lname" size="40" tabindex="2"></td></tr><tr><td colspan="2" align="center"><div id="errormsg" class="errormsg" ></div></td></tr></table>
        <table cellpadding="0" align="center">
        <tr><td colspan="2" align="center"><br /><a href="javascript:next1()" class="cssbtn" tabindex="3">Next</a></td></tr></table>
		</div>
	
    	<div id="checkoutbox" class="checkoutbox" style="display:none">
            <p><b>Terms of Loan</b></p>
            <p>The property is loaned to user <span id="username"> </span> for the mutual benefit of the user and the University, and is to be used for the purpose of instruction, demonstration, experimentation, research or administrative support. <br /><br /> I understand by checking the checkbox below, I am responsible for its return. If the equipment and/or accessories is stolen, damaged, or returned in non-working order, I am responsible for paying any and all replacement equipment, items and/or repairs.</p>
           <div align="center"><label><input name="agreement" type="checkbox" id="agreement">I agree to these terms <span style="font-size:10px">on <? print(Date("F d, Y")); ?></span></label><br /></div>
            </p>
            <br />
            
            <div id="listing" style="height:90px; overflow:auto; text-align:center; margin: auto;"><br /><br /><img src="img/ajax-loader.gif" alt="Loading..." /></div>
            
            <br />
            <div align="center"> <a href="javascript:checkout()" class="cssbtn">Check out</a><br /><br /><span style="font-size:9px;"><a href="javascript:back1()">Back</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:reset1()">Reset</a></span></div>
            
    	
        
       		 
		</div> 

	</form>
<div id='sub' class='sub'>Beta v.14</div>
</div>




</body>
</html>
