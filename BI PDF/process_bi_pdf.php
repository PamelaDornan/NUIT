<?php function just_clean($string)  {  // Replace other special chars  
	// Remove all remaining other unknown characters  
	#$string = preg_replace('/[^a-zA-Z0-9 -,-;#%&@()!?.$+*:=\/]/', '', $string);  
	#$string = preg_replace('/^[-]+/', '', $string);  
	#$string = preg_replace('/[-]+$/', '', $string);  
	#$string = preg_replace('/[-]{2,}/', '', $string);  
	return $string;  
} ?>
<html>
	<head>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	</head>
	<script>
		history.forward();
	</script>
	<body onload="setTimeout('document.Submitted.submit()',50);"> 
		<div id="timer" /> <?php
		require('fpdf.php');
		$NETID = $_SERVER['REMOTE_USER'];
		include 'ldapconnection.php';
		$TODAY = date("m-d-Y_H:i:s");
		$FILEDATE = date("M_Y_dHis");
		$SUBJECTDATE = date("M j, Y");
		class PDF extends FPDF {
			//Page header
			function Header() {
				//Logo
				$this->Image('NU.jpg',10,8,33);
				//Arial bold 15
				$this->SetFont('Arial','B',13);
				//Line break
				$this->Ln(30);
				//Title
				$this->Cell(170,10,'Business Intelligence Solutions Proposal Submission Form',0,0,'C');
				//Line break
				$this->Ln(10);
			}
			//Page footer
			function Footer() {
				//Position at 1.5 cm from bottom
				$this->SetY(-15);
				//Arial italic 8
				$this->SetFont('Arial','I',8);
				$this->Cell(170,10,'This proposal will help determine which projects to approve as part of the enterprise system project prioritization process.',0,0,'C');
				//Line break
				$this->Ln(5);
				//Page number
				$this->Cell(170,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}
		}
		$FILETITLE = $_POST['NAME'];
		$FILETITLE = substr($FILETITLE,0,30);
		$SPACE = '/ /';
		$REPLACE = "_";
		$FILETITLE = preg_replace("/[^a-zA-Z0-9 ]/", "", $FILETITLE);
		$USERNAME = preg_replace("/[^a-zA-Z0-9 ]/", "", $LDAPName);
		$fileatt = preg_replace($SPACE, $REPLACE, $FILETITLE) . "-" . preg_replace($SPACE, $REPLACE, $USERNAME) . '-' . $FILEDATE . '.pdf'; // Path to the file
		$fileatt_type = "application/pdf"; // File Type
		$fileatt_name = $NETID . '_' . $TODAY . '.pdf'; // Filename that will be used for the file as the attachment 

		//Instanciation of inherited class
		$pdf=new PDF();
		$pdf->SetLeftMargin(20);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'Request Title: ');
		$pdf->SetFont('Times','',12);
		$pdf->Write(5,$_POST['NAME']);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'Requestor: ');
		$pdf->SetFont('Times','',12);
		$pdf->Write(5,$LDAPName." (".$NETID.")");
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'Request Date: ');
		$pdf->SetFont('Times','',12);
		$pdf->Write(5,$today);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'Requesting School/Unit: ');
		$pdf->SetFont('Times','',12);
		$pdf->Write(5,$_POST['UNIT']);
		if(!empty($_POST['PRIORITY'])) {
			//Line break
			$pdf->Ln(10);
			$pdf->SetFont('Times','B',12);
			$pdf->Write(5,'The relative importance of this request: ');
			$pdf->SetFont('Times','',12);
			$pdf->Write(5,$_POST['PRIORITY']);
		}
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'Due Date or Business Cycle:');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$DUE_DATE = just_clean($_POST['DUE_DATE']);
		$pdf->Write(5,$DUE_DATE);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'Request Description:');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$DESCRIPTION = just_clean($_POST['DESCRIPTION']);
		$pdf->Write(5,$DESCRIPTION);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'1)  Who has reviewed this request and agreed it should be pursued?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$AUTHORIZATION = just_clean($_POST['AUTHORIZATION']);
		$pdf->Write(5,$AUTHORIZATION);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'2)  How is this project important to your school or unit’s strategy?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$STRATEGY = just_clean($_POST['STRATEGY']);
		$pdf->Write(5,$STRATEGY);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'3)  How could another school/department/unit use this solution?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$OUTSIDE_USE = just_clean($_POST['OUTSIDE_USE']);
		$pdf->Write(5,$OUTSIDE_USE);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'4)  How does this project improve the student, faculty, or staff experience at Northwestern University?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$ENHANCE = just_clean($_POST['ENHANCE']);
		$pdf->Write(5,$ENHANCE);    
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'5)  How does this project improve student, staff or faculty effectiveness?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$EFFECTIVE = just_clean($_POST['EFFECTIVE']);
		$pdf->Write(5,$EFFECTIVE);
		//Line break	
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'6)  What are the quantitative benefits or anticipated ROI of doing the project (e.g., cost savings, costs avoided, additional revenue generated, reduced workload etc.)?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$BENEFITS = just_clean($_POST['BENEFITS']);
		$pdf->Write(5,$BENEFITS);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'7)  If this project is not done, what is the impact?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$IMPACT = just_clean($_POST['IMPACT']);
		$pdf->Write(5,$IMPACT);
		//Line break
		$pdf->Ln(10);
		$pdf->SetFont('Times','B',12);
		$pdf->Write(5,'8)  What types of resources (subject matter experts, users, etc.) will you commit to this project?');
		//Line break
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$RESOURCES = just_clean($_POST['RESOURCES']);
		$pdf->Write(5,$RESOURCES);
		$FileHandle = fopen($fileatt, 'w') or die("can't open file");
		fclose($FileHandle);
		$pdf->Output($fileatt,'F');
		$TEXT = 'Request Title: '.$_POST['NAME'].'<br>
