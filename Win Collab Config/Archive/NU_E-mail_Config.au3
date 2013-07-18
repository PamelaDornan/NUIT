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
; Path of Office 2010 if Installed																							;######
Global $Office2010RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\14.0\Outlook\InstallRoot", "Path") 		;######
; Path of Office 2007 if Installed																							;######
Global $Office2007RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\12.0\Outlook\InstallRoot", "Path") 		;######
; Path of Thunderbird 3.1.9 if Installed																					;######
Global $Thunderbird030109RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.9\bin", "PathToExe");######
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
			If IsDeclared("Outlook2010ID") = 1 Then
				GUICtrlDelete($Outlook2010ID)
			EndIf
			If IsDeclared("Outlook2007ID") = 1 Then
				GUICtrlDelete($Outlook2007ID)
			EndIf
			If IsDeclared("Thunderbird030109ID") = 1 Then
				GUICtrlDelete($Thunderbird030109ID)
			EndIf
			Global $LabelID = GUICtrlCreateLabel("Pick your e-mail Client:", 10, 20)
			If ($Office2010RegPath<>"" And $Thunderbird030109RegPath<>"") Then
				Global $Outlook2010ID  = GUICtrlCreateRadio("Outlook 2010", 40, 50, 100, 20)
				Global $Thunderbird030109ID   = GUICtrlCreateRadio("Thunderbird 3.1.9", 160, 50, 150, 20)
			ElseIf ($Office2007RegPath<>"" And $Thunderbird030109RegPath<>"") Then
				Global $Outlook2007ID   = GUICtrlCreateRadio("Outlook 2007", 40, 50, 100, 20)
				Global $Thunderbird030109ID   = GUICtrlCreateRadio("Thunderbird 3.1.9", 160, 50, 150, 20)
			ElseIf ($Office2010RegPath<>"") Then
				Global $Outlook2010ID  = GUICtrlCreateRadio("Outlook 2010", 40, 50, 100, 20)
			ElseIf ($Office2007RegPath<>"") Then
				Global $Outlook2007ID   = GUICtrlCreateRadio("Outlook 2007", 40, 50, 100, 20)
			ElseIf ($Thunderbird030109RegPath<>"") Then
				Global $Thunderbird030109ID   = GUICtrlCreateRadio("Thunderbird 3.1.9", 40, 50, 150, 20)
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
			If (IsDeclared("Outlook2010ID") = 1 And GUICtrlRead($Outlook2010ID) = 1) Then
				Global $uClient = "Outlook"
				If IsDeclared("Outlook2010ID") = 1 Then
					GUICtrlDelete($Outlook2010ID)
				EndIf
				If IsDeclared("$Outlook2007ID") = 1 Then
					GUICtrlDelete($Outlook2007ID)
				EndIf
				If IsDeclared("Thunderbird030109ID") = 1 Then
					GUICtrlDelete($Thunderbird030109ID)
				EndIf
				OutlookInformationDisplay()
			ElseIf (IsDeclared("Outlook2007ID") = 1 And GUICtrlRead($Outlook2007ID) = 1) Then
				Global $uClient = "Outlook"
				If IsDeclared("Outlook2010ID") = 1 Then
					GUICtrlDelete($Outlook2010ID)
				EndIf
				If IsDeclared("$Outlook2007ID") = 1 Then
					GUICtrlDelete($Outlook2007ID)
				EndIf
				If IsDeclared("Thunderbird030109ID") = 1 Then
					GUICtrlDelete($Thunderbird030109ID)
				EndIf
				OutlookInformationDisplay()
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

	;Function Checks to see if Selected Client is open and if not opens client;  Currently Not in use.
	;	Func OpenClient()
	;		If $uClient = "Outlook" Then
	;			$Outlook2010ProcessFlag = ProcessExists("OUTLOOK.EXE")
	;			If $Outlook2010ProcessFlag = 0 Then
	;				SearchOpen($Office2010RegPath,"outlook.exe");replace with your search directory and file extension required
	;				;WinWaitActive("- Microsoft Outlook","")
	;				;If WinExists("Connect to") Then
	;				;EndIf
	;			Else
	;				$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
	;				$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $Outlook2010ProcessFlag, 'WQL', 0x10 + 0x20)
	;				For $objItem In $colItems
	;					$Outlook2010ProcessPath = $objItem.ExecutablePath
	;				Next
	;				$Office2010RegPath &= "OUTLOOK.EXE"
	;				If $Office2010RegPath = $Outlook2010ProcessPath Then
	;				Else
	;					MsgBox(0, "NU E-mail Config Alert", "Error finding Outlook 2010.  Please close " & $Outlook2010ProcessPath & " and run NU_E-mail_Config.exe again.")
	;					Exit
	;				EndIf
	;			EndIf
	;			ConfigureOutlook()
	;		EndIf
	;	EndFunc

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
				ControlClick("[CLASS:#32770;TITLE:Mail Setup - Outlook]", "", "[CLASS:Button; INSTANCE:1]")
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
							$available = WinWait("[CLASS:#32770;TITLE:Connect to]","",180)
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

		Func OnExit()
			GUIDelete()
			Exit
		EndFunc
