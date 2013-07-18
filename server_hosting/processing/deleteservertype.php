<?php 		$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$VM_ORDER_DETAIL = mysql_query("
				SELECT * 
				FROM VM_ORDER_DETAIL
				WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID'
				ORDER BY VM_TYPE ASC
			")or die(mysql_error());
			$VM_ORDER_DETAIL_RECORD = mysql_fetch_array($VM_ORDER_DETAIL) or die(mysql_error());
			if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'] > 0) {
				$VM_FILES = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
				$NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
				$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
				$list = explode(",",$temp);
				for ($i=0;$i<$NUMBER_OF_FILES;$i++) {
					unlink($list[$i]);
				}
			}
			$VM_NAME = $VM_ORDER_DETAIL_RECORD['VM_NAME'];
			$VM_TYPE = $VM_ORDER_DETAIL_RECORD['VM_TYPE'];
			mysql_query("DELETE FROM VM_ORDER_DETAIL WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID'");
			$VM_ORDER_DETAIL = mysql_query("
				SELECT * 
				FROM VM_ORDER_DETAIL
				WHERE VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE = '$VM_TYPE'
				ORDER BY VM_TYPE ASC
			")or die(mysql_error());
			$QTY_TYPE = mysql_num_rows($VM_ORDER_DETAIL );
			
			if ($VM_TYPE == "Application") { 
				mysql_query("UPDATE VM_ORDER SET QTY_APPLICATION ='$QTY_TYPE' WHERE VM_ORDER_ID='$VM_ORDER_ID'");
			}
			if ($VM_TYPE == "Database") {
				mysql_query("UPDATE VM_ORDER SET QTY_DATABASE ='$QTY_TYPE' WHERE VM_ORDER_ID='$VM_ORDER_ID'");
			}
			if ($VM_TYPE == "Fileserv") { 
				mysql_query("UPDATE VM_ORDER SET QTY_FILESERV ='$QTY_TYPE' WHERE VM_ORDER_ID='$VM_ORDER_ID'");
			}
			if ($VM_TYPE == "Webserv") { 
				mysql_query("UPDATE VM_ORDER SET QTY_WEBSERV ='$QTY_TYPE' WHERE VM_ORDER_ID='$VM_ORDER_ID'");
			}
			$MESG .= "<font color='#308014'>".$VM_NAME . " has been deleted.</font><br>";
			echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">';
				echo '<input type="hidden" name="VM_ORDER_ID" value="' . $_POST['VM_ORDER_ID'] . '" />';
				if (!empty($_POST['ELSEWHERE']) && isset($_POST['VM_ORDER_DETAIL_ID'])) {
					echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $_POST['VM_ORDER_DETAIL_ID'] . '" />';
					echo '<input type="hidden" name="VM_TYPE" value="' . $_POST['VM_TYPE'] . '" />';
				} else {
					echo '<input type="hidden" name="CONTACT" value="CONTACT" />';
				}
				echo '<input type="hidden" name="MESG" value="' . $MESG . '" />';
							echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
						echo '<input type="hidden" name="PAGE" value="APPLICATION" /></form>'; ?>