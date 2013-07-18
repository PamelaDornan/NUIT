<?php $PROJECT_NAME = just_clean($_POST['PROJECT_NAME']); 
			$CREATE_DATE = date("20y-m-d H:i:s", time()); 
			$VM_ORDER_TYPE = $_POST['VM_ORDER_TYPE'];
			$SUBMIT_FLAG = "0"; 
			$QTY_APPLICATION = 0;
			$QTY_DATABASE = 0;
			$QTY_FILESERV = 0;
			$QTY_WEBSERV = 0;
			$COMPLETE_FLAG = "0";
			mysql_query("INSERT INTO VM_ORDER
				(NETID,PROJECT_NAME,COMPLETE_FLAG,CREATE_DATE,SUBMIT_FLAG,VM_ORDER_TYPE,QTY_APPLICATION,QTY_DATABASE,QTY_FILESERV,QTY_WEBSERV)
						VALUES 
				('$NETID','".mysql_real_escape_string($PROJECT_NAME)."','$COMPLETE_FLAG','$CREATE_DATE','$SUBMIT_FLAG','$VM_ORDER_TYPE','$QTY_APPLICATION','$QTY_DATABASE','$QTY_FILESERV','$QTY_WEBSERV')");
			$VM_ORDER_ID = mysql_insert_id();
			$MESG .= "<font color='#308014'>&#34;".$PROJECT_NAME."&#34; managed server request has been created.</font><br>";
			echo '	<form name="Next" action="index.php" method="post" style="display:inline; margin:0; padding:0;">
						<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
						<input type="hidden" name="CONTACT" value="CONTACT" />
						<input type="hidden" name="MESG" value="' . $MESG . '" />
						<input type="hidden" name="PAGE" value="APPLICATION" />
					</form>'; ?>