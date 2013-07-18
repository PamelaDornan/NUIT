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
		<script language="JavaScript" type="text/javascript">
			function hide(x) {
				document.getElementById(x).style.display='none';
			}
			function show(x) {
				document.getElementById(x).style.display='';
			}
			function confirm_delete(thisform){
				var answer = confirm ("Confirm deletion of this request.")
				if (answer)
					return true;
				else
					return false;
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
			function validateQTY(x) {
				var parsedNo = "";
				var i = x.value.substr(0,1);
				if((i=="1")||(i=="2")||(i=="3")||(i=="4")||(i=="5")||(i=="6")||(i=="7")||(i=="8")||(i=="9")) { parsedNo += i;}
				var i = x.value.substr(1,1);
				if((i=="1")||(i=="2")||(i=="3")||(i=="4")||(i=="5")||(i=="6")||(i=="7")||(i=="8")||(i=="9")||(i=="0")) { parsedNo += i;  }
				x.value = parsedNo;
				if(x.value == 0) { x.value = "";}
				if(x.value > 25) {
					alert("Quantity must be less than 25."); x.value="";
				}
			}
			function checkEmail(field)
			{
				with (field)
				{
					apos=value.indexOf("@");
					dotpos=value.lastIndexOf(".");
					if (apos<1||dotpos-apos<2) {
						alert( 'Invalid Entry: ' + value );
						value = '';
						focus();
						return false;
					}
					else {
						return true;
					}
				}
			}
			function checkPhone( obj ) {
				var re1 = new RegExp( '^\\d{10}$' );
				var re2 = new RegExp( '^\\d{5}$' );
				var re3 = new RegExp( '^\\d{11}$' );
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
					obj.value = "(" + parsedNo.substr(1, 3) + ")" + parsedNo.substr(2,3) + "-" + parsedNo.substr(7,4);   // output = "(123)456-7890"   
					return;
				}else{
					alert( 'Invalid Entry: ' + val );
					obj.value = '';
					return;
				}
			}
			function validate_form(thisform){
				with (thisform){
					if (VM_ORDER_TYPE[0].checked == false && VM_ORDER_TYPE[1].checked == false && VM_ORDER_TYPE[2].checked == false) {
						alert("Choose a request type."); return false;
					}
					if (validate_required(PROJECT_NAME,"Project name must be filled out.")==false){
						PROJECT_NAME.focus();return false;
					}
					if (VM_ORDER_TYPE[2].checked){
						ACTION.value = "NEW MANAGED SERVER";
					} else { 
						ACTION.value = "NEW GUEST HOSTING";
					}
					document.newForm.submit();
				}
			}
		</script>
	</head>
	<body onload="P7_ExpMenu();
				document.newForm.VM_ORDER_TYPE[0].checked = false;
				document.newForm.VM_ORDER_TYPE[1].checked = false;
				document.newForm.VM_ORDER_TYPE[2].checked = false;">
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
					<!--================== Begin Left Nav ==================-->
					<!-- start page -->
					<div id="sidebar">
						<div id="leftnav">
							<h3>Additional Information</h3>                   
						</div>
						<!-- begin Current page -->
						<!-- begin showShortTitle select -->
						<p><b>Request Virtual Server Hosting</b></p>	
						<!-- end showShortTitle select -->
						<!-- begin showInfo select -->
						<ul>
							<li><a class="" title="" href="http://www.it.northwestern.edu/data-centers/hosting-services.html" target="_self">Virtual Hosting Services at Northwestern</a></li>
						</ul>
						<!-- end showInfo select -->	
						<!-- end Current page -->
						<!-- begin indexfile select -->
						<!-- if there is has an index in CurrentLevel -->
						<!-- begin CurrentLevel indexfile -->
						<hr size="1px" />
						<p><a href="http://www.it.northwestern.edu/data-centers/index.html">University Data Center Facilities</a></p>
						<!-- end CurrentLevel indexfile -->
						<!-- end indexfile select -->
					</div>    
