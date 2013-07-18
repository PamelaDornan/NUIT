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
$ExitID = GuiCtrlCreateButton("Cancel", 345, 275, 50, 20)
GUICtrlSetOnEvent(-1,"OnExit")

GUISetOnEvent($GUI_EVENT_CLOSE,"OnExit")
			
			$name = "Pamela Dornan"
			$email = "p-dornan@sbx.northwestern.edu"
			$password = "Password762"
			$LabelID = GUICtrlCreateLabel("*Please Wait...", 10, 20)
			$progressbar = GUICtrlCreateProgress(10, 40, 280, 20, $PBS_SMOOTH)
GuiSetState()  ; display the GUI
WinSetOnTop('NU E-mail Config', '', 1)
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
			Until ($x = 90 or $wait <> 0)
			If ($wait = 0) then
				msgbox(0,"","ERROR")
				exit
			EndIf
			GUICtrlSetData($progressbar, 90)
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
			msgbox(0,"","Done!")
;Func OnExit()
	;Exit
;EndFunc