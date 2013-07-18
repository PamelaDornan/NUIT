<html>
	<head>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<script>
			history.forward();
		</script>
		<script language="JavaScript" type="text/javascript">
			function printWindow(){
				browserVersion = parseInt(navigator.appVersion)
				if (browserVersion >= 4) window.print()
			}
		</script>
		<style>
			@media print {
				.noprint {display:none;}
			}
		</style>
	</head>
	<body> 
	<div class="noprint">
		&nbsp;<br>
		<input value="Print" type="BUTTON" onclick="javascript:printWindow()" />
		<br>&nbsp;
	</div>
	<?php
			$NETID = $_SERVER['REMOTE_USER'];
			include 'mysql/connection.php';//connection to mysql db
			$BODY="";
			$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$CONTACT_VALUES = mysql_query("
				SELECT * 
				FROM VM_ORDER
				WHERE VM_ORDER_ID = '$VM_ORDER_ID'
			")or die(mysql_error()); 
			$CONTACT_VALUES_RECORD = mysql_fetch_array($CONTACT_VALUES) or die(mysql_error());
			if ($CONTACT_VALUES_RECORD['SUBMIT_FLAG'] == 1) { 
				echo'<script language="javascript">
					<!--
						window.close();
					-->
				</script>';
			}
			$subject = $CONTACT_VALUES_RECORD['PROJECT_NAME'] . " - " . $CONTACT_VALUES_RECORD['VM_ORDER_TYPE'];
			$BODY="Request Type:  ".$CONTACT_VALUES_RECORD['VM_ORDER_TYPE']."<br>
			Project Name:  ".$CONTACT_VALUES_RECORD['PROJECT_NAME']."<br>
			Submitter NetID:  ".$NETID."<br><br>
			Main Contact Information<br>------------------------<br>
			Name:  ".$CONTACT_VALUES_RECORD['CONTACT_NAME']."<br>
			NetID:  ".$CONTACT_VALUES_RECORD['CONTACT_NETID']."<br>
			Dept:  ".$CONTACT_VALUES_RECORD['CONTACT_DEPARTMENT']."<br>
			E-mail:  ".$CONTACT_VALUES_RECORD['CONTACT_EMAIL']."<br>
			Telephone:  ".$CONTACT_VALUES_RECORD['CONTACT_PHONE']."<br><br>";
			#-------------------------------------------- If Managed Server Request -------------------------------------------- 
			if($CONTACT_VALUES_RECORD['VM_ORDER_TYPE']=="Managed Server Hosting"){
				$BODY .= "Server Type Quantities<br>------------------------<br>
				Application:  ".$CONTACT_VALUES_RECORD['QTY_APPLICATION']."<br>
				Database:  ".$CONTACT_VALUES_RECORD['QTY_DATABASE']."<br>
				File Server:  ".$CONTACT_VALUES_RECORD['QTY_FILESERV']."<br>
				Web Server:  ".$CONTACT_VALUES_RECORD['QTY_WEBSERV']."";
				$VM_ORDER_DETAIL = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID'
					ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
				")or die(mysql_error());								
				$NUM_VM_ORDER_DETAIL_RESULTS = mysql_num_rows($VM_ORDER_DETAIL );								
				$VM_ORDER_DETAIL_RESULTS_ARRAY = array(); 
				while ($VM_ORDER_DETAIL_ROW = mysql_fetch_array($VM_ORDER_DETAIL ))
				{ 
					$VM_ORDER_DETAIL_RESULTS_ARRAY[$VM_ORDER_DETAIL_ROW['VM_ORDER_DETAIL_ID']] = $VM_ORDER_DETAIL_ROW;
				} 
				foreach ($VM_ORDER_DETAIL_RESULTS_ARRAY as $VM_ORDER_DETAIL_ID => $VM_ORDER_DETAIL_RECORD) {
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Application") {
						$BODY .= "<br><br>------------------------------------------------------------------------------------------------------------------<br><br>";
						$BODY .= "APPLICATION SERVER: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."<br><br>
						Application Server Specifics<br>------------------------<br>
						Characteristics:  ".$VM_ORDER_DETAIL_RECORD['VM_CHARACTERISTICS']."<br>
						Server Purpose/Volume:  ".$VM_ORDER_DETAIL_RECORD['VM_VOLUME']."<br>
						OS:  ".$VM_ORDER_DETAIL_RECORD['VM_OS']." ".$VM_ORDER_DETAIL_RECORD['VM_OS_BITS']."<br>
						Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."<br>
						CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."<br>
						<br>Application Server Access<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['NUM_USERS'])) {
							$BODY .= "Number of Users Requiring Simultaneous Access:  ".$VM_ORDER_DETAIL_RECORD['NUM_USERS']."<br>"; 
						}
						$BODY .= "User Communities with access:  ";
						$temp = $VM_ORDER_DETAIL_RECORD['USER_COMMUNITY'];
						$USER_COMMUNITY = explode(",",$temp);
						$COUNT = 0;
						$x = count($USER_COMMUNITY);
						for ($i=0;$i<5;$i++) {
							if(!empty($USER_COMMUNITY[$i]) && $USER_COMMUNITY[$i] != "none" && $USER_COMMUNITY[$i] != "Other") {
								if ($COUNT == 0) {
									$BODY .= $USER_COMMUNITY[$i];
									$COUNT++;
								} else {
									$BODY .= ", ".$USER_COMMUNITY[$i];
								}	
							}
						}
						if ($x == 6) { 
							if (!empty($USER_COMMUNITY[5])) {
								if ($COUNT == 0) $BODY .=  $USER_COMMUNITY[5]; 
								else $BODY .=  ", ".$USER_COMMUNITY[5];
							}
						}
						elseif ($x > 6) { 
							for($i = 5; $i<$x; $i++) { 
								if ($COUNT == 0) {
									$BODY .= $USER_COMMUNITY[$i];
									$COUNT++;
								} else {
									$BODY .= "," . $USER_COMMUNITY[$i];
								}
							}
						}
						$BODY .= "<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
							$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."<br>"; 
						}
						if(isset($VM_ORDER_DETAIL_RECORD['FTP_FLAG'])) {
							$BODY .= "<br>Application Server FTP Requirements<br>------------------------<br>
							SFTP Required:  ";
							if($VM_ORDER_DETAIL_RECORD['FTP_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						$BODY .= "<br>Application Server Storage and Backup<br>------------------------<br>
						Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."<br>
						Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."<br>
						Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."<br>"; 
						}
						$BODY .= "<br>Application Server Service Operations Requirements<br>------------------------<br>";
						if($VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_FLAG'] == 1 ) {	
								$BODY .= "Automated Job Scheduling:  is Required";
								if($VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_DETAILS'] <> null) {
									$BODY .= " - ".$VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_DETAILS'];
								}
							} else {
								$BODY .= "Automated Job Scheduling:  is NOT Required";
							}
							$BODY .= "<br>";
						}						
						if (isset($VM_ORDER_DETAIL_RECORD['NUM_CYCLE_JOBS'])) { 
							$BODY .= "Jobs Over a 12-Month Cycle:  ".$VM_ORDER_DETAIL_RECORD['NUM_CYCLE_JOBS']."<br>";
						}
						if(isset($VM_ORDER_DETAIL_RECORD['CALL_OUT_FLAG'])) {
							$BODY .= "24/7 Job Monitoring With Call Outs:  ";
							if($VM_ORDER_DETAIL_RECORD['CALL_OUT_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						$BODY .= "Data Needs HIPAA, FISMA, HITECH Act Compliance:  ";
						if($VM_ORDER_DETAIL_RECORD['DATA_COMPLIANCE_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['DATA_COMPLIANCE_FLAG']==1) $BODY .= "Yes";
							else $BODY .= "No";
						}
						$BODY .= "<br><br>Application Server Firewall Information<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."<br>"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."<br>";
						if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'] <> null) {
							$BODY .= "SSL VPN Required:  ";
							if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "<br>Application Server Attachments<br>------------------------<br>";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."<br>";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "<br>Application Server Additional Comments<br>------------------------<br>".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."<br>";
						}
						$BODY .= "<br>Application Server Monitoring Alert Information<br>------------------------<br>";
						if($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] <> null) {
							if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
								$BODY .= "This service is required <br>
								Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."<br>
								Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."<br>
								Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."<br>";
								$BODY .= "Notification Period:  ";
								if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
									$BODY .= $VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'];
								}
								$BODY .= "<br>";
							} else {
								$BODY .= "This services is not required<br>";
							}
						}
					}
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Database") {
						$BODY .= "<br><br>------------------------------------------------------------------------------------------------------------------<br><br>";
						$BODY .= "DATABASE HOSTING: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."<br>
						<br>Database Hosting Specifics<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['DBA_NAME'])) {
							$BODY .= "Primary DBA Name:  ".$VM_ORDER_DETAIL_RECORD['DBA_NAME']."<br>";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DBA_PHONE'])) {
							$BODY .= "Primary DBA Phone Number:  ".$VM_ORDER_DETAIL_RECORD['DBA_PHONE']."<br>";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DBA_EMAIL'])) {
							$BODY .= "Primary DBA E-mail:  ".$VM_ORDER_DETAIL_RECORD['DBA_EMAIL']."<br>";
						}
						$BODY .= "Software:  ";
						if($VM_ORDER_DETAIL_RECORD['ORACLE_SQL'] <> null) {
							$BODY .= $VM_ORDER_DETAIL_RECORD['ORACLE_SQL'];
							if($VM_ORDER_DETAIL_RECORD['ORACLE_SQL_VERSION'] <> null) {
								$BODY .= " - version ".$VM_ORDER_DETAIL_RECORD['ORACLE_SQL_VERSION'];
							}
						}
						$BODY .= "<br>";
						$BODY .= "Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."<br>";
						$BODY .= "CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['VM_VOLUME'])) {	
							$BODY .= "Expected Transaction Volume:  ".$VM_ORDER_DETAIL_RECORD['VM_VOLUME']."<br>";
						}
						$BODY .= "Oracle Client:  ";
						if($VM_ORDER_DETAIL_RECORD['ORACLE_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['ORACLE_FLAG'] == 1 ) {	
								$BODY .= "is Required";
								if($VM_ORDER_DETAIL_RECORD['ORACLE_VERSION'] <> null) {
									$BODY .= ", version - ".$VM_ORDER_DETAIL_RECORD['ORACLE_VERSION'];
								}
							} else {
								$BODY .= "is NOT Required";
							}
						}
						$BODY .= "<br>";
						$BODY .= "Who will be installing the database:  ".$VM_ORDER_DETAIL_RECORD['INSTALL_CONTACT']."<br>";
						$BODY .= "Vendor Access:  ";
						if($VM_ORDER_DETAIL_RECORD['VENDOR_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['VENDOR_FLAG'] == 1 ) {
								$BODY .= "Yes";
								if(!empty($VM_ORDER_DETAIL_RECORD['VENDOR_DETAIL'])) {
									$BODY .= " - ".$VM_ORDER_DETAIL_RECORD['VENDOR_DETAIL'];
								}
							} else{
								$BODY .= "No";
							}
						}
						$BODY .= "<br>";
						$BODY .= "<br>Database Hosting Storage and Backup<br>------------------------<br>
						Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."<br>
						Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."<br>
						Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL'])) {
							$BODY .= "Particular Data Classification:  ".$VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL']."<br>";
						}
						$BODY .= "Standby Database:  ";
						if($VM_ORDER_DETAIL_RECORD['STANDBY_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['STANDBY_FLAG'] == 1 ) {
								$BODY .= "Yes";
							} else{
								$BODY .= "No";
							}
						}
						$BODY .= "<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."<br>"; 
						}
						$BODY .= "<br>Database Hosting Firewall Information<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."<br>"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."<br>"; 
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "<br>Database Hosting Attachments<br>------------------------<br>";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."<br>";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "<br>Database Hosting Additional Comments<br>------------------------<br>".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."<br>";
						}
						$BODY .= "<br>Database Hosting Monitoring Alert Information<br>------------------------<br>";
						if($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] <> null) {
							if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
								$BODY .= "This service is required <br>
								Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."<br>
								Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."<br>
								Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."<br>";
								$BODY .= "Notification Period:  ";
								if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
									$BODY .= $VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'];
								}
								$BODY .= "<br>";
							} else {
								$BODY .= "This services is not required<br>";
							}
						}
					}
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Fileserv") {
						$BODY .= "<br><br>------------------------------------------------------------------------------------------------------------------<br><br>";
						$BODY .= "FILE SERVER: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."<br>
						<br>File Server Specifics<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_NAME'])) {
							$BODY .= "Primary Contact Name:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_NAME']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_DEPT'])) {
							$BODY .= "Primary Contact Department:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_DEPT']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_EMAIL'])) {
							$BODY .= "Primary Contact E-mail:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_EMAIL']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_PHONE'])) {
							$BODY .= "Primary Contact Phone:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_PHONE']."<br>"; 
						}						
						$BODY .= "Functions:  ".$VM_ORDER_DETAIL_RECORD['VM_CHARACTERISTICS']."<br>";
						$BODY .= "Dependent On Other Systems:  ";
						if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] == 1 ) {
								$BODY .= "Yes";
								if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT_DETAIL'] <> null) {
									$BODY .= " - " . $VM_ORDER_DETAIL_RECORD['VM_DEPENDENT_DETAIL'];
								}
							} else{
								$BODY .= "No";
							}
						}
						$BODY .= "<br>";
						$BODY .= "Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."<br>
						CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."<br>
						<br>File Server Access<br>------------------------<br>";
						$BODY .= "Number of Users Requiring Simultaneous Access:  ".$VM_ORDER_DETAIL_RECORD['NUM_USERS']."<br>"; 
						$BODY .= "User Communities with access:  ";
						$temp = $VM_ORDER_DETAIL_RECORD['USER_COMMUNITY'];
						$USER_COMMUNITY = explode(",",$temp);
						$COUNT = 0;
						$x = count($USER_COMMUNITY);
						for ($i=0;$i<5;$i++) {
							if(!empty($USER_COMMUNITY[$i]) && $USER_COMMUNITY[$i] != "none" && $USER_COMMUNITY[$i] != "Other") {
								if ($COUNT == 0) {
									$BODY .= $USER_COMMUNITY[$i];
									$COUNT++;
								} else {
									$BODY .= ", ".$USER_COMMUNITY[$i];
								}	
							}
						}
						if ($x == 6) { 
							if (!empty($USER_COMMUNITY[5])) {
								if ($COUNT == 0) $BODY .=  $USER_COMMUNITY[5]; 
								else $BODY .=  ", ".$USER_COMMUNITY[5];
							}
						}
						elseif ($x > 6) { 
							for($i = 5; $i<$x; $i++) { 
								if ($COUNT == 0) {
									$BODY .= $USER_COMMUNITY[$i];
									$COUNT++;
								} else {
									$BODY .= "," . $USER_COMMUNITY[$i];
								}
							}
						}
						$BODY .= "<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
							$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."<br>"; 
						}
						if(isset($VM_ORDER_DETAIL_RECORD['FTP_FLAG'])) {
							$BODY .= "<br>File Server FTP Requirements<br>------------------------<br>
							SFTP Required:  ";
							if($VM_ORDER_DETAIL_RECORD['FTP_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						$BODY .= "<br>File Server Storage and Backup<br>------------------------<br>
						Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."<br>
						Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."<br>
						Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."<br>"; 
						}
						$BODY .= "<br>File Server Firewall Information<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."<br>"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."<br>";
						if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'] <> null) {
							$BODY .= "SSL VPN Required:  ";
							if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "<br>File Server Attachments<br>------------------------<br>";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."<br>";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "<br>File Server Additional Comments<br>------------------------<br>".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."<br>";
						}
						$BODY .= "<br>File Server Monitoring Alert Information<br>------------------------<br>";
						if($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] <> null) {
							if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
								$BODY .= "This service is required <br>
								Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."<br>
								Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."<br>
								Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."<br>";
								$BODY .= "Notification Period:  ";
								if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
									$BODY .= $VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'];
								}
								$BODY .= "<br>";
							} else {
								$BODY .= "This services is not required<br>";
							}
						}
					}
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Webserv") {
						$BODY .= "<br><br>------------------------------------------------------------------------------------------------------------------<br><br>";
						$BODY .= "WEB SERVER: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."<br>
						<br>Web Server Specifics<br>------------------------<br>
						Functions:  ".$VM_ORDER_DETAIL_RECORD['VM_CHARACTERISTICS']."<br>";
						$BODY .= "Dependent On Other Systems:  ";
						if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] == 1 ) {
								$BODY .= "Yes";
								if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT_DETAIL'] <> null) {
									$BODY .= " - " . $VM_ORDER_DETAIL_RECORD['VM_DEPENDENT_DETAIL'];
								}
							} else{
								$BODY .= "No";
							}
						}
						$BODY .= "<br>";
						$BODY .= "Load Balancing:  ";
						if($VM_ORDER_DETAIL_RECORD['LOAD_BALANCE'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['LOAD_BALANCE'] == 1 ) {
								$BODY .= "Yes";
							} else{
								$BODY .= "No";
							}
						}
						$BODY .= "<br>";
						$BODY .= "Software Required:  ".$VM_ORDER_DETAIL_RECORD['WEBSERV_TYPE']."<br>";
						$BODY .= "SSL Certificates:  ";
						if($VM_ORDER_DETAIL_RECORD['SSL_CERT_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['SSL_CERT_FLAG'] == 1 ) {
								$BODY .= "Yes";
								if($VM_ORDER_DETAIL_RECORD['SSL_CERT_DETAILS'] <> null) {
									$BODY .= " - ".$VM_ORDER_DETAIL_RECORD['SSL_CERT_DETAILS'];
								}
							} else{
								$BODY .= "No";
							}
						}
						$BODY .= "<br>";
						$BODY .= "OS:  ".$VM_ORDER_DETAIL_RECORD['VM_OS']." ".$VM_ORDER_DETAIL_RECORD['VM_OS_BITS']."<br>";
						$BODY .= "Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."<br>
						CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."<br>
						<br>Web Server Access<br>------------------------<br>";
						$BODY .= "Number of Users Requiring Simultaneous Access:  ".$VM_ORDER_DETAIL_RECORD['NUM_USERS']."<br>"; 
						$BODY .= "User Communities with access:  ";
						$temp = $VM_ORDER_DETAIL_RECORD['USER_COMMUNITY'];
						$USER_COMMUNITY = explode(",",$temp);
						$COUNT = 0;
						$x = count($USER_COMMUNITY);
						for ($i=0;$i<5;$i++) {
							if(!empty($USER_COMMUNITY[$i]) && $USER_COMMUNITY[$i] != "none" && $USER_COMMUNITY[$i] != "Other") {
								if ($COUNT == 0) {
									$BODY .= $USER_COMMUNITY[$i];
									$COUNT++;
								} else {
									$BODY .= ", ".$USER_COMMUNITY[$i];
								}	
							}
						}
						if ($x == 6) { 
							if (!empty($USER_COMMUNITY[5])) {
								if ($COUNT == 0) $BODY .=  $USER_COMMUNITY[5]; 
								else $BODY .=  ", ".$USER_COMMUNITY[5];
							}
						}
						elseif ($x > 6) { 
							for($i = 5; $i<$x; $i++) { 
								if ($COUNT == 0) {
									$BODY .= $USER_COMMUNITY[$i];
									$COUNT++;
								} else {
									$BODY .= "," . $USER_COMMUNITY[$i];
								}
							}
						}
						$BODY .= "<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
							$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."<br>"; 
						}
						if(isset($VM_ORDER_DETAIL_RECORD['FTP_FLAG'])) {
							$BODY .= "<br>Web Server FTP Requirements<br>------------------------<br>
							SFTP Required:  ";
							if($VM_ORDER_DETAIL_RECORD['FTP_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						$BODY .= "<br>Web Server Storage and Backup<br>------------------------<br>
						Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."<br>
						Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."<br>
						Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL'])) {
							$BODY .= "Data Classification Detail:  ".$VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."<br>"; 
						}
						$BODY .= "<br>Web Server Firewall Information<br>------------------------<br>";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."<br>"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."<br>"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."<br>";
						if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'] <> null) {
							$BODY .= "SSL VPN Required:  ";
							if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes<br>";
							else $BODY .= "No<br>";
						}
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "<br>Web Server Attachments<br>------------------------<br>";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."<br>";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "<br>Additional Comments<br>------------------------<br>".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."<br>";
						}
						$BODY .= "<br>Web Server Monitoring Alert Information<br>------------------------<br>";
						if($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] <> null) {
							if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
								$BODY .= "This service is required <br>
								Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."<br>
								Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."<br>
								Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."<br>";
								$BODY .= "Notification Period:  ";
								if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
									$BODY .= $VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'];
								}
								$BODY .= "<br>";
							} else {
								$BODY .= "This services is not required<br>";
							}
						}
					}
				}
			} else {
				$VM_ORDER_DETAIL = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID'
					ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
				")or die(mysql_error());
				$VM_ORDER_DETAIL_RECORD = mysql_fetch_array($VM_ORDER_DETAIL) or die(mysql_error());
				$BODY .= "Guest Hosting Specifics<br>------------------------<br>
				Server's Purpose:  ".$VM_ORDER_DETAIL_RECORD['VM_VOLUME']."<br>
				OS:  ".$VM_ORDER_DETAIL_RECORD['VM_OS']." ".$VM_ORDER_DETAIL_RECORD['VM_OS_BITS']."<br>
				Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."<br>
				CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."<br>";
				if (!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
					$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."<br>";
				}
				$BODY .= "<br>Guest Hosting Storage and Backup<br>------------------------<br>
				Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."<br>
				Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."<br>
				Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."<br>";
				if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
					$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."<br>"; 
				}
				$BODY .= "<br>Guest Hosting Firewall Information<br>------------------------<br>";
				if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) { $BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."<br>"; }
				if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) { $BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."<br>"; }
				$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."<br>";
				if(isset($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'])) { 
					$BODY .= "SSL VPN Required:  ";
					if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes<br>";
					else $BODY .= "No<br>";
				}
				if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
					$BODY .= "<br>Attachments<br>------------------------<br>";
					$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
					$UPLOADED_VM_FILES = explode(",",$temp);
					$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
					for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
						$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
						$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."<br>";
					}
				}
				if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
					$BODY .= "<br>Additional Comments<br>------------------------<br>".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."<br>";
				}
				$BODY .= "<br>Monitoring Alert Information<br>------------------------<br>";
				if($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] <> null) {
					if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
						$BODY .= "This service is required <br>
						Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."<br>
						Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."<br>
						Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."<br>";
						$BODY .= "Notification Period:  ";
						if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
							$BODY .= $VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'];
						}
						$BODY .= "<br>";
					} else {
						$BODY .= "This services is not required<br>";
					}
				}
			}
echo $BODY;
?>
	</body>
</html>