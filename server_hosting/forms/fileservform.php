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
				if (document.fileservForm.VM_NAME.value==null||document.fileservForm.VM_NAME.value==""){
					alert("File server request name must be filled out.");
					document.fileservForm.VM_NAME.focus();
				} 
				else {
					document.fileservForm.DIRECTION.value = 'PREV';
					document.fileservForm.submit();
				}
			}
		</script>
		<script type="text/javascript">
			function validate_form() {
				if (document.fileservForm.VM_NAME.value==null||document.fileservForm.VM_NAME.value==""){
					alert("Database Hosting Request Name name must be filled out.");
					document.fileservForm.VM_NAME.focus();
				} 
				else {
					document.fileservForm.DIRECTION.value = 'SAVE';
					document.getElementById("fileservForm").submit();
				}
			}
		</script>
<?php
		$NEXT_VM_DETAIL_VALUES = mysql_query("
			SELECT * 
			FROM VM_ORDER_DETAIL
			WHERE (VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE != 'Application' AND VM_TYPE != 'Database' AND VM_TYPE != 'Fileserv') OR (VM_ORDER_ID = '$VM_ORDER_ID' && VM_ORDER_DETAIL_ID > '$VM_ORDER_DETAIL_ID' && VM_TYPE = 'Fileserv')
			ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
			")or die(mysql_error());
		$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES); 
		if ($NUM!=0) { ?>
		<script type="text/javascript">
			function next() {
				if (document.fileservForm.VM_NAME.value==null||document.fileservForm.VM_NAME.value==""){
					alert("File server request name must be filled out.");
					document.fileservForm.VM_NAME.focus();
				} 
				else {
					document.fileservForm.DIRECTION.value = 'NEXT';
					document.fileservForm.submit();
				}
			}
		</script>
		<?php ;} ?>
<table style="width:650px;border:3px solid #AAAAAA;margin:0px;">
	<tr>
		<td style="padding:10px;padding-top:0px;margin:0;padding-bottom:0px;">	
		
		
