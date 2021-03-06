; Generated by AutoIt Scriptomatic June 08, 2010

$wbemFlagReturnImmediately = 0x10
$wbemFlagForwardOnly = 0x20
$colItems = ""
$strComputer = "localhost"

$Output=""
$Output &= "Computer: " & $strComputer  & @CRLF
$objWMIService = ObjGet("winmgmts:\\" & $strComputer & "\root\default")
$colItems = $objWMIService.ExecQuery("SELECT * FROM Win32_Process", "WQL", _
                                          $wbemFlagReturnImmediately + $wbemFlagForwardOnly)

If IsObj($colItems) then
   For $objItem In $colItems
      $Output &= "Caption: " & $objItem.Caption & @CRLF
      $Output &= "Description: " & $objItem.Description & @CRLF
      $Output &= "IdentifyingNumber: " & $objItem.IdentifyingNumber & @CRLF
      $Output &= "InstallDate: " & $objItem.InstallDate & @CRLF
      $Output &= "InstallDate2: " & WMIDateStringToDate($objItem.InstallDate2) & @CRLF
      $Output &= "InstallLocation: " & $objItem.InstallLocation & @CRLF
      $Output &= "InstallState: " & $objItem.InstallState & @CRLF
      $Output &= "Name: " & $objItem.Name & @CRLF
      $Output &= "PackageCache: " & $objItem.PackageCache & @CRLF
      $Output &= "SKUNumber: " & $objItem.SKUNumber & @CRLF
      $Output &= "Vendor: " & $objItem.Vendor & @CRLF
      $Output &= "Version: " & $objItem.Version & @CRLF
   Next
   ConsoleWrite($Output)
   FileWrite(@TempDir & "\Win32_Product.TXT", $Output )
   Run(@Comspec & " /c start " & @TempDir & "\Win32_Product.TXT" )
Else
   Msgbox(0,"WMI Output","No WMI Objects Found for class: " & "Win32_Product" )
Endif


Func WMIDateStringToDate($dtmDate)

    Return (StringMid($dtmDate, 5, 2) & "/" & _
    StringMid($dtmDate, 7, 2) & "/" & StringLeft($dtmDate, 4) _
    & " " & StringMid($dtmDate, 9, 2) & ":" & StringMid($dtmDate, 11, 2) & ":" & StringMid($dtmDate,13, 2))
EndFunc
