#AutoIt3Wrapper_icon=NU.ico
#include <Misc.au3>
#include <WinAPI.au3>
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
		Global Const $WS_EX_TOOLWINDOW = 0x00000080
		
; #######MAIN######################################################################################################################
																															;######
AutoItSetOption("WinTitleMatchMode", 1)																						;######
																															;######
																															;######																						
FindOutlook()																												;######
FindThunderbird()																											;######
																															;######
Opt("GuiOnEventMode",1)																										;######						
																															;######																	
Global $GUIWindowID = GuiCreate("E-Mail Config Tool", @DesktopWidth-25, @DesktopHeight-100,-1,-1,$WS_POPUPWINDOW)				;######
Global $X = ((@DesktopWidth-25)/2) - 200																					;######
Global $Y = ((@DesktopHeight-100)/2) - 200	
Global $bullet = Chr(149)																									;######
GUISetFont (10)																												;######	
fileInstall("CollabBackground.bmp", @tempDir & "\CollabBackground.bmp")														;######	
Global $Pic = GUICtrlCreatePic(@tempDir & "\CollabBackground.bmp", $X-200, $Y-150, 800, 600)								;######												
Global $LabelID = GUICtrlCreateLabel("Automatic Set Up Tool for Microsoft Outlook and Thunderbird"& @CRLF & @CRLF & "Click Next to begin automatic configuration for Northwestern Collaboration Service."& @CRLF &"The tool is compatible with the following e-mail programs:"& @CRLF & @CRLF & @CRLF & @CRLF & @CRLF & "Please note that this tool works for Windows XP, Vista, and 7 operating systems only.", $X-60, $Y+30)			;######
Global $ListID = GUICtrlCreateLabel($bullet & "  Microsoft Outlook 2007 or 2010"& @CRLF & $bullet &"  Thunderbird 2.0.0.23 and up", $X, $Y+110)
Global $minID = GuiCtrlCreateButton("_", $X+489, $Y-56, 20, 20,$BS_FLAT)													;######
GUICtrlSetOnEvent(-1,"min")																									;######
Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)												;######
GUICtrlSetOnEvent(-1,"CheckSystem")																							;######
Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)												;######
GUICtrlSetOnEvent(-1,"OnExit")																								;######
																															;######