<?php
				$FILESERV_COMPLETE = mysql_query("
					SELECT * 
					FROM VM_ORDER_DETAIL
					WHERE VM_ORDER_ID = '$VM_ORDER_ID' AND VM_TYPE = 'Fileserv' AND VM_ORDER_DETAIL_ID <> '$VM_ORDER_DETAIL_ID' and COMPLETE_FLAG = '1'
					ORDER BY VM_ORDER_DETAIL_ID
				")or die(mysql_error());
				$NUM_COMPLETE = mysql_num_rows($FILESERV_COMPLETE);
				$COUNT = $NUM_COMPLETE;
				$FILESERV_COMPLETE_ARRAY = array(); 
				while ($FILESERV_COMPLETE_ROW = mysql_fetch_array($FILESERV_COMPLETE ))
				{ 
					$FILESERV_COMPLETE_ARRAY[$FILESERV_COMPLETE_ROW['VM_ORDER_DETAIL_ID']] = $FILESERV_COMPLETE_ROW;
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
								<p nowrap style="display:inline; margin:0; padding:0;vertical-align:-25%">Complete File Server(s)</p>
							</b><br>
							<?php foreach ($FILESERV_COMPLETE_ARRAY as $VM_ORDER_DETAIL_ID => $FILESERV_COMPLETE_RECORD) {							
								if ($COUNT == "1" ) echo '<img style="display:inline; margin:0; padding:0;" src="images/tree-L.png" alt="" align="top">';
								else echo '<img style="display:inline; margin:0; padding:0;" src="images/tree-T.png" alt="" align="top">'; ?>
								<form name="autoPOP<?php echo $FILESERV_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>" id="autoPOP<?php echo $FILESERV_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>" action="index.php" method="post">
									<input type="hidden" name="PAGE" value="APPLICATION" />
									<input type='hidden' name='VM_TYPE' value='Fileserv' />
									<input type='hidden' name='VM_ORDER_ID' value='<?php echo $_POST['VM_ORDER_ID']; ?>' />
									<input type='hidden' name='VM_ORDER_DETAIL_ID' value='<?php echo $_POST['VM_ORDER_DETAIL_ID']; ?>' />
									<input type='hidden' name='POP_VM_ORDER_DETAIL_ID' value='<?php echo $FILESERV_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>' />
									<input type='hidden' name='MESG' value='<font color="#308014">Current request type was auto populated.</font><br>' />
								</form>
							<a  href="#"  style="text-decoration:none;display:inline;" onclick="if (confirm_autopop('autoPOP<?php echo $FILESERV_COMPLETE_RECORD['VM_ORDER_DETAIL_ID'] ?>','<?php echo $FILESERV_COMPLETE_RECORD['VM_NAME']; ?>'))document.autoPOP<?php echo $FILESERV_COMPLETE_RECORD['VM_ORDER_DETAIL_ID']; ?>.submit()"><?php echo $FILESERV_COMPLETE_RECORD['VM_NAME']; ?></a><br>
					<?php $COUNT--;} 
					?><b><a href="#" style="" onclick="init()">Close</a></b></b></td></tr></table></div><br><?php
				;} ?>
				</div>
				<?php 
					$VM_ORDER_DETAIL_ID = $_POST['VM_ORDER_DETAIL_ID'];
					$FILESERV_VALUES = mysql_query("
						SELECT * 
						FROM VM_ORDER_DETAIL
						WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID'
					")or die(mysql_error()); 
					$FILESERV_VALUES_RECORD = mysql_fetch_array($FILESERV_VALUES) or die(mysql_error()); 
					$NUMBER_OF_FILES = $FILESERV_VALUES_RECORD['NUMBER_OF_FILES'];
					$VM_FILES = $FILESERV_VALUES_RECORD['VM_FILES'];
					if (isset($_POST['POP_VM_ORDER_DETAIL_ID'])){
						$VM_NAME= $FILESERV_VALUES_RECORD['VM_NAME'];
						$POP_VM_ORDER_DETAIL_ID = $_POST['POP_VM_ORDER_DETAIL_ID'];
						$FILESERV_VALUES = mysql_query("
							SELECT * 
							FROM VM_ORDER_DETAIL
							WHERE VM_ORDER_DETAIL_ID = '$POP_VM_ORDER_DETAIL_ID'
						")or die(mysql_error()); 
						$FILESERV_VALUES_RECORD = mysql_fetch_array($FILESERV_VALUES) or die(mysql_error()); 
					}
				?>
		
		
		
			<form action="index.php" method="post" id="fileservForm" name="fileservForm" enctype="multipart/form-data">	
			<table style="display:inline;padding:0;margin:0;">
				<tr>
					<td width="250px">
						<h2 style="margin-bottom:7px;padding:0;">File Server Specifics</h2>
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
					<td <?php if(empty($FILESERV_VALUES_RECORD['VM_NAME'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >File Server Requested Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input id="VM_NAME" name="VM_NAME" size="40" value="<?php if (isset($_POST['POP_VM_ORDER_DETAIL_ID'])) { echo $VM_NAME; } else {echo $FILESERV_VALUES_RECORD['VM_NAME']; }?>" /></td>
				</tr>
				<tr>
					<td colspan=2 bgcolor="#FFFFF0">
						List the following information for the primary file server contact.
					</td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary Contact Name:</td>
					<td><input value="<?php echo $FILESERV_VALUES_RECORD['FILESERV_ADMIN_NAME']; ?>" name="FILESERV_ADMIN_NAME" size="40" /></td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary Contact Department:</td>
					<td><input value="<?php echo $FILESERV_VALUES_RECORD['FILESERV_ADMIN_DEPT']; ?>" name="FILESERV_ADMIN_DEPT" size="40" /></td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary Contact Phone Number:</td>
					<td><input value="<?php echo $FILESERV_VALUES_RECORD['FILESERV_ADMIN_PHONE']; ?>" onchange='checkPhone(this)' name="FILESERV_ADMIN_PHONE" size="40" /></td>
				</tr>
				<tr  bgcolor="#FFFFF0">
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary Contact E-mail:</td>
					<td><input value="<?php echo $FILESERV_VALUES_RECORD['FILESERV_ADMIN_EMAIL']; ?>" onchange='checkEmail(this)' name="FILESERV_ADMIN_EMAIL" size="40" /></td>
				</tr>
				<tr>
					<td colspan=2 bgcolor="#dddddd" <?php if(empty($FILESERV_VALUES_RECORD['VM_CHARACTERISTICS'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Describe what functions this file server will fulfill.
						<center><textarea rows="2" cols="70" name="VM_CHARACTERISTICS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['VM_CHARACTERISTICS']; ?></textarea></center>
						<font style='color:black;font-weight:normal;'>(Attach additional documentation if needed.)</font>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td nowrap <?php if(!isset($FILESERV_VALUES_RECORD['VM_DEPENDENT'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Are there any dependencies on other systems?
					</td>
					<td>
						<input <?php if($FILESERV_VALUES_RECORD['VM_DEPENDENT'] == "1"){echo "checked";} ?> type="radio" name="VM_DEPENDENT" value="1">Yes&nbsp;&nbsp;<input <?php if($FILESERV_VALUES_RECORD['VM_DEPENDENT'] == "0"){echo "checked";} ?> type="radio" name="VM_DEPENDENT" value="0">No
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td <?php if(isset($FILESERV_VALUES_RECORD['VM_DEPENDENT']) && $FILESERV_VALUES_RECORD['VM_DEPENDENT']=="1" && empty($FILESERV_VALUES_RECORD['VM_DEPENDENT_DETAIL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> colspan="2" >
						&nbsp;&nbsp;&nbsp;If yes, describe.<br>
						<center><textarea rows="2" cols="70" name="VM_DEPENDENT_DETAIL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['VM_DEPENDENT_DETAIL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(empty($FILESERV_VALUES_RECORD['VM_MEMORY'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> colspan="2">
						What are the application memory (RAM) requirements (GBs)?<br>
						<center><textarea rows="2" cols="70" name="VM_MEMORY" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['VM_MEMORY']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td <?php if(empty($FILESERV_VALUES_RECORD['VM_CPU'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> colspan="2">
						What are the application CPU requirements (# of cores, speed)?<br>
						<center><textarea rows="2" cols="70" name="VM_CPU" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['VM_CPU']; ?></textarea></center>
					</td>
				</tr>
			</table>
			<h2>File Server Access</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['NUM_USERS'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						Number of users who will require simultaneous access to the file server?&nbsp;&nbsp;&nbsp;
						<input value="<?php echo $FILESERV_VALUES_RECORD['NUM_USERS']; ?>" name="NUM_USERS" size=15 />
					</td>
				</tr>
								<tr bgcolor="#FFFFF0">
					<td width="225px" style="<?php if(!isset($FILESERV_VALUES_RECORD['USER_COMMUNITY']) || empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) || $FILESERV_VALUES_RECORD['USER_COMMUNITY'] == "none,none,none,none,none," || $FILESERV_VALUES_RECORD['USER_COMMUNITY'] == ",,,,,") echo "color: #CC1100;font-weight:bold;"; ?>padding-top:0px;text-align:left;vertical-align:text-top;" nowrap>
						What user communities will need access?<br><font style='color:black;font-weight:normal;'>(Check all that apply.)</font>
					</td>
					<td>
						<?php
							$temp = $FILESERV_VALUES_RECORD['USER_COMMUNITY'];
							$USER_COMMUNITY = explode(",",$temp);
						?>
						<table>
							<tr>
								<td>
									<input <?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && 
										($USER_COMMUNITY[0] == "ITMS Developers" ||
										$USER_COMMUNITY[1] == "ITMS Developers" ||
										$USER_COMMUNITY[2] == "ITMS Developers" ||
										$USER_COMMUNITY[3] == "ITMS Developers" ||
										$USER_COMMUNITY[4] == "ITMS Developers")
									){echo "checked";} ?> type="checkbox" name="USER_COMMUNITY[]" value="ITMS Developers">ITMS Developers&nbsp;&nbsp;
								</td>
								<td>
									<input <?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && 
										($USER_COMMUNITY[0] == "Departmental /School IT" ||
										$USER_COMMUNITY[1] == "Departmental /School IT" ||
										$USER_COMMUNITY[2] == "Departmental /School IT" ||
										$USER_COMMUNITY[3] == "Departmental /School IT" ||
										$USER_COMMUNITY[4] == "Departmental /School IT")
									){echo "checked";} ?> type="checkbox" name="USER_COMMUNITY[]" value="Departmental /School IT">Departmental /School IT
								</td>
							</tr>
							<tr>
								<td>
									<input <?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && 
										($USER_COMMUNITY[0] == "NU Community" ||
										$USER_COMMUNITY[1] == "NU Community" ||
										$USER_COMMUNITY[2] == "NU Community" ||
										$USER_COMMUNITY[3] == "NU Community" ||
										$USER_COMMUNITY[4] == "NU Community")
									){echo "checked";} ?> type="checkbox" name="USER_COMMUNITY[]" value="NU Community">NU Community&nbsp;&nbsp;
								</td>
								<td>
									<input <?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && 
										($USER_COMMUNITY[0] == "Vendors" ||
										$USER_COMMUNITY[1] == "Vendors" ||
										$USER_COMMUNITY[2] == "Vendors" ||
										$USER_COMMUNITY[3] == "Vendors" ||
										$USER_COMMUNITY[4] == "Vendors")
									){echo "checked";} ?> type="checkbox" name="USER_COMMUNITY[]" value="Vendors">Vendors
								</td>
							</tr>
							<tr>
								<td colspan=2  <?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && empty($USER_COMMUNITY[5]) &&
										($USER_COMMUNITY[0] == "Other" ||
										$USER_COMMUNITY[1] == "Other" ||
										$USER_COMMUNITY[2] == "Other" ||
										$USER_COMMUNITY[3] == "Other" ||
										$USER_COMMUNITY[4] == "Other")) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
									<input <?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && 
										($USER_COMMUNITY[0] == "Other" ||
										$USER_COMMUNITY[1] == "Other" ||
										$USER_COMMUNITY[2] == "Other" ||
										$USER_COMMUNITY[3] == "Other" ||
										$USER_COMMUNITY[4] == "Other")
									){echo "checked";} ?> type="checkbox" name="USER_COMMUNITY[]" value="Other">Other&nbsp;&nbsp;(List:
									<input name="USER_COMMUNITY_OTHER" size="35" value="<?php if(!empty($FILESERV_VALUES_RECORD['USER_COMMUNITY']) && 
										($USER_COMMUNITY[0] == "Other" ||
										$USER_COMMUNITY[1] == "Other" ||
										$USER_COMMUNITY[2] == "Other" ||
										$USER_COMMUNITY[3] == "Other" ||
										$USER_COMMUNITY[4] == "Other")
									){ 
										$x = count($USER_COMMUNITY);
										if ($x == 6) { echo $USER_COMMUNITY[5]; }
										elseif ($x > 6) { 
											$USER_COMMUNITY_OTHER = "";
											for($i = 5; $i<$x; $i++) { 
												if ($i == 5) {
													$USER_COMMUNITY_OTHER .= $USER_COMMUNITY[$i];
												} else {
													$USER_COMMUNITY_OTHER .= "," . $USER_COMMUNITY[$i];
												}
											}
											echo $USER_COMMUNITY_OTHER;
										}
									} ?>" />)
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td style="padding-top:0px;" colspan=2>
						Will anyone require root or admin access to the server? If so, list name(s) and NetID(s).<br>
						<center><textarea rows="1" cols="70" name="ROOT_ACCESS_USERS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['ROOT_ACCESS_USERS']; ?></textarea></center>
					</td>
				</tr>
			</table>
			<h2>File Server FTP Requirements</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2>
						Is File Transfer Protocol (SFTP) required?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input <?php if($FILESERV_VALUES_RECORD['FTP_FLAG'] == "1"){echo "checked";} ?> type="radio" name="FTP_FLAG" value="1">Yes&nbsp;&nbsp;<input <?php if($FILESERV_VALUES_RECORD['FTP_FLAG'] == "0"){echo "checked";} ?> type="radio" name="FTP_FLAG" value="0">No
					</td>
				</tr>
			</table>
			<h2>File Server Storage and Backup</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['THREE_MONTHS_STORAGE'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What amount of storage (GB) is required for the first three months?
						<center><textarea rows="2" cols="70" name="THREE_MONTHS_STORAGE" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['THREE_MONTHS_STORAGE']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['FIRST_YEAR_STORAGE'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What amount of storage (GB) is required for the first year?
						<center><textarea rows="2" cols="70" name="FIRST_YEAR_STORAGE" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['FIRST_YEAR_STORAGE']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['VM_GROWTH'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What is the projected percentage of growth per year?
						<center><textarea rows="2" cols="70" name="VM_GROWTH" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['VM_GROWTH']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2>
						Our Backup Standard is weekly full backup with a two week incremental rotation; full backups are retained for 29 days. If this does not meet your needs, detail backup requirements.
						<center><textarea rows="2" cols="70" name="BACKUP_REQUIREMENTS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['BACKUP_REQUIREMENTS']; ?></textarea></center>
					</td>
				</tr>
			</table>
			<h2>File Server Firewall Information</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td  colspan="2">
						What is the source IP address(es) and port(s) that connections will be coming from?<br>
						<center><textarea rows="2" cols="70" name="SOURCE_IP" wrap="physical"  style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['SOURCE_IP']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan="2" >
						If the destination IP address(es) and port(s) are different than the source, what are the destination IP Address(es) and port(s) that connections will be going to?
						<center><textarea rows="2" cols="70" name="DESTINATION_IP" wrap="physical"  style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['DESTINATION_IP']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['IP_DESCRIPTION'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Describe the general connectivity requirements to and from the requested server.
						<center><textarea rows="2" cols="70" name="IP_DESCRIPTION" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['IP_DESCRIPTION']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td >
						Will System Administrators require <a href="http://www.it.northwestern.edu/oncampus/vpn/sslvpn/" target="_blank">SSL VPN</a>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input <?php if($FILESERV_VALUES_RECORD['SSL_VP_FLAG'] == "1"){echo "checked";} ?> type="radio" name="SSL_VP_FLAG" value="1">Yes&nbsp;&nbsp;<input <?php if($FILESERV_VALUES_RECORD['SSL_VP_FLAG'] == "0"){echo "checked";} ?> type="radio" name="SSL_VP_FLAG" value="0">No
					</td>
				</tr>
			</table>
			<h2>File Server Attachments</h2>
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
						Provide any additional information or comments that you feel may be helpful in describing your hosting needs.  Attach additional files if needed.<br>
						<center><textarea rows="2" cols="70" name="VM_COMMENTS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['VM_COMMENTS']; ?></textarea></center>
					</td>
				</tr>
			</table><h2>File Server Monitoring</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(!isset($FILESERV_VALUES_RECORD['MONITORING_FLAG'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						Do you require service monitoring?
						<font color="black" style="font-weight:normal;margin-left:250px;"><input <?php if(isset($FILESERV_VALUES_RECORD['MONITORING_FLAG']) && $FILESERV_VALUES_RECORD['MONITORING_FLAG'] == "1"){echo "checked";} ?> type="radio" name="MONITORING_FLAG" value="1" onclick="show();">Yes&nbsp;&nbsp;<input <?php if(isset($FILESERV_VALUES_RECORD['MONITORING_FLAG']) && $FILESERV_VALUES_RECORD['MONITORING_FLAG'] == "0"){echo "checked";} ?> type="radio" name="MONITORING_FLAG" value="0" onclick="hide();">No</font>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0" name="MONITORING1" id="MONITORING1">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['MONITORING_NAME_NETID'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List name(s) and NetID(s) of monitoring alert contacts.<br>
						<center><textarea rows="2" cols="70" name="MONITORING_NAME_NETID" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['MONITORING_NAME_NETID']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd" name="MONITORING2" id="MONITORING2">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['MONITORING_EMAIL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List notification e-mail address(es).<br>
						<center><textarea rows="2" cols="70" name="MONITORING_EMAIL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['MONITORING_EMAIL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0" name="MONITORING3" id="MONITORING3">
					<td colspan=2 <?php if(empty($FILESERV_VALUES_RECORD['MONITORING_CELL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List mobile carrier(s) and cell number(s) for text message alerts.<br>
						<center><textarea rows="2" cols="70" name="MONITORING_CELL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $FILESERV_VALUES_RECORD['MONITORING_CELL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd" name="MONITORING4" id="MONITORING4">
					<td <?php if(empty($FILESERV_VALUES_RECORD['MONITORING_NOTIFY'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Choose a Monitoring Alert service notification period:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input <?php if($FILESERV_VALUES_RECORD['MONITORING_NOTIFY'] == "7x24"){echo "checked";} ?> type="radio" name="MONITORING_NOTIFY" value="7x24">7x24&nbsp;&nbsp;<input <?php if($FILESERV_VALUES_RECORD['MONITORING_NOTIFY'] == "Monday-Friday 8am to 6pm"){echo "checked";} ?> type="radio" name="MONITORING_NOTIFY" value="Monday-Friday 8am to 6pm">Monday-Friday 8am to 6pm
					</td>
				</tr>
			</table><br>
			<input type="hidden" name="VM_TYPE" value="<? echo $FILESERV_VALUES_RECORD['VM_TYPE'] ?>" />
			<input type="hidden" id="ELSEWHERE" name="ELSEWHERE" value="" />
			<input type="hidden" name="DIRECTION" value="" />
			<input type="hidden" name="PAGE" value="PROCESSING" />
			<input type="hidden"  name="ACTION" value="POST FILESERV" />
			<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
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
<br>&nbsp;<? if(!isset($FILESERV_VALUES_RECORD['MONITORING_FLAG']) || empty($FILESERV_VALUES_RECORD['MONITORING_FLAG']) || $FILESERV_VALUES_RECORD['MONITORING_FLAG']==0){
	echo "<script type='text/javascript'> 				
		document.getElementById('MONITORING1').style.display='none';
		document.getElementById('MONITORING2').style.display='none';
		document.getElementById('MONITORING3').style.display='none';
		document.getElementById('MONITORING4').style.display='none'; 
	</script>"; 
} ?><br></div>