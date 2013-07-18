<?php		
					
					$DELETE_VM_FILES = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID' AND VM_FILES IS NOT NULL AND VM_FILES <> ','
				")or die(mysql_error());
				$NUM_DELETE = mysql_num_rows($DELETE_VM_FILES); 
				if ($NUM_DELETE == 1) {
					$DELETE_VM_FILES_RECORD = mysql_fetch_array($DELETE_VM_FILES) or die(mysql_error());
					$NUMBER_OF_FILES=$DELETE_VM_FILES_RECORD['NUMBER_OF_FILES'];
					$VM_FILES = $DELETE_VM_FILES_RECORD['VM_FILES'];
					$temp = $DELETE_VM_FILES_RECORD['VM_FILES'];
					$list = explode(",",$temp);
					$NEW_DELETE_VM_FILES = ",";
					for ($j=0; $j<$DELETE_VM_FILES_RECORD['NUMBER_OF_FILES']; $j++) {
						for ($k=0;$k<$DELETE_VM_FILES_RECORD['NUMBER_OF_FILES'];$k++){
							if (isset($_POST['UPLOADED_VM_FILES'.$k]) && $_POST['UPLOADED_VM_FILES'.$k] ==  $list[$j]) {
								$filename = $_POST['UPLOADED_VM_FILES'.$k];
								unlink($filename);
								$temp = $VM_FILES;
								$VM_FILES = "";
								$NEW_VM_FILES = explode(",",$temp);
								for ($m=0;$m<$NUMBER_OF_FILES;$m++){
									if ($NEW_VM_FILES[$m] != $filename) {
										if(empty($VM_FILES)) {
											$VM_FILES = $NEW_VM_FILES[$m];
										} else {
											$VM_FILES = $VM_FILES . "," . $NEW_VM_FILES[$m];
										}
									}
								}
								$NUMBER_OF_FILES--;
							} 
						}
					}
					mysql_query("UPDATE VM_ORDER_DETAIL SET	
						NUMBER_OF_FILES='$NUMBER_OF_FILES',
						VM_FILES='".mysql_real_escape_string($VM_FILES)."'
						WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'
					");
				}
		if (empty($_POST['NUMBER_OF_FILES'])) {  }
		else { 
			$NUMBER_OF_FILES = $_POST['NUMBER_OF_FILES']; 
			$SUCESSFUL_NUMBER_OF_FILES = 0;
			$VM_FILES = "";
			$limit_size=26214400;
			$first = 0;
			for ($counter = 1; $counter <= $NUMBER_OF_FILES; $counter++) {
				$target_path = "bin/";
				$NAME = "VM_FILES" . $counter;
				if (!empty($_FILES[$NAME]['name']) && $_FILES[$NAME]['size'] <= $limit_size) {
					$target_path = $target_path . basename( $_FILES[$NAME]['name']);
					$flag=true;
					$count=1;
					while ($flag == true) {
						if(file_exists($target_path)){
							$temp = explode(".",$target_path);
							$target_path = $temp[0] . $count . "." . $temp[1];
							$count++;
						} else {
							$flag = false;
						}
					}
					if(move_uploaded_file($_FILES[$NAME]['tmp_name'], $target_path)) {
						$MESG .= "<font color='#308014'>File " . basename( $_FILES[$NAME]['name']) . " has been uploaded.</font><br>";
						if ($first == 0){
							$VM_FILES = $target_path;
						} else {
							$VM_FILES = $target_path . "," . $VM_FILES;
						}
						$first++;
						$SUCESSFUL_NUMBER_OF_FILES++; 
					} else{
						$ERROR = "<font color='#CC1100'>There was an error uploading file " .  $target_path . ", please try again.</font><br>";
					}
				}
			}
			if(!empty($VM_FILES)){
				$UPLOAD_VM_FILES = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID' AND VM_FILES IS NOT NULL AND VM_FILES <> ','
				")or die(mysql_error());
				$NUM_UPLOAD = mysql_num_rows($UPLOAD_VM_FILES);
				if ($NUM_UPLOAD == 1) {
					$UPLOAD_VM_FILES_RECORD = mysql_fetch_array($UPLOAD_VM_FILES) or die(mysql_error()); 
					if (isset($UPLOAD_VM_FILES_RECORD['VM_FILES']) && !empty($UPLOAD_VM_FILES_RECORD['VM_FILES'])) { 
						$VM_FILES = $UPLOAD_VM_FILES_RECORD['VM_FILES'].",".$VM_FILES; 
					} 
					$NUMBER_OF_FILES = $SUCESSFUL_NUMBER_OF_FILES + $UPLOAD_VM_FILES_RECORD['NUMBER_OF_FILES'];
				} else {
					$NUMBER_OF_FILES = $SUCESSFUL_NUMBER_OF_FILES;
				} 
				mysql_query("UPDATE VM_ORDER_DETAIL SET	
					NUMBER_OF_FILES='$NUMBER_OF_FILES',
					VM_FILES='".mysql_real_escape_string($VM_FILES)."'
					WHERE VM_ORDER_DETAIL_ID='$VM_ORDER_DETAIL_ID'");
			}
			
		} ?>