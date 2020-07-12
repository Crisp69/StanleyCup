<?php
########################################################################
# Edit-Point 4.00 Beta - Simple Content Management System
# Copyright (C)2005-2007 Todd Strattman
# strattman@gmail.com
# http://covertheweb.com/edit-point/
# License: LGPL
########################################################################

// Admin.php
$l_admin1 = "Choose a name for the new Edit-Point.";
$l_admin2 = "Select a webpage to add the Edit-Point.";
$l_admin3 = "Create Edit-Point";
$l_admin4 = "Manual Editing";
$l_admin5 = "Manually add or delete Edit-Points on the Editor Page.";
$l_admin6 = "Edit the raw html of a webpage.";
$l_admin6a = "Choose an Edit-Point to delete.";
$l_admin6b = "Choose which webpage to remove Edit-Point $file from.";
$l_admin7 = "Choose an Edit-Point to modify:";
$l_admin8 = "Edit-point <b>$name</b> was successfully created and the Edit-Point editor link has been added to the <a href=\"index.php\">Editor-Page</a>";
$l_admin9 = " and the <a href=\"admin.php\">Admin-Page</a>.";
$l_admin10 = "To include Edit-Point <b>$name</b> to webpage <b>$file</b>, the following code needs to be added to the form below. Either copy/paste the code where to want it, or put your cursor where you want the code and click \"Insert Code at Cursor.\" You may also use \"Insert Code with Edit link at Cursor\" to insert the code with a link to edit the point.";
$l_admin11 = "Edit-Point <b>$name</b> has been successfully added to <b>$file</b>!!!";
$l_admin12 = "Automatically redirecting to the <a href=\"admin.php\">Admin-Page</a>";
$l_admin13 = "Edit-Page Successfully Edited!!!";
$l_admin15 = "Would you like to add Edit-Point <b>$name</b> to another file?";
$l_admin16 = "Select a webpage to add Edit-Point <b>$name</b>.";
$l_admin17 = "Editing Webpage";
$l_admin18 = "The webpage <b>$file</b> has been successfully edited!!!";
$l_admin19 = "The Edit-Point was successfully deleted!!!";
$l_admin20 = "Insert Code at Cursor";
$l_admin21 = "Insert Code with Edit link at Cursor";

// Header.php
$l_head1 = "Administration-All Pages";
$l_head2 = "Administration";
$l_head3 = "Options";
$l_head4 = "Editor";
$l_head5 = "File Upload";
$l_head6 = "PHP Info";
$l_head7 = "Custom php.ini";
$l_head8 = "Setup Utility";

// Index.php
$l_index1 = "Editing Point";
$l_index2 = "Edit-Point <b>$name</b> Successfully Edited!!!";
$l_index3 = "Automatically redirecting to the <a href=\"index.php\">Edit-Page</a>";

