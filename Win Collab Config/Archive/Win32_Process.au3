$dir = _GetPIDPath('OUTLOOK.EXE')
MsgBox(0, '', $dir)

Func _GetPIDPath($exe)
	$Output = ""
    $pid = ProcessExists($exe)
    $objWMIService = ObjGet('winmgmts:\\localhost\root\CIMV2')
    $colItems = $objWMIService.ExecQuery ('SELECT * FROM Win32_Process WHERE ProcessId = ' & $pid, 'WQL', 0x10 + 0x20)
	If IsObj($colItems) then
		For $objItem In $colItems
			If $objItem.Caption Then $Output &= "Caption: " & $objItem.Caption & @CRLF
			If $objItem.Description Then $Output &= "Description: " & $objItem.Description & @CRLF
			;If $objItem.IdentifyingNumber Then $Output &= "IdentifyingNumber: " & $objItem.IdentifyingNumber & @CRLF
			If $objItem.InstallDate Then $Output &= "InstallDate: " & $objItem.InstallDate & @CRLF
			;If $objItem.InstallDate2 Then $Output &= "InstallDate2: " & WMIDateToDate($objItem.InstallDate2) & @CRLF
			;If $objItem.InstallLocation Then $Output &= "InstallLocation: " & $objItem.InstallLocation & @CRLF
			;If $objItem.InstallState  Then $Output &= "InstallState: " & $objItem.InstallState & @CRLF
			If $objItem.Name Then $Output &= "Name: " & $objItem.Name & @CRLF
			;If $objItem.PackageCache Then $Output &= "PackageCache: " & $objItem.PackageCache & @CRLF
			;If $objItem.SKUNumber Then $Output &= "SKUNumber: " & $objItem.SKUNumber & @CRLF
			;If $objItem.Vendor Then $Output &= "Vendor: " & $objItem.Vendor & @CRLF
			;If $objItem.Version Then $Output &= "Version: " & $objItem.Version & @CRLF
			If $objItem.ExecutablePath Then $Output &= "Path: " & $objItem.ExecutablePath & @CRLF
			;If $objItem.FileVersionInfo Then $Output &= "Version: " & $objItem.FileVersionInfo & @CRLF
			If $objItem.Caption Then $Output &= "Caption: " & $objItem.Caption & @CRLF;
			If $objItem.CommandLine Then $Output &= "CommandLine: " & $objItem.CommandLine & @CRLF;
			If $objItem.CreationClassName Then $Output &= "CreationClassName: " & $objItem.CreationClassName & @CRLF;
			If $objItem.CreationDate Then $Output &= "CreationDate: " & $objItem.CreationDate & @CRLF;
			If $objItem.CSCreationClassName Then $Output &= "CSCreationClassName: " & $objItem.CSCreationClassName & @CRLF;
			If $objItem.CSName Then $Output &= "CSName: " & $objItem.CSName & @CRLF;
			If $objItem.Description Then $Output &= "Description: " & $objItem.Description & @CRLF;
			If $objItem.ExecutablePath Then $Output &= "ExecutablePath: " & $objItem.ExecutablePath & @CRLF;
			If $objItem.ExecutionState Then $Output &= "ExecutionState: " & $objItem.ExecutionState & @CRLF;
			If $objItem.Handle Then $Output &= "Handle: " & $objItem.Handle & @CRLF;
			If $objItem.HandleCount Then $Output &= "HandleCount: " & $objItem.HandleCount & @CRLF;
			If $objItem.InstallDate Then $Output &= "InstallDate: " & $objItem.InstallDate & @CRLF;
			If $objItem.KernelModeTime Then $Output &= "KernelModeTime: " & $objItem.KernelModeTime & @CRLF;
     		If $objItem.MaximumWorkingSetSize Then $Output &= "MaximumWorkingSetSize: " & $objItem.MaximumWorkingSetSize & @CRLF;
     		If $objItem.MinimumWorkingSetSize Then $Output &= "MinimumWorkingSetSize: " & $objItem.MinimumWorkingSetSize & @CRLF;
     		If $objItem.Name Then $Output &= "Name: " & $objItem.Name & @CRLF;
     		If $objItem.OSCreationClassName Then $Output &= "OSCreationClassName: " & $objItem.OSCreationClassName & @CRLF;
     		If $objItem.OSName Then $Output &= "OSName: " & $objItem.OSName & @CRLF;
     		If $objItem.OtherOperationCount Then $Output &= "OtherOperationCount: " & $objItem.OtherOperationCount & @CRLF;
     		If $objItem.OtherTransferCount Then $Output &= "OtherTransferCount: " & $objItem.OtherTransferCount & @CRLF;
     		If $objItem.PageFaults Then $Output &= "PageFaults: " & $objItem.PageFaults & @CRLF;
     		If $objItem.PageFileUsage Then $Output &= "PageFileUsage: " & $objItem.PageFileUsage & @CRLF;
     		If $objItem.ParentProcessId Then $Output &= "ParentProcessId: " & $objItem.ParentProcessId & @CRLF;
     		If $objItem.PeakPageFileUsage Then $Output &= "PeakPageFileUsage: " & $objItem.PeakPageFileUsage & @CRLF;
     		If $objItem.PeakVirtualSize Then $Output &= "PeakVirtualSize: " & $objItem.PeakVirtualSize & @CRLF;
     		If $objItem.PeakWorkingSetSize Then $Output &= "PeakWorkingSetSize: " & $objItem.PeakWorkingSetSize & @CRLF;
     		If $objItem.Priority Then $Output &= "Priority: " & $objItem.Priority & @CRLF;
     		If $objItem.PrivatePageCount Then $Output &= "PrivatePageCount: " & $objItem.PrivatePageCount & @CRLF;
     		If $objItem.ProcessId Then $Output &= "ProcessId: " & $objItem.ProcessId & @CRLF;
     		If $objItem.QuotaNonPagedPoolUsage Then $Output &= "QuotaNonPagedPoolUsage: " & $objItem.QuotaNonPagedPoolUsage & @CRLF;
     		If $objItem.QuotaPagedPoolUsage Then $Output &= "QuotaPagedPoolUsage: " & $objItem.QuotaPagedPoolUsage & @CRLF;
     		If $objItem.QuotaPeakNonPagedPoolUsage Then $Output &= "QuotaPeakNonPagedPoolUsage: " & $objItem.QuotaPeakNonPagedPoolUsage & @CRLF;
     		If $objItem.QuotaPeakPagedPoolUsage Then $Output &= "QuotaPeakPagedPoolUsage: " & $objItem.QuotaPeakPagedPoolUsage & @CRLF;
     		If $objItem.ReadOperationCount Then $Output &= "ReadOperationCount: " & $objItem.ReadOperationCount & @CRLF;
     		If $objItem.ReadTransferCount Then $Output &= "ReadTransferCount: " & $objItem.ReadTransferCount & @CRLF;
     		If $objItem.SessionId Then $Output &= "SessionId: " & $objItem.SessionId & @CRLF;
     		If $objItem.Status Then $Output &= "Status: " & $objItem.Status & @CRLF;
			If $objItem.TerminationDate Then $Output &= "TerminationDate: " & $objItem.TerminationDate & @CRLF
     		If $objItem.ThreadCount Then $Output &= "ThreadCount: " & $objItem.ThreadCount & @CRLF;
     		If $objItem.UserModeTime Then $Output &= "UserModeTime: " & $objItem.UserModeTime & @CRLF;
     		If $objItem.VirtualSize Then $Output &= "VirtualSize: " & $objItem.VirtualSize & @CRLF;
     		If $objItem.WindowsVersion Then $Output &= "WindowsVersion: " & $objItem.WindowsVersion & @CRLF;
     		If $objItem.WorkingSetSize Then $Output &= "WorkingSetSize: " & $objItem.WorkingSetSize & @CRLF;
     		If $objItem.WriteOperationCount Then $Output &= "WriteOperationCount: " & $objItem.WriteOperationCount & @CRLF;
     		If $objItem.WriteTransferCount Then $Output &= "WriteTransferCount: " & $objItem.WriteTransferCount & @CRLF;
		Next
		Return $Output
	Else 
		MsgBox(0, '','Error')
	EndIf
EndFunc

Func WMIDateToDate($dtmDate)
    Return (Mid($dtmDate, 5, 2) & "/" & _
    Mid($dtmDate, 7, 2) & "/" & Left($dtmDate, 4) _
    & " " & Mid($dtmDate, 9, 2) & ":" & Mid($dtmDate, 11, 2) & ":" & Mid($dtmDate,13, 2))
EndFunc
