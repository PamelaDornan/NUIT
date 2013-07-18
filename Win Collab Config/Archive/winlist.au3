AutoItSetOption("WinTitleMatchMode", 4)
While
$Client = WinList("[CLASS:#32770]","")
ConsoleWrite("Debug: " & $Client[0][0] & @LF ) ; Count of windows returned
For $i = 1 to $Client[0][0] ; do for each copy
	If ($Client[$i][0] = "Mail Setup - Outlook" or $Client[$i][0] = "New RSS Feed" or $Client[$i][0] = "New Outlook Data File" or $Client[$i][0] = "MobileMe" or $Client[$i][0] = "Microsoft Office Outlook" or $Client[$i][0] = "Add New Account" or $Client[$i][0] = "New Outlook Data File" or $Client[$i][0] = "Account Settings" or $Client[$i][0] = "Subscription Options" or $Client[$i][0] = "Microsoft Outlook" or $Client[$i][0] = "Microsoft Outlook Address Book" or $Client[$i][0] = "New Internet Calendar Subscription" or $Client[$i][0] = "Microsoft Exchange" or $Client[$i][0] = "Outlook Data File Settings" or $Client[$i][0] = "Microsoft Exchange Proxy Settings" or $Client[$i][0] = "Mail Delivery Location" or $Client[$i][0] = "New Email Delivery Location" or $Client[$i][0] = "Repair Account" or $Client[$i][0] = "") Then
		WinClose($Client[$i][1])
	EndIf
Next
MsgBox(0,"","Done")