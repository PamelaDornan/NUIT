<?php session_start(); 
	if(isset($_POST['PAGE'])){
		if($_POST['PAGE']=="MAIN") {
			require("main.php");
		} else if($_POST['PAGE']=="PROCESSING") {
			require("processing.php");
		} else if($_POST['PAGE']=="APPLICATION") {
			require("application.php");
		}  else if($_POST['PAGE']=="SUBMIT") {
			require("submit.php");
		}
	} else {
		require("main.php");
	} 
	
	if(isset($_POST['PREVIEW'])) {
		echo '<form name="PREVIEW" target="_blank" method="post" action="preview.php" style="display:inline;margin:0;padding:0;" >
				<input type="hidden" name="VM_ORDER_ID" value="' . $VM_ORDER_ID . '" />
			</form>
			<script language="javascript">
				<!--
					document.PREVIEW.submit();
				-->
			</script>';
	}?>