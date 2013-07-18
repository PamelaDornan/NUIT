$ProcessPath = ""
$RegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Office\14.0\Outlook\InstallRoot", "Path")
If $RegPath = -1 Then
	MsgBox(0, 'Error', 'Outlook 2011 is not installed on your computer.')
	Exit
Else
	$ProcessFlag = ProcessExists("OUTLOOK.EXE")
	If $ProcessFlag = 0 Then
		SearchOpen ($RegPath,"outlook.exe");replace with your search directory and file extension required
	Else
		$objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
		$colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $ProcessFlag, 'WQL', 0x10 + 0x20)
		For $objItem In $colItems
			$ProcessPath = $objItem.ExecutablePath 
		Next
		MsgBox(0, "Alert", $RegPath)
		MsgBox(0, "Alert", $ProcessPath)
		$RegPath &= "OUTLOOK.EXE"
		If $RegPath = $ProcessPath Then
			MsgBox(0, "Alert", "Office 2010 is allready running.")
		Else 
			MsgBox(0, "Alert", "The current mail client in use is not Office 2010.")
			Exit
		EndIf
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