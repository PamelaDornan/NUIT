; #CONSTANTS# ===================================================================================================================
	; Events and messages
		Global Const $GUI_EVENT_CLOSE = -3
		Global Const $GUI_EVENT_MINIMIZE = -4
		Global Const $GUI_EVENT_RESTORE = -5
		Global Const $GUI_EVENT_MAXIMIZE = -6
		Global Const $GUI_EVENT_PRIMARYDOWN = -7
		Global Const $GUI_EVENT_PRIMARYUP = -8
		Global Const $GUI_EVENT_SECONDARYDOWN = -9
		Global Const $GUI_EVENT_SECONDARYUP = -10
		Global Const $GUI_EVENT_MOUSEMOVE = -11
		Global Const $GUI_EVENT_RESIZED = -12
		Global Const $GUI_EVENT_DROPPED = -13

		Global Const $GUI_RUNDEFMSG = 'GUI_RUNDEFMSG'

	; State
		Global Const $GUI_AVISTOP = 0
		Global Const $GUI_AVISTART = 1
		Global Const $GUI_AVICLOSE = 2

		Global Const $GUI_CHECKED = 1
		Global Const $GUI_INDETERMINATE = 2
		Global Const $GUI_UNCHECKED = 4

		Global Const $GUI_DROPACCEPTED = 8
		Global Const $GUI_NODROPACCEPTED = 4096
		Global Const $GUI_ACCEPTFILES = $GUI_DROPACCEPTED	; to be suppressed

		Global Const $GUI_SHOW = 16
		Global Const $GUI_HIDE = 32
		Global Const $GUI_ENABLE = 64
		Global Const $GUI_DISABLE = 128

		Global Const $GUI_FOCUS = 256
		Global Const $GUI_NOFOCUS = 8192
		Global Const $GUI_DEFBUTTON = 512

		Global Const $GUI_EXPAND = 1024
		Global Const $GUI_ONTOP = 2048


	; Font
		Global Const $GUI_FONTITALIC = 2
		Global Const $GUI_FONTUNDER = 4
		Global Const $GUI_FONTSTRIKE = 8


	; Resizing
		Global Const $GUI_DOCKAUTO = 0x0001
		Global Const $GUI_DOCKLEFT = 0x0002
		Global Const $GUI_DOCKRIGHT = 0x0004
		Global Const $GUI_DOCKHCENTER = 0x0008
		Global Const $GUI_DOCKTOP = 0x0020
		Global Const $GUI_DOCKBOTTOM = 0x0040
		Global Const $GUI_DOCKVCENTER = 0x0080
		Global Const $GUI_DOCKWIDTH = 0x0100
		Global Const $GUI_DOCKHEIGHT = 0x0200

		Global Const $GUI_DOCKSIZE = 0x0300	; width+height
		Global Const $GUI_DOCKMENUBAR = 0x0220	; top+height
		Global Const $GUI_DOCKSTATEBAR = 0x0240	; bottom+height
		Global Const $GUI_DOCKALL = 0x0322	; left+top+width+height
		Global Const $GUI_DOCKBORDERS = 0x0066	; left+top+right+bottom

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
		Global Const $BS_FLAT = 0x8000
		Global Const $BS_ICON = 0x0040
		Global Const $SS_BLACKRECT = 0x04
		Global Const $WS_POPUP = 0x80000000
		Global Const $WS_BORDER = 0x00800000
		Global Const $WS_DLGFRAME = 0x00400000
		Global Const $WS_POPUPWINDOW = 0x80880000
		Global Const $WS_SYSMENU = 0x00080000
		Global Const $WS_CAPTION = 0x00C00000
		
; #######MAIN######################################################################################################################
																															;######
AutoItSetOption("WinTitleMatchMode", 1)																						;######
																															;######
Global $OSversion = @OSVersion ;User's OS																					;######
Global $OSbit = @OSArch ;User's OS Bits																						;######
																															;######	
FindOutlook()																												;######
FindThunderbird()																											;######
																															;######
Opt("GuiOnEventMode",1)																										;######
																															;######
Global $GUIWindowID = GuiCreate("NU E-mail Config", 400, 300,-1,-1,$WS_POPUPWINDOW)											;######
GUISetFont (10)																												;######
Global $LabelID = GUICtrlCreateLabel("Welcome!", 20, 30)																	;######
Global $NextID = GuiCtrlCreateButton("Next>>", 221, 260, 80, 30,$BS_FLAT)													;######
GUICtrlSetOnEvent(-1,"EmailClientSelect")																					;######
Global $ExitID = GuiCtrlCreateButton("Cancel", 308, 260, 80, 30,$BS_FLAT)													;######
GUICtrlSetOnEvent(-1,"OnExit")																								;######
																															;######
