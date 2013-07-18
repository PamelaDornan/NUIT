<html>
	<head>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	</head>
	<script>
		history.forward();
	</script>
<body onload="setTimeout('document.Next.submit()',1000);"> 
	<div id="timer" />
<?php 
	if (isset($_POST['VM_ORDER_ID'])) {
		include 'mysql/connection.php';//connection to mysql db
		$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
		$SUBMIT_VALUES = mysql_query("
			SELECT * 
			FROM VM_ORDER
			WHERE VM_ORDER_ID = '$VM_ORDER_ID'
		")or die(mysql_error()); 
		$SUBMIT_VALUES_RECORD = mysql_fetch_array($SUBMIT_VALUES) or die(mysql_error());
		if ($SUBMIT_VALUES_RECORD['SUBMIT_FLAG'] == 1) { 
			echo"<script language='javascript'>
				<!--
					window.location = 'https://software.northwestern.edu/server_hosting/virtual/index.php'
				-->
			</script>";
		}
	}
	function just_clean($string)  {  // Replace other special chars  
	// Remove all remaining other unknown characters  
	$string = preg_replace('/[^a-zA-Z0-9 -,-;#%&@()_!?.$+*:=\/]/', '', $string);  
	$string = preg_replace('/^[-]+/', '', $string);  
	$string = preg_replace('/[-]+$/', '', $string);  
	$string = preg_replace('/[-]{2,}/', '', $string);
	return $string;  
} ?>
	<?php 
		$ERROR = "";
		$MESG = "";
		$NETID = $_SERVER['REMOTE_USER'];	
		include 'mysql/connection.php';//connection to mysql db
		$ACTION = $_POST['ACTION'];
		if ($ACTION == "POST CONTACT"){
			require("processing/postcontact.php");
		} elseif ($ACTION == "POST GUEST"){ 
			require("processing/postguest.php");
		} elseif ($ACTION == "POST APPLICATION"){
			require("processing/postapplication.php");
		} elseif ($ACTION == "POST DATABASE"){
			require("processing/postdatabase.php");
		} elseif ($ACTION == "POST FILESERV"){
			require("processing/postfileserv.php");
		} elseif ($ACTION == "POST WEBSERV"){
			require("processing/postwebserv.php");
		} elseif ($ACTION == "DELETE SERVER TYPE"){
			$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
			require("processing/deleteservertype.php");
		} elseif ($ACTION == "ADD WEBSERV"){
			require("processing/addwebserv.php");
		} elseif ($ACTION == "ADD FILESERV"){
			require("processing/addfileserv.php");
		} elseif ($ACTION == "ADD DATABASE"){
			require("processing/adddatabase.php");
		} elseif ($ACTION == "ADD APPLICATION"){
			require("processing/addapplication.php");
		} elseif ($ACTION == "NEW GUEST HOSTING"){
			require("processing/newguesthosting.php");
		} elseif ($ACTION == "NEW MANAGED SERVER"){
			require("processing/newmanagedserver.php");
		} elseif ($ACTION == "ORDER DELETE"){
			require("processing/orderdelete.php");
		} 
		if (isset($_POST['ELSEWHERE'])) { 
			if ($_POST['ELSEWHERE'] == "SKIP APPLICATION"){
				require("processing/addapplication.php");
			} elseif ($_POST['ELSEWHERE'] == "SKIP DATABASE"){
				require("processing/adddatabase.php");
			} elseif ($_POST['ELSEWHERE'] == "SKIP FILESERV"){
				require("processing/addfileserv.php");
			} elseif ($_POST['ELSEWHERE'] == "SKIP WEBSERV"){
				require("processing/addwebserv.php");
			} else{
				$temp = $_POST['ELSEWHERE']; 
				$DELETE = explode(' ',$temp);
				if ($DELETE[0] == "DELETE"){ 
					$VM_ORDER_DETAIL_ID = $DELETE[1]; 
					require("processing/deleteservertype.php");
				}
			}
		}
	echo '<br><center><p>Processing...</p><img src="images/wait.gif" alt="loading" /></center><br><br><br><br>&nbsp;';
	?>
</body>

