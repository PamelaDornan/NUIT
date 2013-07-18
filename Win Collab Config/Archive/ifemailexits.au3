;HKEY_CURRENT_USER\Software\Microsoft\Exchange\Client\Options\PickLogonProfile
;1 = "Prompt for a profile to be used"
;0 = "Always use this profile"
;HKEY_CURRENT_USER\Software\Microsoft\Windows NT\CurrentVersion\Windows Messaging Subsystem\Profiles

Global $ProfileDefault = RegRead("HKEY_CURRENT_USER\Software\Microsoft\Exchange\Client\Options", "PickLogonProfile")
Global $DefaultedProfile = RegRead("HKEY_CURRENT_USER\Software\Microsoft\Windows NT\CurrentVersion\Windows Messaging Subsystem\Profiles", "DefaultProfile")
msgbox(0,"",$ProfileDefault)
msgbox(0,"",$DefaultedProfile)
If ($DefaultedProfile==-1 or $DefaultedProfile==-2 or $DefaultedProfile=="") Then
	msgbox(0,"","No Profiles Exists")
Elseif  ($DefaultedProfile==1 or $DefaultedProfile==2 or $DefaultedProfile==3) Then
	msgbox(0,"","No Admin Access to computer")
Elseif ($ProfileDefault == 1) Then
	msgbox(0,"","Prompts for Profile")
Elseif ($ProfileDefault == 0) Then
	msgbox(0,"","Everything is ok");
	$oOApp = ObjCreate("Outlook.Application")
	msgbox (0,"",$oOApp)
	if ($oOApp <> 0) Then
		Global $myNamespace =$oOApp.GetNamespace("MAPI")
		msgbox (0,"",$myNamespace)
		Global $myfolder=$myNamespace.currentuser.address ;ERROR
		If @error Then
			msgbox (0,"","No Exchange Account");
		Else
			msgbox (0,"",$myfolder)
			Global $oMyError = ObjEvent("AutoIt.Error", "ComError")
			Global $UserObj = ObjGet("WinNT://" & @LogonDomain & "/" & @UserName)
		Endif
	Else
		MsgBox(0,"","No Microsoft Outlook profiles have been created. IN microsoft Windows, click the Start button, and then click Control Panel.  Click User Account, and then click Mail.  Click Show Profiles, and then click Add.")
	EndIf
Else
	msgbox(0,"","Error")
Endif 