Requestor: '.$LDAPName.' ('.$NETID.')<br>
Request Date: '.$today.'<br>
Requesting School/Unit: '.$_POST['UNIT'].'<br>';
		if(!empty($_POST['PRIORITY'])) {
			$TEXT .= 'The relative importance of this request: '.$_POST['PRIORITY'].'<br>';
		}
		$TEXT .= '<br>Due Date or Business Cycle:<br>'.$_POST['DUE_DATE'].'<br><br>
Request Description<br>'.$_POST['DESCRIPTION'].'<br><br>
1)  Who has reviewed this request and agreed it should be pursued?<br>'.$_POST['AUTHORIZATION'].'<br><br>
2)  How is this project important to your school or unit’s strategy?<br>'.$_POST['STRATEGY'].'<br><br>
3)  How could another school/department/unit use this solution?<br>'.$_POST['OUTSIDE_USE'].'<br><br>
4)  How does this project improve the student, faculty, or staff experience at Northwestern University?<br>'.$_POST['ENHANCE'].'<br><br>
5)  How does this project improve student, staff or faculty effectiveness?<br>'.$_POST['EFFECTIVE'].'<br><br>
6)  What are the quantitative benefits or anticipated ROI of doing the project (e.g., cost savings, costs avoided, additional revenue generated, reduced workload etc.)??<br>'.$_POST['BENEFITS'].'<br><br>
7)  If this project is not done, what is the impact?<br>'.$_POST['IMPACT'].'<br><br>
8)  What types of resources (subject matter experts, users, etc.) will you commit to this project?<br>'.$_POST['RESOURCES'].'<br>';

#--ADMIN EMAIL-----------------------------------------------------------------------------------------
// email stuff (change data below)
$to = "user@example.com"; 
$from = $LDAPMail; 
$subject = "BI Project Request: " . $_POST['NAME'] . ", " . $SUBJECTDATE; 
$message = $TEXT . "<br>--<br><br>SUBMITTER DIRECTORY INFORMATION:<br>" . $LDAPALL;

// a random hash will be necessary to send mixed content
$separator = md5(time());
 
// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = $fileatt;

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header (multipart mandatory)
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol; 
$headers .= "Content-Transfer-Encoding: 7bit".$eol;
$headers .= "This is a MIME encoded message.".$eol.$eol;

// message
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$headers .= $message.$eol.$eol;

// attachment
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$headers .= "Content-Transfer-Encoding: base64".$eol;
$headers .= "Content-Disposition: attachment".$eol.$eol;
$headers .= $attachment.$eol.$eol;
$headers .= "--".$separator."--";
		
$okBI = @mail($to, $subject, "", $headers);
		
		if($okBI) {
			#---USER EMAIL----------------------------------------------------------------------------------------------------------------
			// email stuff
			$from = "user@example.com"; 
			$to = $LDAPMail; 
			$message = "Thank you for your BI project submission.<br><br>All requests are evaluated according to <a href='<target.domain>business-intelligence/project-selection.html'>project selection guidelines</a>.<br><br>Please contact <a href='mailto:user@example.com'>user@example.com</a> with any questions.<br><br>";

			// main header (multipart mandatory)
			$headers  = "From: ".$from.$eol;
			$headers .= "MIME-Version: 1.0".$eol; 
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol; 
			$headers .= "Content-Transfer-Encoding: 7bit".$eol;
			$headers .= "This is a MIME encoded message.".$eol.$eol;

			// message
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$headers .= $message.$eol.$eol;

			// attachment
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
			$headers .= "Content-Transfer-Encoding: base64".$eol;
			$headers .= "Content-Disposition: attachment".$eol.$eol;
			$headers .= $attachment.$eol.$eol;
			$headers .= "--".$separator."--";
		
			mail($to, $subject, "", $headers);
			echo '<br><center><p>Processing...</p></center>';
		} else {
			die("Sorry, your request could not be sent. Please go back and try again.");
		} 
		$File = "SUBMIT.log";
		$Handle = fopen($File, 'a');
		$SUBMIT_DATE = date("20y-m-d H:i:s", time());
		$Data = $SUBMIT_DATE." - by ".$NETID . "\r\n";
		fwrite($Handle, $Data); 
		fclose($Handle);
		?><form name="Submitted" action="<target.domain>/secure/bi-confirmation.html" method="post" 
style="display:inline; margin:0; padding:0;"></form>
	</body>
</html>
