			msgbox(0,"","Begin")
			Global $name = "Pamela Dornan" 
			Global $email = "p-dornan@sbx.northwestern.edu"
			Global $password = "Password762"
			WindowKill() ;closes all windows in the 32770 class.
			If WinExists("[CLASS:#32770;TITLE:Mail Setup - Outlook]") Then 
				msgbox(0,"","error1")
			ElseIf WinExists("[CLASS:#32770;TITLE:Mail]") Then 
				msgbox(0,"","error2")
			Else
				Run('control mlcfg32.cpl')
				msgbox(0,"","1")
				sleep(1000)
				msgbox(0,"","2")
				WinActivate("[CLASS:#32770;TITLE:Mail Setup]","")
				$available = WinWait("[CLASS:#32770;TITLE:Mail Setup]","",10)
				if $available = 0 Then
					msgbox(0,"","error3")
				Else
					Send ("{ENTER}")
					sleep(1000)
					msgbox(0,"","3")
					WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
					$available = WinWait("[CLASS:#32770;TITLE:Account Settings]","",10)
					if $available = 0 Then 
						msgbox(0,"","error4")
					Else
						Send ("{TAB}")
						Send ("{ENTER}")
						sleep(1000)
						msgbox(0,"","4")
						WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
						$available = WinWait("[CLASS:#32770;TITLE:Add New Account]","",10)
						if $available = 0 Then 
							msgbox(0,"","error5")
						Else
							$text = WinGetText("[CLASS:#32770;TITLE:Add New Account]")
							Global $result = StringInStr($text, "Manually configure server settings or additional server types")
							if $result = 0 Then
								WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
								$available = WinWait("[CLASS:#32770;TITLE:Add New Account]","",10)
								if $available = 0 Then 
									msgbox(0,"","error6")
									Exit
								Endif
								Send ("{ENTER}")
								sleep(1000)
							EndIf
							Send ("{SPACE}")
							sleep(1000)
							Send ("{TAB}")
							Send($name)
							sleep(1000)
							Send ("{TAB}")
							Send($email)
							sleep(1000)
							Send ("{TAB}")
							Send($password)
							sleep(1000)
							Send ("{TAB}")
							Send($password)
							sleep(1000)
							Send ("{TAB}")
							If $result = 0 Then
								Send ("{TAB}")
							EndIf
							Send ("{ENTER}")
							$x = 14
							$wait = 0
							do
								$x = $x + 1
								sleep(3000)
								If $wait = 0 then
									$wait = WinActive("[CLASS:#32770;TITLE:Connect to]", "")
								EndIf
								If $wait = 0 then
									$wait = WinActive("[CLASS:#32770;TITLE:Add New Account]", "Your e-mail account is successfully configured.")
								EndIf
								If $wait = 0 then
									$wait = WinActive("[CLASS:#32770;TITLE:Microsoft Outlook]", "This account already exists")
								EndIf
							Until ($x = 90 or $wait <> 0)
							If ($wait = 0) then
								msgbox(0,"","error7")
							Elseif WinActive("[CLASS:#32770;TITLE:Add New Account]", "Your e-mail account is successfully configured.") Then
								Send ("{ENTER}")
								sleep(2000)
								if WinActive("[CLASS:#32770;TITLE:Microsoft Outlook]", "") Then
									Send ("{ENTER}")
								EndIf
								Send("{ESC}")
								Send("{ESC}")
								Send("{ESC}")
								SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
								OutlookFinished()
							Elseif WinActive("[CLASS:#32770;TITLE:Microsoft Outlook]","") Then
								$text = WinGetText("[CLASS:#32770;TITLE:Microsoft Outlook]")
								$result = StringInStr($text, "This account already exists")
								if $result <> 0 Then
									msgbox(0,"","All Ready Installed 1")
								EndIf
							Else
								WinActivate("[CLASS:#32770;TITLE:Connect to]","")
								$available = WinWait("[CLASS:#32770;TITLE:Connect to]","",180)
								If $available = 0 Then
									msgbox(0,"","error8")
								Else
									sleep(2000)
									Send($password)
									Send ("{TAB}")
									Send ("{TAB}")
									Send ("{ENTER}")
									sleep(2000)
									If WinActivate("[CLASS:#32770;TITLE:Connect to]","") Then
										msgbox(0,"","error9")
									Else
										WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
										$available = WinWait("[CLASS:#32770;TITLE:Add New Account]","",60)
										If $available = 0 Then
											WindowKill()
											SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
											OutlookFinished()
										Else
											sleep(2000)
											Send ("{ENTER}")
											WinActivate("[CLASS:#32770;TITLE:Mail Delivery Location]","")
											$available = WinWait("[CLASS:#32770;TITLE:Mail Delivery Location]","",60)
											If $available = 0 Then
												WindowKill()
												SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
												OutlookFinished()
											Else
												Send ("{ENTER}")
												if $result = 0 Then
													WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
													$available = WinWait("[CLASS:#32770;TITLE:Account Settings]","",60)
													If $available = 0 Then
														WindowKill()
														SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
														OutlookFinished()
														Sleep(3000)
														OnExit()
													EndIf
													Send("{TAB}")
													Send("{TAB}")
													Send("{TAB}")
													Send("{Enter}")
												Endif
												sleep(3000);
												Send("{ESC}")
												Send("{ESC}")
												Send("{ESC}")
												SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
												OutlookFinished()
											EndIf
										EndIf
									EndIf
								Endif
							Endif
						Endif
					Endif
				EndIf
			EndIf
			
		Func WindowKill()
			$MaxTime = 0
			$StartSec = @Sec
			$x=1
			$timer = TimerInit()
			Do
				$Client = WinList("[CLASS:#32770]","")
				Local $iMax = UBound($Client)
				For $i = 1 to $iMax - 1 ; do for each copy
					WinClose($Client[$i][1])
				Next
				$x = $x + 1
				$dif = TimerDiff($timer)
			Until ($x = 6 or $dif > 5000)
		EndFunc