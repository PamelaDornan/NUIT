//
//  Northwestern_CollabAppDelegate.h
//  Northwestern Collab
//
//  Created by Test on 5/18/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import <Cocoa/Cocoa.h>

@interface Northwestern_CollabAppDelegate : NSObject <NSApplicationDelegate> {
    NSWindow *window;
    IBOutlet NSButton *ClientNext;
    IBOutlet NSTextField *MessageLabel;
    IBOutlet NSButton *Outlook;
    IBOutlet NSButton *Thunderbird;
    IBOutlet NSButton *AppleMail;
    IBOutlet NSTextField *UserName;
    IBOutlet NSTextField *UserEmail;
    IBOutlet NSTextField *UserNetid;
    IBOutlet NSSecureTextField *UserNetidPassword;
    
    IBOutlet NSTextField *RequiredName;
    IBOutlet NSButton *Next;
    
    IBOutlet NSButton *Close2;
    IBOutlet NSButton *Close;
    IBOutlet NSTextField *UserNameLabel;
    IBOutlet NSTextField *UserEmailLabel;
    IBOutlet NSTextField *UserNetidLabel;
    IBOutlet NSTextField *UserNetidPasswordLabel;
    
    IBOutlet NSTextField *ExampleName;
    IBOutlet NSTextField *ExampleEmail;
    IBOutlet NSTextField *RequiredEmail;
    
    IBOutlet NSTextField *InvalidEmail;
    IBOutlet NSTextField *RequiredNetIDPassword;
    IBOutlet NSTextField *RequiredNetID;
    
}
- (IBAction)ClientNext:(id)sender;
- (IBAction)Outlook:(id)sender;
- (IBAction)Thunderbird:(id)sender;
- (IBAction)AppleMail:(id)sender;


@property (assign) IBOutlet NSWindow *window;

@end
