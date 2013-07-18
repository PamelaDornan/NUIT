#include <Misc.au3>
#include <WinAPI.au3>
;

Global $hUser32_Dll = DllOpen("User32.dll")

HotKeySet("^e", "_Quit")

While 1
    If _IsPressed("01", $hUser32_Dll) Then
        ;Waiting untill the button is released
        While _IsPressed("01", $hUser32_Dll)
            Sleep(10)
        WEnd
        
        $hWindow = _WinGetHoveredHandle()
        $iCtrlID = _ControlGetHoveredID()
        
        $sWinClass = _WinAPI_GetClassName($hWindow)
        $sCtrlData = ControlGetText($hWindow, "", $iCtrlID)
        
        If $sWinClass = "SciCalc" And $iCtrlID <> 0 And $sCtrlData = "=" Then
            $sResult = Number(ControlGetText($hWindow, "", "Edit1"))
            ToolTip("The result has been calculated: " & $sResult, Default, Default, "Calc Info", 1, 5)
        Else
            ToolTip("")
        EndIf
    EndIf
    
    Sleep(10)
WEnd

Func _ControlGetHoveredID()
    Local $iOld_Opt_MCM = Opt("MouseCoordMode", 1)
    
    Local $hRet = DllCall("user32.dll", "int", "WindowFromPoint", "long", MouseGetPos(0), "long", MouseGetPos(1))
    
    $hRet = DllCall("user32.dll", "int", "GetDlgCtrlID", "hwnd", $hRet[0])
    If $hRet[0] < 0 Then $hRet[0] = 0
    
    Opt("MouseCoordMode", $iOld_Opt_MCM)
    
    Return $hRet[0]
EndFunc

Func _WinGetHoveredHandle()
    Local $iOld_Opt_MCM = Opt("MouseCoordMode", 1)
    Local $aRet = DllCall("user32.dll", "int", "WindowFromPoint", "long", MouseGetPos(0), "long", MouseGetPos(1))
    
    Opt("MouseCoordMode", $iOld_Opt_MCM)
    
    $aRet = DllCall("User32.dll", "hwnd", "GetAncestor", "hwnd", $aRet[0], "uint", 2) ;$GA_ROOT
    
    Return HWnd($aRet[0])
EndFunc

Func _Quit()
    DllClose($hUser32_Dll)
    Exit
EndFunc
