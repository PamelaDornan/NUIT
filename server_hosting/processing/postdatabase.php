<?php 
			$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
			require("processing/processfiles.php");
			$VM_NAME = just_clean($_POST['VM_NAME']);
			$DBA_NAME = just_clean($_POST['DBA_NAME']);
			$DBA_PHONE = just_clean($_POST['DBA_PHONE']);
			$DBA_EMAIL = just_clean($_POST['DBA_EMAIL']);
			if(isset($_POST['ORACLE_SQL'])) {
				$ORACLE_SQL = just_clean($_POST['ORACLE_SQL']); 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					ORACLE_SQL='$ORACLE_SQL'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			$ORACLE_SQL_VERSION = just_clean($_POST['ORACLE_SQL_VERSION']);
			$VM_MEMORY = just_clean($_POST['VM_MEMORY']);
			$VM_CPU = just_clean($_POST['VM_CPU']);
			$VM_VOLUME = just_clean($_POST['VM_VOLUME']);
			if(isset($_POST['ORACLE_FLAG'])) {
				$ORACLE_FLAG = $_POST['ORACLE_FLAG']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					ORACLE_FLAG='$ORACLE_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
				if($_POST['ORACLE_FLAG'] == 1 && isset($_POST['ORACLE_VERSION'])) {
					$ORACLE_VERSION = just_clean($_POST['ORACLE_VERSION']); 
					mysql_query("UPDATE VM_ORDER_DETAIL SET		
						ORACLE_VERSION='".mysql_real_escape_string($ORACLE_VERSION)."'
						WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");	
				}
				if($_POST['ORACLE_FLAG'] == 0) {
					mysql_query("UPDATE VM_ORDER_DETAIL SET		
						ORACLE_VERSION=NULL
						WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");	
				}
			}
			if($_POST['INSTALL_CONTACT']=="Other") {
				$INSTALL_CONTACT = just_clean($_POST['INSTALL_CONTACT_OTHER']);
			} else {
				$INSTALL_CONTACT = just_clean($_POST['INSTALL_CONTACT']);
			}
			if(isset($_POST['VENDOR_FLAG'])) {
				$VENDOR_FLAG = $_POST['VENDOR_FLAG']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					VENDOR_FLAG='$VENDOR_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
				if($_POST['VENDOR_FLAG'] == 1 && isset($_POST['VENDOR_DETAIL'])) {
					$VENDOR_DETAIL = just_clean($_POST['VENDOR_DETAIL']); 
					mysql_query("UPDATE VM_ORDER_DETAIL SET		
						VENDOR_DETAIL='".mysql_real_escape_string($VENDOR_DETAIL)."'
						WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");	
				}
				if($_POST['VENDOR_FLAG'] == 0) {
					mysql_query("UPDATE VM_ORDER_DETAIL SET		
						VENDOR_DETAIL=NULL
						WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");	
				
				}
			}
			$THREE_MONTHS_STORAGE = just_clean($_POST['THREE_MONTHS_STORAGE']);
			$FIRST_YEAR_STORAGE = just_clean($_POST['FIRST_YEAR_STORAGE']);
			$VM_GROWTH = just_clean($_POST['VM_GROWTH']);
			$DATA_CLASS_DETAIL = just_clean($_POST['DATA_CLASS_DETAIL']);
			if(isset($_POST['STANDBY_FLAG'])) {
				$STANDBY_FLAG = $_POST['STANDBY_FLAG']; 
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					STANDBY_FLAG='$STANDBY_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			$BACKUP_REQUIREMENTS = just_clean($_POST['BACKUP_REQUIREMENTS']);
			$SOURCE_IP = just_clean($_POST['SOURCE_IP']);
			$DESTINATION_IP = just_clean($_POST['DESTINATION_IP']);
			$IP_DESCRIPTION = just_clean($_POST['IP_DESCRIPTION']);
			$VM_COMMENTS = just_clean($_POST['VM_COMMENTS']);
			$MODIFY_DATE = date("20y-m-d H:i:s", time());
			$MONITORING_NAME_NETID = just_clean($_POST['MONITORING_NAME_NETID']);
			$MONITORING_EMAIL = just_clean($_POST['MONITORING_EMAIL']);
			$MONITORING_CELL = just_clean($_POST['MONITORING_CELL']);
			if(isset($_POST['MONITORING_FLAG'])) {
				$MONITORING_FLAG = $_POST['MONITORING_FLAG'];
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					MONITORING_FLAG='$MONITORING_FLAG'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			if(isset($_POST['MONITORING_NOTIFY'])) {
				$MONITORING_NOTIFY = $_POST['MONITORING_NOTIFY'];
				mysql_query("UPDATE VM_ORDER_DETAIL SET		
					MONITORING_NOTIFY='$MONITORING_NOTIFY'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			if(	empty($_POST['VM_NAME']) ||
				!isset($_POST['ORACLE_SQL']) || 
				empty($_POST['ORACLE_SQL']) || 
				empty($_POST['ORACLE_SQL_VERSION']) || 
				empty($_POST['VM_MEMORY']) || 
				empty($_POST['VM_CPU']) || 
				(!isset($_POST['ORACLE_FLAG']) || 
				($_POST['ORACLE_FLAG'] == "1" && empty($_POST['ORACLE_VERSION'])) ) ||
				empty($_POST['INSTALL_CONTACT']) || 
				(!isset($_POST['VENDOR_FLAG']) || 
				($_POST['VENDOR_FLAG'] == "1" && empty($_POST['VENDOR_DETAIL'])) ) ||
				empty($_POST['THREE_MONTHS_STORAGE']) || 
				empty($_POST['FIRST_YEAR_STORAGE']) || 
				empty($_POST['VM_GROWTH']) || 
				!isset($_POST['STANDBY_FLAG']) || 
				empty($_POST['IP_DESCRIPTION']) ||
				!isset($_POST['MONITORING_FLAG']) ||
				($_POST['MONITORING_FLAG'] == 1 && (empty($_POST['MONITORING_NOTIFY']) || empty($_POST['MONITORING_NAME_NETID']) || empty($_POST['MONITORING_EMAIL']) || empty($_POST['MONITORING_CELL'])))) {
				$COMPLETE_FLAG = 0;
			} else { $COMPLETE_FLAG = 1; }
			
			mysql_query("UPDATE VM_ORDER_DETAIL SET	
				VM_NAME='".mysql_real_escape_string($VM_NAME)."',
				DBA_NAME='".mysql_real_escape_string($DBA_NAME)."',
				DBA_PHONE='".mysql_real_escape_string($DBA_PHONE)."',
				DBA_EMAIL='".mysql_real_escape_string($DBA_EMAIL)."',
				ORACLE_SQL_VERSION='".mysql_real_escape_string($ORACLE_SQL_VERSION)."',
				VM_VOLUME='".mysql_real_escape_string($VM_VOLUME)."',
				VM_MEMORY='".mysql_real_escape_string($VM_MEMORY)."',
				VM_CPU='".mysql_real_escape_string($VM_CPU)."',
				ORACLE_VERSION='".mysql_real_escape_string($ORACLE_VERSION)."',
				INSTALL_CONTACT='".mysql_real_escape_string($INSTALL_CONTACT)."',
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
			WHERE (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE != 'Application' AND VM_TYPE != 'Database') OR (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_ORDER_DETAIL_ID > '$VM_ORDER_DETAIL_ID' AND VM_TYPE = 'Database')
			ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
		")or die(mysql_error());
		$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES);
	}
	if($_POST['DIRECTION'] == "PREV") { 
		$NEXT_VM_DETAIL_VALUES = mysql_query("
			SELECT * 
			FROM VM_ORDER_DETAIL
			WHERE (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE = 'Application') OR (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_ORDER_DETAIL_ID < '$VM_ORDER_DETAIL_ID' AND VM_TYPE = 'Database')
			ORDER BY VM_TYPE DESC, VM_ORDER_DETAIL_ID DESC
		")or die(mysql_error()); 
		$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES);
	}
	if ($_POST['DIRECTION'] == "SAVE") {
		echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $VM_ORDER_DETAIL_ID . '" />
				<input type="hidden" name="VM_TYPE" value="Database" />';
	} elseif ($NUM > 0) {
		$NEXT_VM_VALUES_DETAIL_RECORD = mysql_fetch_array($NEXT_VM_DETAIL_VALUES) or die(mysql_error());
		echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_ORDER_DETAIL_ID'] . '" />
		<input type="hidden" name="VM_TYPE" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_TYPE'] . '" />';
	}else{ 
		echo '<input type="hidden" name="CONTACT" value="CONTACT" />';
	}
	echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
	echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
	echo '</form>';
} else {
	$VALUE = $_POST['ELSEWHERE'];
	$CONDITION = explode(' ',$VALUE);
	if ($CONDITION[0] <> "DELETE" && $CONDITION[0] <> "SKIP") { 
		if ($VALUE == "PREVIEW"){ 

			echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">';
				echo '<input type="hidden" name="VM_ORDER_ID" value="' . $_POST['VM_ORDER_ID'] . '" />';
				echo '<input type="hidden" name="PREVIEW" value="PREVIEW" />';
				if (isset($_POST['VM_ORDER_DETAIL_ID'])) {
					echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $_POST['VM_ORDER_DETAIL_ID'] . '" />';
					echo '<input type="hidden" name="VM_TYPE" value="' . $_POST['VM_TYPE'] . '" />';
				} else {
					echo '<input type="hidden" name="CONTACT" value="CONTACT" />';
				}
				echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
				echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
			echo '<input type="hidden" name="PAGE" value="APPLICATION" /></form>';
		} elseif ($VALUE == "CONTACT") { 
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