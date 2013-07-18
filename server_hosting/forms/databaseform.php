<div style="width:680px;float:left;">
<p>Complete the required fields indicated in <font style="color: #CC1100;font-weight:bold;">RED</font> below.  You may complete the form in one session or add information to your request at a later time.  The <b>Submit</b> option will appear once you have completed all of the required fields.</p>
<p>Use the menu tree on the left to add a specific Server Type to your Managed Server request.  Each Server Type selection will require you to supply information needed to set up the requested server.</p>
<p>Your Managed Server request may include up to twenty-five (25) individual Server Types.</p>
<p>Select <b>Print Preview</b> to view and print each request for your records.</p>
<?php 
	if(isset($_POST['ERROR'])) echo "<div style='margin:5px;'><p>".$_POST['ERROR']."</p></div>";
	if(isset($_POST['MESG'])) echo "<div style='margin:5px;'><code>".$_POST['MESG']."</code></div>";
?>
<?php if($SUBMIT!=0){ ?>
		<script type="text/javascript">
			function confirm_submit() {
				var answer = confirm ("Confirm that you would like to finalize the submission of your server request.\n")
				if (answer) {
					return true;
				} else {
					return false;
				}
			}
		</script>
	<center>&nbsp;&nbsp;&nbsp;<div style="padding:5;margin-left:15px;" id="notice">
	<table>
		<tr>
			<td>
				<b><p style="text-align:left;padding:0;margin:0;" >All required entries are complete. You can add more information at a later time or <i>click</i> the Submit button to finalize your request.</p></b>
			</td>
			<td>
				<form name="FINAL_SUBMIT" action="index.php" method="post" onsubmit="return confirm_submit()" style="float:none;display:inline; margin:0; padding:0;">
					<input type="hidden" name="PAGE" value="SUBMIT" />
					<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
					<input type="submit" name="Submit" value="Submit" id="Submit" />
				</form>
			</td>
		</tr>
	</table>
	</div></center><br>
<?php ;} ?>
		<script type="text/javascript">
			function prev() {
				if (document.databaseForm.VM_NAME.value==null||document.databaseForm.VM_NAME.value==""){
					alert("Database request name must be filled out.");
					document.databaseForm.VM_NAME.focus();
				} 
				else {
					document.databaseForm.DIRECTION.value = 'PREV';
					document.databaseForm.submit();
				}
			}
		</script>
		<script type="text/javascript">
			function validate_form() {
				if (document.databaseForm.VM_NAME.value==null||document.databaseForm.VM_NAME.value==""){
					alert("Database Hosting Request Name name must be filled out.");
					document.databaseForm.VM_NAME.focus();
				} 
				else {
					document.databaseForm.DIRECTION.value = 'SAVE';
					document.getElementById("databaseForm").submit();
				}
			}
		</script>
<?php
		$NEXT_VM_DETAIL_VALUES = mysql_query("
			SELECT * 
			FROM VM_ORDER_DETAIL
			WHERE (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE != 'Application' AND VM_TYPE != 'Database') OR (VM_ORDER_ID = '$VM_ORDER_ID' && VM_ORDER_DETAIL_ID > '$VM_ORDER_DETAIL_ID' && VM_TYPE = 'Database')
			ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
			")or die(mysql_error());
		$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES); 
		if ($NUM!=0) { ?>
		<script type="text/javascript">
			function next() {
				if (document.databaseForm.VM_NAME.value==null||document.databaseForm.VM_NAME.value==""){
					alert("Database request name must be filled out.");
					document.databaseForm.VM_NAME.focus();
				} 
				else {
					document.databaseForm.DIRECTION.value = 'NEXT';
					document.databaseForm.submit();
				}
			}
		</script>
		<?php ;} ?>

<table style="width:650px;border:3px solid #AAAAAA;margin:0px;">
	<tr>
		<td style="padding:10px;padding-top:0px;margin:0;padding-bottom:0px;">	
		
