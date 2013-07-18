Global $name = 'Pamela Dornan' 
Global $email = 'p-dornan@northwestern.edu'
Global $netid = 'pdo762'
Global $server = 'mail.it.northwestern.edu'
If FileExists("C:\Documents and Settings\pdo762\Application Data\Thunderbird\profiles.ini") Then
	$file = "C:\Documents and Settings\pdo762\Application Data\Thunderbird\profiles.ini"
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
			$file = "C:\Documents and Settings\pdo762\Application Data\Thunderbird\" & $found2 & "\prefs.js"
			$prefsjs = FileOpen($file, 0)
			;msgbox(0,"",$prefsjs)
			If $prefsjs = -1 Then
				msgbox(0,"","Error Reading File")
			Else
				$notSetupRegExp = '[.]*mail.it.northwestern.edu[.]*'
				$notSetupFlag = -1
				$num = -1
				$accountListRegExp = 'user_pref\("mail.accountmanager.accounts",[.]*'
				$accountListFlag = -1
				$smtpListRegExp = 'user_pref\("mail.smtpservers",[.]*'
				$smtpListFlag = -1
				$accountRegExp = '[.]*\.account[.]*\.[.]*'
				$idRegExp = '[.]*\.id[.]*\.[.]*'
				$serverRegExp = '[.]*\.server[.]*\.[.]*'
				;$LastVersionRegExp = 'user_pref("extensions.lastAppVersion",[.]*'
				;$LastVersionFlad = "-1"
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
				msgbox(0,"",$num)
				FileClose($prefsjs)
				If $notSetupFlag = -1 Then
					$tempfile = "C:\Documents and Settings\pdo762\Application Data\Thunderbird\" & $found2 & "\user.js"
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
						FileWriteLine($temp, 'user_pref("mail.root.imap", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.authMethod", 0);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.check_new_mail", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.directory", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\ImapMail\\'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.directory-rel", "[ProfD]ImapMail/'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.hostname", "'& $server &'");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.login_at_startup", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.name", "' & $email & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.port", 993);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.socketType", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.type", "imap");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server1.userName", "' & $netid & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server2.directory", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\Mail\\Local Folders");' & @CRLF)
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
						FileWriteLine($temp, 'user_pref("mail.accountmanager.accounts", "account1,account2,account3,account4");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.account.account' & $num & '.identities", "id' & $num & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.account.account' & $num & '.server", "server' & $num & '");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.authMethod", 0);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.check_new_mail", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.directory", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\ImapMail\\mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.directory-rel", "[ProfD]ImapMail/mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.hostname", "mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.login_at_startup", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.name", "p-dornan@northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.port", 993);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.socketType", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.type", "imap");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.server.server' & $num & '.userName", "pdo762");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.imap-rel", "[ProfD]ImapMail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none", "C:\\Documents and Settings\\pdo762\\Application Data\\Thunderbird\\Profiles\\uzhej7fp.default\\Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.root.none-rel", "[ProfD]Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.draft_folder", "imap://pdo762@mail.it.northwestern.edu/Drafts");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.drafts_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.fcc_folder", "imap://pdo762@mail.it.northwestern.edu/Sent");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.fcc_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.fullName", "Pamela Dornan");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.stationery_folder", "imap://pdo762@mail.it.northwestern.edu/Templates");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.tmpl_folder_picker_mode", "0");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.useremail", "p-dornan@northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.identity.id' & $num & '.valid", true);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $num & '.authMethod", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $num & '.description", "NU Exchange Mail");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $num & '.hostname", "Mail.it.northwestern.edu");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $num & '.port", 587);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $num & '.try_ssl", 3);' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpserver.smtp' & $num & '.username", "pdo762");' & @CRLF)
						FileWriteLine($temp, 'user_pref("mail.smtpservers", "smtp1,smtp2,smtp3,smtp4");' & @CRLF)
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