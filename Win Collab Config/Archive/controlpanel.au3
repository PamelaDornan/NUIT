			AutoItSetOption("WinTitleMatchMode", 1)
			If WinExists("Mail") Then
				While WinExists("Mail")
					if WinExists("Add New Account") then 
						WinClose("Add New Account")
						Send ("{ESC}")
					EndIf
					if WinExists("Microsoft Outlook") then 
						WinActivate("Microsoft Outlook","")
						Send ("{ESC}")
					EndIf
					WinClose("Mail")
					sleep(1000)
				WEnd
				Run('control mlcfg32.cpl')
			ElseIf WinExists("Account Settings") Then
				WinActivate("Account Settings","")
				While WinExists("Account Settings")
					Send ("{ESC}")
				WEnd
			Else
				Run('control mlcfg32.cpl')
			EndIf
			;sleep(1000)
			;WinActivate("Mail Setup - Outlook","")
			;sleep(1000)
			Msgbox(0,"","Done")
			;Else
				;While WinExists("Account Settings")
					;Send ("{ESC}")
				;WEnd
			;EndIf
			;msgbox(0,"","Initial Screen Should Only Be Open")
			
			;	Else
			;		$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
			;		$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $Outlook2010ProcessFlag, 'WQL', 0x10 + 0x20)
			;		For $objItem In $colItems
			;			$Outlook2010ProcessPath = $objItem.ExecutablePath 
			;		Next
			;		$Office2010RegPath &= "OUTLOOK.EXE"
			;		If $Office2010RegPath = $Outlook2010ProcessPath Then
			;		Else 
			;			MsgBox(0, "NU E-mail Config Alert", "Error finding Outlook 2010.  Please close " & $Outlook2010ProcessPath & " and run NU_E-mail_Config.exe again.")
			;			Exit
			;		EndIf
			;	EndIf
			;	ConfigureOutlook()
			;EndIf
			
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