// Options.php
$l_opt1 = "Full";
$l_opt2 = "Advanced";
$l_opt3 = "Simple";
$l_opt4 = "True";
$l_opt5 = "False";
$l_opt6 = "All";
$l_opt7 = "None";
$l_opt8 = "Please feel free to customize your <b>Edit-Point</b> installation below.";
$l_opt9 = "No changes need to be made, unless you would like to enter settings to use image uploading and/or file uploading.";
$l_opt10 = "You can revisit this page at any time to make changes and your settings will be remembered.";
$l_opt11 = "Site name and page title.";
$l_opt12 = "Pre-populated text in \"Choose a name for the new Edit-Point.\"";
$l_opt13 = "Pre-populated text in textarea.";
$l_opt14 = "Add Edit-Points to Administration page.";
$l_opt15 = "Option to add links to all script pages on all pages.";
$l_opt16 = "Option to add one Edit-Point to multiple places on a website.";
$l_opt17 = "Option to ignore directories when listing files to add Edit-Points (when using admin.php). The script directory (edit-point) is ignored by default. Use the directory name only, no slashes.";
$l_opt18 = "Password Protection";
$l_opt19 = "Option to use the built-in password protection.";
$l_opt22 = "The administrator password for <b>Administration</b> (admin.php) and <b>Options</b> (options.php)";
$l_opt23 = "The user password for the <b>Editor</b> (index.php).";
$l_opt24 = "The user password for <b>File Upload</b> (upload.php).";
$l_opt25 = "File Upload";
$l_opt26 = "Whether or not the \"File upload\" option is available. The \"File Upload\" directory will be created if it does not exist.";
$l_opt26a = "Create File Upload directory index file.";
$l_opt26b = "The option to create an index file that will either 1) lists the files in a slightly more pleasing manner than the default server listing or 2) makes the directory non-viewable and redirects the browser to the domain name. If there is an existing index file, the script will not overwrite it.";
$l_opt26c = "Non-viewable or viewable index file.";
$l_opt26d = "Delete the file upload directory index.";
$l_opt26e = "WARNING!!! This will delete any existing index file in the fileupload directory.";
$l_opt27 = "Upload Method - Choose between FTP or PHP for uploading files.";
$l_opt28 = "The file upload directory from the domain name.";
$l_opt28a = "For instance, if you use \"http://YOURDOMAIN.com/testing/files/\", the file upload directory will equal: \"testing/files\".<br /><br />This directory will be automatically created.";
$l_opt29 = "Files to ignore(not list) in the upload directory. \".htaccess\" is ignored by default.";
$l_opt30 = "This is <b>ONLY NEEDED IF FTP WAS CHOSEN</b> for the upload method. Your FTP username. It only needs to be changed if you chose \"on\" for \"File Upload\".";
$l_opt31 = "This is <b>ONLY NEEDED IF FTP WAS CHOSEN</b> for the upload method. Your FTP password. It only needs to be changed if you chose \"on\" for \"File Upload\".";
$l_opt32 = "This is <b>ONLY NEEDED IF FTP WAS CHOSEN</b> for the upload method. Path from default FTP login directory to file upload directory. It only needs to be changed if you chose \"on\" for \"File Upload\".";
$l_opt33 = "<b>Custom file upload size settings</b> (php.ini)";
$l_opt34 = "Most servers allow a user to create a custom <b>php.ini</b> file to override default php.ini settings. This is useful if you want to increase the file size upload limits. The custom <b>php.ini</b> file contains the following lines:<br /><b>file_uploads</b> = On<br /><b>post_max_size</b> = *M<br /><b>upload_max_filesize</b> = *M<br /><b>register_globals</b> = On/Off<br /><b>error_log = error_log</b><br /><b>error_reporting</b> = 2039<br /><b>log_errors</b> = On<br />It is recommended to compare the new <b>\"PHP Info\"</b> results with the original <b>\"PHP Info\"</b> results and make any neccesary additions to match the original php.ini.<br /><br />Note!!! This may not work on all servers!!!";
$l_opt35 = "Create \"php.ini\"";
$l_opt36 = "Image Upload/Manager Settings";
$l_opt36a = "Create Image Upload directory index file.";
$l_opt37 = "The \"image directory name\" from your domain name.";
$l_opt38 = "To use the TinyMCE image upload/manager, you must use the <a href=\"#setuputility\" title=\"Setup Utility\"><b>Setup Utility</b></a> (below) or manually set the permissions of your image directory and the following files to 755 or 777:";
$l_opt38a = "\"edit-point/jscripts/tiny_mce/plugins/ibrowser/temp\"<br />\"edit-point/jscripts/tiny_mce/plugins/ibrowser/scripts/phpThumb/cache\"";
$l_opt39 = "All subdirectories of your image directory will also be indexed.";
$l_opt40 = "Option to use the <b>Setup Utility</b> to set the premissions of your \"data\" and image directories.";
$l_opt41 = "If \"on\" is selected, you will be directed to the <b>Setup Utility</b> when you click \"Edit\".";
$l_opt42 = "Basic Settings";
$l_opt43 = "The redirect speed after editing a point (index.php). 1000 = 1 second";
$l_opt44 = "The redirect speed after creating a point (admin.php). 1000 = 1 second";
$l_opt45 = "The width of the textarea when editing points (rows).";
$l_opt46 = "The height of the textarea when editing points (columns).";
$l_opt47 = "TinyMCE Settings";
$l_opt48 = "TinyMCE plugin settings";
$l_opt49 = "documentation";
$l_opt50 = "is the default Edit-Point usage that has all options available.";
$l_opt51 = "is an advanced option that lets you pick and choose between plugins.";
$l_opt52 = "is a simple option with minimal options.";
$l_opt53 = "has no TinyMCE (WYSIWYG) available.";
$l_opt54 = "<b>TinyMCE Compressor</b> This option allows the use of TinyMCE Compressor to speed up the TinyMCE load time. This option may not work on some servers and some plugins may not work correctly.";
$l_opt55 = "The following options are only used if <i>\"Advanced\"</i> was chosen above.";
$l_opt56 = "<b>Advanced HR dialog</b> This is a more advanced hr dialog contributed by Michael Keck. This hr plugin supports noshade, width and size";
$l_opt57 = "<b>Advanced Image</b> This is a more advanced image dialog mostly based on code contributed by Michael Keck. This one supports mouseover/out image swapping.";
$l_opt58 = "<b>Advanced Link</b> This is a more advanced link dialog mostly based on code contributed by Michael Keck. This link plugin supports popup windows and targets.";
$l_opt59 = "<b>Autosave</b> This plugin gives the user a warning if they made modifications to a editor instance but didn't submit them.";
$l_opt60 = "<b>Background Color</b> This plugin lets you choose the background color.";
$l_opt61 = "<b>Context Menu</b>";
$l_opt62 = "<b>Copy</b>";
$l_opt63 = "<b>Cut</b>";
$l_opt64 = "<b>Directionality</b> This plugin adds directionality icons to TinyMCE that enables TinyMCE to better handle languages that is written from right to left.";
$l_opt65 = "<b>Emotions</b> The emotions plugin is able to insert smiley images into the TinyMCE editable area.";
$l_opt66 = "<b>Filemanager</b> Filemanager for \"File Upload\" directory in Edit-Point.";
$l_opt67 = "<b>Select Font</b>";
$l_opt68 = "<b>Select Font Size</b>";
$l_opt69 = "<b>Select Font Color</b>";
$l_opt70 = "<b>Fullscreen</b> This plugin adds fullscreen editing mode to TinyMCE.";
$l_opt71 = "<b>Image Manager</b> Manage images in TinyMCE.";
$l_opt72 = "<b>Internet Explorer Spellchecker</b>";
$l_opt73 = "<b>Inline Popups</b> This plugin makes all dialogs to open as floating DIV layers instead of popup windows. This option can be very useful inorder to get around popup blockers. This plugin should be treated as experimental since it's not 100% compatible yet.";
$l_opt74 = "<b>Insert Date and Time</b>";
$l_opt75 = "Date Format";
$l_opt76 = "Time Format";
$l_opt77 = "<b>Layer</b> Adds a layer suport to TinyMCE by making it possible to create/remove and z-index block elements.";
$l_opt78 = "List Style";
$l_opt79 = "<b>Media</b> This plugin handles embedded media such as QuickTime, Flash, ShockWave, RealPlayer and Windows Media Player.";
$l_opt80 = "<b>Non Breaking</b> This plugin inserts nonbreaking space entities at the current location.";
$l_opt81 = "<b>Non Editable Elements</b> Adds non editable elements support for MSIE and Mozilla/FF.";
$l_opt82 = "<b>Paste</b> This plugin adds paste as plain text and paste from Word icons to TinyMCE.";
$l_opt83 = "Create Paragraphs";
$l_opt84 = "Create Linebreaks";
$l_opt85 = "Paste Dialog";
$l_opt86 = "Auto Cleanup";
$l_opt87 = "Convert Middot Lists to UL Lists";
$l_opt88 = "Unindented List Style";
$l_opt89 = "Convert Headers To Strong";
$l_opt90 = "Remove Spans";
$l_opt91 = "Remove Styles";
$l_opt92 = "Replace Lists";
$l_opt93 = "Strip Class Attributes";
$l_opt94 = "<b>Preview</b> This plugin adds a preview button to TinyMCE, pressing the button opens a popup showing the current content.";
$l_opt95 = "Width of Preview Window";
$l_opt96 = "Height of Preview Window";
$l_opt97 = "<b>Print</b> This plugin adds a print button to TinyMCE.";
$l_opt98 = "<b>Search and Replace</b> This plugin adds search/replace dialogs to TinyMCE.";
$l_opt99 = "<b>Style</b> Adds CSS style editing support to TinyMCE, this will enable you to edit almost any CSS style property in a visual way.";
$l_opt100 = "<b>Table</b> This plugin adds table management functionality to TinyMCE.";
$l_opt101 = " <b>Visual Characters</b> This plugin adds the possibility to see invisible characters like &amp;nbsp;.";
$l_opt102 = "<b>XHTML Extras</b> This plugin adds support for some XHTML elements these include cite, ins, del, abbr, and acronym.";
$l_opt103 = "<b>Zoom</b> Adds a zoom drop list in MSIE5.5+, this plugin was mostly created to show how to add custom droplists as plugins.";
$l_opt104 = "Do Not Change Below (unless you know what you are doing).";
$l_opt105 = "Header";
$l_opt105a = "Whether or not to use the header/footer. NOTE: \"On\" is required for the WYSIWYG option. Do not change unless you do not want to use TinyMCE, the WYSIWYG editor.";
$l_opt106 = "Script Directory";
$l_opt107 = "Do not change unless you manually edit:<br /> <b>\"edit-point/jscripts/tiny_mce/plugins/ibrowser/config/config.inc.php\"</b> line 32<br /><br />and<br /><br /><b>\"edit-point/jscripts/tiny_mce/plugins/filemanager/InsertFile/config.inc.php\"</b> line 9<br /><br />so that \"edit-point\" equals your changed script directory name and location from domain.<br /><br />For instance, if your Edit-Point installation is at \"http://YOURDOMAIN.com/testing/edit-point\", then \"<b>Script Directory</b> = testing/edit-point\".";
$l_opt108 = "Data Directory";
$l_opt109 = "Where the .txt files, created by the script, are stored. Do not change unless you manually change the \"data\" directory name or location.";
$l_opt110 = "Script Path";
$l_opt110a = "From script directory to webpage directory.";
$l_opt111 = "Html start tag";
$l_opt111a = "These are only used for Edit-Point script pages.";
$l_opt112 = "Html end tag";
$l_opt113 = "Edit your configuration";
$l_opt114 = "Your configuration was <b><i>succesfully</i></b> saved.";
$l_opt115 = "Automatically redirecting to the <a href=\"setup.php\">Setup Utility</a>";
$l_opt116 = "Language/Sprache/Lengua/Taal";
$l_opt117 = "English";
$l_opt118 = "Deutsch";
$l_opt119 = "Espa&ntilde;ol";
$l_opt119a = "Nederlands";
$l_opt120 ="Whether or not the \"Image Directory\" option is available. The \"image\" directory will be created if it does not exist.";
$l_opt121 ="has been created and the permissions have been set to";
$l_opt122 ="There was a problem and <b>$imagedir</b> was not created.";
$l_opt123 ="There was a problem and <b>$fileupload_dir_name</b> was not created.";
$l_opt124 = "Custom CSS";
$l_opt125 = "This option let you create custom css selections in the styles dropdown box in TinyMCE.";
$l_opt126 = "Create a custom CSS file.";
$l_opt127 = "CSS file was successfully created!!!";
$l_opt128 = "reset only";
$l_opt129 = "Advanced Settings";
$l_opt130 = "Option to be create Edit-Points in <b>*.html</b> files.";
$l_opt131 = "This <b>EXPERIMENTAL!!!</b> option will <b>create or append</b> a .htaccess file in your webpage directory that will allow the use of php in <b>*.htm</b> and <b>*.html</b> files.";
$l_opt132 = "Create .htaccess";
$l_opt133 = "Viewable";
$l_opt134 = "Non-Viewable";


