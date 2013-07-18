#AutoIt3Wrapper_Res_Icon_Add=\\Jiminy.tss.northwestern.edu\tss projects\Support Services\Projects\AUTOIT\NU.ico
#include <ButtonConstants.au3>
GUICreate("Demo resource ICO's")
$h_Button1 = GUICtrlCreateButton("my picture button", 10, 20, 40, 40, $BS_ICON)
GUISetState()
For $x = 0 To 9
   $rc = TraySetIcon(@ScriptFullPath, -$x)
   $rc2 = GUICtrlSetImage($h_Button1, @ScriptFullPath, -$x)
   If $x < 5 Then
      TrayTip("Default ico:" & $x, "TraySetIcon rc:" & $rc & @LF & "GUICtrlSetImage rc:" & $rc2, 3)
   Else
      TrayTip("New ico:" & $x, "TraySetIcon rc:" & $rc & @LF & "GUICtrlSetImage rc:" & $rc2, 3)
   EndIf
   Sleep(2000)
Next
GUIDelete()