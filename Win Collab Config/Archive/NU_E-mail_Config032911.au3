#include <WinAPI.au3>
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
; ===============================================================================================================================

AutoItSetOption("WinTitleMatchMode", 1)

Global $OSversion = @OSVersion
Global $OSbit = @OSArch
Global $Office2010RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\14.0\Outlook\InstallRoot", "Path")
Global $Office2007RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\12.0\Outlook\InstallRoot", "Path")
Global $Thunderbird030109RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.9\bin", "PathToExe")

Opt("GuiOnEventMode",1)

$GUIWindowID = GuiCreate("NU E-mail Config", 400, 300)
$LabelID = GUICtrlCreateLabel("Welcome!", 10, 20)
$NextID = GuiCtrlCreateButton("Next", 290, 275, 50, 20)
GUICtrlSetOnEvent(-1,"EmailClientSelect")
$ExitID = GuiCtrlCreateButton("Cancel", 345, 275, 50, 20)
GUICtrlSetOnEvent(-1,"OnExit")

GUISetOnEvent($GUI_EVENT_CLOSE,"OnExit")

GuiSetState()  ; display the GUI
WinSetOnTop('NU E-mail Config', '', 1)
While 1
	Sleep (10)
WEnd 
 

; #FUNCTIONS#  ===================================================================================================================

    ;Displays Window Alerting User of Client Options
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
				Global $Outlook2010ID  = GUICtrlCreateRadio("Outlook 2010", 40, 50, 90, 20)
				Global $Thunderbird030109ID   = GUICtrlCreateRadio("Thunderbird 3.1.9", 140, 50, 150, 20)
			ElseIf ($Office2007RegPath<>"" And $Thunderbird030109RegPath<>"") Then
				Global $Outlook2007ID   = GUICtrlCreateRadio("Outlook 2007", 40, 50, 90, 20)
				Global $Thunderbird030109ID   = GUICtrlCreateRadio("Thunderbird 3.1.9", 140, 50, 150, 20)
			ElseIf ($Office2010RegPath<>"") Then
				Global $Outlook2010ID  = GUICtrlCreateRadio("Outlook 2010", 40, 50, 90, 20)
			ElseIf ($Office2007RegPath<>"") Then
				Global $Outlook2007ID   = GUICtrlCreateRadio("Outlook 2007", 40, 50, 90, 20)
			ElseIf ($Thunderbird030109RegPath<>"") Then
				Global $Thunderbird030109ID   = GUICtrlCreateRadio("Thunderbird 3.1.9", 40, 50, 150, 20)
			EndIf
			If IsDeclared("NextID") = 1 Then
				GUICtrlDelete($NextID)
			EndIf
			Global $NextID = GuiCtrlCreateButton("Next", 290, 275, 50, 20)
			GUICtrlSetOnEvent(-1,"ValidateClientChoice")
		EndFunc
		
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
		
		Func OutlookInformationDisplay()
			GUICtrlDelete($LabelID)
			Global $LabelID = GUICtrlCreateLabel("Provide the following information:", 10, 20)
			If IsDeclared("NameLabelID") <> 1 then
				Global $NameLabelID = GUICtrlCreateLabel("Your Name: ", 30, 50)
			EndIf
			If IsDeclared("NameInputID") <> 1 then
				Global $NameInputID = GUICtrlCreateInput("", 115, 47, 175, 20)
			EndIf
			If IsDeclared("EmailLabelID") <> 1 then
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address: ", 30, 75)
			EndIf
			If IsDeclared("EmailInputID") <> 1 then
				Global $EmailInputID = GUICtrlCreateInput("", 115, 72, 175, 20)
			EndIf
			If IsDeclared("PasswordLabelID") <> 1 then
				Global $PasswordLabelID = GUICtrlCreateLabel("NetID Password: ", 30, 100)
			EndIf
			If IsDeclared("PasswordInputID") <> 1 then
				Global $PasswordInputID = GUICtrlCreateInput("", 115, 97, 175, 20, $ES_PASSWORD)
			EndIf
			GUICtrlDelete($NextID)
			$NextID = GuiCtrlCreateButton("Next", 290, 275, 50, 20)
			GUICtrlSetOnEvent(-1,"ValidateOutlook")
		EndFunc
		
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
				Global $ErrorNameLabelID = GUICtrlCreateLabel("*Please Populate", 295, 50)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($EmailInputID) = "" Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Please Populate", 295, 75)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			ElseIf StringRegExp($temp, $sRegExp,1) = 0 Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Please Populate", 295, 75)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If GUICtrlRead($PasswordInputID) = "" Then
				Global $ErrorPasswordLabelID = GUICtrlCreateLabel("*Please Populate", 295, 100)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			If $flag=0 Then
				ConfigureOutlook()
			Else
				OutlookInformationDisplay()
			EndIf
		EndFunc
	
	;Function Checks to see if Selected Client is open and if not opens client
		Func OpenClient()
			If $uClient = "Outlook" Then
				$Outlook2010ProcessFlag = ProcessExists("OUTLOOK.EXE")
				If $Outlook2010ProcessFlag = 0 Then
					SearchOpen($Office2010RegPath,"outlook.exe");replace with your search directory and file extension required
					;WinWaitActive("- Microsoft Outlook","")
					;If WinExists("Connect to") Then
					;EndIf
				Else
					$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
					$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $Outlook2010ProcessFlag, 'WQL', 0x10 + 0x20)
					For $objItem In $colItems
						$Outlook2010ProcessPath = $objItem.ExecutablePath 
					Next
					$Office2010RegPath &= "OUTLOOK.EXE"
					If $Office2010RegPath = $Outlook2010ProcessPath Then
					Else 
						MsgBox(0, "NU E-mail Config Alert", "Error finding Outlook 2010.  Please close " & $Outlook2010ProcessPath & " and run NU_E-mail_Config.exe again.")
						Exit
					EndIf
				EndIf
				ConfigureOutlook()
			EndIf
		EndFunc
		
		Func ConfigureOutlook()
			$name = GUICtrlRead($NameInputID)
			$email = GUICtrlRead($EmailInputID)
			$password = GUICtrlRead($PasswordInputID)
			GUICtrlDelete($LabelID)
			GUICtrlDelete($NameLabelID)
			GUICtrlDelete($NameInputID)
			GUICtrlDelete($EmailLabelID)
			GUICtrlDelete($EmailInputID)
			GUICtrlDelete($PasswordLabelID)
			GUICtrlDelete($PasswordInputID)
			GUICtrlDelete($NextID)
			Global $LabelID = GUICtrlCreateLabel("*Please Wait...", 10, 20)
			Global $progressbar = GUICtrlCreateProgress(10, 40, 280, 20, $PBS_SMOOTH)
			$MaxTime = 0
			$StartSec = @Sec
			$x=1
			$timer = TimerInit()
			Do
				$Client = WinList("[CLASS:#32770]","")
				Local $iMax = UBound($Client)
				For $i = 1 to $iMax - 1 ; do for each copy
					WinClose($Client[$i][1])
					GUICtrlSetData($progressbar, $i)
				Next
				$x = $x + 1
				$dif = TimerDiff($timer)
			Until ($x = 6 or $dif > 7000)
			GUICtrlSetData($progressbar, 7)
			If WinExists("[CLASS:#32770;TITLE:Mail Setup - Outlook]") Then 
				MsgBox (0,"NU E-mail Config","Cannot open Mail Setup for Outlook.  Please close all open windows before executing NU_E-mail_Config.exe again.")
				Exit
			ElseIf WinExists("[CLASS:#32770;TITLE:Mail]") Then 
				MsgBox (0,"NU E-mail Config","Cannot open Mail Setup for Outlook.  Please close all open windows before executing NU_E-mail_Config.exe again.")
				Exit
			Else
				Run('control mlcfg32.cpl')
			EndIf
			GUICtrlSetData($progressbar, 8)
			sleep(3000)
			WinActivate("[CLASS:#32770;TITLE:Mail Setup - Outlook]","")
			WinWait("[CLASS:#32770;TITLE:Mail Setup - Outlook]","")
			GUICtrlSetData($progressbar, 9)
			ControlClick("[CLASS:#32770;TITLE:Mail Setup - Outlook]", "", "[CLASS:Button; INSTANCE:1]")
			sleep(3000)
			Send ("{TAB}")
			Send ("{ENTER}")
			GUICtrlSetData($progressbar, 10)
			sleep(2000)
			Send ("{SPACE}")
			GUICtrlSetData($progressbar, 11)
			sleep(2000)
			Send ("{TAB}")
			GUICtrlSetData($progressbar, 12)
			Send($name)
			sleep(2000)
			Send ("{TAB}")
			GUICtrlSetData($progressbar, 13)
			Send($email)
			sleep(2000)
			Send ("{TAB}")
			GUICtrlSetData($progressbar, 14)
			Send($password)
			sleep(2000)
			Send ("{TAB}")
			GUICtrlSetData($progressbar, 15)
			Send($password)
			sleep(2000)
			Send ("{TAB}")
			Send ("{ENTER}")
			GUICtrlSetData($progressbar, 16)
			$x = 17
			$wait = 0
			do
				GUICtrlSetData($progressbar, $x)
				$x = $x + 1
				sleep(5000)
				$wait = WinActive("[CLASS:#32770;TITLE:Connect to]", "")
				If $wait = 0 then
					$wait = WinActive("[CLASS:#32770;TITLE:Add New Account]", "Your e-mail account is successfully configured.")
				EndIf
			Until ($x = 90 or $wait <> 0)
			GUICtrlSetData($progressbar, 90)
			If ($wait = 0) then
				msgbox(0,"","ERROR")
				exit
			Elseif WinActive("[CLASS:#32770;TITLE:Add New Account]", "Your e-mail account is successfully configured.") Then
				Send ("{ENTER}")
				sleep(2000)
				if WinActive("[CLASS:#32770;TITLE:Microsoft Outlook]", "") Then
					Send ("{ENTER}")
				EndIf
			Else
				WinActivate("[CLASS:#32770;TITLE:Connect to]","")
				WinWait("[CLASS:#32770;TITLE:Connect to]","")
				sleep(2000)
				Send($password)
				Send ("{TAB}")
				Send ("{TAB}")
				Send ("{ENTER}")
				GUICtrlSetData($progressbar, 95)
				WinActivate("[CLASS:#32770;TITLE:Add New Account]","")
				WinWait("[CLASS:#32770;TITLE:Add New Account]","")
				sleep(2000)
				Send ("{ENTER}")
				GUICtrlSetData($progressbar, 100)
				WinActivate("[CLASS:#32770;TITLE:Mail Delivery Location]","")
				WinWait("[CLASS:#32770;TITLE:Mail Delivery Location]","")
				Send ("{ENTER}")
			EndIf
			OutlookFinished()
		EndFunc
		
		Func OutlookFinished()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			GUICtrlDelete($ExitID)
			$LabelID = GUICtrlCreateLabel("Success! You may open Outlook to access your account.", 10, 20)
			$ExitID = GuiCtrlCreateButton("Close", 345, 275, 50, 20)
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

		Func OnExit()
			Exit
		EndFunc