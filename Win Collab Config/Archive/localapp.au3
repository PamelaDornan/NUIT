MsgBox (0, "", _GetAppDir())

Func _GetAppDir()
    $old_opt = Opt ("ExpandEnvStrings", 1)
    $dir = "%APPDATA%"
    Opt ("ExpandEnvStrings", $old_opt)
    Return $dir
EndFunc