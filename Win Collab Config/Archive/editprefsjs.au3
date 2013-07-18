Global $name = 'Pamela Dornan' 
Global $email = 'p-dornan@northwestern.edu'
Global $netid = 'pdo762'
Global $server = 'mail.it.northwestern.edu'
Global $appdir = _GetAppDir()
If FileExists($appdir & "\Thunderbird\profiles.ini") Then
	$file = $appdir & "\Thunderbird\profiles.ini"
	$file1 = FileOpen($file, 0)
	If $file1 = -1 Then
		msgbox(0,"","Error Reading File")
	Else	
		$found = 0
		$sRegExp = 'Path=[.]*'
		While 1
			$line = FileReadLine($file1)
			If @error = -1 Then ExitLoop
			If StringRegExp($line,$sRegExp,1) = 0 Then
			Else
				MsgBox (0,"","Found!")
				$found = StringTrimLeft($line, 5)
				ExitLoop
			EndIf
		Wend
		msgbox(0,"",$found)
		if $found == "0" Then
			msgbox(0,"","Error")
		Else
			$found2=(StringReplace($found, "/", "\"))
			$file = $appdir & "\Thunderbird\" & $found2 & "\prefs.js"
			;'C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\'
			$x = $appdir & "\Thunderbird\" & $found2 & "\"
			$jsdir = StringReplace ( $x, "/", "//")
			msgbox(0,"",$jsdir)
			$prefsjs = FileOpen($file, 0)
			;msgbox(0,"",$prefsjs)
			If $prefsjs = -1 Then
				msgbox(0,"","Error Reading File")
			Else
				$num = 0
				$notSetupRegExp = '[.]*mail.it.northwestern.edu[.]*'
				$notSetupFlag = -1
				$accountListRegExp = 'user_pref\("mail.accountmanager.accounts",[.]*'
				$accountListFlag = -1
				$smtpListRegExp = 'user_pref\("mail.smtpservers",[.]*'
				$smtpListFlag = -1
				$accountRegExp = '[.]*\.account[.]*\.[.]*'
				$idRegExp = '[.]*\.id[.]*\.[.]*'
				$serverRegExp = '[.]*\.server[.]*\.[.]*'
				While 1
					$line = FileReadLine($prefsjs)
					If @error = -1 Then ExitLoop
					;msgbox(0,"",$line)
					If StringRegExp($line,$notSetupRegExp,1) <> 0 Then
						;msgbox(0,"","Version Line found Changing Flag1")
						$notSetupFlag = $line
					EndIf
					If StringRegExp($line,$accountListRegExp,1) <> 0 Then
						;msgbox(0,"","Version Line found Changing Flag1")
						$accountListFlag = $line
					EndIf
					If StringRegExp($line,$smtpListRegExp,1) <> 0 Then
						;msgbox(0,"","Version Line found Changing Flag2")
						$smtpListFlag = $line
					EndIf
					If StringRegExp($line,$accountRegExp,1) <> 0 Then
						$RegExp = 'account[.]*'
						$array = StringSplit($line,".")
						$i=""
						For $i = 0 to UBound($array,1) - 1
							If StringRegExp($array[$i],$RegExp,1) <> 0 Then
								$tempNum = StringTrimLeft ($array[$i], 7 )
								If $tempNum > $num Then
									$num = $tempNum
								Endif
							Endif
						Next
					EndIf
					If StringRegExp($line,$idRegExp,1) <> 0 Then
						$RegExp = 'id[.]*'
						$array = StringSplit($line,".")
						$i=""
						For $i = 0 to UBound($array,1) - 1
							If StringRegExp($array[$i],$RegExp,1) <> 0 Then
								$tempNum = StringTrimLeft ($array[$i], 7 )
								If $tempNum > $num Then
									$num = $tempNum
								Endif
							Endif
						Next
					EndIf
					If StringRegExp($line,$serverRegExp,1) <> 0 Then
						$RegExp = 'server[.]*'
						$array = StringSplit($line,".")
						$i=""
						For $i = 0 to UBound($array,1) - 1
							If StringRegExp($array[$i],$RegExp,1) <> 0 Then
								$tempNum = StringTrimLeft ($array[$i], 7 )
								If $tempNum > $num Then
									$num = $tempNum
								Endif
							Endif
						Next
					EndIf
				Wend
				$num = $num + 1
				FileClose($prefsjs)
				If $notSetupFlag = -1 Then
					$tempfile = $appdir & "\Thunderbird\" & $found2 & "\user.js"
					$temp = FileOpen($tempfile,2)
					If $accountListFlag = -1 And $smtpListFlag = -1 Then
						FileWriteLine($temp, 'user_pref("mail.account.account1.identities", "id1");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.account.account1.server", "server1");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.account.account2.server", "server2");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.accountmanager.accounts", "account1,account2");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.accountmanager.defaultaccount", "account1");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.accountmanager.localfoldersserver", "server2");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.draft_folder", "imap://'	& $netid & '@mail.it.northwestern.edu/Drafts");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.drafts_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.fcc_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Sent");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.fcc_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.fullName", "' & $name & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.stationery_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Templates");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.tmpl_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.useremail", "' & $email & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id1.valid", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap", "' & $jsdir & 'ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none", "' & $jsdir & 'Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.authMethod", 0);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.check_new_mail", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.directory", "' & $jsdir & 'ImapMail\\'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.directory-rel", "[ProfD]ImapMail/'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.hostname", "'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.login_at_startup", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.name", "NU Exchange");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.port", 993);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.socketType", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.type", "imap");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.userName", "' & $netid & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.directory", "' & $jsdir & 'Mail\\Local Folders");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.directory-rel", "[ProfD]Mail/Local Folders");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.hostname", "Local Folders");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.name", "Local Folders");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.type", "none");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.userName", "nobody");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtp.defaultserver", "smtp2");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.authMethod", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.description", "NU Exchange Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.hostname", "'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.port", 587);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.try_ssl", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp2.username", "' & $netid & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpservers", "smtp2");' & @CRLF)
					Else
						If $smtpListFlag <> -1 Then
							$array = StringSplit($smtpListFlag,",")
							$i=UBound($array,1) - 1
							$smtpnum = StringTrimLeft($array[$i],4)
							$smtpnum = StringTrimRight($smtpnum,3)
							$smtpnum = $smtpnum + 1
							$smtpListFlag = StringTrimRight($smtpListFlag,3)
							$smtpListFlag = $smtpListFlag & ',smtp' & $smtpnum & '");'
						Else
							$smtpnum = 1
							$smtpListFlag = 'user_pref("mail.smtpservers", "smtp1");'
						EndIf
						If $accountListFlag <> -1 Then
							$array = StringSplit($accountListFlag,",")
							$i=UBound($array,1) - 1
							$accountnum = StringTrimLeft($array[$i],7)
							$accountnum = StringTrimRight($accountnum,3)
							$accountnum = $accountnum + 1
							if $accountnum < $num Then
								$accountnum = $num
							EndIf
							$accountListFlag = StringTrimRight($accountListFlag,3)
							$accountListFlag = $accountListFlag & ',account' & $accountnum & '");'
						Else
							$accountnum = 1
							$accountListFlag = 'user_pref("mail.accountmanager.accounts", "account1,account2");'
						EndIf
						FileWriteLine($temp, $accountListFlag & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.accountmanager.defaultaccount", "account' & $accountnum & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.account.account' & $accountnum & '.identities", "id' & $accountnum & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.account.account' & $accountnum & '.server", "server' & $accountnum & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.authMethod", 0);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.check_new_mail", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.directory", "' & $jsdir & 'ImapMail\\mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.directory-rel", "[ProfD]ImapMail/mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.hostname", "mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.login_at_startup", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.name", "NU Exchange");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.port", 993);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.socketType", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.type", "imap");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $accountnum & '.userName", "'& $netid & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap", "' & $jsdir & 'ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none", "' & $jsdir & 'Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.draft_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Drafts");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.drafts_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fcc_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Sent");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fcc_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.fullName", "' & $name & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.stationery_folder", "imap://'& $netid & '@mail.it.northwestern.edu/Templates");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.tmpl_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.useremail", "' & $email & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $accountnum & '.valid", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.authMethod", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.description", "NU Exchange Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.hostname", "Mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.port", 587);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.try_ssl", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $smtpnum & '.username", "'& $netid & '");' & @CRLF)
						FileWriteLine($temp, $smtpListFlag & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtp.defaultserver", "smtp' & $smtpnum & '");' & @CRLF)
					EndIf
					FileClose($temp)
					$timestamp = @MON & @MDAY & @YEAR & @HOUR & @MIN & @SEC
					FileCopy($file,$file & $timestamp)
				Else
					msgbox (0,"","already setup")
				EndIf
			EndIf
		EndIf
	Endif
Else

Endif

Func _GetAppDir()
    $old_opt = Opt ("ExpandEnvStrings", 1)
    $dir = "%APPDATA%"
    Opt ("ExpandEnvStrings", $old_opt)
    Return $dir
EndFunc