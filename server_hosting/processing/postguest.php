<?php $VM_ORDER_ID = $_POST['VM_ORDER_ID']; 
			$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
			require("processing/processfiles.php");
			$PROJECT_NAME = just_clean($_POST['PROJECT_NAME']);
			$CONTACT_NAME = just_clean($_POST['CONTACT_NAME']);
			$CONTACT_NETID = just_clean($_POST['CONTACT_NETID']);
			$CONTACT_DEPARTMENT = just_clean($_POST['CONTACT_DEPARTMENT']);
			$CONTACT_EMAIL = $_POST['CONTACT_EMAIL'];
			$CONTACT_PHONE = $_POST['CONTACT_PHONE'];
			$MODIFY_DATE = date("20y-m-d H:i:s", time());
			if (empty($_POST['PROJECT_NAME']) || 
				empty($_POST['CONTACT_NAME']) || 
				empty($_POST['CONTACT_NETID']) || 
				empty($_POST['CONTACT_DEPARTMENT']) || 
				empty($_POST['CONTACT_EMAIL']) ||
				empty($_POST['CONTACT_PHONE']) || 
				empty($_POST['VM_VOLUME']) || 
				empty($_POST['VM_OS']) || 
				!isset($_POST['VM_OS_BITS']) || 
				empty($_POST['VM_MEMORY']) || 
				empty($_POST['VM_CPU']) || 
				empty($_POST['THREE_MONTHS_STORAGE']) ||
				empty($_POST['FIRST_YEAR_STORAGE']) ||
				empty($_POST['VM_GROWTH']) ||
				empty($_POST['IP_DESCRIPTION']) ||
				!isset($_POST['MONITORING_FLAG']) ||
				($_POST['MONITORING_FLAG'] == 1 && (empty($_POST['MONITORING_NOTIFY']) || empty($_POST['MONITORING_NAME_NETID']) || empty($_POST['MONITORING_EMAIL']) || empty($_POST['MONITORING_CELL'])))){
				$COMPLETE_FLAG = "0";
			} else {
				$COMPLETE_FLAG = "1";
			}
			
			mysql_query("UPDATE VM_ORDER SET
				PROJECT_NAME='".mysql_real_escape_string($PROJECT_NAME)."',
				CONTACT_NAME='".mysql_real_escape_string($CONTACT_NAME)."',
				CONTACT_NETID='".mysql_real_escape_string($CONTACT_NETID)."',
				CONTACT_DEPARTMENT='".mysql_real_escape_string($CONTACT_DEPARTMENT)."',
				CONTACT_EMAIL='".mysql_real_escape_string($CONTACT_EMAIL)."',
				CONTACT_PHONE='".mysql_real_escape_string($CONTACT_PHONE)."',
				COMPLETE_FLAG='$COMPLETE_FLAG'
				WHERE VM_ORDER_ID='$VM_ORDER_ID'");
			$VM_VOLUME = just_clean($_POST['VM_VOLUME']);
			if(isset($_POST['VM_OS'])) { 
				$VM_OS = $_POST['VM_OS']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					VM_OS='".mysql_real_escape_string($VM_OS)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			if(isset($_POST['VM_OS_BITS'])) {
				$VM_OS_BITS = $_POST['VM_OS_BITS']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					VM_OS_BITS='".mysql_real_escape_string($VM_OS_BITS)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");				
			}
			$VM_MEMORY = just_clean($_POST['VM_MEMORY']);
			$VM_CPU = just_clean($_POST['VM_CPU']);
			$ROOT_ACCESS_USERS = just_clean($_POST['ROOT_ACCESS_USERS']);
			
			$THREE_MONTHS_STORAGE = just_clean($_POST['THREE_MONTHS_STORAGE']);
			$FIRST_YEAR_STORAGE = just_clean($_POST['FIRST_YEAR_STORAGE']);
			$VM_GROWTH = just_clean($_POST['VM_GROWTH']);
			$BACKUP_REQUIREMENTS = just_clean($_POST['BACKUP_REQUIREMENTS']);
			
			$SOURCE_IP = just_clean($_POST['SOURCE_IP']);
			$DESTINATION_IP = just_clean($_POST['DESTINATION_IP']);
			$IP_DESCRIPTION = just_clean($_POST['IP_DESCRIPTION']);
			if(isset($_POST['SSL_VP_FLAG'])) {
				$SSL_VP_FLAG = $_POST['SSL_VP_FLAG']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					SSL_VP_FLAG='$SSL_VP_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			$VM_COMMENTS = just_clean($_POST['VM_COMMENTS']);
			$MODIFY_DATE = date("20y-m-d H:i:s", time());
			if(isset($_POST['MONITORING_FLAG'])) {
				$MONITORING_FLAG = $_POST['MONITORING_FLAG'];
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					MONITORING_FLAG='$MONITORING_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			$MONITORING_NAME_NETID = just_clean($_POST['MONITORING_NAME_NETID']);
			$MONITORING_EMAIL = just_clean($_POST['MONITORING_EMAIL']);
			$MONITORING_CELL = just_clean($_POST['MONITORING_CELL']);
			if(isset($_POST['MONITORING_NOTIFY'])) {
				$MONITORING_NOTIFY = $_POST['MONITORING_NOTIFY'];
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					MONITORING_NOTIFY='$MONITORING_NOTIFY'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			mysql_query("UPDATE VM_ORDER_DETAIL SET		
				VM_VOLUME='".mysql_real_escape_string($VM_VOLUME)."',
				VM_MEMORY='".mysql_real_escape_string($VM_MEMORY)."',
				VM_CPU='".mysql_real_escape_string($VM_CPU)."',
				ROOT_ACCESS_USERS='".mysql_real_escape_string($ROOT_ACCESS_USERS)."',
				THREE_MONTHS_STORAGE='".mysql_real_escape_string($THREE_MONTHS_STORAGE)."',
				FIRST_YEAR_STORAGE='".mysql_real_escape_string($FIRST_YEAR_STORAGE)."',
				VM_GROWTH='".mysql_real_escape_string($VM_GROWTH)."',
				BACKUP_REQUIREMENTS='".mysql_real_escape_string($BACKUP_REQUIREMENTS)."',
				SOURCE_IP='".mysql_real_escape_string($SOURCE_IP)."',
				DESTINATION_IP='".mysql_real_escape_string($DESTINATION_IP)."',
				IP_DESCRIPTION='".mysql_real_escape_string($IP_DESCRIPTION)."',
				VM_COMMENTS='".mysql_real_escape_string($VM_COMMENTS)."',
				MODIFY_DATE='$MODIFY_DATE',
				MONITORING_NAME_NETID='".mysql_real_escape_string($MONITORING_NAME_NETID)."',
				MONITORING_EMAIL='".mysql_real_escape_string($MONITORING_EMAIL)."',
				MONITORING_CELL='".mysql_real_escape_string($MONITORING_CELL)."',
				COMPLETE_FLAG='$COMPLETE_FLAG'
				WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");	
				$MESG .= "<font color='#308014'>Changes to &#34;".$PROJECT_NAME."&#34; have been saved.</font><br>";
				if (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE'] == "MAIN") { 
							echo'<form name="Next" id="Next" action="index.php"></form>';
				} elseif (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE'] == "FACILITIES") { 
							echo'<form name="Next" id="Next" action="http://www.it.northwestern.edu/data-centers/index.html"></form>';
				} elseif (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE'] == "NUIT") { 
							echo'<form name="Next" id="Next" action="http://www.it.northwestern.edu/index.html"></form>';
				} elseif (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE']  == "PREVIEW"){ 
					echo '<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
						<input type="hidden" name="MESG" value="' . $MESG . '" />	
						<input type="hidden" name="PAGE" value="APPLICATION" />
						<input type="hidden" name="PREVIEW" value="PREVIEW" />
						<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
						<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $VM_ORDER_DETAIL_ID . '" />
					</form>';
				} else {
					echo '<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
						<input type="hidden" name="MESG" value="' . $MESG . '" />	
						<input type="hidden" name="PAGE" value="APPLICATION" />
						<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
						<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $VM_ORDER_DETAIL_ID . '" />
					</form>';
				}
			 ?>