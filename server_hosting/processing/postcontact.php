<?php 
			$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$PROJECT_NAME = just_clean($_POST['PROJECT_NAME']);
			$CONTACT_NAME = just_clean($_POST['CONTACT_NAME']);
			$CONTACT_NETID = just_clean($_POST['CONTACT_NETID']);
			$CONTACT_DEPARTMENT = just_clean($_POST['CONTACT_DEPARTMENT']);
			$CONTACT_EMAIL = $_POST['CONTACT_EMAIL'];
			$CONTACT_PHONE = $_POST['CONTACT_PHONE'];
			$MODIFY_DATE = date("20y-m-d H:i:s", time()); 
			if (!empty($_POST['PROJECT_NAME']) && !empty($_POST['CONTACT_NAME']) && !empty($_POST['CONTACT_NETID']) && !empty($_POST['CONTACT_DEPARTMENT']) && !empty($_POST['CONTACT_EMAIL']) && !empty($_POST['CONTACT_PHONE'])) {
				$COMPLETE_FLAG = "1";
			} else {
				$COMPLETE_FLAG = "0";
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
			$MESG .= "<font color='#308014'>Contact information has been updated.</font><br>";
		if 	(empty($_POST['ELSEWHERE'])) { 
			$NEXT_VM_DETAIL_VALUES = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID'
					ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
				")or die(mysql_error()); 
				$NUM_NEXT_VM_DETAIL_VALUES = mysql_num_rows($NEXT_VM_DETAIL_VALUES);
				
				if ($NUM_NEXT_VM_DETAIL_VALUES != 0) {$NEXT_VM_VALUES_DETAIL_RECORD = mysql_fetch_array($NEXT_VM_DETAIL_VALUES) or die(mysql_error());}
				
				echo '<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
						<input type="hidden" name="PAGE" value="APPLICATION" />
						<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />';
					if ($NUM_NEXT_VM_DETAIL_VALUES == 0 || $_POST['DIRECTION'] == "SAVE"){ echo '<input type="hidden" name="CONTACT" value="CONTACT" />'; }
					else { echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $NEXT_VM_VALUES_DETAIL_RECORD['VM_ORDER_DETAIL_ID'] . '" />';}
					echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
							echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
						echo '</form>';
		} else {
			$temp = $_POST['ELSEWHERE'];
			$CONDITION = explode(' ',$temp);
			if ($CONDITION[0] <> "DELETE" && $CONDITION[0] <> "SKIP") {
				if ($temp == "PREVIEW"){ 
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
				} elseif (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE'] == "MAIN") { 
					echo'<form name="Next" id="Next" action="index.php"></form>';
				} elseif (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE'] == "FACILITIES") { 
					echo'<form name="Next" id="Next" action="http://www.it.northwestern.edu/data-centers/index.html"></form>';
				} elseif (isset($_POST['ELSEWHERE']) && $_POST['ELSEWHERE'] == "NUIT") { 
					echo'<form name="Next" id="Next" action="http://www.it.northwestern.edu/index.html"></form>';
				} else { 
					$ELSEWHERE = $_POST['ELSEWHERE'];
					$NEXT_VM_DETAIL_VALUES = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_DETAIL_ID = '$ELSEWHERE'
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