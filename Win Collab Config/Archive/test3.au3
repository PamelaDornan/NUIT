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
Global Const $WS_VISIBLE = 0x10000000
Global Const $BS_VCENTER = 0x0C00
Global Const $BS_DEFPUSHBUTTON = 0x0001
Global Const $BS_CENTER = 0x0300
Global Const $WS_CLIPSIBLINGS = 0x04000000
Global Const $WS_OVERLAPPEDWINDOW = 0x00CF0000
Global Const $GUI_WS_EX_PARENTDRAG = 0x00100000
Global Const $ES_PASSWORD = 0x0020
Global Const $LABEL_RED = 0xff0000
Global Const $PBS_SMOOTH = 0x01
Global Const $SS_BLACKRECT = 0x04
Global Const $SS_WHITERECT = 0x06
Global Const $SS_GRAYRECT = 0x05
Global Const $SS_NOTIFY = 0x0100
Global Const $SS_CENTER = 0x01
; Script generated by AutoBuilder 0.5 Prototype
Opt("GuiOnEventMode",1)
GUICreate("test",300,100)
$a = _GUICtrlCreateColorButton("test1",   5, 5, 50, 20, 0xff0000)
$b = _GUICtrlCreateColorButton("test2",  65, 5, 50, 20, 0x00ff00)
$c = _GUICtrlCreateColorButton("test3", 125, 5, 50, 20, 0x0000ff,0xffffff)
$d = _GUICtrlCreateColorButton("test4", 185, 5, 50, 20, 0xffff00)
$e = _GUICtrlCreateColorButton("test5", 245, 5, 50, 20, 0xffffff)
$f = _GUICtrlCreateColorButton("test6",   5, 35, 50, 20,0xffaa00)
$g = _GUICtrlCreateColorButton("test7",  65, 35, 50, 20,0xaaff00)
$h = _GUICtrlCreateColorButton("test8", 125, 35, 50, 20,0x00aaff,0xffffff)
$i = _GUICtrlCreateColorButton("test9", 185, 35, 50, 20,0xffffaa)
$j = _GUICtrlCreateColorButton("test10",245, 35, 50, 20,0xdddddd)
$k = _GUICtrlCreateColorButton("test11",  5, 65, 50, 20,0xffee00)
$l = _GUICtrlCreateColorButton("test12", 65, 65, 50, 20,0xccff00)
$m = _GUICtrlCreateColorButton("test13",125, 65, 50, 20,0x00ddff,0xffffff)
$n = _GUICtrlCreateColorButton("test14",185, 65, 50, 20,0xffeedd)
$o = _GUICtrlCreateColorButton("test15",245, 65, 50, 20,0x000000,0xffffff)
GUISetState ()



do
   $msg = GUIGetMsg()
    if $msg = $a[0] then msgbox(0, "colorbutton pressed","You pressed cb1",1)
    if $msg = $b[0] then msgbox(0, "colorbutton pressed","You pressed cb2",1)
    if $msg = $c[0] then msgbox(0, "colorbutton pressed","You pressed cb3",1)
    if $msg = $d[0] then msgbox(0, "colorbutton pressed","You pressed cb4",1)
    if $msg = $e[0] then msgbox(0, "colorbutton pressed","You pressed cb5",1)
    if $msg = $f[0] then msgbox(0, "colorbutton pressed","You pressed cb6",1)
    if $msg = $g[0] then msgbox(0, "colorbutton pressed","You pressed cb7",1)
    if $msg = $h[0] then msgbox(0, "colorbutton pressed","You pressed cb8",1)
    if $msg = $i[0] then msgbox(0, "colorbutton pressed","You pressed cb9",1)
    if $msg = $j[0] then msgbox(0,"colorbutton pressed","You pressed cb10",1)
    if $msg = $k[0] then msgbox(0,"colorbutton pressed","You pressed cb11",1)
    if $msg = $l[0] then msgbox(0,"colorbutton pressed","You pressed cb12",1)
    if $msg = $m[0] then msgbox(0,"colorbutton pressed","You pressed cb13",1)
    if $msg = $n[0] then msgbox(0,"colorbutton pressed","You pressed cb14",1)
    if $msg = $o[0] then msgbox(0,"colorbutton pressed","You pressed cb15",1)
until $msg = $GUI_EVENT_CLOSE


Func _GUICtrlCreateColorButton($text, $left, $top, $width, $height,$bkcolor,$fontcolor = 0x000000)
local $colbut[2]
$colbut[0] = GUICtrlCreateLabel("",$left,$top,$width,$height,$SS_BLACKRECT)
GUICtrlCreateLabel("",$left,$top,$width -1,$height -1,$SS_WHITERECT)
GUICtrlCreateLabel("",$left +1,$top +1,$width -2,$height -2,$SS_GRAYRECT)
$colbut[1] = GUICtrlCreateLabel($text,$left +1,$top + 1,$width -3,$height -3,$SS_NOTIFY & $SS_CENTER)
GUICtrlSetBkColor(-1,$bkcolor)
GUICtrlSetColor(-1,$fontcolor)
Return $colbut
EndFunc