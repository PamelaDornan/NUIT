<?php 
			$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
			$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			require("processing/processfiles.php");
			$VM_NAME = just_clean($_POST['VM_NAME']);
			$VM_CHARACTERISTICS = just_clean($_POST['VM_CHARACTERISTICS']);
			if(isset($_POST['VM_DEPENDENT'])) { 
				$VM_DEPENDENT = $_POST['VM_DEPENDENT']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					VM_DEPENDENT='".mysql_real_escape_string($VM_DEPENDENT)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			if(isset($_POST['LOAD_BALANCE'])) { 
				$LOAD_BALANCE = $_POST['LOAD_BALANCE']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					LOAD_BALANCE='".mysql_real_escape_string($LOAD_BALANCE)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
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
			if(isset($_POST['WEBSERV_TYPE'])) { 
				$WEBSERV_TYPE = $_POST['WEBSERV_TYPE']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					WEBSERV_TYPE='".mysql_real_escape_string($WEBSERV_TYPE)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			if(isset($_POST['SSL_CERT_FLAG'])) { 
				$SSL_CERT_FLAG = $_POST['SSL_CERT_FLAG']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					SSL_CERT_FLAG='".mysql_real_escape_string($SSL_CERT_FLAG)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			$SSL_CERT_DETAILS = just_clean($_POST['SSL_CERT_DETAILS']);
			$VM_MEMORY = just_clean($_POST['VM_MEMORY']);
			$VM_CPU = just_clean($_POST['VM_CPU']);
			$NUM_USERS = just_clean($_POST['NUM_USERS']);
			if(isset($_POST['USER_COMMUNITY'][0])) {$USER_COMMUNITY0 = $_POST['USER_COMMUNITY'][0]; } else { $USER_COMMUNITY0 = "none"; }
			if(isset($_POST['USER_COMMUNITY'][1])) {$USER_COMMUNITY1 = $_POST['USER_COMMUNITY'][1]; } else { $USER_COMMUNITY1 = "none"; }
			if(isset($_POST['USER_COMMUNITY'][2])) {$USER_COMMUNITY2 = $_POST['USER_COMMUNITY'][2]; } else { $USER_COMMUNITY2 = "none"; }
			if(isset($_POST['USER_COMMUNITY'][3])) {$USER_COMMUNITY3 = $_POST['USER_COMMUNITY'][3]; } else { $USER_COMMUNITY3 = "none"; }
			if(isset($_POST['USER_COMMUNITY'][4])) {$USER_COMMUNITY4 = $_POST['USER_COMMUNITY'][4]; } else { $USER_COMMUNITY4 = "none"; }
			if($USER_COMMUNITY0 == "Other" || $USER_COMMUNITY1 == "Other" || $USER_COMMUNITY2 == "Other" || $USER_COMMUNITY3 == "Other" || $USER_COMMUNITY4 == "Other") {
				$USER_COMMUNITY = $USER_COMMUNITY0 . "," . $USER_COMMUNITY1 . "," . $USER_COMMUNITY2 . "," . $USER_COMMUNITY3 . "," . $USER_COMMUNITY4 . "," . just_clean($_POST['USER_COMMUNITY_OTHER']);
			} else {
				$USER_COMMUNITY = $USER_COMMUNITY0 . "," . $USER_COMMUNITY1 . "," . $USER_COMMUNITY2 . "," . $USER_COMMUNITY3 . "," . $USER_COMMUNITY4 . ",";
			}
			$ROOT_ACCESS_USERS = just_clean($_POST['ROOT_ACCESS_USERS']);
			if(isset($_POST['FTP_FLAG'])) {
				$FTP_FLAG = $_POST['FTP_FLAG']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					FTP_FLAG='$FTP_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			$THREE_MONTHS_STORAGE = just_clean($_POST['THREE_MONTHS_STORAGE']);
			$FIRST_YEAR_STORAGE = just_clean($_POST['FIRST_YEAR_STORAGE']);
			$VM_GROWTH = just_clean($_POST['VM_GROWTH']);
			$DATA_CLASS_DETAIL = just_clean($_POST['DATA_CLASS_DETAIL']);
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
			$MONITORING_NAME_NETID = just_clean($_POST['MONITORING_NAME_NETID']);
			$MONITORING_EMAIL = just_clean($_POST['MONITORING_EMAIL']);
			$MONITORING_CELL = just_clean($_POST['MONITORING_CELL']);
			if(isset($_POST['MONITORING_NOTIFY'])) {
				$MONITORING_NOTIFY = $_POST['MONITORING_NOTIFY'];
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					MONITORING_NOTIFY='$MONITORING_NOTIFY'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			if(	empty($_POST['VM_NAME']) ||			
				empty($_POST['VM_CHARACTERISTICS']) || 
				!isset($_POST['VM_DEPENDENT']) || 
				!isset($_POST['LOAD_BALANCE']) ||
				!isset($_POST['VM_OS']) || 
				!isset($_POST['WEBSERV_TYPE']) || 
				!isset($_POST['VM_OS_BITS']) || 
				!isset($_POST['SSL_CERT_FLAG']) ||
				($_POST['SSL_CERT_FLAG'] == "1" && empty($_POST['SSL_CERT_DETAILS'])) ||
				empty($_POST['VM_MEMORY']) || 
				empty($_POST['VM_CPU']) ||
				empty($_POST['NUM_USERS']) ||
				((!isset($_POST['USER_COMMUNITY']) || empty($_POST['USER_COMMUNITY'])) 
					||(
						$_POST['USER_COMMUNITY'][0] == "none" && 
						$_POST['USER_COMMUNITY'][1] == "none" && 
						$_POST['USER_COMMUNITY'][2] == "none" && 
						$_POST['USER_COMMUNITY'][3] == "none" && 
						$_POST['USER_COMMUNITY'][4] == "none") 
					||(
						((isset($_POST['USER_COMMUNITY'][0]) && $_POST['USER_COMMUNITY'][0] == "Other") || 
						(isset($_POST['USER_COMMUNITY'][1]) && $_POST['USER_COMMUNITY'][1] == "Other") || 
						(isset($_POST['USER_COMMUNITY'][2]) && $_POST['USER_COMMUNITY'][2] == "Other") || 
						(isset($_POST['USER_COMMUNITY'][3]) && $_POST['USER_COMMUNITY'][3] == "Other") || 
						(isset($_POST['USER_COMMUNITY'][4]) && $_POST['USER_COMMUNITY'][4] == "Other"))
						&& empty($_POST['USER_COMMUNITY_OTHER']))) || 
				empty($_POST['THREE_MONTHS_STORAGE']) || 
				empty($_POST['FIRST_YEAR_STORAGE']) || 
				empty($_POST['VM_GROWTH']) || 
				empty($_POST['IP_DESCRIPTION']) ||
				empty($_POST['MONITORING_NAME_NETID']) || 
				empty($_POST['MONITORING_EMAIL']) || 
				empty($_POST['MONITORING_CELL'])) {
				$COMPLETE_FLAG = 0;
			} else { $COMPLETE_FLAG = 1; }
			
			mysql_query("UPDATE VM_ORDER_DETAIL SET		
				VM_NAME='".mysql_real_escape_string($VM_NAME)."',
				VM_CHARACTERISTICS='".mysql_real_escape_string($VM_CHARACTERISTICS)."',
				SSL_CERT_DETAILS='".mysql_real_escape_string($SSL_CERT_DETAILS)."',
				VM_MEMORY='".mysql_real_escape_string($VM_MEMORY)."',
				VM_CPU='".mysql_real_escape_string($VM_CPU)."',
				NUM_USERS='".mysql_real_escape_string($NUM_USERS)."',
				USER_COMMUNITY ='".mysql_real_escape_string($USER_COMMUNITY)."',
				ROOT_ACCESS_USERS='".mysql_real_escape_string($ROOT_ACCESS_USERS)."',
				THREE_MONTHS_STORAGE='".mysql_real_escape_string($THREE_MONTHS_STORAGE)."',
				FIRST_YEAR_STORAGE='".mysql_real_escape_string($FIRST_YEAR_STORAGE)."',
				VM_GROWTH='".mysql_real_escape_string($VM_GROWTH)."',
				DATA_CLASS_DETAIL='".mysql_real_escape_string($DATA_CLASS_DETAIL)."',
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

				$MESG .= "<font color='#308014'>Changes to ".$VM_NAME." have been saved.</font><br>";
				
				if 	(empty($_POST['ELSEWHERE'])) {
					echo '<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
					<input type="hidden" name="PAGE" value="APPLICATION" />
					<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />';
						
					if($_POST['DIRECTION'] == "NEXT") {
						$NEXT_VM_DETAIL_VALUES = mysql_query("
							SELECT * 
							FROM VM_ORDER_DETAIL
							WHERE (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_ORDER_DETAIL_ID > '$VM_ORDER_DETAIL_ID' AND VM_TYPE = 'Webserv')
							ORDER BY VM_ORDER_DETAIL_ID
						")or die(mysql_error()); 
						$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES);
					}
					if($_POST['DIRECTION'] == "PREV") {
						$NEXT_VM_DETAIL_VALUES = mysql_query("
							SELECT * 
							FROM VM_ORDER_DETAIL
							WHERE (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE != 'Webserv') OR (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_ORDER_DETAIL_ID < '$VM_ORDER_DETAIL_ID' AND VM_TYPE = 'Webserv')
							ORDER BY VM_TYPE DESC, VM_ORDER_DETAIL_ID DESC
						")or die(mysql_error()); 
						$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES);
					}
					if ($_POST['DIRECTION'] == "SAVE") {
						echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $VM_ORDER_DETAIL_ID . '" />
						<input type="hidden" name="VM_TYPE" value="Webserv" />';
					} elseif ($NUM > 0) {
						$NEXT_VM_VALUES_DETAIL_RECORD = mysql_fetch_array($NEXT_VM_DETAIL_VALUES) or die(mysql_error());
						echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_ORDER_DETAIL_ID'] . '" />
						<input type="hidden" name="VM_TYPE" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_TYPE'] . '" />';
					} else {
						echo '<input type="hidden" name="CONTACT" value="CONTACT" />';
					}
					echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
					echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
					echo '</form>';
				} else {
					$VALUE = $_POST['ELSEWHERE'];
					$CONDITION = explode(' ',$VALUE);
					if ($CONDITION[0] <> "DELETE" && $CONDITION[0] <> "SKIP") { 
						if ($VALUE == "CONTACT") {
							echo '<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
								<input type="hidden" name="PAGE" value="APPLICATION" />
								<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />';
							echo'<input type="hidden" name="CONTACT" value="CONTACT">';
							echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
							echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
						echo '</form>';
						} elseif ($VALUE == "MAIN") { 
							echo'<form name="Next" id="Next" action="index.php"></form>';
						} elseif ($VALUE == "FACILITIES") { 
							echo'<form name="Next" id="Next" action="http://www.it.northwestern.edu/data-centers/index.html"></form>';
						} elseif ($VALUE == "NUIT") { 
							echo'<form name="Next" id="Next" action="http://www.it.northwestern.edu/index.html"></form>';
						} else {
							$NEXT_VM_DETAIL_VALUES = mysql_query("
								SELECT * 
								FROM VM_ORDER_DETAIL
								WHERE VM_ORDER_DETAIL_ID = '$VALUE'
							")or die(mysql_error());
							$NEXT_VM_VALUES_DETAIL_RECORD = mysql_fetch_array($NEXT_VM_DETAIL_VALUES) or die(mysql_error());
							echo '<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
								<input type="hidden" name="PAGE" value="APPLICATION" />
								<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />';
							echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_ORDER_DETAIL_ID'] . '" />
								<input type="hidden" name="VM_TYPE" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_TYPE'] . '" />';
							echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
							echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
							echo '</form>';
						}
					}
				}
			 ?>