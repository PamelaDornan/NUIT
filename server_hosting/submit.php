<html>
	<head>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	</head>
	<script>
		history.forward();
	</script>
	<body onload="setTimeout('document.Submitted.submit()',1000);"> 
		<div id="timer" /> <?php
			$NETID = $_SERVER['REMOTE_USER'];	
			include 'mysql/ldapconnection.php';//connection to ldap db
			include 'mysql/connection.php';//connection to mysql db
			$BODY="";
			$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$CONTACT_VALUES = mysql_query("
				SELECT * 
				FROM VM_ORDER
				WHERE VM_ORDER_ID = '$VM_ORDER_ID'
			")or die(mysql_error()); 
			$CONTACT_VALUES_RECORD = mysql_fetch_array($CONTACT_VALUES) or die(mysql_error());
			$subject = $CONTACT_VALUES_RECORD['PROJECT_NAME'] . " - " . $CONTACT_VALUES_RECORD['VM_ORDER_TYPE'];
			$BODY= $LDAPName . " has requested " . $CONTACT_VALUES_RECORD['VM_ORDER_TYPE'] . " for " . $CONTACT_VALUES_RECORD['CONTACT_NAME'] . ". Please escalate to CI-Hosting.\n
Request Type:  ".$CONTACT_VALUES_RECORD['VM_ORDER_TYPE']."
Project Name:  ".$CONTACT_VALUES_RECORD['PROJECT_NAME']."
Submitter NetID:  ".$NETID."\n
Main Contact Information\n------------------------
Name:  ".$CONTACT_VALUES_RECORD['CONTACT_NAME']."
NetID:  ".$CONTACT_VALUES_RECORD['CONTACT_NETID']."
Dept:  ".$CONTACT_VALUES_RECORD['CONTACT_DEPARTMENT']."
E-mail:  ".$CONTACT_VALUES_RECORD['CONTACT_EMAIL']."
Telephone:  ".$CONTACT_VALUES_RECORD['CONTACT_PHONE']."\n\n";
			#-------------------------------------------- If Managed Server Request --------------------------------------------
			if($CONTACT_VALUES_RECORD['VM_ORDER_TYPE']=="Managed Server Hosting"){
				$BODY .= "Server Type Quantities\n------------------------
Application:  ".$CONTACT_VALUES_RECORD['QTY_APPLICATION']."
Database:  ".$CONTACT_VALUES_RECORD['QTY_DATABASE']."
File Server:  ".$CONTACT_VALUES_RECORD['QTY_FILESERV']."
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
$BODY .= "\n\n------------------------------------------------------------------------------------------------------------------\n\n";
						$BODY .= "APPLICATION SERVER: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."\n
Application Server Specifics\n------------------------
Characteristics:  ".$VM_ORDER_DETAIL_RECORD['VM_CHARACTERISTICS']."
Server Purpose/Volume:  ".$VM_ORDER_DETAIL_RECORD['VM_VOLUME']."
OS:  ".$VM_ORDER_DETAIL_RECORD['VM_OS']." ".$VM_ORDER_DETAIL_RECORD['VM_OS_BITS']."
Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."
CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."
\nApplication Server Access\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['NUM_USERS'])) {
							$BODY .= "Number of Users Requiring Simultaneous Access:  ".$VM_ORDER_DETAIL_RECORD['NUM_USERS']."\n"; 
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
									$BODY .= ", " . $USER_COMMUNITY[$i];
								}
							}
						}
						$BODY .= "\n";	
						if(!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
							$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."\n"; 
						}
						if(isset($VM_ORDER_DETAIL_RECORD['FTP_FLAG'])) {
							$BODY .= "\nApplication Server FTP Requirements\n------------------------
SFTP Required:  ";
							if($VM_ORDER_DETAIL_RECORD['FTP_FLAG']==1) $BODY .= "Yes\n";
							else $BODY .= "No\n";
						}
						$BODY .= "\nApplication Server Storage and Backup\n------------------------
Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."
Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."
Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."\n"; 
						}
						$BODY .= "\nApplication Server Service Operations Requirements\n------------------------\n";
						if($VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_FLAG'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_FLAG'] == 1 ) {	
								$BODY .= "Automated Job Scheduling:  is Required";
								if($VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_DETAILS'] <> null) {
									$BODY .= " - ".$VM_ORDER_DETAIL_RECORD['JOB_SCHEDULING_DETAILS'];
								}
							} else {
								$BODY .= "Automated Job Scheduling:  is NOT Required";
							}
							$BODY .= "\n";
						}
						if (isset($VM_ORDER_DETAIL_RECORD['NUM_CYCLE_JOBS'])) { 
							$BODY .= "Jobs Over a 12-Month Cycle:  ".$VM_ORDER_DETAIL_RECORD['NUM_CYCLE_JOBS']."\n";
						}
						if(isset($VM_ORDER_DETAIL_RECORD['CALL_OUT_FLAG'])) {
							$BODY .= "24/7 Job Monitoring With Call Outs:  ";
							if($VM_ORDER_DETAIL_RECORD['CALL_OUT_FLAG']==1) $BODY .= "Yes\n";
							else $BODY .= "No\n";
						}
						$BODY .= "Data Needs HIPAA, FISMA, HITECH Act Compliance:  ";
						if($VM_ORDER_DETAIL_RECORD['DATA_COMPLIANCE_FLAG']==1) $BODY .= "Yes\n";
						else $BODY .= "No\n";
						$BODY .= "\nApplication Server Firewall Information\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."\n"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."\n"; 
						if(isset($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'])) { 
							$BODY .= "SSL VPN Required:  ";
							if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes";
							else $BODY .= "No";
						}
						$BODY .= "\n";
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "\nApplication Server Attachments\n------------------------\n";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."\n";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "\nApplication Server Additional Comments\n------------------------\n".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."\n";
						}
						$BODY .= "\nApplication Server Monitoring Alert Information\n------------------------\n";
						if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
							$BODY .= "This service is required 
Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."
Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."
Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."\n";
							if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
								$BODY .= "Notification Period:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY']."\n\n";
							} else {
								$BODY .= "\n";
							}
						} else {
							$BODY .= "This services is not required\n\n";
						}		
					}
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Database") {
						$BODY .= "\n\n------------------------------------------------------------------------------------------------------------------\n\n";
						$BODY .= "DATABASE HOSTING: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."
