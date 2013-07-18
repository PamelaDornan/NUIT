		<?php
			function is_safari() {
				return(eregi("safari", $_SERVER['HTTP_USER_AGENT']));
			}
			function is_chrome() {
				return(eregi("chrome", $_SERVER['HTTP_USER_AGENT']));
			}
			$SUBMIT = 1; //Flag to activate submit button
			$NETID = $_SERVER['REMOTE_USER'];	
			include 'mysql/connection.php';//connection to mysql db
										
			$VM_ORDER_ID = $_POST['VM_ORDER_ID'];
			$VM_ORDER = mysql_query("
				SELECT * 
				FROM VM_ORDER
				WHERE VM_ORDER_ID = '$VM_ORDER_ID'
				ORDER BY CREATE_DATE ASC
			")or die(mysql_error());
			$NUM_VM_ORDER_RESULTS = mysql_num_rows($VM_ORDER ); 
										
			$VM_ORDER_RESULTS_ARRAY = array(); 
			while ($VM_ORDER_ROW = mysql_fetch_array($VM_ORDER ))
			{ 
				$VM_ORDER_RESULTS_ARRAY[$VM_ORDER_ROW['VM_ORDER_ID']] = $VM_ORDER_ROW;
			} 
			foreach ($VM_ORDER_RESULTS_ARRAY as $VM_ORDER_ID => $VM_ORDER_RECORD) {
				$PROJECT_NAME = $VM_ORDER_RECORD['PROJECT_NAME'];
				$VM_ORDER_TYPE = $VM_ORDER_RECORD['VM_ORDER_TYPE'];
				$COUNT_APPLICATION = $VM_ORDER_RECORD['QTY_APPLICATION'];
				$COUNT_DATABASE = $VM_ORDER_RECORD['QTY_DATABASE'];
				$COUNT_FILESERV = $VM_ORDER_RECORD['QTY_FILESERV'];
				$COUNT_WEBSERV = $VM_ORDER_RECORD['QTY_WEBSERV'];
										
			}
?>		
<div style="width:230px;float:left;padding:8px;"><br>
	<!--##################################
	    ###    DISPLAY SIDE BAR KEY    ###
		##################################-->
	<table style="border:3px solid #AAAAAA;">
		<tr>
			<td style="padding:5px;padding-top:0;">
				<center><p nowrap style="display:inline; margin:0; padding:0;"><b>Key</b></p></center>
				&nbsp;<img style="display:inline; margin:0; padding:0; vertical-align:middle;" src="images/check.png" alt="" border="0" align="top"><p nowrap style="display:inline; margin:0; padding:0;"> - Section Complete</p><br>
				<?php if ($VM_ORDER_TYPE == "Managed Server Hosting" ) { ?>
					&nbsp;&nbsp;<img style="display:inline; margin:0; padding:0; vertical-align:middle;" src="images/remove.png" alt="Remove Server" border="0" align="top"><p nowrap style="display:inline; margin:0; padding:0;"> -  Delete Request</p>
				<?php  ;} ?>
			</td>
		</tr>
	</table>
			<br> 
			<!--##################################
				###    DISPLAY PROJECT NAME    ###
				##################################-->
			<p style="display:inline; margin:0; padding:0;"><b><?php echo substr($PROJECT_NAME,0,30); ?></b></p><br>
			<!--#######################################################
				###    IF MANAGED SERVER DISPLAY LARGE FILE TREE    ###
				#######################################################-->
			<?php if ($VM_ORDER_TYPE == "Managed Server Hosting" ) { ?>
				<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
				<form name="JUMP_TO_CONTACT" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
					<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
					<input type="hidden" name="CONTACT" value="CONTACT" />
					<!-- ##  Display Contact Hyperlink  ## -->
					<?php if(isset($_POST['CONTACT'])) {
						echo '<p style="background-color:#CC99CC;display:inline; margin:0; padding:0;vertical-align:-25%" nowrap ><b>Primary Contact</b></p>'; 
					} else { echo '<a href="#" onclick="confirm_jump('."'".'CONTACT'."'".');" style="text-decoration:none;display:inline; margin:0; padding:0;vertical-align:-25%" nowrap ><b>Primary Contact</b></a>'; }?>
					<input type="hidden" name="PAGE" value="APPLICATION" />
				</form>
				<?php if ($VM_ORDER_RECORD['COMPLETE_FLAG'] == "1") { ?>
					<img style="display:inline; margin:0; padding:0; vertical-align:-40%;" src="images/check.png" alt="" border="0" align="top">
				<?php ;} else { $SUBMIT = 0; } ?><br><? 
				$VM_ORDER_DETAIL = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID'
					ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
				")or die(mysql_error());
									
				$NUM_VM_ORDER_DETAIL_RESULTS = mysql_num_rows($VM_ORDER_DETAIL );
								
				$VM_ORDER_DETAIL_RESULTS_ARRAY = array(); 
				while ($VM_ORDER_DETAIL_ROW = mysql_fetch_array($VM_ORDER_DETAIL ))
				{ 
					$VM_ORDER_DETAIL_RESULTS_ARRAY[$VM_ORDER_DETAIL_ROW['VM_ORDER_DETAIL_ID']] = $VM_ORDER_DETAIL_ROW;
				} 

				$APPLICATION_PRINT = 0;
				$DATABASE_PRINT = 0;
				$FILESERV_PRINT = 0;
				$WEBSERV_PRINT = 0;
				$LIST_INDEX = "";
				foreach ($VM_ORDER_DETAIL_RESULTS_ARRAY as $VM_ORDER_DETAIL_ID => $VM_ORDER_DETAIL_RECORD) {
					if ($APPLICATION_PRINT == 0) { 
						$APPLICATION_PRINT = 1; ?>
						<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
						<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
						<form name="ADD_APPLICATION1" id="ADD_APPLICATION1" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
							<input type="hidden" name="ACTION" value="ADD APPLICATION" />
							<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
							<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
							<input type="hidden" name="PAGE" value="PROCESSING" />
						</form>
						<a href="#" onclick="confirm_jump('SKIP APPLICATION');" style="display:inline; margin:0; padding:0;vertical-align:-25%"><b>Add Application</b></a><br>
						<?php ; } 
						if ($DATABASE_PRINT == 0 && $VM_ORDER_DETAIL_RECORD['VM_TYPE'] != "Application"){
							$DATABASE_PRINT = 1; ?>
							<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
							<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
							<form name="ADD_DATABASE1" id="ADD_DATABASE1" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
								<input type="hidden" name="ACTION" value="ADD DATABASE" />
								<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
								<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
								<input type="hidden" name="PAGE" value="PROCESSING" />
							</form>
							<b><a href="#" onclick="confirm_jump('SKIP DATABASE');" style="display:inline; margin:0; padding:0;vertical-align:-25%;">Add Database</a></b><br>
											<?php ; } 
											if ($FILESERV_PRINT == 0 && $VM_ORDER_DETAIL_RECORD['VM_TYPE'] != "Application" && $VM_ORDER_DETAIL_RECORD['VM_TYPE'] != "Database" ){
												$FILESERV_PRINT = 1; ?>
												<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
												<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
												<form name="ADD_FILESERV1" id="ADD_FILESERV1" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
													<input type="hidden" name="ACTION" value="ADD FILESERV" />
													<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
													<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
													<input type="hidden" name="PAGE" value="PROCESSING" />
												</form>
												<b><a href="#" onclick="confirm_jump('SKIP FILESERV');" style="display:inline; margin:0; padding:0;vertical-align:-25%;">Add File Server</a></b><br>
											<?php ; } 
											if ($WEBSERV_PRINT == 0 && $VM_ORDER_DETAIL_RECORD['VM_TYPE'] == "Webserv"){
												$WEBSERV_PRINT = 1; ?>
												<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
												<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
												<form name="ADD_WEBSERV1" id="ADD_WEBSERV1" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
													<input type="hidden" name="ACTION" value="ADD WEBSERV" />
													<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
													<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
													<input type="hidden" name="PAGE" value="PROCESSING" />
												</form>
												<b><a href="#" onclick="confirm_jump('SKIP WEBSERV');" style="display:inline; margin:0; padding:0;vertical-align:-25%">Add Web Server</a></b><br>
											<?php ; } 
											if ($COUNT_APPLICATION != 0){
												if ($COUNT_APPLICATION == 1) { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-V.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
												<?php ;} else { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-V.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
												<?php ;}
												$COUNT_APPLICATION--;
											;}elseif($COUNT_DATABASE != 0){
												if ($COUNT_DATABASE == 1) { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-V.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
												<?php ;} else { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-V.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
												<?php ;}
												$COUNT_DATABASE--;
											;}elseif($COUNT_FILESERV != 0){
												if ($COUNT_FILESERV == 1) { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-V.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
												<?php ;} else { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-V.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
												<?php ;}
												$COUNT_FILESERV--;
											;}elseif($COUNT_WEBSERV != 0){
												if ($COUNT_WEBSERV == 1) { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-S.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
												<?php ;} else { ?>
													<img style="display:inline; margin:0; padding:0;" src="images/tree-S.png" alt="" align="top">
													<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
												<?php ;}
												$COUNT_WEBSERV--;
											;} ?>
											<form name="JUMP_TO_<?php echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
												<input type="hidden" name="PAGE" value="APPLICATION" />
												<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
												<input type="hidden" name="VM_ORDER_DETAIL_ID" value="<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>" />
												<input type="hidden" name="VM_TYPE" value="<? echo $VM_ORDER_DETAIL_RECORD['VM_TYPE']; ?>" />
												<?php if(isset($_POST['VM_ORDER_DETAIL_ID']) && $_POST['VM_ORDER_DETAIL_ID'] == $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']) {
													echo '<p style="background-color:#CC99CC;display:inline; margin:0; padding:0;vertical-align:-25%" nowrap ><b>' . substr($VM_ORDER_DETAIL_RECORD['VM_NAME'],0,20) . '</b></p>'; 
												} else { echo '<a href="#" onclick="confirm_jump('."'".$VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']."'".');" style="text-decoration:none;display:inline; margin:0; padding:0;vertical-align:-25%" nowrap >' . substr($VM_ORDER_DETAIL_RECORD['VM_NAME'],0,20) . '</a>'; }?>
											</form>
											<form name="DELETE_SERVER_TYPE<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>" id="DELETE_SERVER_TYPE<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
												<input type="hidden" name="PAGE" value="PROCESSING" />
												<input type="hidden" name="ACTION" value="DELETE SERVER TYPE" />
												<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
												<input type="hidden" name="VM_ORDER_DETAIL_ID" value="<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>" />
												<input type="hidden" name="VM_TYPE" value="<? echo $VM_ORDER_DETAIL_RECORD['VM_TYPE']; ?>" />
											</form>
											<input type="image" style="display:inline; margin:0; padding:0; vertical-align:middle;" <?php
												if(isset($_POST['VM_ORDER_DETAIL_ID']) && $_POST['VM_ORDER_DETAIL_ID'] == $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']) { ?>  
													onclick="confirm_delete('DELETE_SERVER_TYPE<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>')"
												<?php ;} else { ?> 
													onclick="if (confirm_save_delete('DELETE <? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>'))document.DELETE_SERVER_TYPE<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>.submit()" 
												<?php ;} ?>  src="images/remove.png" alt="" border="0" align="top">
											<?php if ($VM_ORDER_DETAIL_RECORD['COMPLETE_FLAG'] == "1") { ?>
												<img style="display:inline; margin:0; padding:0; vertical-align:middle;" src="images/check.png" alt="" border="0" align="top">
											<?php ;} else { $SUBMIT = 0; } ?>
											<br/>
											
										<?php ;}
										if ($APPLICATION_PRINT == 0) { 
											$APPLICATION_PRINT = 1; ?> 
											<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
											<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
											<form name="ADD_APPLICATION2" id="ADD_APPLICATION2" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
												<input type="hidden" name="PAGE" value="PROCESSING" />
												<input type="hidden" name="ACTION" value="ADD APPLICATION" />
												<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
												<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
											</form>
											<b><a href="#" onclick="confirm_jump('SKIP APPLICATION');" style="display:inline; margin:0; padding:0;vertical-align:-25%">Add Application</a></b><br>
										<?php ; }
										if ($DATABASE_PRINT == 0) { 
											$DATABASE_PRINT = 1; ?>
											<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
											<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
											<form name="ADD_DATABASE2" id="ADD_DATABASE2" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
												<input type="hidden" name="PAGE" value="PROCESSING" />
												<input type="hidden" name="ACTION" value="ADD DATABASE" />
												<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
												<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
											</form>
											<b><a href="#" onclick="confirm_jump('SKIP DATABASE');" style="display:inline; margin:0; padding:0;vertical-align:-25%;">Add Database</a></b>
											<br>
										<?php ; }
										if ($FILESERV_PRINT == 0) {
											$FILESERV_PRINT = 1; ?>
											<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">
											<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
											<form name="ADD_FILESERV2" id="ADD_FILESERV2" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
												<input type="hidden" name="PAGE" value="PROCESSING" />
												<input type="hidden" name="ACTION" value="ADD FILESERV" />
												<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
												<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
											</form>
											<b><a href="#" onclick="confirm_jump('SKIP FILESERV');" style="display:inline; margin:0; padding:0;vertical-align:-25%;">Add File Server</a></b><br>
										<?php ; }
										if ($WEBSERV_PRINT == 0) { 
											$WEBSERV_PRINT = 1; ?>
											<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
											<img style="display:inline; margin:0; padding:0;vertical-align:-50%" src="images/folder.png" alt="" align="top">
											<form name="ADD_WEBSERV2" id="ADD_WEBSERV2" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
												<input type="hidden" name="PAGE" value="PROCESSING" />
												<input type="hidden" name="ACTION" value="ADD WEBSERV" />
												<?php if(isset($_POST['VM_ORDER_DETAIL_ID'])) echo '<input type="hidden" name="VM_ORDER_DETAIL_ID" value="'.$_POST['VM_ORDER_DETAIL_ID'].'" />'; ?>
												<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
											</form>
											<b><a href="#" onclick="confirm_jump('SKIP WEBSERV');" style="display:inline; margin:0; padding:0;vertical-align:-25%">Add Web Server</a></b><br>
										<?php ; } 
			} else { 
				$VM_ORDER_DETAIL = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID'
					ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
				")or die(mysql_error());
				$VM_ORDER_DETAIL_RECORD = mysql_fetch_array($VM_ORDER_DETAIL) or die(mysql_error());
			?>
						<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">
						<form name="JUMP_TO_GUEST" action="index.php" method="post" style="float:none;display:inline; margin:0; padding:0;">
							<input type="hidden" name="PAGE" value="APPLICATION" />
							<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
							<input type="hidden" name="VM_ORDER_DETAIL_ID" value="<? echo $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']; ?>" />
							<input type="hidden" name="VM_TYPE" value="<? echo $VM_ORDER_DETAIL_RECORD['VM_TYPE']; ?>" />
							<?php if(isset($_POST['VM_ORDER_DETAIL_ID']) && $_POST['VM_ORDER_DETAIL_ID'] == $VM_ORDER_DETAIL_RECORD['VM_ORDER_DETAIL_ID']) {
								echo '<p style="background-color:#CC99CC;display:inline; margin:0; padding:0;vertical-align:-25%" nowrap ><b>Guest Server</b></p>'; 
							} else { echo '<a onclick="document.JUMP_TO_GUEST.submit()" style="display:inline; margin:0; padding:0;vertical-align:-25%" nowrap ><b>Guest Server</b></a>'; }?>
						</form>
						<?php if ($VM_ORDER_DETAIL_RECORD['COMPLETE_FLAG'] == "1") { ?>
							<img style="display:inline; margin:0; padding:0; vertical-align:-40%;" src="images/check.png" alt="" border="0" align="top">
						<?php ;} else { $SUBMIT = 0; } ?><br>


						
			<?php ;} ?><br><?php
			#if(!is_safari() && ! is_chrome()) { ?>
			<a href="#" onclick="pre_preview('PREVIEW');" nowrap ><b>Print Preview</b></a>
			<br><br> <?php #;} ?>
			<b><a href="#" onclick="confirm_jump('MAIN');">Back to Dashboard</a></b>
			<br>
		</div>		
