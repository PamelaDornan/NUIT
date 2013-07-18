; #CONSTANTS# ===================================================================================================================
	; Events and messages
		Global Const $GUI_EVENT_CLOSE = -3

	; State
		Global Const $GUI_DISABLE = 128 ;

	; Font
		Global Const $GUI_FONTITALIC = 2
		Global Const $GUI_FONTUNDER = 4
		Global Const $GUI_FONTSTRIKE = 8

	; Graphic
		Global Const $GUI_GR_CLOSE = 1
		Global Const $GUI_GR_LINE = 2
		Global Const $GUI_GR_BEZIER = 4
		Global Const $GUI_GR_MOVE = 6
		Global Const $GUI_GR_COLOR = 8
		Global Const $GUI_GR_RECT = 10
		Global Const $GUI_GR_ELLIPSE = 12
		Global Const $GUI_GR_PIE = 14
		Global Const $GUI_GR_DOT = 16
		Global Const $GUI_GR_PIXEL = 18
		Global Const $GUI_GR_HINT = 20
		Global Const $GUI_GR_REFRESH = 22
		Global Const $GUI_GR_PENSIZE = 24
		Global Const $GUI_GR_NOBKCOLOR = -2

	; Background color special flags
		Global Const $GUI_BKCOLOR_DEFAULT = -1
		Global Const $GUI_BKCOLOR_TRANSPARENT = -2
		Global Const $GUI_BKCOLOR_LV_ALTERNATE = 0xFE000000

	; Other
		Global Const $GUI_WS_EX_PARENTDRAG = 0x00100000
		Global Const $ES_PASSWORD = 0x0020
		Global Const $LABEL_RED = 0xff0000
		Global Const $PBS_SMOOTH = 0x01
		Global Const $BS_DEFPUSHBUTTON = 0x0001
		Global Const $BS_BITMAP = 0x0080
		Global Const $BS_FLAT = 0x8000 ;
		Global Const $BS_ICON = 0x0040
		Global Const $SS_BLACKRECT = 0x04
		Global Const $WS_POPUP = 0x80000000
		Global Const $WS_BORDER = 0x00800000
		Global Const $WS_DLGFRAME = 0x00400000
		Global Const $WS_POPUPWINDOW = 0x80880000 ;
		Global Const $WS_SYSMENU = 0x00080000
		Global Const $WS_CAPTION = 0x00C00000
		Global Const $WS_SIZEBOX = 0x00040000
		Global Const $TRAY_EVENT_PRIMARYDOWN = -7
		
; #######MAIN######################################################################################################################
																															;######
AutoItSetOption("WinTitleMatchMode", 1)																						;######
																															;######
																															;######																															;######	
FindOutlook()																												;######
FindThunderbird()																											;######
																															;######
Opt("GuiOnEventMode",1)																										;######						
																															;######																																;######									;######
Global $GUIWindowID = GuiCreate("NU E-mail Config", @DesktopWidth-25, @DesktopHeight-100,-1,-1,$WS_POPUPWINDOW)				;######
Global $X = ((@DesktopWidth-25)/2) - 200																					;######
Global $Y = ((@DesktopHeight-100)/2) - 200																					;######
GUISetFont (10)																												;######	
fileInstall("NUBackground.bmp", @tempDir & "\NUBackground.bmp")																;######	
Global $Pic = GUICtrlCreatePic(@tempDir & "\NUBackground.bmp", $X-200, $Y-150, 800, 600)									;######																														;######
Global $LabelID = GUICtrlCreateLabel("Welcome!", $X+20, $Y+30)																;######
Global $minID = GuiCtrlCreateButton("_", $X+469, $Y-40, 20, 20,$BS_FLAT)													;######
GUICtrlSetOnEvent(-1,"min")																									;######
Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)												;######
GUICtrlSetOnEvent(-1,"CheckSystem")																							;######
Global $ExitID = GuiCtrlCreateButton("Cancel", $X+308, $Y+260, 80, 30,$BS_FLAT)												;######
GUICtrlSetOnEvent(-1,"OnExit")																								;######
																															;######
GUISetOnEvent($GUI_EVENT_CLOSE,"OnExit")																					;######
GUISetBkColor(0xFFFFFF)																										;######
GuiSetState()  ; display the GUI																							;######
WinSetOnTop('NU E-mail Config', '', 1) ;Set GUI to allways be on top														;######
TraySetOnEvent($TRAY_EVENT_PRIMARYDOWN, "max")																				;######
GUICtrlSetState ( $Pic, $GUI_DISABLE )																						;######
fileDelete(@tempDir & "\NUBackground.bmp")																					;######
While 1																														;######
	Sleep (10)																												;######
WEnd 																														;######
 																															;######
; #######END MAIN##################################################################################################################




