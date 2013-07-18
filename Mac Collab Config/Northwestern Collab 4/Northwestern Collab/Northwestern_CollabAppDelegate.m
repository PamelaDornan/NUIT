//
//  Northwestern_CollabAppDelegate.m
//  Northwestern Collab
//
//  Created by Test on 5/18/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import "Northwestern_CollabAppDelegate.h"

@implementation Northwestern_CollabAppDelegate

@synthesize window;

int clicks = 0;
NSString *ClientSelected = @"none";

- (void)applicationDidFinishLaunching:(NSNotification *)aNotification
{
    [Outlook setTransparent: YES];
    [Outlook setEnabled: NO];
    [Thunderbird setTransparent: YES];
    [Thunderbird setEnabled: NO];
    [AppleMail setTransparent: YES];
    [AppleMail setEnabled: NO];
    [UserName setHidden:YES];
    [UserEmail setHidden:YES];
    [UserNetid setHidden:YES];
    [UserNetidPassword setHidden:YES];
    [UserNameLabel setHidden:YES];
    [UserEmailLabel setHidden:YES];
    [UserNetidLabel setHidden:YES];
    [UserNetidPasswordLabel setHidden:YES];
    [ExampleEmail setHidden:YES];
    [ExampleName setHidden:YES];
    [RequiredName setHidden:YES];
    [RequiredEmail setHidden:YES];
    [RequiredNetID setHidden:YES];
    [RequiredNetIDPassword setHidden:YES];
    [InvalidEmail setHidden:YES];
    [Close2 setHidden:YES];
}