<?php
				$DATABASE_COMPLETE = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE = 'Database' AND VM_ORDER_DETAIL_ID <> '$VM_ORDER_DETAIL_ID' and COMPLETE_FLAG = '1'
					ORDER BY VM_ORDER_DETAIL_ID
				")or die(mysql_error());
				$NUM_COMPLETE = mysql_num_rows($DATABASE_COMPLETE);
				$COUNT = $NUM_COMPLETE;
				$DATABASE_COMPLETE_ARRAY = array(); 
				while ($DATABASE_COMPLETE_ROW = mysql_fetch_array($DATABASE_COMPLETE ))
				{ 
					$DATABASE_COMPLETE_ARRAY[$DATABASE_COMPLETE_ROW['VM_ORDER_DETAIL_ID']] = $DATABASE_COMPLETE_ROW;
				} 
				if ($NUM_COMPLETE>0) { ?> 
					<div style="display:inline;margin:0;padding:15px 0px 0px 15px;" name="LINKPOP" id="LINKPOP">	
						<input type="button" style="display:inline;" onclick="autopop();" value="Copy Information From..." />
					</div>
				<?php ;} else {echo'<div id="LINKPOP"></div>';} ?>
				<div style="display:inline;margin:0px;padding:0;" name="POP" id="POP"><?php 
					if ($NUM_COMPLETE>0) { ?>
						<p style="font-style:italic;padding-top:10px;padding-right:40px;padding-left:50px;">Choose from the list below to copy details.</p>
						<div style="padding-left:175px;">	<table style="border:3px solid #AAAAAA;">
		<tr>
			<td style="padding:5px;padding-top:0;">
							<b>
								<p nowrap style="display:inline; margin:0; padding:0;vertical-align:-25%">Complete Database(s)</p>
							</b><br>
							<?php foreach ($DATABASE_COMPLETE_ARRAY as $VM_ORDER_DETAIL_ID => $DATABASE_COMPLETE_RECORD) {							
								if ($COUNT == "1" ) echo '<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">';
								else echo '<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">'; ?>
								<form name="autoPOP<?php echo $DATABASE_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>" id="autoPOP<?php echo $DATABASE_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>" action="index.php" method="post">
									<input type="hidden" name="PAGE" value="APPLICATION" />
									<input type='hidden' name='VM_TYPE' value='Database' />
									<input type='hidden' name='VM_ORDER_ID' value='<?php echo $_POST['VM_ORDER_ID']; ?>' />
									<input type='hidden' name='VM_ORDER_DETAIL_ID' value='<?php echo $_POST['VM_ORDER_DETAIL_ID']; ?>' />
									<input type='hidden' name='POP_VM_ORDER_DETAIL_ID' value='<?php echo $DATABASE_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>' />
									<input type='hidden' name='MESG' value='<font color="#308014">Current request type was auto populated.</font><br>' />
								</form>
							<a  href="#" style="text-decoration:none;display:inline;" onclick="if (confirm_autopop('autoPOP<?php echo $DATABASE_COMPLETE_RECORD['VM_ORDER_DETAIL_ID'] ?>','<?php echo $DATABASE_COMPLETE_RECORD['VM_NAME']; ?>'))document.autoPOP<?php echo $DATABASE_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>.submit()"><?php echo $DATABASE_COMPLETE_RECORD['VM_NAME']; ?></a><br>
					<?php $COUNT--;} 
					?><b><a href="#" style="" onclick="init()">Close</a></b></b></td></tr></table></div><br><?php
				;} ?>
				</div>
				<?php 
					$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
					$DATABASE_VALUES = mysql_query("
						SELECT * 
						FROM VM_ORDER_DETAIL
						WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID'
					")or die(mysql_error()); 
					$DATABASE_VALUES_RECORD = mysql_fetch_array($DATABASE_VALUES) or die(mysql_error()); 
					$NUMBER_OF_FILES = $DATABASE_VALUES_RECORD['NUMBER_OF_FILES'];
					$VM_FILES = $DATABASE_VALUES_RECORD['VM_FILES'];
					if (isset($_POST['POP_VM_ORDER_DETAIL_ID'])){
						$VM_NAME= $DATABASE_VALUES_RECORD['VM_NAME'];
						$POP_VM_ORDER_DETAIL_ID = $_POST['POP_VM_ORDER_DETAIL_ID'];
						$DATABASE_VALUES = mysql_query("
							SELECT * 
							FROM VM_ORDER_DETAIL
							WHERE VM_ORDER_DETAIL_ID = '$POP_VM_ORDER_DETAIL_ID'
						")or die(mysql_error()); 
						$DATABASE_VALUES_RECORD = mysql_fetch_array($DATABASE_VALUES) or die(mysql_error()); 
					}
				?>
		
		
		
		
		
		
		
			<form action="index.php" method="post" id="databaseForm" name="databaseForm" enctype="multipart/form-data">	
				<table style="display:inline;padding:0;margin:0;">
					<tr>
						<td width="250px">
							<h2 style="margin-bottom:7px;padding:0;">Database Hosting Specifics</h2>
						</td>
						<td width="400px" style="text-align:right;">
							&nbsp;<input type="button" style="display:inline;" onclick="prev();" value="&laquo; Save & Previous" />
							&nbsp;<input type="button" style="display:inline;" onclick="validate_form();" value="Save" />
							&nbsp;<input type="button" style="display:inline;" onclick="next();" <?php if ($NUM==0) { echo" disabled ";} ?> value="Save & Next &raquo;" />
						</td>
					</tr>
				</table>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td <?php if(empty($DATABASE_VALUES_RECORD['VM_NAME'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >Database Hosting Requested Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input id="VM_NAME" name="VM_NAME" size="40" value="<?php if (isset($_POST['POP_VM_ORDER_DETAIL_ID'])) { echo $VM_NAME; } else {echo $DATABASE_VALUES_RECORD['VM_NAME']; }?>" /></td>
				</tr>
				<tr>
					<td colspan=2 bgcolor="#FFFFF0">
						List the following information for the primary DBA contact.
					</td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary DBA Name:</td>
					<td><input value="<?php echo $DATABASE_VALUES_RECORD['DBA_NAME']; ?>" name="DBA_NAME" size="40" /></td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary DBA Phone Number:</td>
					<td><input value="<?php echo $DATABASE_VALUES_RECORD['DBA_PHONE']; ?>" onchange='checkPhone(this)' name="DBA_PHONE" size="40" /></td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary DBA E-mail:</td>
					<td><input value="<?php echo $DATABASE_VALUES_RECORD['DBA_EMAIL']; ?>" onchange='checkEmail(this)' name="DBA_EMAIL" size="40" /></td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(!isset($DATABASE_VALUES_RECORD['ORACLE_SQL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Will this Database be MS SQL or Oracle?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input <?php if($DATABASE_VALUES_RECORD['ORACLE_SQL'] == "MS SQL"){echo "checked";} ?> type="radio" name="ORACLE_SQL" value="MS SQL">MS SQL&nbsp;&nbsp;<input <?php if($DATABASE_VALUES_RECORD['ORACLE_SQL'] == "Oracle"){echo "checked";} ?> type="radio" name="ORACLE_SQL" value="Oracle">Oracle
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(empty($DATABASE_VALUES_RECORD['ORACLE_SQL_VERSION'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						State required version as well.&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input value="<?php echo $DATABASE_VALUES_RECORD['ORACLE_SQL_VERSION']; ?>" name="ORACLE_SQL_VERSION" size="40" />
					</td>
				</tr>	
				<tr bgcolor="#FFFFF0">
					<td colspan="2" <?php if(empty($DATABASE_VALUES_RECORD['VM_MEMORY'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What are the application memory (RAM) requirements (GBs)?<br>
						<center><textarea rows="2" cols="70" name="VM_MEMORY" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['VM_MEMORY']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan="2" <?php if(empty($DATABASE_VALUES_RECORD['VM_CPU'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What are the application CPU requirements (# of cores, speed)?<br>
						<center><textarea rows="2" cols="70" name="VM_CPU" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['VM_CPU']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2 >
						If this is a high transaction database, estimate the average number of transactions per hour.
						<center><textarea rows="2" cols="70" name="VM_VOLUME" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['VM_VOLUME']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(!isset($DATABASE_VALUES_RECORD['ORACLE_FLAG'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Will Oracle Client be required?
					</td>
					<td>
						<input <?php if($DATABASE_VALUES_RECORD['ORACLE_FLAG'] == "1"){echo "checked";} ?> type="radio" name="ORACLE_FLAG" value="1">Yes&nbsp;&nbsp;<input <?php if($DATABASE_VALUES_RECORD['ORACLE_FLAG'] == "0"){echo "checked";} ?> type="radio" name="ORACLE_FLAG" value="0">No
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(isset($DATABASE_VALUES_RECORD['ORACLE_FLAG']) && $DATABASE_VALUES_RECORD['ORACLE_FLAG']=="1" && empty($DATABASE_VALUES_RECORD['ORACLE_VERSION'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						&nbsp;&nbsp;&nbsp;If yes, what version?
					</td>
					<td>
						<input value="<?php echo $DATABASE_VALUES_RECORD['ORACLE_VERSION']; ?>" name="ORACLE_VERSION" size="40" />
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['INSTALL_CONTACT'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Process Information Management installs database binaries on dabase servers.  Who will be installing the database?
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2>
						<center>
							<input <?php if($DATABASE_VALUES_RECORD['INSTALL_CONTACT'] == "ITMS DBA"){echo "checked";} ?> type="radio" name="INSTALL_CONTACT" value="ITMS DBA">ITMS DBA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input <?php if($DATABASE_VALUES_RECORD['INSTALL_CONTACT'] == "Vendor"){echo "checked";} ?> type="radio" name="INSTALL_CONTACT" value="Vendor">Vendor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input <?php if(!empty($DATABASE_VALUES_RECORD['INSTALL_CONTACT']) && ($DATABASE_VALUES_RECORD['INSTALL_CONTACT'] != "ITMS DBA" && $DATABASE_VALUES_RECORD['INSTALL_CONTACT'] != "Vendor")){echo "checked";} ?> type="radio" name="INSTALL_CONTACT" value="Other">Other:&nbsp;<input name="INSTALL_CONTACT_OTHER" size="40" value="<?php if(!empty($DATABASE_VALUES_RECORD['INSTALL_CONTACT']) && ($DATABASE_VALUES_RECORD['INSTALL_CONTACT'] != "ITMS DBA" && $DATABASE_VALUES_RECORD['INSTALL_CONTACT'] != "Vendor")){echo $DATABASE_VALUES_RECORD['INSTALL_CONTACT'];} ?>">
						</center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(!isset($DATABASE_VALUES_RECORD['VENDOR_FLAG'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Will vendors require access?
					</td>
					<td>
						<input <?php if($DATABASE_VALUES_RECORD['VENDOR_FLAG'] == "1"){echo "checked";} ?> type="radio" name="VENDOR_FLAG" value="1">Yes&nbsp;&nbsp;<input <?php if($DATABASE_VALUES_RECORD['VENDOR_FLAG'] == "0"){echo "checked";} ?> type="radio" name="VENDOR_FLAG" value="0">No
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(isset($DATABASE_VALUES_RECORD['VENDOR_FLAG']) && $DATABASE_VALUES_RECORD['VENDOR_FLAG']=="1" && empty($DATABASE_VALUES_RECORD['VENDOR_DETAIL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						&nbsp;&nbsp;&nbsp;If so, detail access and access method.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<center><textarea rows="2" cols="70" name="VENDOR_DETAIL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['VENDOR_DETAIL']; ?></textarea></center>
					</td>
				</tr>	
			</table>
			<h2>Database Hosting Storage and Backup</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['THREE_MONTHS_STORAGE'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What amount of storage (GB) is required for the first three months? 
						<center><textarea rows="2" cols="70" name="THREE_MONTHS_STORAGE" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['THREE_MONTHS_STORAGE']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['FIRST_YEAR_STORAGE'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What amount of storage (GB) is required for the first year?
						<center><textarea rows="2" cols="70" name="FIRST_YEAR_STORAGE" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['FIRST_YEAR_STORAGE']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['VM_GROWTH'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What is the projected percentage of growth per year?
						<center><textarea rows="2" cols="70" name="VM_GROWTH" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['VM_GROWTH']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2 >
						Will a particular level of data classification be required (e.g. confidential, sensitive, public)?
						<center><textarea rows="2" cols="70" name="DATA_CLASS_DETAIL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['DATA_CLASS_DETAIL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(!isset($DATABASE_VALUES_RECORD['STANDBY_FLAG'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Will a standby database be required?
					</td>
					<td>
						<input <?php if($DATABASE_VALUES_RECORD['STANDBY_FLAG'] == "1"){echo "checked";} ?> type="radio" name="STANDBY_FLAG" value="1">Yes&nbsp;&nbsp;<input <?php if($DATABASE_VALUES_RECORD['STANDBY_FLAG'] == "0"){echo "checked";} ?> type="radio" name="STANDBY_FLAG" value="0">No
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2>
						Detail database backup requirements.
						<center><textarea rows="2" cols="70" name="BACKUP_REQUIREMENTS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['BACKUP_REQUIREMENTS']; ?></textarea></center>
						Refer to the <a href="http://www.it.northwestern.edu/bin/docs/cyb/OracleBackup.pdf" target="_blank" >Database Backup standards</a> document.&nbsp;&nbsp;
					</td>
				</tr>
			</table>
			<h2>Database Hosting Firewall Information</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan="2">
						What is the source IP address(es) and port(s) that connections will be coming from?<br>
						<center><textarea rows="2" cols="70" name="SOURCE_IP" wrap="physical"  style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['SOURCE_IP']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan="2" >
						If the destination IP address(es) and port(s) are different than the source, what are the destination IP Address(es) and port(s) that connections will be going to?
						<center><textarea rows="2" cols="70" name="DESTINATION_IP" wrap="physical"  style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['DESTINATION_IP']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['IP_DESCRIPTION'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Describe the general connectivity requirements to and from the requested server.
						<center><textarea rows="2" cols="70" name="IP_DESCRIPTION" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['IP_DESCRIPTION']; ?></textarea></center>
					</td>
				</tr>
			</table>
			<h2>Database Hosting Attachments</h2>
			<table style="width:650px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2>
						Attach additional documentation if needed: (e.g. technical specifications, vendor requirements, etc.)<br>&nbsp;
						<center style="margin:0;padding:0;">
						<div style="display:inline;margin:0;padding:0;" name="FILE1" id="FILE1">
							<input size='70' id="VM_FILES1" name="VM_FILES1" type="file" />
						</div>
						<div style="display:inline;margin:0;padding:0;" name="REMOVE1" id="REMOVE1">
							<input type="button" onclick="addfile(1)" style='width:75px' onclick="remove(1);" value="Attach" />
						</div>
						<div style="display:inline;margin:0;padding:0;" id="SHOW_FILES1"></div>
						<input type="hidden" id="NUMBER_OF_FILES" name="NUMBER_OF_FILES"/>
						</center>
						&nbsp;<br><i>Click</i> the <b>Attach</b> button after choosing each file(s).  Maximum per file upload limit per file is 25MB.
						<?php if (isset($NUMBER_OF_FILES) && !empty($NUMBER_OF_FILES) && $NUMBER_OF_FILES > 0) { ?>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2>
						Files Uploaded:<br>
						<?php
							$temp = $VM_FILES;
							$UPLOADED_VM_FILES = explode(",",$temp);
							$UPLOADED_NUMBER_OF_FILES = $NUMBER_OF_FILES;
							for ( $i = 0; $i < $UPLOADED_NUMBER_OF_FILES; $i++) {
								$FILE_NAME =  explode("/",$UPLOADED_VM_FILES[$i]);
								echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='UPLOADED_VM_FILES".$i."' value='".$UPLOADED_VM_FILES[$i]."' />&nbsp;&nbsp;&nbsp;&nbsp;
								<a href='https://software.northwestern.edu/server_hosting/virtual/".$UPLOADED_VM_FILES[$i]."' target='_blank'>".$FILE_NAME[1]."</a>";
							}
						?>
						<br><br>To remove a file, select a checkbox and then click save.
						<?php ;} ?>
					</td>
				</tr>
			</table>
			<h2>Additional Information/Comments:</h2>
			<table style="width:650px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2>
						Provide any additional information or comments that you feel may be helpful in describing your hosting needs.<br>
						<center><textarea rows="2" cols="70" name="VM_COMMENTS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['VM_COMMENTS']; ?></textarea></center>
					</td>
				</tr>
			</table>
			<h2>Database Hosting Monitoring</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(!isset($DATABASE_VALUES_RECORD['MONITORING_FLAG'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						Do you require service monitoring?
						<font color="black" style="font-weight:normal;margin-left:250px;"><input <?php if(isset($DATABASE_VALUES_RECORD['MONITORING_FLAG']) && $DATABASE_VALUES_RECORD['MONITORING_FLAG'] == "1"){echo "checked";} ?> type="radio" name="MONITORING_FLAG" value="1" onclick="show();">Yes&nbsp;&nbsp;<input <?php if(isset($DATABASE_VALUES_RECORD['MONITORING_FLAG']) && $DATABASE_VALUES_RECORD['MONITORING_FLAG'] == "0"){echo "checked";} ?> type="radio" name="MONITORING_FLAG" value="0" onclick="hide();">No</font>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0" name="MONITORING1" id="MONITORING1">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['MONITORING_NAME_NETID'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List name(s) and NetID(s) of monitoring alert contacts.<br>
						<center><textarea rows="2" cols="70" name="MONITORING_NAME_NETID" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['MONITORING_NAME_NETID']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd" name="MONITORING2" id="MONITORING2">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['MONITORING_EMAIL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List notification e-mail address(es).<br>
						<center><textarea rows="2" cols="70" name="MONITORING_EMAIL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['MONITORING_EMAIL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0" name="MONITORING3" id="MONITORING3">
					<td colspan=2 <?php if(empty($DATABASE_VALUES_RECORD['MONITORING_CELL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List mobile carrier(s) and cell number(s) for text message alerts.<br>
						<center><textarea rows="2" cols="70" name="MONITORING_CELL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $DATABASE_VALUES_RECORD['MONITORING_CELL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd" name="MONITORING4" id="MONITORING4">
					<td <?php if(empty($DATABASE_VALUES_RECORD['MONITORING_NOTIFY'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Choose a Monitoring Alert service notification period:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input <?php if($DATABASE_VALUES_RECORD['MONITORING_NOTIFY'] == "7x24"){echo "checked";} ?> type="radio" name="MONITORING_NOTIFY" value="7x24">7x24&nbsp;&nbsp;<input <?php if($DATABASE_VALUES_RECORD['MONITORING_NOTIFY'] == "Monday-Friday 8am to 6pm"){echo "checked";} ?> type="radio" name="MONITORING_NOTIFY" value="Monday-Friday 8am to 6pm">Monday-Friday 8am to 6pm
					</td>
				</tr>
			</table><br>
			<input type="hidden" name="VM_TYPE" value="<? echo $DATABASE_VALUES_RECORD['VM_TYPE'] ?>" />
			<input type="hidden" id="ELSEWHERE" name="ELSEWHERE" value="" />
			<input type="hidden" name="DIRECTION" value="" />
			<input type="hidden" name="ACTION" value="POST DATABASE" />
			<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
			<input type="hidden" name="PAGE" value="PROCESSING" />
			<input type="hidden" name="VM_ORDER_DETAIL_ID" value="<? echo $VM_ORDER_DETAIL_ID; ?>" />
			</form>
			<table style="display:inline;padding:0;margin:0;">
				<tr>
					<td width="250px">
					</td>
					<td width="400px" style="text-align:right;">
						&nbsp;<input type="button" style="display:inline;" onclick="prev();" value="&laquo; Save & Previous" />
						&nbsp;<input type="button" style="display:inline;" onclick="validate_form();" value="Save" />
						&nbsp;<input type="button" style="display:inline;" onclick="next();" <?php if ($NUM==0) { echo" disabled ";} ?> value="Save & Next &raquo;" />
					</td>
				</tr>
			</table>			
		</td>
	</tr>
</table>
<br>&nbsp;<? if(!isset($DATABASE_VALUES_RECORD['MONITORING_FLAG']) || empty($DATABASE_VALUES_RECORD['MONITORING_FLAG']) || $DATABASE_VALUES_RECORD['MONITORING_FLAG']==0){
	echo "<script type='text/javascript'> 				
		document.getElementById('MONITORING1').style.display='none';
		document.getElementById('MONITORING2').style.display='none';
		document.getElementById('MONITORING3').style.display='none';
		document.getElementById('MONITORING4').style.display='none'; 
	</script>"; 
} ?><br></div>