// Setup.php
$l_set1 = "Setup Utility";
$l_set2 = "This <b>Setup Utility</b> performs the following functions.";
$l_set3 = "<b>1)</b> The <b>Setup Utility</b> automatically sets the permissions of your \"data\" directory to 755 or 777.";
$l_set4 = "<b>2)</b> The <b>Setup Utility</b> will check to see if the \"image\" directory, specified in \"Options\"(config.php), exists.";
$l_set5 = "If the directory does exist, the utility will automatically set the permissions of the directory and all subdirectories to 755 or 777 and all files contained in the directories to 644.";
$l_set6 = "If the directory does exist, the utility will automatically set the permissions for the necessary directories so that the image upload/manager (iBrowser) plugin will work correctly.";
$l_set7 = "<b>3)</b> The <b>Setup Utility</b> will check to see if the \"file upload\" direcory, specified in \"Options\"(config.php), exists.";
$l_set7a = "If the directory does exist, the utility will automatically set the permissions of the directory and all subdirectories to 755 or 777 and all files contained in the directories to 644.";
$l_set8 = "WARNING!!!";
$l_set9 = "The utility will set the permissions of <b>ALL SUBDIRECTORIES</b> to 755 or 777 and the permissions of <b>ALL FILES</b> under the image directory to 644!!!";
$l_set10 = "Set the directory permissions to 755 or 777.";
$l_set11 = "Setup Utility Results";
$l_set12 = "Directory";
$l_set13 = "permissions set to";
$l_set14 = "<b>Failed</b> to set directory permissions on:";
$l_set15 = "has been created and the permissions have been set to";
$l_set17 = "Maximum file upload size. For instance: 55M";
$l_set18 = "Register Globals, on/off";
$l_set19 = "Create";
$l_set20 = "<b>PHP.INI</b> created!!!";
$l_set21 = "Automatically closing...";
$l_set22 = "<b>THERE WAS A PROBLEM!!!</b> php.ini was not created!!!";
$l_set23 = "File";
$l_set24 = "<b>Failed</b> to set file permissions on:";
$l_set25 = "<b>.htaccess</b> created!!!";
$l_set26 = "<b>THERE WAS A PROBLEM!!!</b> .htaccess was not created!!!";
$l_set27 = "<b>THERE WAS A PROBLEM!!!</b> CSS file was not created!!!";

