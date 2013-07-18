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
AutoItSetOption("WinTitleMatchMode", 1)																						;######																											;######
																															;######
Opt("GuiOnEventMode",1)																										;######						
$OutlookVersion = "Outlook 2010"
$ThunderbirdVersion = "Thunderbird 3.1.9"																															;######																																;######									;######
Global $GUIWindowID = GuiCreate("NU E-mail Config", @DesktopWidth-25, @DesktopHeight-100,-1,-1,$WS_POPUPWINDOW)				;######
Global $X = ((@DesktopWidth-25)/2) - 200																					;######
Global $Y = ((@DesktopHeight-100)/2) - 200	
Global $bullet = Chr(149)																				;######
GUISetFont (10)																												;######	
fileInstall("CollabBackground.bmp", @tempDir & "\CollabBackground.bmp")																;######	
Global $Pic = GUICtrlCreatePic(@tempDir & "\CollabBackground.bmp", $X-200, $Y-150, 800, 600)															;######
;Global $minID = GuiCtrlCreateButton("_", $X+489, $Y-56, 20, 20,$BS_FLAT)													;######
GUICtrlSetOnEvent(-1,"min")	
Global $LabelID = GUICtrlCreateLabel("Now, enter your user information, and click Next:", $X-60, $Y+10)
			If IsDeclared("NameLabelID") = 0 then
				Global $NameLabelID = GUICtrlCreateLabel("Your Name:", $X, $Y+65)
			EndIf
			If IsDeclared("NameInputID") = 0 then
				Global $NameInputID = GUICtrlCreateInput("", $X+105, $Y+62, 175, 20)
			EndIf
			If IsDeclared("EmailLabelID") = 0 then
				Global $EmailLabelID = GUICtrlCreateLabel("E-mail Address:", $X, $Y+95)
			EndIf
			If IsDeclared("EmailInputID") = 0 then
				Global $EmailInputID = GUICtrlCreateInput("", $X+105, $Y+92, 175, 20)
			EndIf
			If IsDeclared("NetidLabelID") = 0 then
				Global $NetidLabelID = GUICtrlCreateLabel("NetID: ", $X, $Y+125)
			EndIf
			If IsDeclared("NetidInputID") = 0 then
				Global $NetidInputID = GUICtrlCreateInput("", $X+105, $Y+122, 175, 20, $ES_PASSWORD)
			EndIf
			If IsDeclared("PasswordLabelID") = 0 then
				Global $PasswordLabelID = GUICtrlCreateLabel("NetID Password: ", $X, $Y+155)
			EndIf
			If IsDeclared("PasswordInputID") = 0 then
				Global $PasswordInputID = GUICtrlCreateInput("", $X+105, $Y+152, 175, 20, $ES_PASSWORD)
			EndIf
			Global $NextID = GuiCtrlCreateButton("Next>>", $X+315, $Y+250, 80, 30,$BS_FLAT)
Global $ExitID = GuiCtrlCreateButton("Close", $X+400, $Y+250, 80, 30,$BS_FLAT)	
											;######
GUICtrlSetOnEvent(-1,"OnExit")																						;######
GUISetBkColor(0xFFFFFF)																										;######
GuiSetState()  ; display the GUI																							;######
;WinSetOnTop('NU E-mail Config', '', 1) ;Set GUI to allways be on top														;######
TraySetOnEvent($TRAY_EVENT_PRIMARYDOWN, "max")																				;######
GUICtrlSetState ( $Pic, $GUI_DISABLE )																						;######
fileDelete(@tempDir & "\NUBackground.bmp")																					;######
While 1																														;######
	Sleep (10)																												;######
WEnd 																														;######
 																															;######
; #######END MAIN##################################################################################################################