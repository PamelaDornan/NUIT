<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<meta content="Northwestern University" name="author"/>
		<meta content="Northwestern University (Evanston, IL)" name="dc.subject.name.corporate"/>
		<meta content="Administrative,Information Technology" name="dc.subject"/>
		<meta content="Information Technology (NUIT)" name="dc.publisher"/>
		<meta content="Data Center Server Hosting Request" name="dc.description"/>
		<meta content="eng" name="dc.language"/>
		<meta content="Data Center, Application Server, Database Hosting, File Servers, Web Servers, Hosting" name="keywords"/>
		<link href="http://www.it.northwestern.edu/shared/nuit/images/nuitfavicon.ico" rel="shortcut icon" type="image/x-icon"/>
		<link href="http://www.it.northwestern.edu/shared/nuit/style/print.css" media="print" rel="stylesheet" type="text/css"/>
		<link href="http://www.it.northwestern.edu/shared/nuit/style/globalstyles.css" media="screen" rel="stylesheet" type="text/css"/>
		<script src="http://www.it.northwestern.edu/shared/nuit/scripts/p7exp.js" type="text/javascript"></script>
		<title>Data Center Server Hosting Request</title>
		<link href="http://www.it.northwestern.edu/shared/nuit/style/toc2.css" rel="stylesheet" type="text/css"/>
		<script language="JavaScript" type="text/javascript"> 
			function hide() {
				document.getElementById('MONITORING1').style.display='none';
				document.getElementById('MONITORING2').style.display='none';
				document.getElementById('MONITORING3').style.display='none';
				document.getElementById('MONITORING4').style.display='none';
			}
			function show() {
				document.getElementById('MONITORING1').style.display='';
				document.getElementById('MONITORING2').style.display='';
				document.getElementById('MONITORING3').style.display='';
				document.getElementById('MONITORING4').style.display='';
			}
			function notEmpty(x) {
				while (x.substring(0,1) == ' ') 
					x = x.substring(1, x.length);
				if (x == "")
					return false;
				else
					return true
			}
			function confirm_delete(formName){
				var answer = confirm ("Confirm deletion of this server.")
				if (answer) {
					document.getElementById(formName).submit();
				}
			}
			function checkEmail(field) {
				with (field) {
					apos=value.indexOf("@");
					dotpos=value.lastIndexOf(".");
					if (value == "") {
						return true;
					} else if (apos<1||dotpos-apos<2) {
						alert( 'Invalid Entry: ' + value );
						value = '';
						focus();
						return false;
					} else {
						return true;
					}
				}
			}
			function pre_preview(x) {
				element = document.getElementById('ELSEWHERE');
				formName = element.form.id;
				if (formName == "guestForm") { 
					var temp = document.guestForm.PROJECT_NAME.value
					if(notEmpty(temp)==false) { 
						alert('Project Name must be populated.');
						document.guestForm.PROJECT_NAME.value = "";
						document.guestForm.PROJECT_NAME.focus();
						return false;
					} 
				} else if (formName == "contactForm") { 
					var temp = document.contactForm.PROJECT_NAME.value
					if(notEmpty(temp)==false) { 
						alert('Project Name must be populated.');
						document.contactForm.PROJECT_NAME.value = "";
						document.contactForm.PROJECT_NAME.focus();
						return false;
					} 
				}else { 
					var temp = document.getElementById('VM_NAME').value
					if(notEmpty(temp)==false) { 
						alert('Requested Name must be populated.');
						document.getElementById('VM_NAME').value = "";
						document.getElementById('VM_NAME').focus();
						return false;
					}
				} 
				document.getElementById('ELSEWHERE').value=x; 
				document.getElementById(formName).submit();				
			}
			function confirm_save_delete(x) { 
				var answer = confirm ("Confirm deletion of this server.")
				if (answer) { 
					element = document.getElementById('ELSEWHERE');
					formName = element.form.id; 
					if (formName == "contactForm") { 
						var temp = document.contactForm.PROJECT_NAME.value
						if(notEmpty(temp)==false) { 
							alert('Project Name must be populated.');
							document.contactForm.PROJECT_NAME.value = "";
							document.contactForm.PROJECT_NAME.focus();
							return false;
						} 
					}else { 
						var temp = document.getElementById('VM_NAME').value
						if(notEmpty(temp)==false) { 
							alert('Requested Name must be populated.');
							document.getElementById('VM_NAME').value = "";
							document.getElementById('VM_NAME').focus();
							return false;
						}
					}
					document.getElementById('ELSEWHERE').value=x;
					document.getElementById(formName).submit();
				}
			}
			function confirm_jump(x) { 
				element = document.getElementById('ELSEWHERE');
				formName = element.form.id; 
				if (formName == "guestForm") {
					var temp = document.guestForm.PROJECT_NAME.value
					if(notEmpty(temp)==false) { 
						alert('Project Name must be populated.');
						document.contactForm.PROJECT_NAME.value = "";
						document.contactForm.PROJECT_NAME.focus();
						return false;
					}  
				}else if (formName == "contactForm") { 
					var temp = document.contactForm.PROJECT_NAME.value
					if(notEmpty(temp)==false) { 
						alert('Project Name must be populated.');
						document.contactForm.PROJECT_NAME.value = "";
						document.contactForm.PROJECT_NAME.focus();
						return false;
					} 
				}else { 
					var temp = document.getElementById('VM_NAME').value
					if(notEmpty(temp)==false) { 
						alert('Requested Name must be populated.');
						document.getElementById('VM_NAME').value = "";
						document.getElementById('VM_NAME').focus();
						return false;
					}
				}
				document.getElementById('ELSEWHERE').value=x;
				document.getElementById(formName).submit();
			}
			function checkPhone( obj ) {
				var re1 = new RegExp( '^\\d{10}$' );
				var re2 = new RegExp( '^\\d{5}$' );
				var re3 = new RegExp( '^\\d{11}$' );
				var re4 = new RegExp( '^\\d{7}$' );
				var val = obj.value;
				var num = val.length;
				var parsedNo = "";
				for(var n=0; n<val.length; n++){
					var i = val.substr(n,1);
					if((i=="1")||(i=="2")||(i=="3")||(i=="4")||(i=="5")||(i=="6")||(i=="7")||(i=="8")||(i=="9")||(i=="0"))
						parsedNo += i;
				}
				if ( re1.test( parsedNo ) ) {
					obj.value = "(" + parsedNo.substr(0, 3) + ")" + parsedNo.substr(3,3) + "-" + parsedNo.substr(6,4);   // output = "(123)456-7890"  
					return;
				}else if ( re2.test( parsedNo ) ) {
					obj.value = parsedNo.substr(0, 1) + "-" + parsedNo.substr(1,4);   // output = "6-7890"  
					return;
				}else if ( re3.test( parsedNo ) && parsedNo.substr(0, 1) == "1" ) {
					obj.value = "(" + parsedNo.substr(1, 3) + ")" + parsedNo.substr(4,3) + "-" + parsedNo.substr(7,4);   // output = "(123)456-7890"   
					return;
				}else if ( re4.test( parsedNo ) ) {
					obj.value = parsedNo.substr(0, 3) + "-" + parsedNo.substr(3,4);   // output = "456-7890"  
					return;
				}else if (val == "") {
						return true;
				}else {
					alert(val + 'is an invalid telephone number. Verify and re-enter.');
					obj.value = '';
					return;
				}
			}
			function validate_required(field,alerttxt){
				with (field){
					if (value==null||value==""){
						alert(alerttxt);return false;
					}
					else
					{
						return true;
					}
				}
			}
			function remove(x)  {
				display="";
				document.getElementById("VM_FILES"+x).value = "";
				document.getElementById("FILE"+x).innerHTML = display;
				document.getElementById("REMOVE"+x).innerHTML = display;
			}
			function addfile(x) {
				if (navigator.appName == "Netscape") {
					var node = document.getElementById("VM_FILES"+x);
					var check = node.files[0].fileSize;
					if (check > '26214400') {   //26214400 = 25mb
						alert('This file exceeds the the 25MB limit.');
						document.getElementById("VM_FILES"+x).value = "";
						"VM_FILES"+x.focus();
						return false;
					}
				}
				if (validate_required(document.getElementById("VM_FILES"+x),"Bad file.")==false){
					document.getElementById("VM_FILES"+x).value = "";
					"VM_FILES"+x.focus();
					return false;
				}
				if(document.getElementById("VM_FILES"+x).value.lastIndexOf(".exe")==-1) {
					var next = x+1;
					var display1 = "<input type='button'  onclick='remove("+x+");' style='width:75px' value='Remove'>";
					var display2 = "<div style='display:inline;margin:0;padding:0;' name='FILE"+next+"' id='FILE"+next+"'><br><input name='VM_FILES"+next+"' id='VM_FILES"+next+"' type='file'  size='70' />&nbsp;</div><div style='display:inline;margin:0;padding:0;' name='REMOVE"+next+"' id='REMOVE"+next+"'><input type='button' onclick='addfile("+next+")' style='width:75px' value='Attach' /></div><div style='display:inline;margin:0;padding:0;' id='SHOW_FILES"+next+"'></div>";
					document.getElementById("REMOVE"+x).innerHTML = display1;
					document.getElementById("SHOW_FILES"+x).innerHTML = display2;
					document.getElementById("NUMBER_OF_FILES").value = x;
				} else {
					alert("Files with .exe extention are not permitted for upload.");
					document.getElementById("VM_FILES"+x).value = "";
					"VM_FILES"+x.focus();
					return false;
				}				
			}
			function init() {
				document.getElementById('POP').style.display='none';
				document.getElementById('LINKPOP').style.display='';
				
			}
			function autopop() {
				document.getElementById('POP').style.display='';
				document.getElementById('LINKPOP').style.display='none';
			}
			function confirm_autopop(formname,x) {
				var answer = confirm ("Click OK to auto populate current form with data from "+x+" Request.")
				if (answer) {
					document.getElementById(formname).submit();
				}
			}
			function osbits(vmOS) {
				if (vmOS.value === 'Windows 2008 SR') {
					document.getElementById('VM_OS_BITS').value = '32 bit';
				} else {
					document.getElementById('VM_OS_BITS').value = '64 bit';
				}
			}
		</script>
		<!--[if lte IE 7]> 
			<style>
				#menuwrapper, #p7menubar ul a {height: 1%;}
				a:active {width: auto;}
				.off {visibility: hidden;}
				.on {visibility: visible;}
			</style>
		<![endif]-->
		<!--[if lte IE 7]>
			<style>
				#left_menuwrapper, #left_mp7menubar ul a {height: 1%;}
				a:active {width: auto;}
				.off {visibility: hidden;}
				.on {visibility: visible;}
			</style>
		<![endif]-->
	</head>
	<body onload="P7_ExpMenu();">
		<a id="top" name="top"></a>
		<div class="container" id="doc2">
			<!---alternate rows js -->
			<script src="http://www.it.northwestern.edu/shared/nuit/scripts/alternate_rows.js" type="text/javascript"></script>
			<!-- end script -->
			<!---alternate rows js -->
			<script src="http://www.it.northwestern.edu/shared/nuit/scripts/icair.js" type="text/javascript"></script>
			<!-- end script -->
			<script language="JavaScript" type="text/javascript"><!-- 
				function goToURL(form) {
					var myindex=form.dropdownmenu.selectedIndex
					if(!myindex=="")  {
						window.location.href=form.dropdownmenu.options[myindex].value;      
					}
				}
			//--></script>
			<div id="hd"><!-- masthead and searchbox code -->
				<div id="searchbox">
					<div class="logo"><a href="http://www.it.northwestern.edu/index.html" id="logo-zone"></a></div>
					<div class="search">
						<form action="http://search.northwestern.edu/query" method="get"><input checked="checked" class="radio" id="web2" name="qp" type="radio" value="nugroup:nuit"/><a href="http://www.it.northwestern.edu" title="NUIT home page">Information Technology</a> <input class="zradio" name="qp" type="radio"/><a href="http://www.northwestern.edu" title="Northwestern University home page">Northwestern University</a> <input class="searchbox" id="searchinput" maxlength="256" name="qt" size="20" title="search" type="text"/> <input alt="search" src="http://www.it.northwestern.edu/shared/nuit/images/searchicon.gif" type="image"/></form>
						<form name="Quicklinks">
							<select name="dropdownmenu" onchange="goToURL(this.form)" size="1">
								<option>Quick Links</option>
								<option value="https://meetingmaker.northwestern.edu/mmwebclient/">Meeting Maker Online</option>
								<option value="https://listserv.it.northwestern.edu/cgi-bin/wa?HOME">NU Listserv Online</option>
								<option value="http://directory.northwestern.edu/">Online Directory</option>
								<option value="http://www.univsvcs.northwestern.edu/Purchasing/">Purchase Resources</option>
								<option value="http://www.it.northwestern.edu/servicestatus/index.html">Service Status</option>
								<option value="http://www.it.northwestern.edu/accounts/email/webmail.html#t7">Set Vacation Message</option>
								<option value="http://www.northwestern.edu/webmail/">WebMail</option>
							</select>
						</form>
					</div>
					<!--end search-->
				</div>
				<!--end searchbox-->
			</div>
			<!--end hd-->
			<div id="inner_wrap">
				<div id="menuwrapper">
					<ul id="p7menubar">
						<li>
							<a class="trigger" href="http://www.it.northwestern.edu/support/index.html">SUPPORT</a> 
							<ul>
								<li><a href="http://www.it.northwestern.edu/supportcenter/index.html">NUIT Support Center</a></li>
								<li><a href="http://www.it.northwestern.edu/support/index.html" title="General Technology Support">General Support</a></li>
								<li><a href="http://www.it.northwestern.edu/dss/index.html">Department &amp; School</a></li>
							</ul>
						</li>
						<li>
							<a class="trigger" href="http://www.it.northwestern.edu/connected/index.html">GET CONNECTED</a> 
							<ul>
								<li><a href="http://www.it.northwestern.edu/mobility/index.html">Mobile</a></li>
								<li><a href="http://www.it.northwestern.edu/offcampus/index.html" title="Connecting from Off Campus">Off Campus</a></li>
								<li><a href="http://www.it.northwestern.edu/oncampus/index.html" title="Connecting from On Campus">On Campus</a></li>
								<li><a href="http://www.it.northwestern.edu/netid/index.html">NetID and Password</a></li>
								<li><a href="http://www.it.northwestern.edu/accounts/index.html">E-mail and Collaboration</a></li>
								<li><a href="http://www.it.northwestern.edu/oncampus/wireless/locations.html">Wireless Access Points</a></li>
							</ul>
						</li>
						<li>
							<a class="trigger" href="http://www.it.northwestern.edu/education/index.html">LEARNING &amp; TEACHING</a> 
							<ul>
								<li><a href="http://www.it.northwestern.edu/education/complabs/index.html">Computer Labs</a></li>
								<li><a href="http://www.it.northwestern.edu/education/course-management/index.html">Course Management System</a></li>
								<li><a href="http://www.it.northwestern.edu/education/depot/index.html">Depot</a></li>
								<li><a href="http://nuamps.at.northwestern.edu/" title="Digital Media Services (NUAMPS)">Digital Media Services</a></li>
								<li><a href="http://www.it.northwestern.edu/education/classrooms/index.html" title="Smart Classrooms">Smart Classrooms</a></li>
								<li><a href="http://www.it.northwestern.edu/srs/index.html" title="Student Response System (SRS)">Student Response System</a></li>
								<li><a href="http://www.it.northwestern.edu/education/vislab/overview.html" title="Visualization Lab (Vislab)">Visualization Lab</a></li>
								<li><a href="http://www.it.northwestern.edu/learning/index.html" title="NUIT Workshops and Events">Workshops and Events</a></li>
							</ul>
						</li>
						<li>
							<a class="trigger" href="http://www.it.northwestern.edu/services/index.html">SERVICES</a> 
							<ul>
								<li><a href="http://www.it.northwestern.edu/security/index.html" title="Secure IT @ NU">Secure IT @ NU</a></li>
								<li><a href="http://www.it.northwestern.edu/business-intelligence/index.html" title="Business Intelligence Solutions">Business Intelligence</a></li>
								<li><a href="http://www.it.northwestern.edu/conduits/index.html" title="CONDUITS Online">CONDUITS</a></li>
								<li><a href="http://www.it.northwestern.edu/conferencing/index.html">Conferencing Services</a></li>
								<li><a href="http://www.it.northwestern.edu/crs/index.html" title="Customer Request System (CRS)">Customer Request System</a></li>
								<li><a href="http://www.it.northwestern.edu/data-centers/index.html">Data Center Facilities</a></li>
								<li><a href="http://www.it.northwestern.edu/hardware/index.html">Hardware</a></li>
								<li><a href="http://www.it.northwestern.edu/listserv/index.html">Listserv</a></li>
								<li><a href="http://www.it.northwestern.edu/software/meetingmaker/">Meeting Maker</a></li>
								<li><a href="http://www.it.northwestern.edu/network/index.html" title="Network Services">Network</a></li>
								<li><a href="http://www.it.northwestern.edu/tv/index.html" title="NUTV and TV Services">NUTV and TV</a></li>
								<li><a href="http://www.it.northwestern.edu/policies/index.html">Policies and Guidelines</a></li>
								<li><a href="http://www.it.northwestern.edu/reserve/index.html">Reserve a Facility</a></li>
								<li><a href="http://www.it.northwestern.edu/servicestatus/index.html">Service Status</a></li>
								<li><a href="http://www.it.northwestern.edu/software/index.html">Software</a></li>
								<li><a href="http://www.it.northwestern.edu/telephone/index.html" title="Telephone Services">Telephone</a></li>
								<li><a href="http://nuportal.northwestern.edu/">The NUPortal</a></li>
								<li><a href="http://www.it.northwestern.edu/auth-svcs/index.html" title="User Authentication Services">User Authentication</a></li>
								<li><a href="http://www.it.northwestern.edu/desktop-videoconference/index.html">Desktop Videoconferencing</a></li>
								<li><a href="http://www.it.northwestern.edu/videoconferencing/index.html" title="Videoconferencing Services">Videoconferencing</a></li>
								<li><a href="http://www.it.northwestern.edu/webpub/index.html" title="Web Publishing Services">Web Publishing</a></li>
								<li><a href="http://www.northwestern.edu/webmail/">WebMail</a></li>
							</ul>
						</li>
						<li>
							<a class="trigger" href="http://www.it.northwestern.edu/research/index.html">RESEARCH RESOURCES</a> 
							<ul>
								<li><a href="http://www.it.northwestern.edu/research/adv-research/index.html">Advanced Research Computing</a></li>
								<li><a href="http://www.it.northwestern.edu/research/adv-research/hpc/index.html" title="High Performance Computing">High Performance Computing</a></li>
								<li><a href="http://www.it.northwestern.edu/research/adv-research/hpc/quest/index.html" title="Quest">Quest</a></li>
								<li><a href="http://www.it.northwestern.edu/data-centers/research-data-centers.html">Research Data Center Facilities</a></li>
								<li><a href="http://www.startap.net/starlight/ABOUT/" title="StarLight">Advanced Network Access Point</a></li>
								<li><a href="http://www.icair.org/" title="International Center for Advanced Internet Research (iCAIR)">iCAIR.org</a></li>
								<li><a href="http://www.it.northwestern.edu/research/global-networks.html" title="Global Network Collaborations">Global Network Collaborations</a></li>
								<li><a href="http://sscc.northwestern.edu/" title="Social Sciences Computing Cluster (SSCC)">Social Sciences Computing Cluster</a></li>
							</ul>
						</li>
						<li>
							<a class="trigger" href="../index.html">ABOUT NUIT</a> 
							<ul>
								<li><a href="../organization/index.html">NUIT Organization</a></li>
								<li><a href="http://www.it.northwestern.edu/blog/insider.html">Blog</a></li>
								<li><a href="index.html" title="NUIT Committees">Committees</a></li>
								<li><a href="http://www.it.northwestern.edu/it-intranet/index" title="NUIT Intranet">Intranet (NUIT only)</a></li>
								<li><a href="../jobs/index.html" title="Job Opportunities in NUIT">Jobs</a></li>
								<li><a href="http://www.it.northwestern.edu/podcasts/index.html" title="NUIT To Go">Podcasts</a></li>
								<li><a href="http://www.it.northwestern.edu/policies/index.html">Policies and Guidelines</a></li>
								<li><a href="http://www.it.northwestern.edu/news/publication/index.html" title="NUIT Publications">Publications</a></li>
								<li><a href="../stats/index.html" title="NUIT Results and Statistics">Results and Statistics</a></li>
								<li><a href="http://www.it.northwestern.edu/learning/index.html" title="NUIT Workshops and Events">Workshops and Events</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div id="page">
					<div style="width: 100%;display:inline;margin:0;padding:0;">
						<div class="breadcrumb">
							<a href="#" onclick="confirm_jump('NUIT');">NUIT Home</a> 
							&rsaquo; <a href="#" onclick="confirm_jump('FACILITIES');">University Data Center Facilities</a>							
							&rsaquo; <a href="#" onclick="confirm_jump('MAIN');">Virtual Server Dashboard</a> 
							&rsaquo; <span class="zbccurrent">Server Hosting Request</span>
						</div>
						<div class="l">
							<div id="maincontent"><br>
								<div id="ztitle">
									<h1>Data Center Server Hosting Request</h1>
								</div>
								<?php 
									require("sidebar.php");
									if(isset($_POST['CONTACT'])) {
										require("forms/contactform.php");
									} else {
										if (isset($_POST['VM_TYPE']) && $_POST['VM_TYPE'] == "Guest"){ 
											$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
											require("forms/guestform.php");
										} elseif (isset($_POST['VM_TYPE']) && $_POST['VM_TYPE'] == "Application") {
											$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
											require("forms/applicationform.php");
										} elseif (isset($_POST['VM_TYPE']) && $_POST['VM_TYPE'] == "Database") {
											$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
											require("forms/databaseform.php");
										} elseif (isset($_POST['VM_TYPE']) && $_POST['VM_TYPE'] == "Fileserv") {
											$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
											require("forms/fileservform.php");
										} elseif (isset($_POST['VM_TYPE']) && $_POST['VM_TYPE'] == "Webserv") {
											$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
											require("forms/webservform.php");
										} else {
											$FIRST_VM_VALUES = mysql_query("
												SELECT VM_ORDER_DETAIL_ID, VM_TYPE 
												FROM VM_ORDER_DETAIL
												WHERE VM_ORDER_ID = '$VM_ORDER_ID'
												ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
											")or die(mysql_error()); 
											$FIRST_VM_VALUES_RECORD = mysql_fetch_array($FIRST_VM_VALUES) or die(mysql_error());
											$VM_ORDER_DETAIL_ID = $FIRST_VM_VALUES_RECORD['VM_ORDER_DETAIL_ID'];
											$VM_TYPE = $FIRST_VM_VALUES_RECORD['VM_TYPE']; 
											if ($VM_TYPE == "Application"){
												require("forms/applicationform.php");
											} elseif ($VM_TYPE == "Database"){
												require("forms/databaseform.php");
											} elseif ($VM_TYPE == "Fileserv"){
												require("forms/fileservform.php");
											} elseif ($VM_TYPE == "Webserv"){
												require("forms/webservform.php");
											} elseif ($VM_TYPE == "Guest"){
												require("forms/guestform.php");
											}
										}
									}
								if (isset($NUM_COMPLETE) && $NUM_COMPLETE >0) { echo'<div style="clear: both;"><script type="text/javascript">window.onload = init;</script></div>';}
								?>
							</div>
						</div>
					</div>
					<div id="ft">
						<p class="nulogo"><a href="http://www.northwestern.edu"><img alt="Northwestern University logo" border="0" src="http://www.it.northwestern.edu/shared/nuit/images/seal-purple.gif" title="Northwestern University home page"/></a></p>
						<div class="info">
							<p>Information Technology 1800 Sherman Avenue Evanston, Illinois 60201 | <a href="http://www.it.northwestern.edu/support/index.html"><strong>Contact Us</strong></a></p>
							<p><a href="http://www.northwestern.edu/" title="Northestern University Home">Northwestern Home</a> | <a href="http://planitpurple.northwestern.edu/" title="Plan-It Purple, Northwestern University Calendar">Calendar: Plan-It Purple</a> | <a href="http://directory.northwestern.edu/">Online Directory</a> | <a href="http://www.northwestern.edu/search/" title="Search Northwestern University">Search</a></p>
							<p><a href="http://www.northwestern.edu/disclaimer.html">World Wide Web Disclaimer</a> and <a href="http://www.northwestern.edu/policy.html">University Policy Statements</a></p>
							<p>&copy; 2010 Northwestern University</p>
						</div>
						<div id="gglogo"><a href="http://www.it.northwestern.edu/greenberg/index.html"><img alt="Gary Greenberg Technology for Children Scholarship Fund" src="http://www.it.northwestern.edu/shared/nuit/images/garygreenberg.gif" title="Gary Greenberg Technology for Children Scholarship Fund"/></a></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>