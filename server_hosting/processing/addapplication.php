<?php 		$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$VM_TYPE = "Application";
			$VM_ORDER_DETAIL = mysql_query("
				SELECT * 
				FROM VM_ORDER_DETAIL
				WHERE VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE = '$VM_TYPE'
				ORDER BY VM_TYPE ASC
			")or die(mysql_error());
			$NUM_VM_ORDER_DETAIL_RESULTS = mysql_num_rows($VM_ORDER_DETAIL );
			$NUM_VM_ORDER_DETAIL_RESULTS ++;
			if ($NUM_VM_ORDER_DETAIL_RESULTS > 25) {
				$ERROR .= "<font color='#CC1100'>You cannot request more than 25 Application Servers on a Managed Server Request.</font><br>";
				echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">';
				if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; 
					echo '<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
					<input type="hidden" name="ERROR" value="' . $ERROR . '" />
					<input type="hidden" name="PAGE" value="APPLICATION" />
				</form>'; 
			} else {
				$VM_ORDER_DETAIL_NAME = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE = '$VM_TYPE' AND VM_NAME LIKE 'Application %'
				")or die(mysql_error());
				$VM_ORDER_DETAIL_NAME_ARRAY = array();
				while ($VM_ORDER_DETAIL_NAMEROW = mysql_fetch_array($VM_ORDER_DETAIL_NAME))
				{ 
					$VM_ORDER_DETAIL_NAME_ARRAY[$VM_ORDER_DETAIL_NAMEROW['VM_ORDER_DETAIL_ID']] = $VM_ORDER_DETAIL_NAMEROW;
				}
				$HIGHEST_NAME_NUM = 0;
				foreach ($VM_ORDER_DETAIL_NAME_ARRAY as $ID => $VM_ORDER_DETAIL_NAME_RECORD) {
					$temp = $VM_ORDER_DETAIL_NAME_RECORD['VM_NAME'];
					$LAST_NAME_IN_LIST = explode(' ',$temp);
					if(is_numeric($LAST_NAME_IN_LIST[1])) {
						$NUM = $LAST_NAME_IN_LIST[1] + 1; 
						if($NUM > $HIGHEST_NAME_NUM) $HIGHEST_NAME_NUM = $NUM;
					}
				}
				if ($NUM_VM_ORDER_DETAIL_RESULTS>$HIGHEST_NAME_NUM) {
					$VM_NAME = "Application " . $NUM_VM_ORDER_DETAIL_RESULTS;
				} else { 
					$VM_NAME = "Application " . $HIGHEST_NAME_NUM;
				}
				mysql_query("INSERT INTO VM_ORDER_DETAIL
					(VM_ORDER_ID,VM_NAME,VM_TYPE)
						VALUES 
					('$VM_ORDER_ID','$VM_NAME','$VM_TYPE')");
				$VM_ORDER_DETAIL_ID = mysql_insert_id();
				$MESG .= "<font color='#308014'>".$VM_NAME." has been added to your Managed Server request.</font><br>";
				mysql_query("UPDATE VM_ORDER SET QTY_APPLICATION ='$NUM_VM_ORDER_DETAIL_RESULTS' WHERE VM_ORDER_ID='$VM_ORDER_ID'");
				echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
							<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
							<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $VM_ORDER_DETAIL_ID . '" />
							<input type="hidden" name="ACTION" value="NEW" />
							<input type="hidden" name="PAGE" value="APPLICATION" />
							<input type="hidden" name="VM_TYPE" value="Application" />
							<input type="hidden" name="MESG" value="' . $MESG . '" />';
							echo'<input type="hidden" name="ERROR" value="' . $ERROR . '" />';
						echo '</form>'; 
			}?>