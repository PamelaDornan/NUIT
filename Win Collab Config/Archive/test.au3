#include <GuiMenu.au3>
#Include <WinAPI.au3>

; Note:  $hGUI is the handle to the GUI/Window of interest
AutoItSetOption("WinTitleMatchMode", 2)
WinActivate("Add New Account","")
$s = ControlGetHandle("Add New Account","","")
$x = ControlGetFocus ("Add New Account")
MsgBox(64, "Test", $s & " - " & $x)
$y = ControlGetText ( "Add New Account", "", $s )
MsgBox(64, "Test", $y)
$path = _WinGetPath()
MsgBox(0,WinGetTitle(""),$path)

Func _WinGetPath($Title="", $strComputer='localhost')
    $win = WinGetTitle($Title)
    $pid = WinGetProcess($win)
   $wbemFlagReturnImmediately = 0x10
   $wbemFlagForwardOnly = 0x20
   $colItems = ""
   $objWMIService = ObjGet("winmgmts:\\" & $strComputer & "\root\CIMV2")
   $colItems = $objWMIService.ExecQuery ("SELECT * FROM Win32_Process WHERE ProcessId = " & $pid, "WQL", _
         $wbemFlagReturnImmediately + $wbemFlagForwardOnly)
   If IsObj($colItems) Then
      For $objItem In $colItems
         If $objItem.ExecutablePath Then Return $objItem.ExecutablePath
      Next
   EndIf
EndFunc