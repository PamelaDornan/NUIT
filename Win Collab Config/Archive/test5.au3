			Global $ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.9\bin", "PathToExe")
			Global $ThunderbirdPath = StringReplace($ThunderbirdRegPath, "thunderbird.exe", "")
			msgbox(0,"",$ThunderbirdRegPath)
			$ThunderbirdProcessFlag = ProcessExists("thunderbird.exe")
			If $ThunderbirdProcessFlag = 0 Then
				msgbox(0,"",$ThunderbirdPath)
				SearchOpen($ThunderbirdPath,"thunderbird.exe");replace with your search directory and file extension required
				;WinWaitActive("- Microsoft Outlook","")
				;If WinExists("Connect to") Then
				;EndIf
			Else
				$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
				$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $Outlook2010ProcessFlag, 'WQL', 0x10 + 0x20)
				For $objItem In $colItems
					$ThunderbirdProcessPath = $objItem.ExecutablePath 
				Next
				If $ThunderbirdPath = $ThunderbirdProcessPath Then
				Else 
					MsgBox(0, "NU E-mail Config Alert", "Error finding Outlook 2010.  Please close " & $Outlook2010ProcessPath & " and run NU_E-mail_Config.exe again.")
					Exit
				EndIf
			EndIf
			
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