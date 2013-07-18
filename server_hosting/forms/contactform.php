<?php
$CONTACT_VALUES = mysql_query("
	SELECT * 
	FROM VM_ORDER
	WHERE VM_ORDER_ID = '$VM_ORDER_ID'
")or die(mysql_error()); 
$CONTACT_VALUES_RECORD = mysql_fetch_array($CONTACT_VALUES) or die(mysql_error());
?>
<div style="width:680px;float:left;">
<p>Complete the required fields indicated in <font style="color: #CC1100;font-weight:bold;">RED</font> below.  You may complete the form in one session or add information to your request at a later time.  The <b>Submit</b> option will appear once you have completed all of the required fields.</p>
<p>Use the menu tree on the left to add a specific Server Type to your Managed Server request.  Each Server Type selection will require you to supply information needed to set up the requested server.</p>
<p>Your Managed Server request may include up to twenty-five (25) individual Server Types.</p>
<p>Select <b>Print Preview</b> to view and print each request for your records.</p>
<?php 
	if(isset($_POST['ERROR'])) echo "<div style='margin:5px;'><p>".$_POST['ERROR']."</p></div>";
	if(isset($_POST['MESG'])) echo "<div style='margin:5px;'><code>".$_POST['MESG']."</code></div>";
	$CHECK_VM_ORDER_DETAIL = mysql_query("
		SELECT * 
		FROM VM_ORDER_DETAIL
		WHERE VM_ORDER_ID = '$VM_ORDER_ID'
	")or die(mysql_error());
	$NUM_VCHECK_VM_ORDER_DETAIL = mysql_num_rows($CHECK_VM_ORDER_DETAIL ); 
	if($NUM_VCHECK_VM_ORDER_DETAIL > 0 && $SUBMIT!=0){ ?>
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
<?php
		$NEXT_VM_DETAIL_VALUES = mysql_query("
			SELECT * 
			FROM VM_ORDER_DETAIL
			WHERE VM_ORDER_ID = '$VM_ORDER_ID'
			ORDER BY VM_TYPE, VM_ORDER_DETAIL_ID
			")or die(mysql_error());
		$NUM = mysql_num_rows($NEXT_VM_DETAIL_VALUES); 
		if ($NUM!=0) { ?>
			<script type="text/javascript">
				function next() {
					if (document.contactForm.PROJECT_NAME.value==null||document.contactForm.PROJECT_NAME.value==""){
						alert("Project name must be filled out.");
						document.contactForm.PROJECT_NAME.focus();
					} 
					else {
						document.contactForm.DIRECTION.value = 'NEXT';
						document.contactForm.submit();
					}
				}
			</script>
		<?php ;} ?>
		<script type="text/javascript">
			function validate_form() {
				if (document.contactForm.PROJECT_NAME.value==null||document.contactForm.PROJECT_NAME.value==""){
					alert("Project name must be filled out.");
					document.contactForm.PROJECT_NAME.focus();
				} 
				else {
					document.contactForm.DIRECTION.value = 'SAVE';
					document.getElementById("contactForm").submit();
				}
			}
		</script>			
<div id="LINKPOP"></div><div id="POP"></div>
<form action="index.php" method="post" id="contactForm" name="contactForm" >
<table style="width:650px;border:3px solid #AAAAAA;margin:0px;">
	<tr>
		<td style="padding:10px;padding-top:0px;margin:0;padding-bottom:0px;">
					<table style="display:inline;padding:0;margin:0;">
						<tr>
							<td>
								<h3 style="margin-bottom:7px;padding:0;">Managed Server Project Name&nbsp;&nbsp;</h3>
							</td>
							<td width="400px" style="text-align:right;">
								&nbsp;<input type="button" style="display:inline;" onclick="prev();" disabled value="&laquo; Save & Previous" />
								&nbsp;<input type="button" style="display:inline;" tabindex=7 onclick="validate_form();" value="Save" />
								&nbsp;<input type="button" style="display:inline;" onclick="next();" <?php if ($NUM==0) { echo" disabled ";} ?> value="Save & Next &raquo;" />
							</td>
						</tr>
					</table>
					<table CELLPADDING=2 style="width:650px;margin-bottom:10px;margin-left:5px;border-collapse:collapse;border:1px solid #dddddd;">
						<tr>
							<td bgcolor=#dddddd style="padding:5px;width:225px;">
								<input id="PROJECT_NAME" name="PROJECT_NAME" size="94" tabindex=1 maxlength="50" value="<?php echo $CONTACT_VALUES_RECORD['PROJECT_NAME'];	?>" />
							</td>
						</tr>
					</table>
					<h3>Primary Contact Information:</h3>
					<table CELLPADDING=2 style="width:650px;margin-bottom:10px;margin-left:5px;border-collapse:collapse;border:1px solid #dddddd;">
						<tr bgcolor=#dddddd>
							<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_NAME'])) echo "color: #CC1100;font-weight:bold;"; ?>padding-top:5px;width:225px; text-align:right;">Contact Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td style="padding-top:5px;">
								<input name="CONTACT_NAME" size="40" tabindex=2 value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_NAME'];	?>" />
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
						<tr bgcolor=#FFFFF0>
							<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_NETID'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">NetID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><input name="CONTACT_NETID" size="40" tabindex=3 value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_NETID']; ?>" /></td>
						</tr>
						<tr bgcolor=#dddddd>
							<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_DEPARTMENT'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">Department/Business Unit:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><input name="CONTACT_DEPARTMENT" size="40" tabindex=4 tabindex=4 value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_DEPARTMENT']; ?>" /></td>
						</tr>
					<tr bgcolor=#FFFFF0>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_EMAIL'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">E-mail Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><input name="CONTACT_EMAIL" size="40" tabindex=5 onchange='checkEmail(this)' value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_EMAIL']; ?>" /></td>
					</tr>
					<tr bgcolor=#dddddd>
						<td style="<?php if(empty($CONTACT_VALUES_RECORD['CONTACT_PHONE'])) echo "color: #CC1100;font-weight:bold;"; ?>text-align:right;">Phone Number:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="padding-bottom:5px;"><input name="CONTACT_PHONE" tabindex=6 onchange='checkPhone(this)' size="40" value="<?php echo $CONTACT_VALUES_RECORD['CONTACT_PHONE']; ?>" /></td>
					</tr>
				</table><br>
				<input type="hidden" id="ELSEWHERE" name="ELSEWHERE" value="" />
				<input type="hidden"  name="ACTION" value="POST CONTACT" />
				<input type="hidden" name="VM_ORDER_ID" value="<? echo $VM_ORDER_ID; ?>" />
				<input type="hidden" id="DIRECTION" name="DIRECTION" value="" />
				<input type="hidden" name="PAGE" value="PROCESSING" />
		</td>
	</tr>
</table>
</form>
<br>&nbsp;<br></div>
