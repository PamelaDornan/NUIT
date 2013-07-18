<?php 		$VM_ORDER_ID= $_POST['VM_ORDER_ID'];
			$VM_ORDER_DETAIL_NAME = mysql_query("
				SELECT * 
				FROM VM_ORDER
				WHERE VM_ORDER_ID = '$VM_ORDER_ID'
			")or die(mysql_error());
			$VM_ORDER_DETAIL_NAME_RECORD = mysql_fetch_array($VM_ORDER_DETAIL_NAME) or die(mysql_error());
			$PROJECT_NAME = $VM_ORDER_DETAIL_NAME_RECORD['PROJECT_NAME'];
			$VM_ORDER_DETAIL = mysql_query("
				SELECT * 
				FROM VM_ORDER_DETAIL
				WHERE VM_ORDER_ID = '$VM_ORDER_ID'
			")or die(mysql_error());
			$num_listresults = mysql_num_rows($VM_ORDER_DETAIL);
			$VM_ORDER_DETAIL_ARRAY = array(); 
			while ($VM_ORDER_DETAIL_ROW = mysql_fetch_array($VM_ORDER_DETAIL))
			{ 
				$VM_ORDER_DETAIL_ARRAY[$VM_ORDER_DETAIL_ROW['VM_ORDER_ID']] = $VM_ORDER_DETAIL_ROW;
			}
			if ($num_listresults > 0){
				foreach ($VM_ORDER_DETAIL_ARRAY as $VM_ORDER_DETAIL_ID => $VM_ORDER_DETAIL_RECORD) {
					if(isset($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES']) && !empty($VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'])) {
						$VM_FILES = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
						$NUMBER_OF_FILES = $VM_ORDER_DETAIL_RECORD['NUMBER_OF_FILES'];
						$temp = $VM_ORDER_DETAIL_RECORD['VM_FILES'];
						$list = explode(",",$temp);
						for ($i=0;$i<$NUMBER_OF_FILES;$i++) {
							unlink($list[$i]);
						}
					}
				}
			}
			mysql_query("DELETE FROM VM_ORDER WHERE VM_ORDER_ID = '$VM_ORDER_ID'");
			mysql_query("DELETE FROM VM_ORDER_DETAIL WHERE VM_ORDER_ID = '$VM_ORDER_ID'");
			$MESG .= "Request: " . $PROJECT_NAME . ", has been deleted.";
			echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">';
							echo'<input type="hidden" name="PAGE" value="MAIN" /><input type="hidden" name="ERROR" value="' . $ERROR . '" />';
						echo '<input type="hidden" name="MESG" value="' . $MESG . '" /></form>'; ?>