GUISetOnEvent($GUI_EVENT_CLOSE,"OnExit")																					;######
GUISetBkColor(0xFFFFFF)																										;######
GuiSetState()  ; display the GUI																							;######
WinSetOnTop('NU E-mail Config', '', 1) ;Set GUI to allways be on top														;######
																															;######
While 1																														;######
	Sleep (10)																												;######
WEnd 																														;######
 																															;######
; #######END MAIN##################################################################################################################




; #FUNCTIONS#  ===================================================================================================================

    ;Displays Window Allowing User to Choose from Available E-mail Client options.
		Func EmailClientSelect()
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("OutlookID") = 1 Then
				GUICtrlDelete($OutlookID)
			EndIf
			If IsDeclared("ThunderbirdID") = 1 Then
				GUICtrlDelete($ThunderbirdID)
			EndIf
			Global $LabelID = GUICtrlCreateLabel("Pick your e-mail Client:", 10, 20)
			If ($OutlookVersion<>-1 And $ThunderbirdVersion <> -1) Then
				Global $OutlookID  = GUICtrlCreateRadio($OutlookVersion, 40, 50, 100, 20)
				Global $ThunderbirdID   = GUICtrlCreateRadio($ThunderbirdVersion, 160, 50, 150, 20)
			ElseIf ($OutlookVersion<>-1) Then
				Global $OutlookID  = GUICtrlCreateRadio($OutlookVersion, 40, 50, 100, 20)
			ElseIf ($ThunderbirdVersion<>"") Then
				Global $ThunderbirdID = GUICtrlCreateRadio($ThunderbirdVersion, 40, 50, 150, 20)
			EndIf
			If IsDeclared("NextID") = 1 Then
				GUICtrlDelete($NextID)
			EndIf
			Global $NextID = GuiCtrlCreateButton("Next>>", 221, 260, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ValidateClientChoice")
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
				OutlookInformationDisplay()
			ElseIf (IsDeclared("ThunderbirdID") = 1 And GUICtrlRead($ThunderbirdID) = 1) Then
				Global $uClient = "Thunderbird"
				If IsDeclared("OutlookID") = 1 Then
					GUICtrlDelete($OutlookID)
				EndIf
				If IsDeclared("ThunderbirdID") = 1 Then
					GUICtrlDelete($ThunderbirdID)
				EndIf
				ThunderbirdInformationDisplay()
			Else
				EmailClientSelect()
			EndIf
		EndFunc
		
	;If Outlook is chosen this function display user inputs for name, e-mail address and NetID password.
		Func OutlookInformationDisplay()
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("Provide the following information:", 10, 20)
			If IsDeclared("NameLabelID") <> 1 then
				Global $NameLabelID = GUICtrlCreateLabel("Your Name: ", 30, 55)
			EndIf
			If IsDeclared("NameInputID") <> 1 then
				Global $NameInputID = GUICtrlCreateInput("", 135, 52, 175, 20)
			EndIf
			If IsDeclared("EmailLabelID") <> 1 then
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address: ", 30, 85)
			EndIf
			If IsDeclared("EmailInputID") <> 1 then
				Global $EmailInputID = GUICtrlCreateInput("", 135, 82, 175, 20)
			EndIf
			If IsDeclared("PasswordLabelID") <> 1 then
				Global $PasswordLabelID = GUICtrlCreateLabel("NetID Password: ", 30, 115)
			EndIf
			If IsDeclared("PasswordInputID") <> 1 then
				Global $PasswordInputID = GUICtrlCreateInput("", 135, 112, 175, 20, $ES_PASSWORD)
			EndIf
			GUICtrlDelete($NextID)
			Global $NextID = GuiCtrlCreateButton("Next>>", 221, 260, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ValidateOutlook")
		EndFunc
		
		Func ThunderbirdInformationDisplay()
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("Provide the following information:", 10, 20)
			If IsDeclared("NameLabelID") <> 1 then
				Global $NameLabelID = GUICtrlCreateLabel("Your Name: ", 30, 55)
			EndIf
			If IsDeclared("NameInputID") <> 1 then
				Global $NameInputID = GUICtrlCreateInput("", 135, 52, 175, 20)
			EndIf
			If IsDeclared("EmailLabelID") <> 1 then
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address: ", 30, 85)
			EndIf
			If IsDeclared("EmailInputID") <> 1 then
				Global $EmailInputID = GUICtrlCreateInput("", 135, 82, 175, 20)
			EndIf
			If IsDeclared("NetidLabelID") <> 1 then
				Global $NetidLabelID = GUICtrlCreateLabel("NetID: ", 30, 115)
			EndIf
			If IsDeclared("NetidInputID") <> 1 then
				Global $NetidInputID = GUICtrlCreateInput("", 135, 112, 175, 20)
			EndIf
			If IsDeclared("PasswordLabelID") <> 1 then
				Global $PasswordLabelID = GUICtrlCreateLabel("NetID Password: ", 30, 145)
			EndIf
			If IsDeclared("PasswordInputID") <> 1 then
				Global $PasswordInputID = GUICtrlCreateInput("", 135, 142, 175, 20, $ES_PASSWORD)
			EndIf
			GUICtrlDelete($NextID)
			Global $NextID = GuiCtrlCreateButton("Next>>", 221, 260, 80, 30,$BS_FLAT)
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
				Global $ErrorNameLabelID = GUICtrlCreateLabel("*Required", 312, 55)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1; 
			EndIf
			If GUICtrlRead($EmailInputID) = "" Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Required", 312, 85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			ElseIf StringRegExp($temp, $sRegExp,1) = 0 Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Invalid", 312, 85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($PasswordInputID) = "" Then
				Global $ErrorPasswordLabelID = GUICtrlCreateLabel("*Required", 312, 115)
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
			If IsDeclared("ErrorPasswordLabelID") = 1 Then
				GUICtrlDelete($ErrorPasswordLabelID)
			EndIf
			
			If GUICtrlRead($NameInputID) = "" Then
				Global $ErrorNameLabelID = GUICtrlCreateLabel("*Required", 312, 55)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($EmailInputID) = "" Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Required", 312, 85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			ElseIf StringRegExp($temp, $sRegExp,1) = 0 Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Invalid", 312, 85)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($NetidInputID) = "" Then
				Global $ErrorNetidLabelID = GUICtrlCreateLabel("*Required", 312, 115)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($PasswordInputID) = "" Then
				Global $ErrorPasswordLabelID = GUICtrlCreateLabel("*Required", 312, 145)
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
			Global $LabelID = GUICtrlCreateLabel("Please Wait...", 10, 20)
			Global $progressbar = GUICtrlCreateProgress(10, 40, 280, 20, $PBS_SMOOTH)
			GUICtrlSetData($progressbar, 2)
			WindowKill() ;closes all windows in the 32770 class.
			GUICtrlSetData($progressbar, 4)
			If WinExists("[CLASS:#32770;TITLE:Mail Setup - Outlook]") Then 
				OutlookSetupNotOpen()
			ElseIf WinExists("[CLASS:#32770;TITLE:Mail]") Then 
				OutlookSetupNotOpen()
			Else
				Run('control mlcfg32.cpl')
				GUICtrlSetData($progressbar, 5)
				sleep(2000)
				WinActivate("[CLASS:#32770;TITLE:Mail Setup - Outlook]","")
				WinWait("[CLASS:#32770;TITLE:Mail Setup - Outlook]","")
				GUICtrlSetData($progressbar, 6)
				ControlClick("[CLASS:#32770;TITLE:Mail Setup - Outlook]", "", "[CLASS:Button; INSTANCE:1]","left",1,50,11)
				sleep(2000)
				WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
				$available = WinWait("[CLASS:#32770;TITLE:Account Settings]","",60)
				if $available = 0 Then 
					OutlookSetupNotOpen()
				Else
					Send ("{TAB}")
					Send ("{ENTER}")
					GUICtrlSetData($progressbar, 7)
					sleep(1000)
					WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
					$available = WinWait("[CLASS:#32770;TITLE:Add New Account]","",60)
					if $available = 0 Then 
						OutlookSetupNotOpen()
					Else
						$text = WinGetText("[CLASS:#32770;TITLE:Add New Account]")
						Global $result = StringInStr($text, "Manually configure server settings or additional server types")
						if $result = 0 Then
							WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
							$available = WinWait("[CLASS:#32770;TITLE:Add New Account]","",60)
							if $available = 0 Then 
								OutlookSetupNotOpen()
								Sleep(3000)
								OnExit()
							Endif
							Send ("{ENTER}")
							sleep(1000)
						EndIf
						Send ("{SPACE}")
						GUICtrlSetData($progressbar, 8)
						sleep(1000)
						Send ("{TAB}")
						GUICtrlSetData($progressbar, 9)
						Send($name)
						sleep(1000)
						Send ("{TAB}")
						GUICtrlSetData($progressbar, 10)
						Send($email)
						sleep(1000)
						Send ("{TAB}")
						GUICtrlSetData($progressbar, 11)
						Send($password)
						sleep(1000)
						Send ("{TAB}")
						GUICtrlSetData($progressbar, 12)
						Send($password)
						sleep(1000)
						Send ("{TAB}")
						If $result = 0 Then
							Send ("{TAB}")
						EndIf
						Send ("{ENTER}")
						GUICtrlSetData($progressbar, 13)
						$x = 14
						$wait = 0
						do
							GUICtrlSetData($progressbar, $x)
							$x = $x + 1
							sleep(1500)
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
							OutlookSetupNotOpen()
						Elseif WinActive("[CLASS:#32770;TITLE:Add New Account]", "Your e-mail account is successfully configured.") Then
							GUICtrlSetData($progressbar, 90)
							Send ("{ENTER}")
							GUICtrlSetData($progressbar, 92)
							sleep(2000)
							GUICtrlSetData($progressbar, 97)
							if WinActive("[CLASS:#32770;TITLE:Microsoft Outlook]", "") Then
								Send ("{ENTER}")
							EndIf
							Send("{ESC}")
							Send("{ESC}")
							Send("{ESC}")
							GUICtrlSetData($progressbar, 100)
							OutlookFinished()
						Elseif WinActive("[CLASS:#32770;TITLE:Microsoft Outlook]","") Then
							$text = WinGetText("[CLASS:#32770;TITLE:Microsoft Outlook]")
							$result = StringInStr($text, "This account already exists")
							if $result <> 0 Then
								OutlookExists()
							EndIf
						Else
							WinActivate("[CLASS:#32770;TITLE:Connect to]","")
							$available = ("[CLASS:#32770;TITLE:Connect to]","",180)
							If $available = 0 Then
								OutlookSetupNotOpen()
							Else
								sleep(2000)
								Send($password)
								Send ("{TAB}")
								Send ("{TAB}")
								Send ("{ENTER}")
								sleep(2000)
								If WinActivate("[CLASS:#32770;TITLE:Connect to]","") Then
									OutlookBadData()
								Else
									GUICtrlSetData($progressbar, 90)
									WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
									$available = WinWait("[CLASS:#32770;TITLE:Add New Account]","",60)
									If $available = 0 Then
										WindowKill()
										OutlookFinished()
									Else
										GUICtrlSetData($progressbar, 91)
										sleep(2000)
										GUICtrlSetData($progressbar, 93)
										Send ("{ENTER}")
										GUICtrlSetData($progressbar, 94)
										WinActivate("[CLASS:#32770;TITLE:Mail Delivery Location]","")
										$available = WinWait("[CLASS:#32770;TITLE:Mail Delivery Location]","",60)
										If $available = 0 Then
											WindowKill()
											OutlookFinished()
										Else
											GUICtrlSetData($progressbar, 95)
											Send ("{ENTER}")
											GUICtrlSetData($progressbar, 96)
											if $result = 0 Then
												WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
												$available = WinWait("[CLASS:#32770;TITLE:Account Settings]","",60)
												If $available = 0 Then
													WindowKill()
													OutlookFinished()
													Sleep(3000)
													OnExit()
												EndIf
												Send("{TAB}")
												Send("{TAB}")
												Send("{TAB}")
												Send("{Enter}")
											Endif
											GUICtrlSetData($progressbar, 98)
											sleep(3000);
											GUICtrlSetData($progressbar, 99)
											Send("{ESC}")
											Send("{ESC}")
											Send("{ESC}")
											GUICtrlSetData($progressbar, 100)
											OutlookFinished()
										EndIf
									EndIf
								EndIf
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
			Global $password = GUICtrlRead($PasswordInputID)
			GUICtrlDelete($LabelID)
			GUICtrlDelete($NameLabelID)
			GUICtrlDelete($NameInputID)
			GUICtrlDelete($EmailLabelID)
			GUICtrlDelete($EmailInputID)
			GUICtrlDelete($NetidLabelID)
			GUICtrlDelete($NetidInputID)
			GUICtrlDelete($PasswordLabelID)
			GUICtrlDelete($PasswordInputID)
			GUICtrlDelete($NextID)
			GUICtrlDelete($ExitID)
			Global $LabelID = GUICtrlCreateLabel("Please Wait...", 10, 20)
			Global $progressbar = GUICtrlCreateProgress(10, 40, 280, 20, $PBS_SMOOTH)
			GUICtrlSetData($progressbar, 1)
			Global $ThunderbirdPath = StringReplace($ThunderbirdRegPath, "thunderbird.exe", "")
			$ThunderbirdProcessFlag = ProcessExists("thunderbird.exe")
			If $ThunderbirdProcessFlag <> 0 Then
				$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
				$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $ThunderbirdProcessFlag, 'WQL', 0x10 + 0x20)
				For $objItem In $colItems
					$ThunderbirdProcessPath = $objItem.ExecutablePath 
				Next
			Else
				SearchOpen($ThunderbirdPath,"thunderbird.exe");replace with your search directory and file extension required
			EndIf
			If IsDeclared("ThunderbirdProcessPath") = 1 And $ThunderbirdRegPath <> $ThunderbirdProcessPath Then
				ThunderbirdSetupNotOpen()
			Else
				$available = WinExists ("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
				if $available = 1 then
					WinKill("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
				EndIf
				sleep(2000)
				MozillaKill()
				sleep(2000)
				WinActivate("[CLASS:MozillaUIWindowClass;TITLE:- Mozilla Thunderbird]","")
				$available = WinWait("[CLASS:MozillaUIWindowClass;TITLE:- Mozilla Thunderbird]","",60)
				if $available = 0 Then 
					ThunderbirdSetupNotOpen()
				Else
					Send("{ALT}{T}")
					sleep(2000)
					Send("{DOWN 11}")
					sleep(1000)
					Send("{ENTER}")
					sleep(1000)
					WinActivate("[TITLE:Account Settings;CLASS:MozillaDialogClass]","")
					$available = WinWait("[TITLE:Account Settings;CLASS:MozillaDialogClass]","",60)
					sleep(1000)
					if $available = 0 Then 
						ThunderbirdSetupNotOpen()
					Else
						sleep(1000)
						Send("{TAB}")
						sleep(1000)
						ControlClick("[TITLE:Account Settings;CLASS:MozillaDialogClass]", "", "[CLASS:MozillaWindowClass; INSTANCE:1]","left",1,124,486)
						Send("{SPACE}")
						sleep(1000)
						Send("{DOWN}")
						sleep(1000)
						Send("{ENTER}")
						WinActivate("[TITLE:Mail Account Setup;CLASS:MozillaDialogClass]","")
						$available = WinWait("[TITLE:Mail Account Setup;CLASS:MozillaDialogClass]","",60)
						sleep(1000)
						if $available = 0 Then 
							ThunderbirdSetupNotOpen()
						Else
							Send("{TAB}")
							sleep(1000)
							Send($name)
							sleep(1000)
							Send("{TAB}")
							sleep(1000)
							Send($email)
							sleep(1000)
							Send("{TAB}")
							sleep(1000)
							Send($password)
							sleep(1000)
							Send("{TAB}")
							sleep(1000)
							Send("{SPACE}")
							sleep(1000)
							Send("{TAB}")
							sleep(1000)
							Send("{TAB}")
							sleep(1000)
							Send("{ENTER}")
							sleep(1000)
							Send("{TAB 2}")
							Send("{ENTER}")
							sleep(1000)
							GUIDelete()
							msgbox(0,"","Done.")
						EndIf
					Endif
				Endif
			EndIf
		EndFunc
		
		Func OutlookExists()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			global $LabelID = GUICtrlCreateLabel("This account already exists in this profile and cannot be added" & @CRLF & "again.", 10, 20)
			WindowKill()
			Global $ExitID = GuiCtrlCreateButton("Cancel", 308, 260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func OutlookBadData()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			global $LabelID = GUICtrlCreateLabel("You're account could not be setup.  Please verify you entered" & @CRLF & "the correct password and e-mail address before executing" & @CRLF & "NU_E-mail_Config.exe.", 10, 20)
			WindowSuperKill()
			Global $ExitID = GuiCtrlCreateButton("Cancel", 308, 260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func OutlookSetupNotOpen()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			Global $LabelID = GUICtrlCreateLabel("An error occurred.  Please close all open" & @CRLF & "windows before executing NU_E-mail_Config.exe again.", 10, 20)
			WindowSuperKill()
			Global $ExitID = GuiCtrlCreateButton("Cancel", 308, 260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func OutlookFinished()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			global $LabelID = GUICtrlCreateLabel("Success! You may open Outlook to access your account.", 10, 20)
			Global $ExitID = GuiCtrlCreateButton("Cancel", 308, 260, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func ThunderbirdSetupNotOpen()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			Global $LabelID = GUICtrlCreateLabel("An error occurred.  Please close all open" & @CRLF & "windows before executing NU_E-mail_Config.exe again.", 10, 20)
			WindowSuperKill()
			Global $ExitID = GuiCtrlCreateButton("Cancel", 308, 260, 80, 30,$BS_FLAT)	
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

		Func OnExit()
			GUIDelete()
			Exit
		EndFunc