// Upload.php
$l_upload1 = "Upload File";
$l_upload2 = "My Files";
$l_upload3 = "Name";
$l_upload4 = "Size";
$l_upload5 = "Modified";
$l_upload6 = "Rename";
$l_upload7 = "Delete";
$l_upload8 = "Location";
$l_upload9 = "Binary";
$l_upload10 = "<b>ASCII</b> files are text files that can be opened with any word processor.<br /><b>Binary</b> files are encoded data files.<br /><br />Please consult the list of examples or \"google\" if you are unsure.<br /><br /><b>Examples:</b><br /><b>ASCII</b> = txt, html, doc, php, pdf<br /><b>Binary</b> = jpg, gif, zip, mp3, wav, mov";
$l_upload11 = "upload files directory doesn't exist and creation failed!!!";
$l_upload12 = "change permission to 755 failed!!!";
$l_upload13 = "Successfully uploaded";
$l_upload14 = "There was a problem uploading";
$l_upload15 = "Automatically redirecting to the <a href=\"upload.php\">Upload-Page</a>";
$l_upload16 = "File was not uploaded!!!";
$l_upload17 = "Please choose Binary or ASCII when uploading.";
$l_upload18 = "was <b>succesfully</b> deleted.";
$l_upload19 = "Could not rename file";
$l_upload20 = "was <b>succesfully</b> renamed to";

// Global
$l_global1 = "Edit";
$l_global2 = "Go";
$l_global3 = "Could not open file!";
$l_global4 = "Submit";
$l_global5 = "Cancel";
$l_global6 = "Add/Edit";
$l_global7 = "On";
$l_global8 = "Off";
$l_global9 = "Continue";
$l_global10 = "Successfully Logged Out";
$l_global11 = "Redirecting...";
$l_global12 = "Logout";
$l_global13 = "Enter Password";
$l_global14 = "Login";
$l_global15 = "&uarr; Up";
$l_global16 = "&darr; Down";
$l_global17 = "Yes";
$l_global18 = "No";
?>