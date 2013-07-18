<?php 			
			$PROJECT_NAME = just_clean($_POST['PROJECT_NAME']);
			$CREATE_DATE = date("20y-m-d H:i:s", time());
			$VM_ORDER_TYPE = $_POST['VM_ORDER_TYPE'];
			$SUBMIT_FLAG = "0";
			$VM_TYPE = "Guest";
			if (!empty($_POST['PROJECT_NAME']) && !empty($_POST['CONTACT_NAME']) && !empty($_POST['CONTACT_NETID']) && !empty($_POST['CONTACT_DEPARTMENT']) && !empty($_POST['CONTACT_EMAIL']) && !empty($_POST['CONTACT_PHONE'])) {
				$COMPLETE_FLAG = "1";
			} else {
				$COMPLETE_FLAG = "0";
			}
			mysql_query("INSERT INTO VM_ORDER
				(NETID,PROJECT_NAME,COMPLETE_FLAG,CREATE_DATE,SUBMIT_FLAG,VM_ORDER_TYPE)
						VALUES 
				('$NETID','".mysql_real_escape_string($PROJECT_NAME)."','$COMPLETE_FLAG','$CREATE_DATE','$SUBMIT_FLAG','$VM_ORDER_TYPE')");
			$VM_ORDER_ID = mysql_insert_id();
			mysql_query("INSERT INTO VM_ORDER_DETAIL
				(VM_ORDER_ID,VM_TYPE,CREATE_DATE)
					VALUES 
				('$VM_ORDER_ID','$VM_TYPE','$CREATE_DATE')");
			$MESG .= "<font color='#308014'>&#34;".$PROJECT_NAME."&#34; guest hosting request has been created.</font><br>";
			$VM_ORDER_DETAIL_ID = mysql_insert_id();
			echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
						<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
						<input type="hidden" name="VM_TYPE" value="' . $VM_TYPE . '" />
						<input type="hidden" name="VM_ORDER_DETAIL_ID" value="' . $VM_ORDER_DETAIL_ID . '" />
						<input type="hidden" name="MESG" value="' . $MESG . '" />
						<input type="hidden" name="PAGE" value="APPLICATION" />
					</form>'; 
					?>