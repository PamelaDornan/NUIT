<?php 
$CONTACT_VALUES = mysql_query("
	SELECT * 
	FROM VM_ORDER
	WHERE VM_ORDER_ID = '$VM_ORDER_ID'
")or die(mysql_error()); 
$CONTACT_VALUES_RECORD = mysql_fetch_array($CONTACT_VALUES) or die(mysql_error());
$APPLICATION_VALUES = mysql_query("
	SELECT * 
	FROM VM_ORDER_DETAIL
	WHERE VM_ORDER_DETAIL_ID = '$VM_ORDER_DETAIL_ID'
")or die(mysql_error()); 
$APPLICATION_VALUES_RECORD = mysql_fetch_array($APPLICATION_VALUES) or die(mysql_error()); 
$NUMBER_OF_FILES = $APPLICATION_VALUES_RECORD['NUMBER_OF_FILES'];
$VM_FILES = $APPLICATION_VALUES_RECORD['VM_FILES'];
?>
<div style="width:680px;float:left;">
<p>Complete the required fields indicated in <font style="color: #CC1100;font-weight:bold;">RED</font> below.  You may complete the form in one session or save changes and add data at a later time.  A Submit option will appear once you have saved the form and all required fields are completed.</p>
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
			function validate_guest_form() {
				if (document.guestForm.PROJECT_NAME.value==null||document.guestForm.PROJECT_NAME.value==""){
					alert("Project name must be filled out.");
					document.guestForm.PROJECT_NAME.focus();
				} 
				else {
					document.getElementById("guestForm").submit();
				}
			}
		</script>
<div id="POP" style="display:inline;margin:0;padding:0;"></div><div id="LINKPOP" style="display:inline;margin:0;padding:0;"></div>
<form action="index.php" method="post" id="guestForm" name="guestForm" onsubmit="return validate_form(this)" style="margin:0;padding:0;display:inline;" enctype="multipart/form-data">
<table style="width:650px;border:3px solid #AAAAAA;margin:0px;">
	<tr>
		<td style="padding:10px;padding-top:0px;margin:0;padding-bottom:0px;">	
			<table style="display:inline;padding:0;margin:0;"><tr><td width="600px"><h2 style="margin-bottom:7px;padding:0;">Guest Hosting Project Name&nbsp;&nbsp;&nbsp;</h2></td><td><input type="button" style="float:right;display:inline;" onclick="validate_guest_form();" value="Save" /></td></tr></table>
				<table CELLPADDING=2 style="width:650px;margin-bottom:10px;margin-left:5px;border-collapse:collapse;border:1px solid #dddddd;">
					<tr>
						<td bgcolor=#dddddd style="padding:5px;width:225px;">
							<input name="PROJECT_NAME" maxlength="50" size="94" value="<?php echo $CONTACT_VALUES_RECORD['PROJECT_NAME'];	?>" />
						</td>
					</tr>
				</table>
				<h2>Guest Hosting Primary Contact Information</h2>
				<table CELLPADDING=2 style="width:650px;;margin-bottom:10px;margin-left:5px;border-collapse:collapse;border:1px solid #dddddd;">
					<tr bgcolor=#dddddd>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_NAME'])) echo "color: #CC1100;font-weight:bold;"; ?>padding-top:5px;width:225px; text-align:right;">Contact Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="padding-top:5px;">
							<input name="CONTACT_NAME" size="40" value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_NAME'];	?>" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
					<tr bgcolor=#FFFFF0>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_NETID'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">NetID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><input name="CONTACT_NETID" size="40" value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_NETID']; ?>" /></td>
					</tr>
					<tr bgcolor=#dddddd>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_DEPARTMENT'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">Department/Business Unit:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><input name="CONTACT_DEPARTMENT" size="40" value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_DEPARTMENT']; ?>" /></td>
					</tr>
					<tr bgcolor=#FFFFF0>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_EMAIL'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">E-mail Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><input name="CONTACT_EMAIL" size="40" onchange='checkEmail(this)' value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_EMAIL']; ?>" /></td>
					</tr>
					<tr bgcolor=#dddddd>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_PHONE'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">Phone Number:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="padding-bottom:5px;"><input name="CONTACT_PHONE" onchange='checkPhone(this)' size="40" value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_PHONE']; ?>" /></td>
					</tr>
				</table>		
			<h2>Guest Hosting Specifics</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['VM_VOLUME'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						What is the general purpose of the server?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<center><textarea rows="2" cols="70" name="VM_VOLUME" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['VM_VOLUME']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td <?php if(empty($APPLICATION_VALUES_RECORD['VM_OS'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						What Operating System does the application require?
					</td>
					<td>
						<select name="VM_OS" onchange="osbits(this);">
							<option></option>
							<option <?php if($APPLICATION_VALUES_RECORD['VM_OS'] == "RHEL 5.X"){echo "selected='yes'";} ?> value="RHEL 5.X">RHEL 5.X</option>
							<option <?php if($APPLICATION_VALUES_RECORD['VM_OS'] == "RHEL 6.X"){echo "selected='yes'";} ?> value="RHEL 6.X">RHEL 6.X</option>
							<option <?php if($APPLICATION_VALUES_RECORD['VM_OS'] == "Windows 2008 R2"){echo "selected='yes'";} ?> value="Windows 2008 R2">Windows 2008 R2</option>
							<option <?php if($APPLICATION_VALUES_RECORD['VM_OS'] == "Windows 2008 SR"){echo "selected='yes'";} ?> value="Windows 2008 SR">Windows 2008 (deprecated by R2) Special Request</option>
						</select>
						<input type="hidden" id="VM_OS_BITS" name="VM_OS_BITS" value="<?php if(isset($APPLICATION_VALUES_RECORD['VM_OS_BITS'])) { echo $APPLICATION_VALUES_RECORD['VM_OS_BITS'];} ?>">
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td <?php if(empty($APPLICATION_VALUES_RECORD['VM_MEMORY'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> colspan="2">
						What are the application memory (RAM) requirements (GBs)?<br>
						<center><textarea rows="2" cols="70" name="VM_MEMORY" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['VM_MEMORY']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td <?php if(empty($APPLICATION_VALUES_RECORD['VM_CPU'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> colspan="2">
						What are the application CPU requirements (# of cores, speed)?<br>
						<center><textarea rows="2" cols="70" name="VM_CPU" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['VM_CPU']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2>
						Will anyone require root or admin access to the server?  If so, list name(s) and NetID(s).<br>
						<center><textarea rows="2" cols="70" name="ROOT_ACCESS_USERS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['ROOT_ACCESS_USERS']; ?></textarea></center>
					</td>
				</tr>
			</table>
			
			<h2>Guest Hosting Storage and Backup</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['THREE_MONTHS_STORAGE'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What amount of storage (GB) is required for the first three months?
						<center><textarea rows="2" cols="70" name="THREE_MONTHS_STORAGE" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['THREE_MONTHS_STORAGE']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['FIRST_YEAR_STORAGE'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What amount of storage (GB) is required for the first year?
						<center><textarea rows="2" cols="70" name="FIRST_YEAR_STORAGE" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['FIRST_YEAR_STORAGE']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['VM_GROWTH'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						What is the projected percentage of growth per year?
						<center><textarea rows="2" cols="70" name="VM_GROWTH" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['VM_GROWTH']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan=2>
						Our Backup Standard is weekly full backup with a two week incremental rotation; full backups are retained for 29 days.  If this does not meet your needs, detail backup requirements.&nbsp;&nbsp;
						<center><textarea rows="2" cols="70" name="BACKUP_REQUIREMENTS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['BACKUP_REQUIREMENTS']; ?></textarea></center>
					</td>
				</tr>
			</table>
			
			<h2>Guest Hosting Firewall Information</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan="2" >
						What is the source IP address(es) and port(s) that connections will be coming from?<br>
						<center><textarea rows="2" cols="70" name="SOURCE_IP" wrap="physical"  style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['SOURCE_IP']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td colspan="2" >
						If the destination IP address(es) and port(s) are different than the source, what are the destination IP Address(es) and port(s) that connections will be going to?
						<center><textarea rows="2" cols="70" name="DESTINATION_IP" wrap="physical"  style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['DESTINATION_IP']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['IP_DESCRIPTION'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Describe the general connectivity requirements to and from the requested server.
						<center><textarea rows="2" cols="70" name="IP_DESCRIPTION" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['IP_DESCRIPTION']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0">
					<td>
						Will System Administrators require <a href="http://www.it.northwestern.edu/oncampus/vpn/sslvpn/" target="_blank">SSL VPN</a>?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input <?php if($APPLICATION_VALUES_RECORD['SSL_VP_FLAG'] == "1"){echo "checked";} ?> type="radio" name="SSL_VP_FLAG" value="1">Yes&nbsp;&nbsp;<input <?php if($APPLICATION_VALUES_RECORD['SSL_VP_FLAG'] == "0"){echo "checked";} ?> type="radio" name="SSL_VP_FLAG" value="0">No
					</td>
				</tr>
			</table>
			<h2>Guest Hosting Attachments</h2>
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
						&nbsp;<br><i>Click</i> the <b>Attach</b> button</b> after choosing each file(s).  Maximum per file upload limit is 25MB.
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
			<h2>Additional Information/Comments</h2>
			<table style="width:650px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2>
						Provide any additional information or comments that you feel may be helpful in describing your hosting needs.<br>
						<center><textarea rows="2" cols="70" name="VM_COMMENTS" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['VM_COMMENTS']; ?></textarea></center>
					</td>
				</tr>
			</table>
			<h2>Guest Hosting Monitoring</h2>
			<table style="width:650px;margin-bottom:10px;margin-left:10px;margin-top:0px;border-collapse:collapse;border:1px solid #dddddd;" cellpadding=4>
				<tr bgcolor="#dddddd">
					<td colspan=2 <?php if(!isset($APPLICATION_VALUES_RECORD['MONITORING_FLAG'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						Do you require service monitoring?
						<font color="black" style="font-weight:normal;margin-left:250px;"><input <?php if(isset($APPLICATION_VALUES_RECORD['MONITORING_FLAG']) && $APPLICATION_VALUES_RECORD['MONITORING_FLAG'] == "1"){echo "checked";} ?> type="radio" name="MONITORING_FLAG" value="1" onclick="show();">Yes&nbsp;&nbsp;<input <?php if(isset($APPLICATION_VALUES_RECORD['MONITORING_FLAG']) && $APPLICATION_VALUES_RECORD['MONITORING_FLAG'] == "0"){echo "checked";} ?> type="radio" name="MONITORING_FLAG" value="0" onclick="hide();">No</font>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0" name="MONITORING1" id="MONITORING1">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['MONITORING_NAME_NETID'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List name(s) and NetID(s) of monitoring alert contacts.<br>
						<center><textarea rows="2" cols="70" name="MONITORING_NAME_NETID" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['MONITORING_NAME_NETID']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd" name="MONITORING2" id="MONITORING2">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['MONITORING_EMAIL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List notification e-mail address(es).<br>
						<center><textarea rows="2" cols="70" name="MONITORING_EMAIL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['MONITORING_EMAIL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#FFFFF0" name="MONITORING3" id="MONITORING3">
					<td colspan=2 <?php if(empty($APPLICATION_VALUES_RECORD['MONITORING_CELL'])) echo "style='color: #CC1100;font-weight:bold;'"; ?>>
						List mobile carrier(s) and cell number(s) for text message alerts.<br>
						<center><textarea rows="2" cols="70" name="MONITORING_CELL" wrap="physical" style="text-align:left;vertical-align:top;margin-top:0%;margin-left:0%"><?php echo $APPLICATION_VALUES_RECORD['MONITORING_CELL']; ?></textarea></center>
					</td>
				</tr>
				<tr bgcolor="#dddddd" name="MONITORING4" id="MONITORING4">
					<td <?php if(empty($APPLICATION_VALUES_RECORD['MONITORING_NOTIFY'])) echo "style='color: #CC1100;font-weight:bold;'"; ?> >
						Choose a Monitoring Alert service notification period:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input <?php if($APPLICATION_VALUES_RECORD['MONITORING_NOTIFY'] == "7x24"){echo "checked";} ?> type="radio" name="MONITORING_NOTIFY" value="7x24">7x24&nbsp;&nbsp;<input <?php if($APPLICATION_VALUES_RECORD['MONITORING_NOTIFY'] == "Monday-Friday 8am to 6pm"){echo "checked";} ?> type="radio" name="MONITORING_NOTIFY" value="Monday-Friday 8am to 6pm">Monday-Friday 8am to 6pm
					</td>
				</tr>
			</table><br>
			<input type="hidden" id="ELSEWHERE" name="ELSEWHERE" value="" />
			<input type="hidden" name="ACTION" value="POST GUEST" />
			<input type="hidden" name="PAGE" value="PROCESSING" />
			<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
			<input type="hidden" name="VM_ORDER_DETAIL_ID" value="<? echo $VM_ORDER_DETAIL_ID; ?>" />
			<input type="button" style="float:right;" onclick="validate_guest_form();" value="Save" />
		</td>
	</tr>
</table>
</form>	
<div style="display:inline;">
</div><br>&nbsp;<? if(!isset($APPLICATION_VALUES_RECORD['MONITORING_FLAG']) || empty($APPLICATION_VALUES_RECORD['MONITORING_FLAG']) || $APPLICATION_VALUES_RECORD['MONITORING_FLAG']==0){
	echo "<script type='text/javascript'> 				
		document.getElementById('MONITORING1').style.display='none';
		document.getElementById('MONITORING2').style.display='none';
		document.getElementById('MONITORING3').style.display='none';
		document.getElementById('MONITORING4').style.display='none'; 
	</script>"; 
} ?><br></div>