- (IBAction)ClientNext:(id)sender {
    if (clicks == 0){
        NSFileManager *filemgr;
        filemgr = [NSFileManager defaultManager];
        NSString *profileThunderbirdpath = [NSHomeDirectory() stringByAppendingPathComponent:@"/Library/Thunderbird/"];
        if(([filemgr fileExistsAtPath:@"/Applications/Microsoft Office 2011/Microsoft Outlook.app"] == YES) || ([filemgr fileExistsAtPath:@"/Applications/Thunderbird.app"] == YES) || ([filemgr fileExistsAtPath:profileThunderbirdpath] == YES)) {
            [MessageLabel setStringValue:@"Choose the e-mail program that you would like to set up for use with Northwestern Collaboration Services:"];
            [ClientNext setTransparent: YES];
            [ClientNext setEnabled: NO];
            [Outlook setTransparent: NO];
            [Thunderbird setTransparent: NO];
           // NSFileManager *fileprofile;
           // fileprofile = [NSFileManager defaultManager];
            // [AppleMail setTransparent: NO];
            if ([filemgr fileExistsAtPath:@"/Applications/Microsoft Office 2011/Microsoft Outlook.app"] == YES ){
                [Outlook setEnabled: YES];
            }
            if (([filemgr fileExistsAtPath:profileThunderbirdpath] == YES) || ([filemgr fileExistsAtPath:@"/Applications/Thunderbird.app"] == YES)){
            //if ([filemgr fileExistsAtPath:@"/Applications/Thunderbird.app"] == YES ){
                [Thunderbird setEnabled: YES];   
            }
            // if ([filemgr fileExistsAtPath:@"/Applications/Mail.app"] == YES){
            //    [AppleMail setEnabled: YES];    
            //  }
            clicks = 1;
        } else {
            [MessageLabel setStringValue:@"There are no compatible e-mail programs found on your computer.  This tool is compatible with the following e-mail programs:\r\n\r\n\t\tMicrosoft Outlook 2011\r\n\t\tThunderbird\r\n\r\nClick Cancel to exit, or contact the NUIT Support Center at 847-491-HELP (4357) or www.it.northwestern.edu/supportcenter/ for additional assistance."];
        }
    } else if (clicks == 1) {
        NSString *ProcessName = [UserName stringValue];
        NSString *ProcessEmail = [UserEmail stringValue];
        NSString *ProcessNetid = [UserNetid stringValue];
        NSString *ProcessNetidPassword = [UserNetidPassword stringValue];
        if ([ProcessName length] != 0 && [ProcessEmail length] != 0 && [ProcessNetid length] != 0 && [ProcessNetidPassword length] != 0) {
            NSPredicate *predicate;
            predicate = [NSPredicate predicateWithFormat:@"SELF MATCHES '.*@[nN][oO][rR][tT][hH][wW][eE][sS][tT][eE][rR][nN].[eE][dD][uU]'"];
            BOOL result = [predicate evaluateWithObject:ProcessEmail];
            if (result == YES) {
                [UserName setHidden:YES];
                [UserEmail setHidden:YES];
                [UserNetid setHidden:YES];
                [UserNetidPassword setHidden:YES];
                [UserNameLabel setHidden:YES];
                [UserEmailLabel setHidden:YES];
                [UserNetidLabel setHidden:YES];
                [UserNetidPasswordLabel setHidden:YES];
                [ExampleEmail setHidden:YES];
                [ExampleName setHidden:YES];
                [RequiredName setHidden:YES];
                [RequiredEmail setHidden:YES];
                [RequiredNetID setHidden:YES];
                [RequiredNetIDPassword setHidden:YES];
                [InvalidEmail setHidden:YES];
                [MessageLabel setStringValue:@"Processing..."];
                [Next setHidden:YES];
                if ([ClientSelected isEqualToString:@"Outlook"]) {
                   // int *tempstr = [@"BLAH"];
                    NSMutableString *appleString = [NSMutableString stringWithString:@"tell application \"Microsoft Outlook\"\r\nactivate\r\nset newExchangeAccount to make new exchange account with properties ¬\r\n{name:\"Mailbox - NU Exchange\", user name:\""];
                    [appleString appendString:ProcessNetid];
                    [appleString appendString:@"\", password:\""];
                    [appleString appendString:ProcessNetidPassword];
                    [appleString appendString:@"\", full name:\""];
                    [appleString appendString:ProcessName];
                    [appleString appendString:@"\", email address:\""];
                    [appleString appendString:ProcessEmail]; 
                    [appleString appendString:@"\", server:\"MAIL.CHICAGO.NORTHWESTERN.EDU\", use ssl:true, port:443, ldap server:\"\", ldap needs authentication:true, ldap use ssl:false, ldap max entries:1000, ldap search base:\"\"}\r\nset email addresses of me contact to{address:\""];
                    [appleString appendString:ProcessEmail]; 
                    [appleString appendString:@"\", type:work}\r\nend tell"];
                    NSAppleScript *ascript;
                    ascript =[[NSAppleScript alloc] initWithSource:appleString];
                    [ascript executeAndReturnError:nil];
                    NSMutableString *appleString2 = [NSMutableString stringWithString:@"tell application \"Microsoft Outlook\"\r\nquit\r\nend tell"];
                    NSAppleScript *ascript2;
                    ascript2 =[[NSAppleScript alloc] initWithSource:appleString2];
                    [ascript2 executeAndReturnError:nil];
                    [MessageLabel setStringValue:@"Access to your Northwestern Collaboration Service account within Outlook has been sucessfully added.  You may now click Close and login to Outlook."];
                    [Close setHidden:YES];
                    [Close2 setHidden:NO];
                } else if ([ClientSelected isEqualToString:@"Thunderbird"]) {
                    NSFileManager *fileprofile;
                    fileprofile = [NSFileManager defaultManager];
                    NSString *profilepath = [NSHomeDirectory() stringByAppendingPathComponent:@"/Library/Thunderbird/profiles.ini"];
                    
                    //if ([fileprofile fileExistsAtPath:profilepath] == NO){
                    NSMutableString *appleString1 = [NSMutableString stringWithString:@"set qChar to ASCII character 34\r\nset username to (short user name of (system info))\r\nset tempFile to \"/users/\" & username & \"/Library/Thunderbird/profiles.ini\"\r\ntell application \"Thunderbird\"\r\nactivate\r\ndelay 5\r\ndo shell script (\"killall thunderbird-bin\")\r\nend tell\r\ndelay 3\r\n"];
                    NSAppleScript *ascript;
                    ascript =[[NSAppleScript alloc] initWithSource:appleString1];
                    [ascript executeAndReturnError:nil];
                    //}
                    NSString *profiletext = [[NSString alloc] initWithContentsOfFile:profilepath usedEncoding:Nil error:nil];
                    NSArray *profilefoldertemp1 = [profiletext componentsSeparatedByString:@"Path=Profiles/"];
                    NSString *profilefoldertemp2 = [profilefoldertemp1 objectAtIndex:1];
                   // NSArray *profilefoldertemp3 = [profilefoldertemp2 componentsSeparatedByString:@".default"];
                    NSString *profilefolder = [profilefoldertemp2 stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];
                    NSMutableString *configpath = [NSMutableString stringWithString:NSHomeDirectory()];
                    [configpath appendString:@"/Library/Thunderbird/profiles/"];
                    [configpath appendString:profilefolder];
                    
                    NSMutableString *jsdir = [NSMutableString stringWithString:NSHomeDirectory()];
                    [jsdir appendString:@"/Library/Thunderbird/profiles/"];
                    [jsdir appendString:profilefolder];
                    [jsdir appendString:@"/"];
                    
                    
                    [configpath appendString:@"/prefs.js"];
                    
                    NSString *configtext = [[NSString alloc] initWithContentsOfFile:configpath usedEncoding:Nil error:nil];
                    //BOOL NotSetupStr = ([configtext rangeOfString:@"imap.northwestern.edu" options:NSCaseInsensitiveSearch].location != NSNotFound);
                    if ([configtext rangeOfString:@"imap.northwestern.edu"].location == NSNotFound){
                        BOOL accountListStr = ([configtext rangeOfString:@"mail.accountmanager.accounts" options:NSCaseInsensitiveSearch].location != NSNotFound);
                        BOOL smtpListStr = ([configtext rangeOfString:@"mail.smtpservers" options:NSCaseInsensitiveSearch].location != NSNotFound);
                        if (accountListStr == NO && smtpListStr == NO) {
                            NSMutableString *copyconfigpath = [NSMutableString stringWithString:configpath];
                            NSDate *nowdate = [[NSDate alloc]init];
                            NSDateFormatter *now = [[NSDateFormatter alloc]init];
                            [now setDateFormat:@"yyyMMddHHmm"];
                            NSString *datenow = [now stringFromDate:nowdate];
                            [copyconfigpath appendString:datenow];
                            [fileprofile copyItemAtPath:configpath toPath:copyconfigpath error:nil];
                            
                            NSMutableString *EOFcontents = [NSMutableString stringWithString:@"user_pref(\"mail.account.account1.identities\", \"id1\");\r\nuser_pref(\"mail.account.account1.server\", \"server1\");\r\nuser_pref(\"mail.account.account2.server\", \"server2\");\r\nuser_pref(\"mail.accountmanager.accounts\", \"account1,account2\");\r\nuser_pref(\"mail.accountmanager.defaultaccount\", \"account1\");\r\nuser_pref(\"mail.accountmanager.localfoldersserver\", \"server2\");\r\nuser_pref(\"mail.identity.id1.draft_folder\", \"imap://"];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"@imap.northwestern.edu/Drafts\");\r\nuser_pref(\"mail.identity.id1.drafts_folder_picker_mode\", \"0\");\r\nuser_pref(\"mail.identity.id1.fcc_folder\", \"imap://"];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"@imap.northwestern.edu/Sent\");\r\nuser_pref(\"mail.identity.id1.fcc_folder_picker_mode\", \"0\");\r\nuser_pref(\"mail.identity.id1.fullName\", \""];
                            [EOFcontents appendString:ProcessName];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.identity.id1.stationery_folder\", \"imap://"];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"@imap.northwestern.edu/Templates\");\r\nuser_pref(\"mail.identity.id1.tmpl_folder_picker_mode\", \"0\");\r\nuser_pref(\"mail.identity.id1.useremail\", \""];
                            [EOFcontents appendString:ProcessEmail];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.identity.id1.valid\", true);\r\nuser_pref(\"mail.root.imap\", \""];
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"ImapMail\");\r\nuser_pref(\"mail.root.imap-rel\", \"[ProfD]ImapMail\");\r\nuser_pref(\"mail.root.none\", \""];
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"Mail\");\r\nuser_pref(\"mail.root.none-rel\", \"[ProfD]Mail\");\r\nuser_pref(\"mail.server.server1.authMethod\", 0);\r\nuser_pref(\"mail.server.server1.check_new_mail\", true);\r\nuser_pref(\"mail.server.server1.directory\", \""]; 
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"ImapMail\\imap.northwestern.edu\");\r\nuser_pref(\"mail.server.server1.directory-rel\", \"[ProfD]ImapMail/imap.northwestern.edu\");\r\nuser_pref(\"mail.server.server1.hostname\", \"imap.northwestern.edu\");\r\nuser_pref(\"mail.server.server1.login_at_startup\", true);\r\nuser_pref(\"mail.server.server1.name\", \"NU Exchange\");\r\nuser_pref(\"mail.server.server1.port\", 993);\r\nuser_pref(\"mail.server.server1.socketType\", 3);\r\nuser_pref(\"mail.server.server1.type\", \"imap\");\r\nuser_pref(\"mail.server.server1.userName\", \""];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.server.server2.directory\", \""];
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"Mail\\Local Folders\");\r\nuser_pref(\"mail.server.server2.directory-rel\", \"[ProfD]Mail/Local Folders\");\r\nuser_pref(\"mail.server.server2.hostname\", \"Local Folders\");\r\nuser_pref(\"mail.server.server2.name\", \"Local Folders\");\r\nuser_pref(\"mail.server.server2.type\", \"none\");\r\nuser_pref(\"mail.server.server2.userName\", \"nobody\");\r\nuser_pref(\"mail.smtp.defaultserver\", \"smtp2\");\r\nuser_pref(\"mail.smtpserver.smtp2.authMethod\", 3);\r\nuser_pref(\"mail.smtpserver.smtp2.description\", \"NU Exchange Mail\");\r\nuser_pref(\"mail.smtpserver.smtp2.hostname\", \"smtp.northwestern.edu\");\r\nuser_pref(\"mail.smtpserver.smtp2.port\", 587);\r\nuser_pref(\"mail.smtpserver.smtp2.try_ssl\", 3);\r\nuser_pref(\"mail.smtpserver.smtp2.username\", \""];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.smtpservers\", \"smtp2\");"];
                            NSFileHandle *fh = [NSFileHandle fileHandleForWritingAtPath:configpath];
                            [fh seekToEndOfFile];
                            [fh writeData:[EOFcontents dataUsingEncoding: NSUTF8StringEncoding]];
                            [fh synchronizeFile];
                            [MessageLabel setStringValue:@"Access to you Northwestern Collaboration Service account within Thunderbird has been sucessfully added.  You may now click Close and login to Thunderbird."];
                            [Close setHidden:YES];
                            [Close2 setHidden:NO];
                        } else {
                            NSString *foundaccountList;
                            NSString *foundsmtpList;
                            NSArray *configtextarray = [[NSArray alloc] initWithArray:[configtext componentsSeparatedByString:@"\n"]];
                            int num = 1;
                            for (NSString *myStr in configtextarray){
                                BOOL accountStr = ([myStr rangeOfString:@"mail.account.account" options:NSCaseInsensitiveSearch].location != NSNotFound);
                                BOOL idStr = ([myStr rangeOfString:@"mail.identity.id" options:NSCaseInsensitiveSearch].location != NSNotFound);
                                BOOL serverStr = ([myStr rangeOfString:@"mail.server.server" options:NSCaseInsensitiveSearch].location != NSNotFound);
                                BOOL accountListStr2 = ([myStr rangeOfString:@"mail.accountmanager.accounts" options:NSCaseInsensitiveSearch].location != NSNotFound);
                                BOOL smtpListStr2 = ([myStr rangeOfString:@"mail.smtpservers" options:NSCaseInsensitiveSearch].location != NSNotFound);
                                if (accountListStr2 == YES) {
                                    foundaccountList = [myStr stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];
                                }
                                if (smtpListStr2 == YES) {
                                    foundsmtpList = [myStr stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];
                                }
                                if (accountStr == YES) {
                                    NSArray *temp1 = [myStr componentsSeparatedByString:@","];
                                    NSString *temp2 = [temp1 objectAtIndex:0];
                                    NSArray *temp3 = [temp2 componentsSeparatedByString:@"mail.account.account"];
                                    NSString *temp4 = [temp3 objectAtIndex:1];
                                    NSArray *temp5 = [temp4 componentsSeparatedByString:@"."];
                                    NSString *temp6 = [temp5 objectAtIndex:0];
                                    int numtemp = [temp6 intValue];
                                    if(numtemp > num){
                                        num = numtemp;
                                    }
                                }
                                if (idStr == YES) {
                                    NSArray *temp1 = [myStr componentsSeparatedByString:@","];
                                    NSString *temp2 = [temp1 objectAtIndex:0];
                                    NSArray *temp3 = [temp2 componentsSeparatedByString:@"mail.identity.id"];
                                    NSString *temp4 = [temp3 objectAtIndex:1];
                                    NSArray *temp5 = [temp4 componentsSeparatedByString:@"."];
                                    NSString *temp6 = [temp5 objectAtIndex:0];
                                    int numtemp = [temp6 intValue];
                                    if(numtemp > num){
                                        num = numtemp;
                                    }
                                }
                                if (serverStr == YES) {
                                    NSArray *temp1 = [myStr componentsSeparatedByString:@","];
                                    NSString *temp2 = [temp1 objectAtIndex:0];
                                    NSArray *temp3 = [temp2 componentsSeparatedByString:@"mail.server.server"];
                                    NSString *temp4 = [temp3 objectAtIndex:1];
                                    NSArray *temp5 = [temp4 componentsSeparatedByString:@"."];
                                    NSString *temp6 = [temp5 objectAtIndex:0];
                                    int numtemp = [temp6 intValue];
                                    if(numtemp > num){
                                        num = numtemp;
                                    }
                                }
                            }
                            num = num + 1;
                            //[MessageLabel setStringValue:[NSString stringWithFormat:@"%d",num]];
                            //user_pref("mail.accountmanager.accounts", "account1,account2,account3");
                            //user_pref("mail.smtpservers", "smtp1,smtp2");
                            NSArray *accountlist1 = [foundaccountList componentsSeparatedByString:@"\");"];
                            NSString *accountlist2 = [accountlist1 objectAtIndex:0];
                            NSMutableString *accountlist = [NSMutableString stringWithString:accountlist2];
                            [accountlist appendString:@",account"];
                            [accountlist appendString:[NSString stringWithFormat:@"%d",num]];
                            [accountlist appendString:@"\");\r\n"];
                            
                            NSArray *accountsmtp1 = [foundsmtpList componentsSeparatedByString:@"\");"];
                            NSString *accountsmtp2 = [accountsmtp1 objectAtIndex:0];
                            NSMutableString *accountsmtp = [NSMutableString stringWithString:accountsmtp2];
                            [accountsmtp appendString:@",smtp"];
                            [accountsmtp appendString:[NSString stringWithFormat:@"%d",num]];
                            [accountsmtp appendString:@"\");\r\n"];
                            
                            
                            NSMutableString *copyconfigpath = [NSMutableString stringWithString:configpath];
                            NSDate *nowdate = [[NSDate alloc]init];
                            NSDateFormatter *now = [[NSDateFormatter alloc]init];
                            [now setDateFormat:@"yyyMMddHHmm"];
                            NSString *datenow = [now stringFromDate:nowdate];
                            [copyconfigpath appendString:datenow];
                            [fileprofile copyItemAtPath:configpath toPath:copyconfigpath error:nil];
                            
                            NSMutableString *EOFcontents = [NSMutableString stringWithString:accountlist];
                            [EOFcontents appendString:@"user_pref(\"mail.accountmanager.defaultaccount\", \"account"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.account.account"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".identities\", \"id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.account.account"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".server\", \"server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".authMethod\", 0);\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".check_new_mail\", true);\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".directory\", \""];
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"ImapMail\\imap.northwestern.edu\");\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".directory-rel\", \"[ProfD]ImapMail/imap.northwestern.edu\");\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".hostname\", \"imap.northwestern.edu\");\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".login_at_startup\", true);\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".name\", \"NU Exchange\");\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".port\", 993);\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".socketType\", 3);\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".type\", \"imap\");\r\nuser_pref(\"mail.server.server"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".userName\", \""];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.root.imap\", \""];
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"ImapMail\");\r\nuser_pref(\"mail.root.imap-rel\", \"[ProfD]ImapMail\");\r\nuser_pref(\"mail.root.none\", \""];
                            [EOFcontents appendString:jsdir];
                            [EOFcontents appendString:@"Mail\");\r\nuser_pref(\"mail.root.none-rel\", \"[ProfD]Mail\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".draft_folder\", \"imap://"];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"@imap.northwestern.edu/Drafts\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".drafts_folder_picker_mode\", \"0\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".fcc_folder\", \"imap://"];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"@imap.northwestern.edu/Sent\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".fcc_folder_picker_mode\", \"0\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".fullName\", \""];
                            [EOFcontents appendString:ProcessName];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".stationery_folder\", \"imap://"];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"@imap.northwestern.edu/Templates\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".tmpl_folder_picker_mode\", \"0\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".useremail\", \""];
                            [EOFcontents appendString:ProcessEmail];
                            [EOFcontents appendString:@"\");\r\nuser_pref(\"mail.identity.id"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".valid\", true);\r\nuser_pref(\"mail.smtpserver.smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".authMethod\", 3);\r\nuser_pref(\"mail.smtpserver.smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".description\", \"NU Exchange Mail\");\r\nuser_pref(\"mail.smtpserver.smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".hostname\", \"smtp.northwestern.edu\");\r\nuser_pref(\"mail.smtpserver.smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".port\", 587);\r\nuser_pref(\"mail.smtpserver.smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".try_ssl\", 3);\r\nuser_pref(\"mail.smtpserver.smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@".username\", \""];
                            [EOFcontents appendString:ProcessNetid];
                            [EOFcontents appendString:@"\");\r\n"];
                            [EOFcontents appendString:accountsmtp];
                            [EOFcontents appendString:@"user_pref(\"mail.smtp.defaultserver\", \"smtp"];
                            [EOFcontents appendString:[NSString stringWithFormat:@"%d",num]];
                            [EOFcontents appendString:@"\");\r\n"];
                            NSFileHandle *fh = [NSFileHandle fileHandleForWritingAtPath:configpath];
                            [fh seekToEndOfFile];
                            [fh writeData:[EOFcontents dataUsingEncoding: NSUTF8StringEncoding]];
                            [fh synchronizeFile];
                            [MessageLabel setStringValue:@"Access to your Northwestern Collaboration Service account within Thunderbird has been sucessfully added.  You may now click Close and login to Thunderbird."];
                            [Close setHidden:YES];
                            [Close2 setHidden:NO];
                        } //End Multi Accounts
                    } else {
                        [MessageLabel setStringValue:@"A Northwestern Collaboration Services account for this e-mail program already exists and cannot be added again.  Click Cancel to exit, or contact the NUIT Support Center at 847-491-HELP (4357) or www.it.northwestern.edu/supportcenter/ for additional assistance."];
                    }
                } else if ([ClientSelected isEqualToString:@"AppleMail"]){
                    NSMutableString *appleString = [NSMutableString stringWithString:@"tell application \"Mail\"\r\nactivate\r\nif ((count of windows) > 0) then\r\nif name of front window is \"Welcome to Mail\" then\r\nreturn true\r\nelse\r\nreturn false\r\nend if\r\nend if\r\nend tell\r\n"];
                    NSAppleScript *ascript;
                    NSAppleEventDescriptor *result;
                  //  NSAppleEventDescriptor *unicodeResult;
                  //  NSData* unicodeData;
                   // NSString* resultString;
                    NSDictionary* errorDic;
                    ascript =[[NSAppleScript alloc] initWithSource:appleString];
                    //result = [ascript executeAndReturnError:nil];
                    result = [ascript executeAndReturnError:&errorDic];
                    NSString* resultString = [result stringValue];
                   // unicodeResult = [result coerceToDescriptorType:typeUnicodeText];
                   // unicodeData =[unicodeResult data];
                   // resultString = [[NSString alloc] initWithCharacters:(unichar*)[data bytes] length:[data length] / sizeof(unichar)];
                    [MessageLabel setStringValue:resultString];
                    
                }
            } else {
                [ExampleEmail setHidden:YES];
                [InvalidEmail setHidden:NO];
                [RequiredEmail setHidden:YES];
            }
        }else{   
            if ([ProcessName length] == 0) {
                [ExampleName setHidden:YES];
                [RequiredName setHidden:NO];
            }else{
                [ExampleName setHidden:NO];
                [RequiredName setHidden:YES];
            }
            if ([ProcessEmail length] == 0) {
                [ExampleEmail setHidden:YES];
                [InvalidEmail setHidden:YES];
                [RequiredEmail setHidden:NO];
            } else {
                NSPredicate *predicate;
                predicate = [NSPredicate predicateWithFormat:@"SELF MATCHES '.*@[nN][oO][rR][tT][hH][wW][eE][sS][tT][eE][rR][nN].[eE][dD][uU]'"];
                BOOL result = [predicate evaluateWithObject:ProcessEmail];
                if (result == NO) {
                    [ExampleEmail setHidden:YES];
                    [InvalidEmail setHidden:NO];
                    [RequiredEmail setHidden:YES];
                } else {
                    [ExampleEmail setHidden:NO];
                    [InvalidEmail setHidden:YES];
                    [RequiredEmail setHidden:YES];
                }
            }
            if ([ProcessNetid length] == 0) {
                [RequiredNetID setHidden:NO];
            } else {
                [RequiredNetID setHidden:YES];
            }
            if ([ProcessNetidPassword length] == 0) {
                [RequiredNetIDPassword setHidden:NO];
            } else {
                [RequiredNetIDPassword setHidden:YES];
            }
        }
    }
}

