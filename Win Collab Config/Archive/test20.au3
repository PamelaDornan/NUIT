#include <IE.au3>

_IEErrorHandlerRegister()
$oOutlook = ObjCreate("Outlook.Application")
If Not IsObj($oOutlook) Then
    MsgBox(0, "", "Unable to create object!")
    Exit
EndIf

$oNameSpace = $oOutlook.GetNameSpace ("MAPI")
$oAccounts = $oNameSpace.Accounts
$iCount = $oAccounts.Count
$sProp = ""
For $oAccount In $oAccounts
    With $oAccount
		If .SmtpAddress == "p-dornan@northwestern.edu" then
			$sProp = 1
		endif
    EndWith
Next
If $sProp == "" Then
msgbox(0,"","no account")
else
msgbox(0,"","found!")
endif