\nDatabase Hosting Specifics\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['DBA_NAME'])) {
							$BODY .= "Primary DBA Name:  ".$VM_ORDER_DETAIL_RECORD['DBA_NAME']."\n";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DBA_PHONE'])) {
							$BODY .= "Primary DBA Phone Number:  ".$VM_ORDER_DETAIL_RECORD['DBA_PHONE']."\n";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DBA_EMAIL'])) {
							$BODY .= "Primary DBA E-mail:  ".$VM_ORDER_DETAIL_RECORD['DBA_EMAIL']."\n";
						}
						$BODY .= "Software:  ".$VM_ORDER_DETAIL_RECORD['ORACLE_SQL']." - version ".$VM_ORDER_DETAIL_RECORD['ORACLE_SQL_VERSION']."\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['VM_MEMORY'])) {
							$BODY .= "Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."\n";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['VM_CPU'])) {	
							$BODY .= "CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."\n";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['VM_VOLUME'])) {	
							$BODY .= "Expected Transaction Volume:  ".$VM_ORDER_DETAIL_RECORD['VM_VOLUME']."\n";
						}	
						if($VM_ORDER_DETAIL_RECORD['ORACLE_FLAG'] == 1 ) {	
							$BODY .= "Oracle Client is Required, version - ".$VM_ORDER_DETAIL_RECORD['ORACLE_VERSION']."\n";
						} else {
							$BODY .= "Oracle Client is NOT Required\n";
						}
						$BODY .= "Who will be installing the database:  ".$VM_ORDER_DETAIL_RECORD['INSTALL_CONTACT']."\n";
						if($VM_ORDER_DETAIL_RECORD['VENDOR_FLAG'] == 1 ) {
							$BODY .= "Vendor Access: Yes - ".$VM_ORDER_DETAIL_RECORD['VENDOR_DETAIL']."\n";
						} else{
							$BODY .= "Vendor Access: No\n";
						}
						$BODY .= "\nDatabase Hosting Storage and Backup\n------------------------
Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."
Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."
Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL'])) {
							$BODY .= "Particular Data Classification:  ".$VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL']."\n";
						}
						if($VM_ORDER_DETAIL_RECORD['STANDBY_FLAG'] == 1 ) {
							$BODY .= "Standby Database:  Yes\n";
						} else{
							$BODY .= "Standby Database:  No\n";
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."\n"; 
						}