<!--================== End Left Nav ==================-->
					<div id="content">
						<div class="breadcrumb">
							<a href="http://www.it.northwestern.edu/index.html">NUIT Home</a> 
							&rsaquo; <a href="http://www.it.northwestern.edu/data-centers/index.html">University Data Center Facilities</a>
							&rsaquo; <span class="zbccurrent">Virtual Server Dashboard</span>
						</div>
						<div class="l">
							<div id="maincontent">
									<?php $NETID = $_SERVER['REMOTE_USER']; ?>
								<div id="ztitle">
									<h1>Request Virtual Server Hosting Services</h1>
								</div>
							<? 
								if ( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0 )  {  
									$displayMaxSize = ini_get('post_max_size');  
									switch ( substr($displayMaxSize,-1) )  {  
										case 'G':  
											$displayMaxSize = $displayMaxSize * 1024;  
										case 'M':  
											$displayMaxSize = $displayMaxSize * 1024;  
										case 'K':  
											$displayMaxSize = $displayMaxSize * 1024;  
									}  
									echo '<font color="#CC1100">Posted data was too large. Reapply changes to your request and check that your attached files are under 25MB before saving.</font>';  
								} ?>
								<?php if(isset($_POST['MESG'])) echo '<div style="padding:5;" id="notice"><b>'.$_POST['MESG'].'</b></div><br>'; ?>
								<p>To request virtualized hosting services at Northwestern, complete the request form below and provide the required supporting information depending on the server hosting type requested:</p>
								<ul>
									<li>Research Guest Hosting</li>
									<li>Administrative Guest Hosting</li>
									<li>Managed Server Hosting</li>
								</ul>
								<p>You may complete the request form in one session, or save and submit it at a later date.  Saved requests are displayed in the <b>Unsubmitted Requests</b> section and can be modified or deleted at any time prior to your final submission.</p>
								<p>When you are satisfied that all data is complete, <i>click</i> the submit button. Allow up to <b>three business days</b> for NUIT to process your request.</p>
								<p><b>Note:</b> NUIT's data center strategy relies upon virtual infrastructures for storage, computation, and network services. Any request for Physical Servers will require a face-to-face meeting to examine the requirements for a physical rather than virtual server(s). Physical server requests should be e-mailed to <a href="mailto:hosting@ci.northwestern.edu">hosting@ci.northwestern.edu</a>.</p>
								<p>More information, about virtual server hosting services can be found in <a href="http://www.it.northwestern.edu/policies/admin-datacenter-hosting.html" target="_blank">Practice on Locating Administrative Applications or Equipment In Central Data Centers</a>.</p>
								<a NAME="restable"></a> 
								<table cellpadding="4" style="border:2px solid #6c4272;border-collapse:collapse;table-layout:fixed;width:640px;padding:0;margin-top:10px;">
									<tr>
										<td width="85px" style="overflow:hidden;white-space:nowrap;border:0; padding:0; margin:0;"></td>
										<td width="68px" style="overflow:hidden;white-space:nowrap;border:0; padding:0; margin:0;"></td>
										<td width="380px" style="overflow:hidden;white-space:nowrap;border:0; padding:0; margin:0;"></td>
										<td width="52px" style="overflow:hidden;white-space:nowrap;border:0; padding:0; margin:0;"></td>
										<td width="52px" style="overflow:hidden;white-space:nowrap;border:0; padding:0; margin:0;"></td>
									</tr>
									<tr bgcolor=#6c4272 >
										<th style="color: #ffffff; overflow:hidden;white-space:nowrap; border-bottom: 2px solid #6c4272; border-right:2px solid #6c4272; border-left:2px solid #6c4272; border-top:2px solid #6c4272;" colspan="5" valign="top">
											<div align="left">
												<?php echo $NETID; ?>'s Unsubmitted Requests
											</div>
										</th>
									</tr>
									<tr bgcolor=#dddddd>
										<td style="margin:0; padding:0; text-align:center; border-left:2px solid #a78d84; border-right:2px solid #a78d84; border-bottom:2px solid #a78d84;">Create Date</td>
										<td style="margin:0; padding:0; text-align:left; border-left:2px solid #a78d84; border-right:2px solid #a78d84; border-bottom:2px solid #a78d84;">&nbsp;&nbsp;Type</td>
										<td style="margin:0; padding:0; text-align:left;  border-left:2px solid #a78d84; border-right:2px solid #a78d84; border-bottom:2px solid #a78d84;">&nbsp;Project Name</td>
										<td style="margin:0; padding:0; text-align:left;  border-left:2px solid #a78d84; border-right:2px solid #a78d84; border-bottom:2px solid #a78d84;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td style="margin:0; padding:0; text-align:left;  border-left:2px solid #a78d84; border-right:2px solid #a78d84; border-bottom:2px solid #a78d84;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									</tr>
									<?php 
										include 'mysql/connection.php';//connection to mysql db
			
										$list = mysql_query("
											SELECT * 
											FROM VM_ORDER
											WHERE NETID = '$NETID' AND SUBMIT_FLAG = '0'
											ORDER BY CREATE_DATE ASC
										")or die(mysql_error());
										$num_listresults = mysql_num_rows($list);
										$listresults_array = array(); 
										while ($listrow = mysql_fetch_array($list))
										{ 
											$listresults_array[$listrow['VM_ORDER_ID']] = $listrow;
										}
										if ($num_listresults < 1){
											echo '<tr class="even">
												<td colspan="5" style="border-bottom:2px solid #6c4272;border-left:2px solid #6c4272;border-right:2px solid #6c4272;"><center>You do not have any unsubmitted requests at this time.</center></td>
											</tr>';
										}  
										else {
											$i = 1;
											$OddEven = 1;
											foreach ($listresults_array as $ID => $listrecord) {
												$CREATE_DATE = date( 'm/d/Y', strtotime($listrecord['CREATE_DATE']));
												echo'<tr '; if ($OddEven == "1") {echo' style="background-color:#FFFFF0" ';} if ($OddEven == "2") {echo' style="background-color:#dddddd;" ';} echo'>';
													$OddEven = $OddEven + 1; //to Maintain Alternating Row Color on Table
													echo'<td style="'; if ($num_listresults == $i) echo 'border-bottom:2px solid #6c4272;'; echo 'border-right:1px solid white;overflow:hidden;white-space:nowrap;text-align:center;"><p nowrap style="display:inline;margin:0;padding:0;">'; echo $CREATE_DATE; echo'</p></td>';
#---------BEGIN Request Type Column---------					
													echo'<td style="'; if ($num_listresults == $i) echo 'border-bottom:2px solid #6c4272;'; echo 'border-right:1px solid white;overflow:hidden;white-space:nowrap;">&nbsp;'; 
															if ($listrecord['VM_ORDER_TYPE'] == 'Administrative Guest Hosting' || $listrecord['VM_ORDER_TYPE'] == 'Research Guest Hosting') {echo 'Guest';} 
															else {echo 'Managed';}
														echo'</td>';
#---------END Request Type Column---------';						
													echo'<td style="'; if ($num_listresults == $i) echo 'border-bottom:2px solid #6c4272;'; echo 'margin-right:3px;border-right:1px solid white;overflow:hidden;white-space:nowrap;">&nbsp;'; echo $listrecord['PROJECT_NAME']; echo'</td>';
													echo'<td style="'; if ($num_listresults == $i) echo 'border-bottom:2px solid #6c4272;'; echo 'border-right:1px solid white;overflow:hidden;white-space:nowrap;">
														<form name="edit' . $listrecord['VM_ORDER_ID'] . '" action="index.php" method="post" style="display:inline;margin:0;padding:0;">';
														echo'<input type="hidden" name="VM_ORDER_ID" value="' . $listrecord['VM_ORDER_ID'] . '">';
															if ($listrecord['VM_ORDER_TYPE'] == 'Managed Server Hosting') {echo '<input type="hidden" name="CONTACT" value="CONTACT">';} 
															else {
																$VM_ORDER_ID = $listrecord['VM_ORDER_ID'];
																$FIRST_VM_VALUES = mysql_query("
																	SELECT VM_ORDER_DETAIL_ID, VM_TYPE 
																	FROM VM_ORDER_DETAIL
																	WHERE VM_ORDER_ID = '$VM_ORDER_ID'
																	ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
																")or die(mysql_error()); 
																$FIRST_VM_VALUES_RECORD = mysql_fetch_array($FIRST_VM_VALUES) or die(mysql_error());
																echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$FIRST_VM_VALUES_RECORD['VM_ORDER_DETAIL_ID'].'">';
															}
														echo '<a href="#" onclick="parentNode.submit();">
																<p style="display:inline;margin:0;padding:0;">
																	Modify
																</p>
															</a>
															<input type="hidden" name="PAGE" value="APPLICATION" />
														</form>
													</td>';
													echo'<td name="delete' . $listrecord['VM_ORDER_ID'] . '" style="'; if ($num_listresults == $i) echo 'border-bottom:2px solid #6c4272;'; echo 'overflow:hidden;white-space:nowrap;text-align:center;">
														<form name="deleteForm" action="index.php" onsubmit="return confirm_delete(this);" method="post" style="display:inline;margin:0;padding:0;">
															<input type="hidden" name="VM_ORDER_ID" value="' . $listrecord['VM_ORDER_ID'] . '">
															<input type="hidden" name="ACTION" value="ORDER DELETE">
															<a href="#" onclick="if (confirm_delete(this)) parentNode.submit();">
																<p style="display:inline;margin:0;padding:0;">
																	Delete
																</p>
															</a>
															<input type="hidden" name="PAGE" value="PROCESSING" />
														</form>
													</td>';
												echo'<tr>';
												if ($OddEven =="3"){ $OddEven = 1;}//to Maintain Alternating Row Color on Table
												$i++;
											}
											unset($ID);
										}
									?>
								</table><br>
								<table style="width: 640px;border:3px solid #AAAAAA;">
									<tr>
										<th style="padding-top: 3px;padding-right: 4px;padding-bottom: 3px;padding-left: 4px;background-color: #6c4272;color: #ffffff;border-bottom: 2px solid #6c4272; border-right:2px solid #6c4272; border-left:2px solid #6c4272; border-top:2px solid #6c4272;" colspan="6" valign="top">
											<div align="left">
												<p style="display:inline;margin:0;padding:0;">New Request</p>
											</div>
										</th>
									</tr>
									<tr>
										<td>
											<form action="index.php" onsubmit="return validate_form(this)" method="post" name="newForm">
												<h3>Request Type&nbsp;&nbsp;&nbsp;</h3>
												<table CELLPADDING=4 style="width:600px;margin-bottom:10px;margin-left:5px;border-collapse:collapse;border:1px solid #dddddd;">
													<tr bgcolor=#dddddd>
														<td style="text-align:left;">
															<input name="VM_ORDER_TYPE" value="Research Guest Hosting" style="vertical-align:-25%;vertical-align:100%;" type="radio" />
														</td>
														<td>
															<b>Research Guest Hosting: </b>  Choose this option to request a self-managed virtual server for the purpose of research.
														</td>
													</tr>
													<tr bgcolor=#FFFFF0>
														<td style="text-align:left;">
															<input name="VM_ORDER_TYPE" value="Administrative Guest Hosting" style="vertical-align:-25%;vertical-align:100%;" type="radio" />
														</td>
														<td>
															<b>Administrative Guest Hosting: </b>  Choose this option to request a self-managed virtual server for administrative or departmental use.
														</td>
													</tr>
													<tr bgcolor=#dddddd>
														<td style="text-align:left;">
															<input name="VM_ORDER_TYPE" value="Managed Server Hosting" style="vertical-align:-25%;vertical-align:100%;" type="radio" />
														</td>
														<td>
															<b>Managed Server Hosting: </b>  Choose this option for an enterprise-level application jointly managed with NUIT Cyberinfastructure.  You may request a combination of virtual servers including web servers, files servers, database servers, or application servers.
														</td>
													</tr>
												</table>
												<h3>Project Name (required)&nbsp;&nbsp;&nbsp;</h3>
												<table CELLPADDING=2 style="width:600px;margin-bottom:10px;margin-left:5px;border-collapse:collapse;border:1px solid #dddddd;">
													<tr>
														<td bgcolor=#dddddd style="padding:5px;width:225px;">
															The project name will serve as a general identifier for this request.<br>
															<input name="PROJECT_NAME" maxlength="50" size="91" />
														</td>
													</tr>
												</table>
												<input type="hidden" name="ACTION" />
												<div style="display:inline;width:300px;"></div>
												<div style="display:inline;float:right;text-align:right;width:300px;">
													<input type="button" style="float:right;display:inline;" onclick="if (validate_form(document.newForm)) { document.newForm.submit();}" value="Add & Continue &raquo;" />
												</div>
												<input type="hidden" name="PAGE" value="PROCESSING" />
											</form>
										</td>
									</tr>
								</table>
								<br>
								<a name="bottom"></a>
								<div style="clear: both;"></div>
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
		</div>
	</body>
</html>
