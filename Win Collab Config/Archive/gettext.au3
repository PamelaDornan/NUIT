$s = WinGetText("[CLASS:#32770;TITLE:Add New Account]")
if ($s = "Add New E-mail Account" & @CRLF & "&E-mail Account" & @CRLF & "Te&xt Messaging (SMS)" & @CRLF & "&Other" & @CRLF & "Connect to an e-mail account provided by your Internet service provider (ISP) or your organization." & @CRLF & "Connect to a mobile messaging service." & @CRLF & "Connect to a server type shown below." & @CRLF & "< &Back" & @CRLF & "&Next >" & @CRLF & "Cancel") Then
Msgbox(0,"","Found!")
EndIf


msgbox(0,"",$s)