GUISetOnEvent($GUI_EVENT_CLOSE,"OnExit")																					;######
GUISetBkColor(0xFFFFFF)																										;######
GuiSetState()  ; display the GUI	
TraySetState(2)																												;######
WinSetOnTop('E-Mail Config Tool', '', 1) ;Set GUI to allways be on top														;######
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
			If IsDeclared("ListID") = 1 Then
				GUICtrlDelete($ListID)
			EndIf
			If IsDeclared("OutlookID") = 1 Then
				GUICtrlDelete($OutlookID)
			EndIf
			If IsDeclared("ThunderbirdID") = 1 Then
				GUICtrlDelete($ThunderbirdID)
			EndIf
			If ($OSversion <> "WIN_7" AND $OSversion <> "WIN_VISTA" AND $OSversion <> "WIN_XP" AND $OSversion <> "WIN_XPe") OR ($OSbit <> "X86" AND $OSbit <> "X64" AND $OSbit <> "IA64")Then
				Global $LabelID = GUICtrlCreateLabel("This tool is compatible with Windows XP, Vista, and 7 operating systems only."& @CRLF &"Your operating system is not compatible."& @CRLF & @CRLF &"Click Cancel to exit, or contact the NUIT Support Center at 847-491-HELP (4357) or"& @CRLF &"www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				EndIf
			Else
				EmailClientSelect()
			EndIf
		EndFunc

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
			If IsDeclared("NextID") = 1 Then
				GUICtrlDelete($NextID)
			EndIf
			If ($OutlookVersion<>-1 And $ThunderbirdVersion <>-1) Then
				Global $LabelID = GUICtrlCreateLabel("Choose the e-mail program that you would like to set up for use with Northwestern"& @CRLF &"Collaboration Services, and click Next:", $X-60, $Y+30)
				Global $OutlookID  = GUICtrlCreateRadio($OutlookVersion, $X+40, $Y+80, 100, 20)
				Global $ThunderbirdID   = GUICtrlCreateRadio($ThunderbirdVersion, $X+160, $Y+80, 150, 20)
				Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
				GUICtrlSetOnEvent(-1,"ValidateClientChoice")
			ElseIf ($OutlookVersion<>-1) Then
				Global $LabelID = GUICtrlCreateLabel("Choose the e-mail program that you would like to set up for use with Northwestern"& @CRLF &"Collaboration Services, and click Next:", $X-60, $Y+30)
				Global $OutlookID  = GUICtrlCreateRadio($OutlookVersion, $X+40, $Y+80, 100, 20)
				Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
				GUICtrlSetOnEvent(-1,"ValidateClientChoice")
			ElseIf ($ThunderbirdVersion<>-1) Then
				Global $LabelID = GUICtrlCreateLabel("Choose the e-mail program that you would like to set up for use with Northwestern"& @CRLF &"Collaboration Services, and click Next:", $X-60, $Y+30)
				Global $ThunderbirdID = GUICtrlCreateRadio($ThunderbirdVersion, $X+40, $Y+80, 150, 20)
				Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
				GUICtrlSetOnEvent(-1,"ValidateClientChoice")
			Else
				Global $LabelID = GUICtrlCreateLabel("There are no compatible e-mail programs found on your computer."& @CRLF & @CRLF &"This tool is compatible with the following e-mail programs:"& @CRLF & @CRLF & @CRLF & @CRLF & @CRLF & "Click Cancel to exit, or contact the NUIT Support Center at 847-491-HELP (4357) or"& @CRLF &"www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
				Global $ListID = GUICtrlCreateLabel($bullet & "  Microsoft Outlook 2007 or 2010"& @CRLF & $bullet &"  Thunderbird 2.0.0.23 and up", $X, $Y+95)
			EndIf
		EndFunc
		
	;Validates function EmailClientSelect.  Checks to see if a section is chosen, if so 
	;it will parse out the process to need function, otherwise it will return to 
	;EmailClientSelect until a client is choosen.
		Func ValidateClientChoice()
			If (IsDeclared("OutlookID") = 1 And GUICtrlRead($OutlookID) = 1) Then
				Global $uClient = "Outlook"
				If IsDeclared("LabelID") = 1 Then
					GUICtrlDelete($LabelID)
				EndIf
				If IsDeclared("OutlookID") = 1 Then
					GUICtrlDelete($OutlookID)
				EndIf
				If IsDeclared("ThunderbirdID") = 1 Then
					GUICtrlDelete($ThunderbirdID)
				EndIf
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				EndIf
				OutlookProfiles()
			ElseIf (IsDeclared("ThunderbirdID") = 1 And GUICtrlRead($ThunderbirdID) = 1) Then
				Global $uClient = "Thunderbird"
				If IsDeclared("LabelID") = 1 Then
					GUICtrlDelete($LabelID)
				EndIf
				If IsDeclared("OutlookID") = 1 Then
					GUICtrlDelete($OutlookID)
				EndIf
				If IsDeclared("ThunderbirdID") = 1 Then
					GUICtrlDelete($ThunderbirdID)
				EndIf
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				EndIf
				ThunderbirdOpenCheck()
			Else
				If IsDeclared("LabelID") = 1 Then
					GUICtrlDelete($LabelID)
				EndIf
				If IsDeclared("OutlookID") = 1 Then
					GUICtrlDelete($OutlookID)
				EndIf
				If IsDeclared("ThunderbirdID") = 1 Then
					GUICtrlDelete($ThunderbirdID)
				EndIf
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				EndIf
				EmailClientSelect()
			EndIf
		EndFunc
		
		Func OutlookProfiles()
			Global $ProfileDefault = RegRead("HKEY_CURRENT_USER\Software\Microsoft\Exchange\Client\Options", "PickLogonProfile")
			Global $DefaultedProfile = RegRead("HKEY_CURRENT_USER\Software\Microsoft\Windows NT\CurrentVersion\Windows Messaging Subsystem\Profiles", "DefaultProfile")
			If ($DefaultedProfile==-1 or $DefaultedProfile==-2 or $DefaultedProfile=="") Then
				NoProfile()
			Elseif  ($DefaultedProfile==1 or $DefaultedProfile==2 or $DefaultedProfile==3) Then
				OutlookSetupNotOpen()
			Elseif ($ProfileDefault == 1) Then
				ProfilePrompting()
			Elseif ($ProfileDefault == 0 or $ProfileDefault=="") Then
				OutlookOpenCheck()
			Else
				OutlookSetupNotOpen()
			Endif 
		EndFunc
		
		Func OutlookOpenCheck()
			WinSetOnTop('E-Mail Config Tool', '', 1) ;Set GUI to allways be on top	
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
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				Endif
				If IsDeclared("LabelID") = 1 Then
					GUICtrlDelete($LabelID)
				Endif
				If IsDeclared("ExitID") = 1 Then
					GUICtrlDelete($ExitID)
				Endif
				ConfigureOutlook()
			EndIf
		EndFunc
	
		Func ThunderbirdOpenCheck()
			WinSetOnTop('E-Mail Config Tool', '', 1) ;Set GUI to allways be on top	
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
				If IsDeclared("NextID") = 1 Then
					GUICtrlDelete($NextID)
				Endif
				If IsDeclared("LabelID") = 1 Then
					GUICtrlDelete($LabelID)
				Endif
				Global $LabelID = GUICtrlCreateLabel("Now, enter your user information, and click Next:", $X-60, $Y+10)
				Global $NameLabelID = GUICtrlCreateLabel("Your Name:", $X, $Y+65)
				Global $ErrorNameLabelID = GUICtrlCreateLabel(" (Joe Wildcat)", $X+280, $Y+62)
				Global $NameInputID = GUICtrlCreateInput("", $X+105, $Y+62, 175, 20)
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address:", $X, $Y+95)
				Global $ErrorEmailLabelID = GUICtrlCreateLabel(" (user@example.com)", $X+280, $Y+92)
				Global $EmailInputID = GUICtrlCreateInput("", $X+105, $Y+92, 175, 20)
				Global $NetidLabelID = GUICtrlCreateLabel("NetID: ", $X, $Y+125)
				Global $NetidInputID = GUICtrlCreateInput("", $X+105, $Y+122, 175, 20)
				;Global $PasswordLabelID = GUICtrlCreateLabel("NetID Password: ", $X, $Y+155)
				;Global $PasswordInputID = GUICtrlCreateInput("", $X+105, $Y+152, 175, 20, $ES_PASSWORD)
				ThunderbirdInformationDisplay()
			EndIf
		EndFunc
		
		Func CloseOutlookWait()
			WinSetOnTop('E-Mail Config Tool', '', 0) 
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			Endif
			Global $LabelID = GUICtrlCreateLabel("To continue set up, you must first close Microsoft Outlook." & @CRLF & "Please close Microsoft Outlook, and click Next to continue set up.", $X-60, $Y+30)
			If IsDeclared("NextID") = 1 Then
				GUICtrlDelete($NextID)
			Endif
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"OutlookOpenCheck")
		EndFunc
		
		Func CloseThunderbirdWait()
			WinSetOnTop('E-Mail Config Tool', '', 0) 
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			Endif
			Global $LabelID = GUICtrlCreateLabel("To continue set up, you must first close Thunderbird." & @CRLF & "Please close Thunderbird, and click Next to continue set up.", $X-60, $Y+30)
			If IsDeclared("NextID") = 1 Then
				GUICtrlDelete($NextID)
			Endif
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ThunderbirdOpenCheck")
		EndFunc
		
		Func ThunderbirdInformationDisplay()
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"ValidateThunderbird")
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
			If IsDeclared("ErrorPasswordLabelID") = 1 Then
				GUICtrlDelete($ErrorPasswordLabelID)
			EndIf
			If IsDeclared("ErrorNetidLabelID") = 1 Then
				GUICtrlDelete($ErrorNetidLabelID)
			EndIf
			If IsDeclared("NameExampleID") = 1 Then
				GUICtrlDelete($NameExampleID)
			EndIf
			If IsDeclared("EmailExampleID") = 1 Then
				GUICtrlDelete($EmailExampleID)
			EndIf
			If GUICtrlRead($NameInputID) = "" Then
				Global $ErrorNameLabelID = GUICtrlCreateLabel("*Required", $X+280, $Y+62,200,20)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			Else
				Global $ErrorNameLabelID = GUICtrlCreateLabel(" (Joe Wildcat)", $X+280, $Y+62)
			EndIf
			If GUICtrlRead($EmailInputID) = "" Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Required", $X+280, $Y+92,200,20)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			ElseIf StringRegExp($temp, $sRegExp,1) = 0 Then
				Global $ErrorEmailLabelID = GUICtrlCreateLabel("*Invalid", $X+280, $Y+92,200,20)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			Else
				Global $ErrorEmailLabelID = GUICtrlCreateLabel(" (user@example.com)", $X+280, $Y+92)
			EndIf
			If GUICtrlRead($NetidInputID) = "" Then
				Global $ErrorNetidLabelID = GUICtrlCreateLabel("*Required", $X+280, $Y+122)
				GUICtrlSetColor(-1, 0xff0000)   ; Red
				$flag=1;
			EndIf
			;If GUICtrlRead($PasswordInputID) = "" Then
			;	Global $ErrorPasswordLabelID = GUICtrlCreateLabel("*Required", $X+280, $Y+152)
			;	GUICtrlSetColor(-1, 0xff0000)   ; Red
			;	$flag=1;
			;EndIf
			If $flag=0 Then
				ConfigureThunderbird()
			Else
				ThunderbirdInformationDisplay()
			EndIf
		EndFunc
		
	;Function configures Outlook account by using control panel's Mail configuration set.	
		Func ConfigureOutlook()
			If IsDeclared("ExitID") = 1 Then
					GUICtrlDelete($ExitID)
			Endif
			Global $LabelID = GUICtrlCreateLabel("Processing. Please wait ...", $X-60, $Y+30)
			Global $progressbar = GUICtrlCreateProgress($X-40, $Y+60, 475, 20, $PBS_SMOOTH)
			GUICtrlSetData($progressbar, 10)
			WindowKill() ;closes all windows in the 32770 class.
			If WinExists("[CLASS:#32770;TITLE:Mail Setup - Outlook]") Then 
				OutlookSetupNotOpen()
			ElseIf WinExists("[CLASS:#32770;TITLE:Mail]") Then 
				OutlookSetupNotOpen()
			Else
				GUICtrlSetData($progressbar, 50)
				Run('control mlcfg32.cpl')
				GUICtrlSetData($progressbar, 60)
				sleep(2000)
				WinActivate("[CLASS:#32770;TITLE:Mail Setup]","")
				$available = WinExists("[CLASS:#32770;TITLE:Mail Setup]","")
				if $available = 0 Then
					OutlookSetupNotOpen()
				Else
					ControlSend ( "[CLASS:#32770;TITLE:Mail Setup]", "", "", "{ENTER}")
					GUICtrlSetData($progressbar, 70)
					sleep(2000)
					WinActivate("[CLASS:#32770;TITLE:Account Settings]","")
					$available = WinExists("[CLASS:#32770;TITLE:Account Settings]","")
					if $available = 0 Then 
						OutlookSetupNotOpen()
					Else
						ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{TAB}")
						ControlSend ( "[CLASS:#32770;TITLE:Account Settings]", "", "", "{ENTER}")
						GUICtrlSetData($progressbar, 80)
						sleep(2000)
						WinActivate("[CLASS:#32770;TITLE:Add New]","")
						$available = WinExists("[CLASS:#32770;TITLE:Add New]","")
						GUICtrlSetData($progressbar, 90)
						if $available = 0 Then 
							OutlookSetupNotOpen()
						Else
							$text = WinGetText("[CLASS:#32770;TITLE:Add New]")
							Global $result = StringInStr($text, "Manually configure server settings or additional server types")
							if $result = 0 Then
								sleep(2000)
								WinActivate("[CLASS:#32770;TITLE:Add New]","")
								$available = WinExists("[CLASS:#32770;TITLE:Add New]","")
								if $available = 0 Then 
									OutlookSetupNotOpen()
									Sleep(3000)
									OnExit()
								Endif
								ControlSend ( "[CLASS:#32770;TITLE:Add New]", "", "", "{ENTER}")
								sleep(1000)
							EndIf
							;GUICtrlDelete($LabelID)
							;WinSetOnTop('[CLASS:#32770;TITLE:Add New]', '', 0) 
							GUICtrlSetData($progressbar, 98)
							;Global $LabelID = GUICtrlCreateLabel("Processing. Please wait ...", $X-60, $Y+30)
							;Global $LabelID2 = GUICtrlCreateLabel("Please populate the Add New Account window with needed information and click Next.", $X-60, $Y+90)
							ControlSend ( "[CLASS:#32770;TITLE:Add New]", "", "", "{SPACE}")
							ControlSetText ( "[CLASS:#32770;TITLE:Add New]", "", "[CLASS:RichEdit20WPT; INSTANCE:1]", "")
							ControlSetText ( "[CLASS:#32770;TITLE:Add New]", "", "[CLASS:RichEdit20WPT; INSTANCE:2]", "")
							ControlSetText ( "[CLASS:#32770;TITLE:Add New]", "", "[CLASS:RichEdit20WPT; INSTANCE:3]", "")
							ControlSetText ( "[CLASS:#32770;TITLE:Add New]", "", "[CLASS:RichEdit20WPT; INSTANCE:4]", "")
							WinSetOnTop("[CLASS:#32770;TITLE:Add New]", "", 1)
							WinSetOnTop("[CLASS:#32770;TITLE:Add New]", "", 0)
							WinSetOnTop('E-Mail Config Tool', '', 0) 
							min()
							GUISetState(@SW_HIDE, $GUIWindowID)
							Msgbox(0,"E-Mail Config Tool","Please populate the 'Add New Account' window with needed information and then click Next.")
							Opt("WinDetectHiddenText",0);
							$wait = "0"
							$x=1
							$userquit = 1
							do
								$userquit = WinExists("[CLASS:#32770;TITLE:Add New]","")
								$wait = WinExists("[CLASS:#32770;TITLE:Add New]", "Configuring")
								$x=$x+1
							Until ($wait<>0 or $x>50000 or $userquit==0)
							if ( $wait<>0 and $userquit==1) then
								$wait = "0"
								$x = 0
								$userquit = 1
								do
									$userquit = WinExists("[CLASS:#32770;TITLE:Add New]","")
									$x = $x + 1
									sleep(50)
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
												$wait = WinExists("[CLASS:#32770;TITLE:Microsoft Outlook]", "account already exists")
											EndIf
											If $wait <> 0 then
												$wait = "Microsoft Outlook"
											Else
												If $wait = 0 then
													$wait = WinExists("[CLASS:#32770;TITLE:Add New]", "successfully configured.")
													If $wait <> 0 then
														$wait = "Add New Account"
													EndIf
												EndIf
											EndIf
										EndIf
									EndIf
								Until ($x = 5000000 or $userquit==0 or $wait == "Connect to" or $wait == "Add New Account" or $wait == "Microsoft Outlook" or $wait == "Windows Security")
								If (($wait == "Windows Security" or $wait == "Connect to") and $userquit==1) Then
									;GUICtrlSetData($progressbar, 91)
									
									$available = WinExists("[CLASS:#32770;TITLE:Connect to]","")
									$available2  = WinExists("[CLASS:#32770;TITLE:Windows Security]","")
									If $available == 0 AND $available2 == 0 Then
										GUISetState(@SW_SHOW,$GUIWindowID)
										GUISetState(@SW_MAXIMIZE,$GUIWindowID)
										max()
										OutlookSetupNotOpen()
									Else
										If $wait == "Connect to" Then
											ControlSetText ( "[CLASS:#32770;TITLE:Connect to]", "", "[CLASS:Edit; INSTANCE:2]", "ADS\")
											ControlFocus ("[CLASS:#32770;TITLE:Connect to]", "", "[CLASS:Edit; INSTANCE:2]")
										ElseIf $wait == "Windows Security" and  $OSversion == "WIN_VISTA" Then
											sleep(500)
											ControlSend( "[CLASS:#32770;TITLE:Windows Security]", "","","{DOWN 2}")
											sleep(500)
											ControlSetText ( "[CLASS:#32770;TITLE:Windows Security]", "", "[CLASS:Edit; INSTANCE:1]", "ADS\")
											ControlFocus ("[CLASS:#32770;TITLE:Windows Security]", "", "[CLASS:Edit; INSTANCE:1]")
										ElseIf $wait == "Windows Security" Then
											sleep(500)
											ControlSend( "[CLASS:#32770;TITLE:Windows Security]", "","","{DOWN 2}")
											sleep(500)
											ControlSetText ( "[CLASS:#32770;TITLE:Windows Security]", "", "[CLASS:Edit; INSTANCE:2]", "ADS\")
											ControlFocus ("[CLASS:#32770;TITLE:Windows Security]", "", "[CLASS:Edit; INSTANCE:2]")
										EndIf
										MsgBox ( 262144, "NUConfig","Please enter your NetID credentials. Be sure to use 'ADS\' + NetID as your User name.")
										Opt("WinDetectHiddenText",0);
										$wait = "0"
										$x=1
										$userquit = 1
										$available3  = 0
										do
											$available3  = WinExists("[CLASS:#32770;TITLE:Microsoft Outlook]", "account already exists")
											$userquit = WinExists("[CLASS:#32770;TITLE:Add New]","")
											$wait = WinExists("[CLASS:#32770;TITLE:Add New]", "successfully configured")
											$x=$x+1
										Until ($wait<>0 or $x>80000000 or $userquit==0 or $available3 == 1)
										If $available3 == 1 Then
											WinKill("[CLASS:#32770;TITLE:Connect to]", "")
											WinKill("[CLASS:#32770;TITLE:Windows Security]", "")
											GUISetState(@SW_SHOW,$GUIWindowID)
											GUISetState(@SW_MAXIMIZE,$GUIWindowID)
											max()
											OutlookExists()
										Elseif $wait == 1 then
											$wait = "1"
											$x=1
											do
												$wait = WinExists("[CLASS:#32770;TITLE:Add New]", "")
												$x=$x+1
											Until ($wait==0 or $x>80000000)
											if ( $wait==0) then 
												WinActivate("[CLASS:#32770;TITLE:Account Settings]")
												Send("!d")
												Sleep(1000)
												GUISetState(@SW_SHOW,$GUIWindowID)
												GUISetState(@SW_MAXIMIZE,$GUIWindowID)
												max()
												WinSetOnTop('E-Mail Config Tool', '', 1)
												OutlookFinished()
												WinKill( "[CLASS:#32770;TITLE:Account Settings]", "")
												WinKill( "[CLASS:#32770;TITLE:Mail Setup]", "")
											else 
												GUIDelete()
												Exit
											Endif
										Else
											GUIDelete()
											Exit
										Endif
									Endif
								Else
									Exit
								EndIf
							Else
								Exit
							EndIf
						EndIf
					EndIf
				EndIf
			EndIf
		EndFunc
		
		Func ConfigureThunderbird()
			Global $name = GUICtrlRead($NameInputID) 
			Global $email = GUICtrlRead($EmailInputID)
			Global $netid = GUICtrlRead($NetidInputID)
			;Global $password = GUICtrlRead($PasswordInputID)
			GUICtrlDelete($ErrorEmailLabelID)
			GUICtrlDelete($ErrorNameLabelID)
			GUICtrlDelete($LabelID)
			GUICtrlDelete($NameLabelID)
			GUICtrlDelete($NameInputID)
			GUICtrlDelete($EmailLabelID)
			GUICtrlDelete($EmailInputID)
			GUICtrlDelete($NetidLabelID)
			GUICtrlDelete($NetidInputID)
			;GUICtrlDelete($PasswordLabelID)
			;GUICtrlDelete($PasswordInputID)
			GUICtrlDelete($NextID)
			GUICtrlDelete($ExitID)
			GUICtrlDelete($minID)
			Global $LabelID = GUICtrlCreateLabel("Processing. Please wait ...", $X-60, $Y+30)
			Global $progressbar = GUICtrlCreateProgress($X-40, $Y+60, 475, 20, $PBS_SMOOTH)
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
							$notSetupRegExp = '[.]*imap.northwestern.edu[.]*'
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
									FileWriteLine($temp, 'user_pref("mail.identity.id1.draft_folder", "imap://'	& $netid & '@imap.northwestern.edu/Drafts");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.drafts_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.fcc_folder", "imap://'& $netid & '@imap.northwestern.edu/Sent");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.fcc_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.fullName", "' & $name & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.stationery_folder", "imap://'& $netid & '@imap.northwestern.edu/Templates");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.tmpl_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.useremail", "' & $email & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id1.valid", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.imap", "' & $jsdir & 'ImapMail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.none", "' & $jsdir & 'Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.authMethod", 0);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.check_new_mail", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.directory", "' & $jsdir & 'ImapMail\\imap.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.directory-rel", "[ProfD]ImapMail/imap.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server1.hostname", "imap.northwestern.edu");' & @CRLF)
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
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.hostname", "smtp.northwestern.edu");' & @CRLF)
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
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.directory", "' & $jsdir & 'ImapMail\\imap.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.directory-rel", "[ProfD]ImapMail/imap.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.hostname", "imap.northwestern.edu");' & @CRLF)
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
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.draft_folder", "imap://'& $netid & '@imap.northwestern.edu/Drafts");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.drafts_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fcc_folder", "imap://'& $netid & '@imap.northwestern.edu/Sent");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fcc_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fullName", "' & $name & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.stationery_folder", "imap://'& $netid & '@imap.northwestern.edu/Templates");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.tmpl_folder_picker_mode", "0");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.useremail", "' & $email & '");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.valid", true);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.authMethod", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.description", "NU Exchange Mail");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.hostname", "smtp.northwestern.edu");' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.port", 587);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.try_ssl", 3);' & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.username", "'& $netid & '");' & @CRLF)
									FileWriteLine($temp, $smtpListFlag & @CRLF)
									FileWriteLine($temp, 'user_pref("mail.smtp.defaultserver", "smtp' & $smtpnum & '");' & @CRLF)
								EndIf
								FileClose($temp)
								GUICtrlSetData($progressbar, 60)
								;$available = WinExists("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
								;if $available = 1 then
								;	WinClose("[CLASS:MozillaDialogClass;TITLE:Import Wizard]","")
								;Endif
								GUICtrlSetData($progressbar, 75)
								;$ThunderbirdProcessFlag = ProcessExists("thunderbird.exe")
								GUICtrlSetData($progressbar, 85)
								;If $ThunderbirdProcessFlag = 0 Then
								;	SearchOpen($ThunderbirdPath,"thunderbird.exe");replace with your search directory and file extension required
								;	sleep(3000)
								;EndIf
								;MozillaKill()
								;sleep(1000)
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
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("progressbar") = 1 Then
				GUICtrlDelete($progressbar)
			EndIf
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("A Northwestern Collaboration Services account for this e-mail program already exists and" & @CRLF & "cannot be added again." & @CRLF & @CRLF & "Click Cancel to exit, or contact the NUIT Support Center at 847-491-HELP (4357) or" & @CRLF & "www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowKill()
		EndFunc
		
		Func OutlookBadData()
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("progressbar") = 1 Then
				GUICtrlDelete($progressbar)
			EndIf
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200		
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("Account set up could not be completed. It could be that you provided incomplete or" & @CRLF & "inaccurate information.  Please click Cancel to exit this tool, and close all open windows" & @CRLF & "to restart the process." & @CRLF & @CRLF & "If this issue continues, contact the NUIT Support Center at 847-491-HELP (4357) or" & @CRLF & "www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowSuperKill()
		EndFunc
		
		Func NoProfile()
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("progressbar") = 1 Then
				GUICtrlDelete($progressbar)
			EndIf
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200		
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("No Microsoft Outlook profiles have been created. Before running the this tool again," & @CRLF & "please click the Start button, and then navigate to Control Panel > Mail.  Click Show" & @CRLF & "Profiles, and then click Add.  Also be sure the radio for 'Allways Use This Profile' is selected.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowSuperKill()
		EndFunc
		
		Func ProfilePrompting()
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("progressbar") = 1 Then
				GUICtrlDelete($progressbar)
			EndIf
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200		
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("No Microsoft Outlook profiles have been created.  Before running the this tool again," & @CRLF & "please click the Start button, and then navigate to Control Panel > Mail. Click Show" & @CRLF & "Profiles, and then select the radio for 'Allways Use This Profile'.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowSuperKill()
		EndFunc
		
		Func OutlookSetupNotOpen()
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("progressbar") = 1 Then
				GUICtrlDelete($progressbar)
			EndIf
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("An error occurred with account set up. Please click Cancel to exit this tool, and close all" & @CRLF & "open windows to restart the process." & @CRLF & @CRLF & "If this issue continues, contact the NUIT Support Center at 847-491-HELP (4357) or" & @CRLF & "www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
			WindowSuperKill()
		EndFunc
		
		Func OutlookFinished()
			If IsDeclared("LabelID") = 1 Then
				GUICtrlDelete($LabelID)
			EndIf
			If IsDeclared("progressbar") = 1 Then
				GUICtrlDelete($progressbar)
			EndIf
			fileDelete(@tempDir & "\loading_bar_animated.gif")
			;SearchOpen($OutlookRegPath,"OUTLOOK.EXE")			
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("Access to your Northwestern Collaboration Services account within Outlook has been" & @CRLF & "successfully added. You may now click Close and log into Outlook.  Note that you may" & @CRLF & "need to re-enter your ADS\NetID login and NetID password to begin.", $X-60, $Y+30)
			Global $CloseID = GuiCtrlCreateButton("Close", $X+400, $Y+250, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func ThunderbirdFinished()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("Access to your Northwestern Collaboration Services account within Thunderbird has been" & @CRLF & "successfully added. You may now click Close, and then open Thunderbird to access your" & @CRLF & "account. Note that you may need to re-enter your NetID password to begin.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Close", $X+400, $Y+250, 80, 30,$BS_FLAT)		
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func ThunderbirdSetupNotOpen()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("An error occurred with account set up. Please click Cancel to exit this tool, and close all" & @CRLF & "open windows to restart the process." & @CRLF & @CRLF & "If this issue continues, contact the NUIT Support Center at 847-491-HELP (4357) or" & @CRLF & "www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)		
			GUICtrlSetOnEvent(-1,"OnExit")
			MozillaKill()
		EndFunc
		
		Func ThunderbirdIsSetup()
			GUICtrlDelete($LabelID)
			GUICtrlDelete($progressbar)
			fileDelete(@tempDir & "\loading_bar_animated.gif")	
			Global $X = ((@DesktopWidth-25)/2) - 200	
			Global $Y = ((@DesktopHeight-100)/2) - 200	
			Global $LabelID = GUICtrlCreateLabel("A Northwestern Collaboration Services account for this e-mail program already exists and" & @CRLF & "cannot be added again." & @CRLF & @CRLF & "Click Cancel to exit, or contact the NUIT Support Center at 847-491-HELP (4357) or" & @CRLF & "www.it.northwestern.edu/supportcenter/ for additional assistance.", $X-60, $Y+30)
			Global $ExitID = GuiCtrlCreateButton("Cancel", $X+400, $Y+250, 80, 30,$BS_FLAT)	
			GUICtrlSetOnEvent(-1,"OnExit")
		EndFunc
		
		Func FindOutlook()
			If FileExists("C:\Program Files\Microsoft Office\Office14\Outlook.exe") then
				Global $OutlookVersion = "Outlook 2010"
				Global $OutlookRegPath = "C:\Program Files\Microsoft Office\Office14\"
			Elseif FileExists("C:\Program Files\Microsoft Office\Office12\Outlook.exe") Then
				Global $OutlookVersion = "Outlook 2007"
				Global $OutlookRegPath = "C:\Program Files\Microsoft Office\Office12\"
			Else
				Global $OutlookVersion = "Outlook 2010"
				Global $OutlookRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\14.0\Outlook\InstallRoot", "Path")
				If @error Then
					$OutlookVersion = "Outlook 2007"
					$OutlookRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\12.0\Outlook\InstallRoot", "Path") 
					If @error Then
						$OutlookVersion = -1
						$OutlookRegPath = -1
					Endif
				EndIf
			EndIf
		EndFunc
		
		#comments-start
			Global $OutlookVersion = "Outlook 2010"
			Global $OutlookRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\14.0\Outlook\InstallRoot", "Path")
			If @error Then
				$OutlookVersion = "Outlook 2007"
				$OutlookRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\12.0\Outlook\InstallRoot", "Path") 
				If @error Then
					If FileExists("C:\Program Files\Microsoft Office\Office14\Outlook.exe") then
						Global $OutlookVersion = "Outlook 2010"
						Global $OutlookRegPath = "C:\Program Files\Microsoft Office\Office14\"
					Elseif FileExists("C:\Program Files\Microsoft Office\Office12\Outlook.exe") Then
						Global $OutlookVersion = "Outlook 2007"
						Global $OutlookRegPath = "C:\Program Files\Microsoft Office\Office12\"
					Else
						$OutlookVersion = -1
						$OutlookRegPath = -1
					Endif
				EndIf
			EndIf
		EndFunc
		#comments-end
		
		Func FindThunderbird()
			$thversion = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird", "CurrentVersion")
			If @error then
				Global $ThunderbirdRegPath = -1
				Global $ThunderbirdVersion = -1
			else
				$version = StringSplit($thversion," ",2)
				$thversion = $version[0]
				$split = StringSplit($thversion,".",2)
				If $split[0] > 2 Then
					Global $ThunderbirdVersion = "Thunderbird " & $thversion
					Global $ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird " & $thversion & "\bin", "PathToExe")
				elseif $split[0] = 2 then
					$x = UBound($split)
					if $x = 4 AND $split[1] = 0 AND $split[2] = 0 AND ($split[3] = 23 OR $split[3] = 24)then
						Global $ThunderbirdVersion = "Thunderbird " & $thversion
						Global $ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird " & $thversion & "\bin", "PathToExe")
					else
						Global $ThunderbirdRegPath = -1
						Global $ThunderbirdVersion = -1
					endif
				else
					Global $ThunderbirdRegPath = -1
					Global $ThunderbirdVersion = -1
				endif
			Endif
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