- (IBAction)Outlook:(id)sender {
    [Outlook setTransparent: YES];
    [Outlook setEnabled: NO];
    [Thunderbird setTransparent: YES];
    [Thunderbird setEnabled: NO];
    [AppleMail setTransparent: YES];
    [AppleMail setEnabled: NO];
    
    [UserName setHidden:NO];
    [UserEmail setHidden:NO];
    [UserNetid setHidden:NO];
    [UserNetidPassword setHidden:NO];
    
    [UserNameLabel setHidden:NO];
    [UserEmailLabel setHidden:NO];
    [UserNetidLabel setHidden:NO];
    [UserNetidPasswordLabel setHidden:NO];
    [ExampleEmail setHidden:NO];
    [ExampleName setHidden:NO];
    
    [ClientNext setTransparent: NO];
    [ClientNext setEnabled: YES];
    
    ClientSelected = @"Outlook";
}

- (IBAction)Thunderbird:(id)sender {
    [Outlook setTransparent: YES];
    [Outlook setEnabled: NO];
    [Thunderbird setTransparent: YES];
    [Thunderbird setEnabled: NO];
    [AppleMail setTransparent: YES];
    [AppleMail setEnabled: NO];
    
    [UserName setHidden:NO];
    [UserEmail setHidden:NO];
    [UserNetid setHidden:NO];
    [UserNetidPassword setHidden:NO];
    
    [UserNameLabel setHidden:NO];
    [UserEmailLabel setHidden:NO];
    [UserNetidLabel setHidden:NO];
    [UserNetidPasswordLabel setHidden:NO];
    [ExampleEmail setHidden:NO];
    [ExampleName setHidden:NO];
    
    [ClientNext setTransparent: NO];
    [ClientNext setEnabled: YES];
    
    ClientSelected = @"Thunderbird";
}

- (IBAction)AppleMail:(id)sender {
    [Outlook setTransparent: YES];
    [Outlook setEnabled: NO];
    [Thunderbird setTransparent: YES];
    [Thunderbird setEnabled: NO];
    [AppleMail setTransparent: YES];
    [AppleMail setEnabled: NO];
    
    [UserName setHidden:NO];
    [UserEmail setHidden:NO];
    [UserNetid setHidden:NO];
    [UserNetidPassword setHidden:NO];
    
    [UserNameLabel setHidden:NO];
    [UserEmailLabel setHidden:NO];
    [UserNetidLabel setHidden:NO];
    [UserNetidPasswordLabel setHidden:NO];
    
    [ClientNext setTransparent: NO];
    [ClientNext setEnabled: YES];
    
    ClientSelected = @"AppleMail";
}



@end