$BODY .= "\nDatabase Hosting Firewall Information\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."\n"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."\n"; 
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "\nDatabase Hosting Attachments\n------------------------\n";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."\n";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "\nDatabase Hosting Additional Comments\n------------------------\n".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."\n";
						}
						$BODY .= "\nDatabase Hosting Monitoring Alert Information\n------------------------\n";
						if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
							$BODY .= "This service is required 
Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."
Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."
Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."\n";
							if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
								$BODY .= "Notification Period:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY']."\n\n";
							} else {
								$BODY .= "\n";
							}
						} else {
							$BODY .= "This services is not required\n\n";
						}
					}
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Fileserv") {
						$BODY .= "\n\n------------------------------------------------------------------------------------------------------------------\n\n";
						$BODY .= "FILE SERVER: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."
\nFile Server Specifics\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_NAME'])) {
							$BODY .= "Primary Contact Name:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_NAME']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_DEPT'])) {
							$BODY .= "Primary Contact Department:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_DEPT']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_EMAIL'])) {
							$BODY .= "Primary Contact E-mail:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_EMAIL']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_PHONE'])) {
							$BODY .= "Primary Contact Phone:  ".$VM_ORDER_DETAIL_RECORD['FILESERV_ADMIN_PHONE']."\n"; 
						}						
						$BODY .= "Functions:  ".$VM_ORDER_DETAIL_RECORD['VM_CHARACTERISTICS']."\n";
						$BODY .= "Dependent On Other Systems:  ";
						if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] <> null) {
							if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] == 1 ) {
								$BODY .= "Yes";
								if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT_DETAIL'] <> null) {
									$BODY .= " - " . $VM_ORDER_DETAIL_RECORD['VM_DEPENDENT_DETAIL\n'];
								}
							} else{
								$BODY .= "No\n";
							}
						}
						$BODY .= "Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."
CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."
\nFile Server Access\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['NUM_USERS'])) {
							$BODY .= "Number of Users Requiring Simultaneous Access:  ".$VM_ORDER_DETAIL_RECORD['NUM_USERS']."\n"; 
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
									$BODY .= ", " . $USER_COMMUNITY[$i];
								}
							}
						}
						$BODY .= "\n";			
						if(!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
							$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."\n"; 
						}
						if(isset($VM_ORDER_DETAIL_RECORD['FTP_FLAG'])) {
							$BODY .= "\nFile Server FTP Requirements\n------------------------
SFTP Required:  ";
							if($VM_ORDER_DETAIL_RECORD['FTP_FLAG']==1) $BODY .= "Yes\n";
							else $BODY .= "No\n";
						}
						$BODY .= "\nFile Server Storage and Backup\n------------------------
Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."
Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."
Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."\n"; 
						}
						$BODY .= "\nFile Server Firewall Information\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."\n"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."\n"; 
						if(isset($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'])) { 
							$BODY .= "SSL VPN Required:  ";
							if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes";
							else $BODY .= "No";
						}
						$BODY .= "\n";
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "\nFile Server Attachments\n------------------------\n";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."\n";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "\nFile Server Additional Comments\n------------------------\n".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."\n";
						}
						$BODY .= "\nFile Server Monitoring Alert Information\n------------------------\n";
						if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
							$BODY .= "This service is required 
Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."
Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."
Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."\n";
							if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
								$BODY .= "Notification Period:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY']."\n\n";
							} else {
								$BODY .= "\n";
							}
						} else {
							$BODY .= "This services is not required\n\n";
						}
					}
					if($VM_ORDER_DETAIL_RECORD['VM_TYPE']=="Webserv") {
						$BODY .= "\n\n------------------------------------------------------------------------------------------------------------------\n\n";
						$BODY .= "WEB SERVER: ".$VM_ORDER_DETAIL_RECORD['VM_NAME']."
\nWeb Server Specifics\n------------------------
Functions:  ".$VM_ORDER_DETAIL_RECORD['VM_CHARACTERISTICS']."\n";
						if($VM_ORDER_DETAIL_RECORD['VM_DEPENDENT'] == 1 ) {
							$BODY .= "Dependent On Other Systems:  Yes\n";
						} else{
							$BODY .= "Dependent On Other Systems:  No\n";
						}
						if($VM_ORDER_DETAIL_RECORD['LOAD_BALANCE'] == 1 ) {
							$BODY .= "Load Balancing:  Yes\n";
						} else{
							$BODY .= "Load Balancing:  No\n";
						}
						$BODY .= "Software Required:  ".$VM_ORDER_DETAIL_RECORD['WEBSERV_TYPE']."\n";
						if($VM_ORDER_DETAIL_RECORD['SSL_CERT_FLAG'] == 1 ) {
							$BODY .= "SSL Certificates:  Yes-".$VM_ORDER_DETAIL_RECORD['SSL_CERT_DETAILS']."\n";
						} else{
							$BODY .= "SSL Certificates:  No\n";
						}
						$BODY .= "OS:  ".$VM_ORDER_DETAIL_RECORD['VM_OS']." ".$VM_ORDER_DETAIL_RECORD['VM_OS_BITS']."\n";
						$BODY .= "Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."
CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."
\nWeb Server Access\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['NUM_USERS'])) {
							$BODY .= "Number of Users Requiring Simultaneous Access:  ".$VM_ORDER_DETAIL_RECORD['NUM_USERS']."\n"; 
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
									$BODY .= ", " . $USER_COMMUNITY[$i];
								}
							}
						}
						$BODY .= "\n";	
						if(!empty($VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS'])) {
							$BODY .= "Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."\n"; 
						}
						if(isset($VM_ORDER_DETAIL_RECORD['FTP_FLAG'])) {
							$BODY .= "\nWeb Server FTP Requirements\n------------------------
SFTP Required:  ";
							if($VM_ORDER_DETAIL_RECORD['FTP_FLAG']==1) $BODY .= "Yes\n";
							else $BODY .= "No\n";
						}
						$BODY .= "\nWeb Server Storage and Backup\n------------------------
Storage Required For The First Three Months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."
Storage Required For The First Year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."
Projected Percentage of Growth Per Year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL'])) {
							$BODY .= "Data Classification Detail:  ".$VM_ORDER_DETAIL_RECORD['DATA_CLASS_DETAIL']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) {
							$BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."\n"; 
						}
						$BODY .= "\nWeb Server Firewall Information\n------------------------\n";
						if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) {
							$BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."\n"; 
						}
						if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) {
							$BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."\n"; 
						}
						$BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."\n"; 
						if(isset($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'])) { 
							$BODY .= "SSL VPN Required:  ";
							if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes";
							else $BODY .= "No";
						}
						$BODY .= "\n";
						if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
							$BODY .= "\nWeb Server Attachments\n------------------------\n";
							$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
								$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."\n";
							}
						}
						if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
							$BODY .= "\nAdditional Comments\n------------------------\n".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."\n";
						}
						$BODY .= "\nWeb Server Monitoring Alert Information\n------------------------\n";
						if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
							$BODY .= "This service is required 
Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."
Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."
Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."\n";
							if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
								$BODY .= "Notification Period:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY']."\n\n";
							} else {
								$BODY .= "\n";
							}
						} else {
							$BODY .= "This services is not required\n\n";
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
				$BODY .= "Guest Hosting Specifics\n------------------------
Server's Purpose:  ".$VM_ORDER_DETAIL_RECORD['VM_VOLUME']."
OS:  ".$VM_ORDER_DETAIL_RECORD['VM_OS']." ".$VM_ORDER_DETAIL_RECORD['VM_OS_BITS']."
Memory Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_MEMORY']."
CPU Requirements:  ".$VM_ORDER_DETAIL_RECORD['VM_CPU']."
Users Requiring Root Access:  ".$VM_ORDER_DETAIL_RECORD['ROOT_ACCESS_USERS']."\n\n";
				if (!empty($VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']) || !empty($VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']) || !empty($VM_ORDER_DETAIL_RECORD['VM_GROWTH']) || !empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) { 
					$BODY .= "Guest Hosting Storage and Backup\n------------------------\n";
					if(!empty($VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE'])) { $BODY .= "Storage required for the first three months:  ".$VM_ORDER_DETAIL_RECORD['THREE_MONTHS_STORAGE']."\n"; }
					if(!empty($VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE'])) { $BODY .= "Storage required for the first year:  ".$VM_ORDER_DETAIL_RECORD['FIRST_YEAR_STORAGE']."\n"; }
					if(!empty($VM_ORDER_DETAIL_RECORD['VM_GROWTH'])) { $BODY .= "Projected percentage of growth per year:  ".$VM_ORDER_DETAIL_RECORD['VM_GROWTH']."\n"; }
					if(!empty($VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS'])) { $BODY .= "Detailed Backup Requirements:  ".$VM_ORDER_DETAIL_RECORD['BACKUP_REQUIREMENTS']."\n";}
					$BODY .= "\n";
				}
				if (!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP']) || !empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP']) || !empty($VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']) || isset($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'])) { 
					$BODY .= "Guest Hosting Firewall Information\n------------------------\n";
					if(!empty($VM_ORDER_DETAIL_RECORD['SOURCE_IP'])) { $BODY .= "From IP Address:  ".$VM_ORDER_DETAIL_RECORD['SOURCE_IP']."\n"; }
					if(!empty($VM_ORDER_DETAIL_RECORD['DESTINATION_IP'])) { $BODY .= "Destination IP Address:  ".$VM_ORDER_DETAIL_RECORD['DESTINATION_IP']."\n"; }
					if(!empty($VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION'])) { $BODY .= "Environment Description:  ".$VM_ORDER_DETAIL_RECORD['IP_DESCRIPTION']."\n"; }
					if(isset($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG'])) { 
						$BODY .= "SSL VPN Required:  ";
						if($VM_ORDER_DETAIL_RECORD['SSL_VP_FLAG']==1) $BODY .= "Yes";
						else $BODY .= "No";
					}
					$BODY .= "\n";
				}
				if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0){
					$BODY .= "Attachments";
					if(isset($VM_ORDER_DETAIL_RECORD['TECH_SPEC_FLAG']) && $VM_ORDER_DETAIL_RECORD['TECH_SPEC_FLAG'] == 1 ) {
						$BODY .= " - Includes Technical Specifications Document";
					}
					$BODY .= "\n------------------------\n";
					$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
					$UPLOADED_VM_FILES = explode(",",$temp);
					$UPLOADED_NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
					for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
						$temp = str_replace(" ", "%20", $UPLOADED_VM_FILES[$i]);
						$BODY .= "https://software.northwestern.edu/server_hosting/virtual/".$temp."\n";
					}
					$BODY .= "\n";
				}
				if (isset($VM_ORDER_DETAIL_RECORD['VM_COMMENTS']) && !empty($VM_ORDER_DETAIL_RECORD['VM_COMMENTS'])) {
					$BODY .= "\nAdditional Comments\n------------------------\n".$VM_ORDER_DETAIL_RECORD['VM_COMMENTS']."\n\n";
				}
				$BODY .= "\nMonitoring Alert Information\n------------------------\n";
				if ($VM_ORDER_DETAIL_RECORD['MONITORING_FLAG'] == 1) {
					$BODY .= "This service is required 
Alert Contacts:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NAME_NETID']."
Notification E-mail Addresses:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_EMAIL']."
Text Alert Information:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_CELL']."\n";
					if(isset($VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY'])) {
						$BODY .= "Notification Period:  ".$VM_ORDER_DETAIL_RECORD['MONITORING_NOTIFY']."\n\n";
					} else {
						$BODY .= "\n";
					}
				} else {
					$BODY .= "This services is not required\n\n";
				}
			}
			$BODY .= "\n--\n\nSUBMITTER DIRECTORY INFORMATION:\n" . $LDAPALL;
			$to = "consultant@northwestern.edu";
			$headers = 'From: ' . $LDAPMail . "\r\n" .
				'Reply-To: ' . $LDAPMail . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $BODY, $headers);
			$File = "bin/VM_SUBMIT.log";
			$Handle = fopen($File, 'a');
			$SUBMIT_DATE = date("20y-m-d H:i:s", time());
			$Data = $SUBMIT_DATE." - ".$_POST['VM_ORDER_ID']." by ".$NETID . "\n";
			fwrite($Handle, $Data); 
			fclose($Handle);
			mysql_query("UPDATE VM_ORDER SET		
				SUBMIT_FLAG='1', SUBMIT_DATE='$SUBMIT_DATE'
				WHERE VM_ORDER_ID='$VM_ORDER_ID'");
			echo '<br><center><p>Processing...</p><img src="images/wait.gif" alt="loading" /></center><br><br><br><br>&nbsp;';
			?><form name="Submitted" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
				<input type="hidden" name="PAGE" value="MAIN" />
				<input type="hidden" name="MESG" value="Request: <?php echo $CONTACT_VALUES_RECORD['PROJECT_NAME']; ?>, has been submitted.<br><br>All requests will be responded to within three business days.">
			</form>
	</body>
</html>