; #FUNCTIONS#  ===================================================================================================================
		Func CheckSystem()
			Global $OSversion = @OSVersion ;User's OS																					
			Global $OSbit = @OSArch ;User's OS Bits	
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("OutlookID") = 1 Then
				GUICtrlDelete($OutlookID)
			EndIf
			If IsDeclared("ThunderbirdID") = 1 Then
				GUICtrlDelete($ThunderbirdID)
			EndIf
			If ($OSversion <> "WIN_7" AND $OSversion <> "WIN_VISTA" AND $OSversion <> "WIN_XP" AND $OSversion <> "WIN_XPe") OR ($OSbit <> "X86" AND $OSbit <> "X64" AND $OSbit <> "IA64")Then
				Global $LabelID = GUICtrlCreateLabel("Your operating system is not compatible with this tool.", $X+10, $Y+20)
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				EndIf
			Else
				EmailClientSelect()
			EndIf
		EndFunc

    ;Displays Window Allowing User to Choose from Available E-mail Client options.
		Func EmailClientSelect()
			If IsDeclared("NextID") = 1 Then
				GUICtrlDelete($NextID)
			EndIf
			If ($OutlookVersion<>-1 And $ThunderbirdVersion <>-1) Then
				Global $LabelID = GUICtrlCreateLabel("Pick your e-mail Client:", $X+10, $Y+20)
				Global $OutlookID  = GUICtrlCreateRadio($OutlookVersion, $X+40, $Y+50, 100, 20)
				Global $ThunderbirdID   = GUICtrlCreateRadio($ThunderbirdVersion, $X+160, $Y+50, 150, 20)
				Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
				GUICtrlSetOnEvent(-1,"ValidateClientChoice")
			ElseIf ($OutlookVersion<>-1) Then
				Global $LabelID = GUICtrlCreateLabel("Pick your e-mail Client:", $X+10, $Y+20)
				Global $OutlookID  = GUICtrlCreateRadio($OutlookVersion, $X+40, $Y+50, 100, 20)
				Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
				GUICtrlSetOnEvent(-1,"ValidateClientChoice")
			ElseIf ($ThunderbirdVersion<>-1) Then
				Global $LabelID = GUICtrlCreateLabel("Pick your e-mail Client:", $X+10, $Y+20)
				Global $ThunderbirdID = GUICtrlCreateRadio($ThunderbirdVersion, $X+40, $Y+50, 150, 20)
				Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
				GUICtrlSetOnEvent(-1,"ValidateClientChoice")
			Else
				Global $LabelID = GUICtrlCreateLabel("No compatible e-mail clients are installed on your computer", $X+10, $Y+20)
			EndIf
		EndFunc
		
	;Validates function EmailClientSelect.  Checks to see if a section is chosen, if so 
	;it will parse out the process to need function, otherwise it will return to 
	;EmailClientSelect until a client is choosen.
		Func ValidateClientChoice()
			If (IsDeclared("OutlookID") = 1 And GUICtrlRead($OutlookID) = 1) Then
				Global $uClient = "Outlook"
				If IsDeclared("OutlookID") = 1 Then
					GUICtrlDelete($OutlookID)
				EndIf
				If IsDeclared("ThunderbirdID") = 1 Then
					GUICtrlDelete($ThunderbirdID)
				EndIf
				OutlookOpenCheck()
			ElseIf (IsDeclared("ThunderbirdID") = 1 And GUICtrlRead($ThunderbirdID) = 1) Then
				Global $uClient = "Thunderbird"
				If IsDeclared("OutlookID") = 1 Then
					GUICtrlDelete($OutlookID)
				EndIf
				If IsDeclared("ThunderbirdID") = 1 Then
					GUICtrlDelete($ThunderbirdID)
				EndIf
				ThunderbirdOpenCheck()
			Else
				EmailClientSelect()
			EndIf
		EndFunc
		
		Func OutlookOpenCheck()
			WinSetOnTop('NU E-mail Config', '', 1) ;Set GUI to allways be on top	
			$OutlookProcessFlag = ProcessExists("OUTLOOK.EXE")
			If $OutlookProcessFlag <> 0 Then
				$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
				$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $OutlookProcessFlag, 'WQL', 0x10 + 0x20)
				For $objItem In $colItems
					$OutlookProcessPath = $objItem.ExecutablePath 
				Next
				If IsDeclared("OutlookProcessPath") = 1 And $OutlookRegPath <> $OutlookProcessPath Then
					OutlookSetupNotOpen()
				Else
					CloseOutlookWait()
				Endif
			Else
				OutlookInformationDisplay()
			EndIf
		EndFunc
		
	;If Outlook is chosen this function display user inputs for name, e-mail address and NetID password.
		Func OutlookInformationDisplay()
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("Provide the following information:", $X+10, $Y+20)
			If IsDeclared("NameLabelID") <> 1 then
				Global $NameLabelID = GUICtrlCreateLabel("Your Name: ", $X+30, $Y+55)
			EndIf
			If IsDeclared("NameInputID") <> 1 then
				Global $NameInputID = GUICtrlCreateInput("", $X+135, $Y+52, 175, 20)
			EndIf
			If IsDeclared("EmailLabelID") <> 1 then
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address: ", $X+30, $Y+85)
			EndIf
			If IsDeclared("EmailInputID") <> 1 then
				Global $EmailInputID = GUICtrlCreateInput("", $X+135, $Y+82, 175, 20)
			EndIf
			If IsDeclared("PasswordLabelID") <> 1 then
				Global $PasswordLabelID = GUICtrlCreateLabel("NetID Password: ", $X+30, $Y+115)
			EndIf
			If IsDeclared("PasswordInputID") <> 1 then
				Global $PasswordInputID = GUICtrlCreateInput("", $X+135, $Y+112, 175, 20, $ES_PASSWORD)
			EndIf
			GUICtrlDelete($NextID)
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ValidateOutlook")
		EndFunc
		
		Func ThunderbirdOpenCheck()
			WinSetOnTop('NU E-mail Config', '', 1) ;Set GUI to allways be on top	
			$ThunderbirdProcessFlag = ProcessExists("thunderbird.exe")
			If $ThunderbirdProcessFlag <> 0 Then
				$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
				$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $ThunderbirdProcessFlag, 'WQL', 0x10 + 0x20)
				For $objItem In $colItems
					$ThunderbirdProcessPath = $objItem.ExecutablePath 
				Next
				If IsDeclared("ThunderbirdProcessPath") = 1 And $ThunderbirdRegPath <> $ThunderbirdProcessPath Then
					ThunderbirdSetupNotOpen()
				Else
					CloseThunderbirdWait()
				Endif
			Else
				ThunderbirdInformationDisplay()
			EndIf
		EndFunc
		
		Func CloseOutlookWait()
			WinSetOnTop('NU E-mail Config', '', 0) 
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("You're Outlook Client is open.  Please close" & @CRLF & "Outlook and click NEXT to continue running the script.", $X+10, $Y+20)
			GUICtrlDelete($NextID)
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"OutlookOpenCheck")
		EndFunc
		
		Func CloseThunderbirdWait()
			WinSetOnTop('NU E-mail Config', '', 0) 
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("You're Thunderbird Client is open.  Please close" & @CRLF & "Thunderbird and click NEXT to continue running the script.", $X+10, $Y+20)
			GUICtrlDelete($NextID)
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ThunderbirdOpenCheck")
		EndFunc
		
		Func ThunderbirdInformationDisplay()
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("Provide the following information:", $X+10, $Y+20)
			If IsDeclared("NameLabelID") <> 1 then
				Global $NameLabelID = GUICtrlCreateLabel("Your Name: ", $X+30, $Y+55)
			EndIf
			If IsDeclared("NameInputID") <> 1 then
				Global $NameInputID = GUICtrlCreateInput("", $X+135, $Y+52, 175, 20)
			EndIf
			If IsDeclared("EmailLabelID") <> 1 then
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address: ", $X+30, $Y+85)
			EndIf
			If IsDeclared("EmailInputID") <> 1 then
				Global $EmailInputID = GUICtrlCreateInput("", $X+135, $Y+82, 175, 20)
			EndIf
			If IsDeclared("NetidLabelID") <> 1 then
				Global $NetidLabelID = GUICtrlCreateLabel("NetID: ", $X+30, $Y+115)
			EndIf
			If IsDeclared("NetidInputID") <> 1 then
				Global $NetidInputID = GUICtrlCreateInput("", $X+135, $Y+112, 175, 20)
			EndIf
			GUICtrlDelete($NextID)
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+221, $Y+260, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ValidateThunderbird")
		EndFunc
		
	;This Function validate data entered by the user in function OutlookInformationDisplay.  
	;If data passes validation it will pass data onto function ConfigureOutlook.
		Func ValidateOutlook()
			$flag=0;
			$sRegExp = "^[-+.\w]{1,64}@[sS][bB][xX]\.[nN][oO][rR][tT][hH][wW][eE][sS][tT][eE][rR][nN]\.[eE][dD][uU]$"   ;REGEX to be used at Launch"^[-+.\w]{1,64}@[nN][oO][rR][tT][hH][wW][eE][sS][tT][eE][rR][nN]\.[eE][dD][uU]$" 
			$temp = GUICtrlRead($EmailInputID)
			If IsDeclared("ErrorNameLabelID") = 1 Then
				GUICtrlDelete($ErrorNameLabelID)
			EndIf
			If IsDeclared("ErrorEmailLabelID") = 1 Then
				GUICtrlDelete($ErrorEmailLabelID)
			EndIf
			If IsDeclared("ErrorPasswordLabelID") = 1 Then
				GUICtrlDelete($ErrorPasswordLabelID)
			EndIf
			
			If GUICtrlRead($NameInputID) = "" Then
				Global $ErrorNameLabelID = GUICtrlCreateLabel("*Required", $X+312, $Y+55)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1; 
			EndIf
			If GUICtrlRead($EmailInputID) = "" Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Required", $X+312, $Y+85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			ElseIf StringRegExp($temp, $sRegExp,1) = 0 Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Invalid", $X+312, $Y+85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($PasswordInputID) = "" Then
				Global $ErrorPasswordLabelID = GUICtrlCreateLabel("*Required", $X+312, $Y+115)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If $flag=0 Then
				ConfigureOutlook()
			Else
				OutlookInformationDisplay()
			EndIf
		EndFunc
		
		Func ValidateThunderbird()
			$flag=0;
			$sRegExp = "^[-+.\w]{1,64}@[nN][oO][rR][tT][hH][wW][eE][sS][tT][eE][rR][nN]\.[eE][dD][uU]$"   ;REGEX to be used at Launch"^[-+.\w]{1,64}@[nN][oO][rR][tT][hH][wW][eE][sS][tT][eE][rR][nN]\.[eE][dD][uU]$" 
			$temp = GUICtrlRead($EmailInputID)
			If IsDeclared("ErrorNameLabelID") = 1 Then
				GUICtrlDelete($ErrorNameLabelID)
			EndIf
			If IsDeclared("ErrorEmailLabelID") = 1 Then
				GUICtrlDelete($ErrorEmailLabelID)
			EndIf
			If IsDeclared("ErrorNetidLabelID") = 1 Then
				GUICtrlDelete($ErrorNetidLabelID)
			EndIf
			
			If GUICtrlRead($NameInputID) = "" Then
				Global $ErrorNameLabelID = GUICtrlCreateLabel("*Required", $X+312, $Y+55)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($EmailInputID) = "" Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Required", $X+312, $Y+85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			ElseIf StringRegExp($temp, $sRegExp,1) = 0 Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Invalid", $X+312, $Y+85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($NetidInputID) = "" Then
				Global $ErrorNetidLabelID = GUICtrlCreateLabel("*Required", $X+312, $Y+115)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If $flag=0 Then
				ConfigureThunderbird()
			Else
				ThunderbirdInformationDisplay()
			EndIf
		EndFunc
		
	;Function configures Outlook account by using control panel's Mail configuration set.	
		Func ConfigureOutlook()
			Global $name = GUICtrlRead($NameInputID) 
			Global $email = GUICtrlRead($EmailInputID)
			Global $password = GUICtrlRead($PasswordInputID)
			GUICtrlDelete($LabelID)
			GUICtrlDelete($NameLabelID)
			GUICtrlDelete($NameInputID)
			GUICtrlDelete($EmailLabelID)
			GUICtrlDelete($EmailInputID)
			GUICtrlDelete($PasswordLabelID)
			GUICtrlDelete($PasswordInputID)
			GUICtrlDelete($NextID)
			GUICtrlDelete($ExitID)
			GUICtrlDelete($minID)
			Global $LabelID = GUICtrlCreateLabel("Please Wait...", $X+10, $Y+20)
			Global $progressbar = GUICtrlCreateProgress($X+10, $Y+40, 280, 20, $PBS_SMOOTH)
			GUICtrlSetData($progressbar, 1)
			WindowKill() ;closes all windows in the 32770 class.
			If WinExists("[CLASS:#32770;TITLE:Mail Setup - Outlook]") Then 
				OutlookSetupNotOpen()
			ElseIf WinExists("[CLASS:#32770;TITLE:Mail]") Then 
				OutlookSetupNotOpen()
			Else
				GUICtrlSetData($progressbar, 3)
				Run('control mlcfg32.cpl')
				GUICtrlSetData($progressbar, 4)
				sleep(2000)
				WinActivate("[CLASS:#32770;TITLE:Mail Setup -]","")
				$available = WinExists("[CLASS:#32770;TITLE:Mail Setup -]","")
				if $available = 0 Then
					OutlookSetupNotOpen()
				Else
					ControlSend ( "[CLASS:#32770;TITLE:Mail Setup -]", "", "", "{ENTER}")
					GUICtrlSetData($progressbar, 5)
					sleep(2000)
					WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
					$available = WinExists("[CLASS:#32770;TITLE:Account Settings]","")
					if $available = 0 Then 
						OutlookSetupNotOpen()
					Else
						ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{TAB}")
						ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{ENTER}")
						GUICtrlSetData($progressbar, 6)
						sleep(2000)
						WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
						$available = WinExists("[CLASS:#32770;TITLE:Add New Account]","")
						if $available = 0 Then 
							OutlookSetupNotOpen()
						Else
							$text = WinGetText("[CLASS:#32770;TITLE:Add New Account]")
							Global $result = StringInStr($text, "Manually configure server settings or additional server types")
							if $result = 0 Then
								sleep(2000)
								WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
								$available = WinExists("[CLASS:#32770;TITLE:Add New Account]","")
								if $available = 0 Then 
									OutlookSetupNotOpen()
									Sleep(3000)
									OnExit()
								Endif
								ControlSend ( "[CLASS:#32770;TITLE:Add New Account]", "", "", "{ENTER}")
								sleep(1000)
							EndIf
							GUICtrlSetData($progressbar, 7)
							ControlSend ( "[CLASS:#32770;TITLE:Add New Account]", "", "", "{SPACE}")
							ControlSetText ( "[CLASS:#32770;TITLE:Add New Account]", "", "[CLASS:RichEdit20WPT; INSTANCE:1]", $name)
							ControlSetText ( "[CLASS:#32770;TITLE:Add New Account]", "", "[CLASS:RichEdit20WPT; INSTANCE:2]", $email)
							ControlSetText ( "[CLASS:#32770;TITLE:Add New Account]", "", "[CLASS:RichEdit20WPT; INSTANCE:3]", $password)
							ControlSetText ( "[CLASS:#32770;TITLE:Add New Account]", "", "[CLASS:RichEdit20WPT; INSTANCE:4]", $password)
							If $result = 0 Then
								ControlClick ( "[CLASS:#32770;TITLE:Add New Account]", "", "[CLASS:Button; INSTANCE:8]")
							Else
								ControlClick ( "[CLASS:#32770;TITLE:Add New Account]", "", "[CLASS:Button; INSTANCE:5]")
							EndIf
							GUICtrlSetData($progressbar, 8)
							$x = 8
							$wait = "0"
							do
								$x = $x + 1
								sleep(4000)
								If $wait = 0 then
									$wait = WinExists("[CLASS:#32770;TITLE:Connect to]", "")
								EndIf
								If $wait <> 0 then
									$wait = "Connect to"
								Else
									If $wait = 0 then
										$wait = WinExists("[CLASS:#32770;TITLE:Windows Security]", "")
									EndIf
									If $wait <> 0 then
										$wait = "Windows Security"
									Else
										If $wait = 0 then
											$wait = WinExists("[CLASS:#32770;TITLE:Add New Account]", "Your e-mail account is successfully configured.")
										EndIf
										If $wait <> 0 then
											$wait = "Add New Account"
										Else
											If $wait = 0 then
												$wait = WinExists("[CLASS:#32770;TITLE:Microsoft Outlook]", "This account already exists")
												If $wait <> 0 then
													$wait = "Microsoft Outlook"
												EndIf
											EndIf
										EndIf
									EndIf
								EndIf
								GUICtrlSetData($progressbar, $x)
							Until ($x = 89 or $wait == "Connect to" or $wait == "Add New Account" or $wait == "Microsoft Outlook" or $wait == "Windows Security")
							GUICtrlSetData($progressbar, 90)
							If ($wait == "0") then
								OutlookSetupNotOpen()
							Elseif ($wait == "Add New Account") Then
								ControlSend ( "[CLASS:#32770;TITLE:Add New Account]", "", "", "{ENTER}")
								GUICtrlSetData($progressbar, 93)
								sleep(2000)
								GUICtrlSetData($progressbar, 94)
								if WinExists("[CLASS:#32770;TITLE:Microsoft Outlook]", "") Then
									ControlSend ( "[CLASS:#32770;TITLE:Microsoft Outlook]", "", "", "{ENTER}")
								EndIf
								GUICtrlSetData($progressbar, 95)
								ControlSend ( "[CLASS:#32770", "", "", "{ESC}")
								ControlSend ( "[CLASS:#32770", "", "", "{ESC}")
								ControlSend ( "[CLASS:#32770", "", "", "{ESC}")
								GUICtrlSetData($progressbar, 96)
								SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
								GUICtrlSetData($progressbar, 97)
								OutlookFinished()
							Elseif ($wait == "Microsoft Outlook") Then
								GUICtrlSetData($progressbar, 93)
								$text = WinGetText("[CLASS:#32770;TITLE:Microsoft Outlook]")
								$result = StringInStr($text, "This account already exists")
								GUICtrlSetData($progressbar, 96)
								if $result <> 0 Then
									OutlookExists()
								Else
									GUICtrlSetData($progressbar, 99)
									OutlookFinished()
								EndIf
							Else
								GUICtrlSetData($progressbar, 91)
								$available = WinExists("[CLASS:#32770;TITLE:Connect to]","")
								If $available = 0 Then
									OutlookSetupNotOpen()
								Else
									GUICtrlSetData($progressbar, 92)
									If $wait == "Connect to" Then
										ControlSetText ( "[CLASS:#32770;TITLE:Connect to]", "", "[CLASS:Edit; INSTANCE:3]", $password)
										ControlClick ( "[CLASS:#32770;TITLE:Connect to]", "", "[CLASS:Button; INSTANCE:3]")
										WinWait ( "[CLASS:#32770;TITLE:Connect to]","",20)
									EndIf
									If $wait == "Windows Security" Then
										ControlSetText ( "[CLASS:#32770;TITLE:Windows Security]", "", "[CLASS:Edit; INSTANCE:1]", $password)
										ControlClick ( "[CLASS:#32770;TITLE:Windows Security]", "", "[CLASS:Button; INSTANCE:2]")
										WinWait ( "[CLASS:#32770;TITLE:Windows Security]","",20)
									EndIf
									If (WinExists("[CLASS:#32770;TITLE:Connect to]","") or WinExists("[CLASS:#32770;TITLE:Windows Security]","")) Then
										WindowKill()
										OutlookBadData()
									Else
										GUICtrlSetData($progressbar, 95)
										sleep(2000)
										WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
										$available = WinExists("[CLASS:#32770;TITLE:Add New Account]","")
										If $available = 0 Then
											WindowKill()
											SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
											OutlookFinished()
										Else
											GUICtrlSetData($progressbar, 96)
											sleep(2000)
											GUICtrlSetData($progressbar, 97)
											ControlSend ( "[CLASS:#32770;TITLE:Add New Account]", "", "", "{ENTER}")
											sleep(2000)
											WinActivate("[CLASS:#32770;TITLE:Mail Delivery Location]","")
											$available = WinExists("[CLASS:#32770;TITLE:Mail Delivery Location]","")
											If $available = 0 Then
												WindowKill()
												SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
												OutlookFinished()
											Else
												GUICtrlSetData($progressbar, 98)
												ControlSend ( "[CLASS:#32770;TITLE:Mail Delivery Location]", "", "", "{ENTER}")
												if $result = 0 Then
													sleep(2000)
													WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
													$available = WinExists("[CLASS:#32770;TITLE:Account Settings]","")
													If $available = 0 Then
														WindowKill()
														SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
														OutlookFinished()
														Sleep(3000)
														OnExit()
													EndIf
													ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{TAB}")
													ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{TAB}")
													ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{TAB}")
													ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{ENTER}")
												Endif
												GUICtrlSetData($progressbar, 99)
												sleep(2000);
												ControlSend ( "[CLASS:#32770", "", "", "{ESC}")
												ControlSend ( "[CLASS:#32770", "", "", "{ESC}")
												ControlSend ( "[CLASS:#32770", "", "", "{ESC}")
												SearchOpen($OutlookRegPath,"OUTLOOK.EXE");replace with your search directory and file extension required
												GUICtrlSetData($progressbar, 100)
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
		EndFunc
		
		Func ConfigureThunderbird()
			Global $name = GUICtrlRead($NameInputID) 
			Global $email = GUICtrlRead($EmailInputID)
			Global $netid = GUICtrlRead($NetidInputID)
			GUICtrlDelete($LabelID)
			GUICtrlDelete($NameLabelID)
			GUICtrlDelete($NameInputID)
			GUICtrlDelete($EmailLabelID)
			GUICtrlDelete($EmailInputID)
			GUICtrlDelete($NetidLabelID)
			GUICtrlDelete($NetidInputID)
			GUICtrlDelete($NextID)
			GUICtrlDelete($ExitID)
			GUICtrlDelete($minID)
			Global $LabelID = GUICtrlCreateLabel("Please Wait...", $X+10, $Y+20)
			Global $progressbar = GUICtrlCreateProgress($X+10, $Y+40, 280, 20, $PBS_SMOOTH)
			GUICtrlSetData($progressbar, 1)
			Global $ThunderbirdPath = StringReplace($ThunderbirdRegPath, "thunderbird.exe", "")
			Global $appdir = _GetAppDir()
			If FileExists($appdir & "\Thunderbird\profiles.ini") = 0 Then
				GUICtrlSetData($progressbar, 3)
				SearchOpen($ThunderbirdPath,"thunderbird.exe");replace with your search directory and file extension required
				sleep(2000)
				GUICtrlSetData($progressbar, 6)
				$available = WinExists("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
				if $available = 1 then
					WinKill("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
				Endif
				GUICtrlSetData($progressbar, 8)
				sleep(5000)
				GUICtrlSetData($progressbar, 11)
				MozillaKill()
				sleep(1000)
				GUICtrlSetData($progressbar, 13)
				WinClose("[CLASS:MozillaUIWindowClass]","")
				sleep(5000)
			EndIf
			GUICtrlSetData($progressbar, 15)
			If FileExists($appdir & "\Thunderbird\profiles.ini") Then
				$file = $appdir & "\Thunderbird\profiles.ini"
				$file1 = FileOpen($file, 0)
				If $file1 = -1 Then
					ThunderbirdSetupNotOpen()
				Else	
					$found = 0
					$sRegExp = 'Path=[.]*'
					While 1
						$line = FileReadLine($file1)
						If @error = -1 Then ExitLoop
						If StringRegExp($line,$sRegExp,1) = 0 Then
						Else
							$found = StringTrimLeft($line, 5)
							ExitLoop
						EndIf
					Wend
					GUICtrlSetData($progressbar, 30)
					if $found == "0" Then
						ThunderbirdSetupNotOpen()
					Else
						$found2=(StringReplace($found, "/", "\"))
						$file = $appdir & "\Thunderbird\" & $found2 & "\prefs.js"
						$timestamp = @MON & @MDAY & @YEAR & @HOUR & @MIN & @SEC
						FileCopy($file,$file & $timestamp)
						$x = $appdir & "\Thunderbird\" & $found2 & "\"
						$jsdir = StringReplace ( $x, "/", "//")
						$prefsjs = FileOpen($file, 0)
						GUICtrlSetData($progressbar, 40)
						If $prefsjs = -1 Then
							ThunderbirdSetupNotOpen()
						Else
							$num = 0
							$notSetupRegExp = '[.]*mail.it.northwestern.edu[.]*'
							$notSetupFlag = -1
							$accountListRegExp = 'user_pref\("mail.accountmanager.accounts",[.]*'
							$accountListFlag = -1
							$smtpListRegExp = 'user_pref\("mail.smtpservers",[.]*'
							$smtpListFlag = -1
							$accountRegExp = '[.]*\.account[.]*\.[.]*'
							$idRegExp = '[.]*\.id[.]*\.[.]*'
							$serverRegExp = '[.]*\.server[.]*\.[.]*'
							While 1
								$line = FileReadLine($prefsjs)
								If @error = -1 Then ExitLoop
								If StringRegExp($line,$notSetupRegExp,1) <> 0 Then
									$notSetupFlag = $line
								EndIf
								If StringRegExp($line,$accountListRegExp,1) <> 0 Then
									$accountListFlag = $line
								EndIf
								If StringRegExp($line,$smtpListRegExp,1) <> 0 Then
									$smtpListFlag = $line
								EndIf
								If StringRegExp($line,$accountRegExp,1) <> 0 Then
									$RegExp = 'account[.]*'
									$array = StringSplit($line,".")
									$i=""
									For $i = 0 to UBound($array,1) - 1
										If StringRegExp($array[$i],$RegExp,1) <> 0 Then
											$tempNum = StringTrimLeft ($array[$i], 7 )
											If $tempNum > $num Then
												$num = $tempNum
											Endif
										Endif
									Next
								EndIf
								If StringRegExp($line,$idRegExp,1) <> 0 Then
									$RegExp = 'id[.]*'
									$array = StringSplit($line,".")
									$i=""
									For $i = 0 to UBound($array,1) - 1
										If StringRegExp($array[$i],$RegExp,1) <> 0 Then
											$tempNum = StringTrimLeft ($array[$i], 7 )
											If $tempNum > $num Then
												$num = $tempNum
											Endif
										Endif
									Next
								EndIf
								If StringRegExp($line,$serverRegExp,1) <> 0 Then
									$RegExp = 'server[.]*'
									$array = StringSplit($line,".")
									$i=""
									For $i = 0 to UBound($array,1) - 1
										If StringRegExp($array[$i],$RegExp,1) <> 0 Then
											$tempNum = StringTrimLeft ($array[$i], 7 )
											If $tempNum > $num Then
												$num = $tempNum
											Endif
										Endif
									Next
								EndIf
							Wend
							$num = $num + 1
							FileClose($prefsjs)
							GUICtrlSetData($progressbar, 50)
							If $notSetupFlag = -1 Then
								$tempfile = $appdir & "\Thunderbird\" & $found2 & "\prefs.js"
								$temp = FileOpen($tempfile,1)
								If $accountListFlag = -1 And $smtpListFlag = -1 Then
									FileWriteLine($temp, 'user_pref("mail.account.account1.identities", "id1");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.account.account1.server", "server1");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.account.account2.server", "server2");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.accountmanager.accounts", "account1,account2");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.accountmanager.defaultaccount", "account1");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.accountmanager.localfoldersserver", "server2");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.draft_folder", "imap://'	& $netid & '@mail.it.northwestern.edu/Drafts");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.drafts_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.fcc_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Sent");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.fcc_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.fullName", "' & $name & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.stationery_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Templates");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.tmpl_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.useremail", "' & $email & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.valid", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.imap", "' & $jsdir & 'ImapMail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.none", "' & $jsdir & 'Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.authMethod", 0);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.check_new_mail", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.directory", "' & $jsdir & 'ImapMail\\mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.directory-rel", "[ProfD]ImapMail/mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.hostname", "mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.login_at_startup", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.name", "NU Exchange");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.port", 993);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.socketType", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.type", "imap");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.userName", "' & $netid & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server2.directory", "' & $jsdir & 'Mail\\Local Folders");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server2.directory-rel", "[ProfD]Mail/Local Folders");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server2.hostname", "Local Folders");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server2.name", "Local Folders");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server2.type", "none");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server2.userName", "nobody");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtp.defaultserver", "smtp2");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.authMethod", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.description", "NU Exchange Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.hostname", "mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.port", 587);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.try_ssl", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.username", "' & $netid & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpservers", "smtp2");' & @CRLF)
								Else
									If $smtpListFlag <> -1 Then
										$array = StringSplit($smtpListFlag,'"')
										$i=UBound($array,1) - 2
										$array = StringSplit($array[$i],",")
										$i=UBound($array,1) - 1
										$smtpnum = StringTrimLeft($array[$i],4)
										$smtpnum = $smtpnum + 1
										$smtpListFlag = StringTrimRight($smtpListFlag,3)
										$smtpListFlag = $smtpListFlag & ',smtp' & $smtpnum & '");'
									Else
										$smtpnum = 1
										$smtpListFlag = 'user_pref("mail.smtpservers", "smtp1");'
									EndIf
									If $accountListFlag <> -1 Then
										$array = StringSplit($accountListFlag,",")
										$i=UBound($array,1) - 1
										$accountnum = StringTrimLeft($array[$i],7)
										$accountnum = StringTrimRight($accountnum,3)
										$accountnum = $accountnum + 1
										if $accountnum < $num Then
											$accountnum = $num
										EndIf
										$accountListFlag = StringTrimRight($accountListFlag,3)
										$accountListFlag = $accountListFlag & ',account' & $accountnum & '");'
									Else
										$accountnum = 1
										$accountListFlag = 'user_pref("mail.accountmanager.accounts", "account1,account2");'
									EndIf
									FileWriteLine($temp, $accountListFlag & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.accountmanager.defaultaccount", "account' & $accountnum & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.account.account' & $accountnum & '.identities", "id' & $accountnum & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.account.account' & $accountnum & '.server", "server' & $accountnum & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.authMethod", 0);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.check_new_mail", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.directory", "' & $jsdir & 'ImapMail\\mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.directory-rel", "[ProfD]ImapMail/mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.hostname", "mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.login_at_startup", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.name", "NU Exchange");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.port", 993);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.socketType", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.type", "imap");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.userName", "'& $netid & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.imap", "' & $jsdir & 'ImapMail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.none", "' & $jsdir & 'Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.draft_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Drafts");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.drafts_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fcc_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Sent");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fcc_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fullName", "' & $name & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.stationery_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Templates");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.tmpl_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.useremail", "' & $email & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.valid", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.authMethod", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.description", "NU Exchange Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.hostname", "Mail.it.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.port", 587);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.try_ssl", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.username", "'& $netid & '");' & @CRLF)
									FileWriteLine($temp, $smtpListFlag & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtp.defaultserver", "smtp' & $smtpnum & '");' & @CRLF)
								EndIf
								FileClose($temp)
								GUICtrlSetData($progressbar, 60)
								$available = WinExists("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
								if $available = 1 then
									WinClose("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
								Endif
								GUICtrlSetData($progressbar, 75)
								$ThunderbirdProcessFlag = ProcessExists("thunderbird.exe")
								GUICtrlSetData($progressbar, 85)
								If $ThunderbirdProcessFlag = 0 Then
									SearchOpen($ThunderbirdPath,"thunderbird.exe");replace with your search directory and file extension required
									sleep(3000)
								EndIf
								MozillaKill()
								sleep(1000)
								GUICtrlSetData($progressbar, 99)
								ThunderbirdFinished()
							Else
								ThunderbirdIsSetup()
							EndIf
						EndIf
					EndIf
				Endif
			Else
				ThunderbirdSetupNotOpen()
			Endif
		EndFunc
		
		Func OutlookExists()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			global $LabelID = GUICtrlCreateLabel("This account already exists in this profile and cannot be added" & @CRLF & "again.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowKill()
		EndFunc
		
		Func OutlookBadData()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200		
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			global $LabelID = GUICtrlCreateLabel("You're account could not be setup.  Please verify you entered" & @CRLF & "the correct password and e-mail address before executing" & @CRLF & "NU_E-mail_Config.exe.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowSuperKill()
		EndFunc
		
		Func OutlookSetupNotOpen()
			
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("An error occurred.  Please close all open" & @CRLF & "windows before executing NU_E-mail_Config.exe again.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowSuperKill()
		EndFunc
		
		Func OutlookFinished()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			global $LabelID = GUICtrlCreateLabel("Success! Your account has been set up in Outlook." & @CRLF & "Please enter your password to access your account.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Close", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func ThunderbirdFinished()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			global $LabelID = GUICtrlCreateLabel("Success! Your account has been set up in Thunderbird." & @CRLF & "Please enter your password to access your account.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Close", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func ThunderbirdSetupNotOpen()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("An error occurred.  Please close all open" & @CRLF & "windows before executing NU_E-mail_Config.exe again.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
			MozillaKill()
		EndFunc
		
		Func ThunderbirdIsSetup()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("Your NU Exchange account is allready setup.", $X+10, $Y+20)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+308, $Y+260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func FindOutlook()
			Global $OutlookVersion = "Outlook 2010"
			Global $OutlookRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\14.0\Outlook\InstallRoot", "Path")
			If @error Then
				$OutlookVersion = "Outlook 2007"
				$OutlookRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\12.0\Outlook\InstallRoot", "Path") 
				If @error Then
					$OutlookVersion = -1
					$OutlookRegPath = -1
				EndIf
			EndIf
		EndFunc
		
		Func FindThunderbird()
			Global $ThunderbirdVersion = "Thunderbird 3.1.9"
			Global $ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.9\bin", "PathToExe")
			If @error Then
				$ThunderbirdVersion = "Thunderbird 3.1.8"
				$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.8\bin", "PathToExe")
				If @error Then
					$ThunderbirdVersion = "Thunderbird 3.1.7"
					$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.7\bin", "PathToExe")
					If @error Then
						$ThunderbirdVersion = "Thunderbird 3.1.6"
						$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.6\bin", "PathToExe")
						If @error Then
							$ThunderbirdVersion = "Thunderbird 3.1.5"
							$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.5\bin", "PathToExe")
							If @error Then
								$ThunderbirdVersion = "Thunderbird 3.1.4"
								$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.4\bin", "PathToExe")
								If @error Then
									$ThunderbirdVersion = "Thunderbird 3.1.3"
									$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.3\bin", "PathToExe")
									If @error Then
										$ThunderbirdVersion = "Thunderbird 3.1.2"
										$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.2\bin", "PathToExe")
										If @error Then
											$ThunderbirdVersion = "Thunderbird 3.1.1"
											$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.1\bin", "PathToExe")
											If @error Then
												$ThunderbirdVersion = "Thunderbird 3.1"
												$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1\bin", "PathToExe")
												If @error Then
													$ThunderbirdVersion = "Thunderbird 3.0.11"
													$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.11\bin", "PathToExe")
													If @error Then
														$ThunderbirdVersion = "Thunderbird 3.0.10"
														$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.10\bin", "PathToExe")
														If @error Then
															$ThunderbirdVersion = "Thunderbird 3.0.9"
															$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.9\bin", "PathToExe")
															If @error Then
																$ThunderbirdVersion = "Thunderbird 3.0.8"
																$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.8\bin", "PathToExe")
																If @error Then	
																	$ThunderbirdVersion = "Thunderbird 3.0.7"
																	$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.7\bin", "PathToExe")
																	If @error Then
																		$ThunderbirdVersion = "Thunderbird 3.0.6"
																		$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.6\bin", "PathToExe")
																		If @error Then
																			$ThunderbirdVersion = "Thunderbird 3.0.5"
																			$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.5\bin", "PathToExe")
																			If @error Then
																				$ThunderbirdVersion = "Thunderbird 3.0.4"
																				$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.4\bin", "PathToExe")
																				If @error Then
																					$ThunderbirdVersion = "Thunderbird 3.0.3"
																					$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.3\bin", "PathToExe")
																					If @error Then
																						$ThunderbirdVersion = "Thunderbird 3.0.1"
																						$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.1\bin", "PathToExe")
																						If @error Then
																							$ThunderbirdVersion = "Thunderbird 3.0"
																							$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0\bin", "PathToExe")
																							If @error Then
																								$ThunderbirdVersion = "Thunderbird 2.0.0.23"
																								$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 2.0.0.23\bin", "PathToExe")
																								If @error Then
																									$ThunderbirdRegPath = -1
																									$ThunderbirdVersion = -1
																								EndIf
																							EndIf
																						EndIf
																					EndIf
																				EndIf
																			EndIf
																		EndIf
																	EndIf
																EndIf
															EndIf
														EndIf
													EndIf
												EndIf
											EndIf
										EndIf
									EndIf
								EndIf
							EndIf
						EndIf
					EndIf
				EndIf
			EndIf
		EndFunc
		
	;If choice e-mail client is not open this function will open it.
		Func SearchOpen($current,$filename)
			Local $search = FileFindFirstFile($current & "\*.*")
			While 1
				Dim $file = FileFindNextFile($search)
				If @error Or StringLen($file) < 1 Then ExitLoop
				If Not StringInStr(FileGetAttrib($current & "\" & $file), "D") And ($file <> "." Or $file <> "..") Then
					If $file = $filename then 
						run($current & "\" & $file)
					Endif
				EndIf
				If StringInStr(FileGetAttrib($current & "\" & $file), "D") And ($file <> "." Or $file <> "..") Then
					SearchOpen($current & "\" & $file, $filename)
				EndIf
			WEnd
			FileClose($search)
		EndFunc
		
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
		
		Func MozillaKill()
			$MaxTime = 0
			$StartSec = @Sec
			$x=1
			$timer = TimerInit()
			Do
				$Client = WinList("[CLASS:MozillaDialogClass]","")
				Local $iMax = UBound($Client)
				For $i = 1 to $iMax - 1 ; do for each copy
					WinClose($Client[$i][1])
				Next
				$x = $x + 1
				$dif = TimerDiff($timer)
			Until ($x = 6 or $dif > 5000)
		EndFunc
		
		Func WindowSuperKill()
			$MaxTime = 0
			$StartSec = @Sec
			$x=1
			$timer = TimerInit()
			Do
				$Client = WinList("[CLASS:#32770]","")
				Local $iMax = UBound($Client)
				For $i = 1 to $iMax - 1 ; do for each copy
					WinKill($Client[$i][1])
				Next
				$x = $x + 1
				$dif = TimerDiff($timer)
			Until ($x = 6 or $dif > 5000)
		EndFunc
		
		Func _GetAppDir()
			$old_opt = Opt ("ExpandEnvStrings", 1)
			$dir = "%APPDATA%"
			Opt ("ExpandEnvStrings", $old_opt)
			Return $dir
		EndFunc
		
		Func max()
			GUISetState(@SW_RESTORE, $GUIWindowID)
		EndFunc
		
		Func min()
            GUISetState(@SW_MINIMIZE, $GUIWindowID)
		EndFunc

		Func OnExit()
			GUIDelete()
			Exit
		EndFunc