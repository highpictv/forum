##
##        Mod title:  Automatic Image Upload with Thumbnails
##
##      Mod version:  1.3.7
##   Works on PunBB:  1.2.*
##     Release date:  2009-08-19
##           Author:  Koos (pampoen10@yahoo.com)
##
##      Description:  This tool allows users to upload images and automatically
##                    creates thumbnails for them which can then be displayed
##                    in your forum posts. Clicking the thumbnail shows the
##                    original image. By only displaying thumbnails pages load
##                    quicker. This is not really a "MOD" since no punbb files
##                    have to be modified and the database is not affected.
##                    This makes for very easy installation and removal if
##                    needed. Also no changes are necessary when upgrading 
##                    your punbb forum.
##
##   Affected files:  none
##                                     
##       Affects DB:  no
## 
##            Notes:  Requires the GD library on your Web server. Script can
##                    upload JPEG, PNG AND GIF images.
##
##       DISCLAIMER:  Please note that "mods" are not officially supported by
##                    PunBB. Installation of this modification is done at your
##                    own risk. Backup your forum database and any and all
##                    applicable files before proceeding.
##
################################################################################
## CHANGELOG:
## 1.3.7 : fixed a sql injection vulnerability
##         some layout fixes
## 1.3.6 : preserves transparency when resizing transparent GIF and PNG images
##         now sorts images according to modification time instead of inode change time
##         BBCode now shown as in the gallery after image upload
##         truncates filenames longer than 100 characters
##         other minor changes
## 1.3.5 : made the necessary changes so that sorting will work in PHP5
##         fixed a serious vulnerability
##         other minor changes
## 1.3.4 : rewrote the 'uploadimg.php' page
##         fixed a vulnerability
##         all pages now valid XHTML 1.0 Strict
##         stats totals now also include thumb size
## 1.3.3 : fixed thumbnail creation bug
##         - previously, when width<twidth and height>theight: no resize
##         removed dimensions column in list view
##         other minor fixes
## 1.3.2 : added statement allocating all necessary memory for image processing
##         transliterates filenames with umlauts, accents, ligatures and runes 
##         added dimensions column to list of uploaded images
##         fixed bug resulting in interrupted uploads being saved
##         other minor changes
## 1.3.1 : much improved thumbnail and image resize quality
##         improved 'resize image' function
##         more efficient use of PHP memory - can now resize larger images
##         removed user id from statistics table
##         other minor changes
## 1.3.0 : strips all non-alphanumeric characters in filename
##         fixed image resize aspect ratio problem
##         added delete functionality
##         added option to resize images on upload
##         added option to view image URL link below thumbnail in the gallery
##         thumbnail now shown on the results page after upload
##         other minor fixes and improvements
## 1.2.2 : totals now shown in the 'upload statistics' table
##         added language support
##         fixed: upload not saved if thumbnail can not be created
##         fixed: PNG Image file interpretation problem in IE
##         - (ie6 sends image/x-png instead of image/png)
##         other minor changes
## 1.2.1 : BBCode now generated below each thumbnail in the gallery
##         - like Photobucket/ImageShack
## 1.2.0 : changed layout to conform more closely to the punbb standard
##         added an 'upload statistics' feature
##         added flickr style gallery feature - with latest upload displayed first
##         added full permission control
##         all spaces in filenames of uploaded images now replaced with _ (underscore)
##         dates in upload list now displayed as in the rest of your forum
##         other minor improvements
## 1.1.1 : fixed compatibility problem with Internet Explorer
##         some other minor fixes
## 1.1.0 : added support for PNG and GIF files
##         simplified  configuration (don't have to specify absolutepath or forumurl)
## 1.0   : initial release 
################################################################################



#
#---------[ 1. OPEN AND CONFIGURE ]-------------------------------------------------------
#

Open the file uploadimg_config.php and configure if you want - or leave as is.


#
#---------[ 2. SAVE/UPLOAD ]-------------------------------------------------
#

Upload all files and folders contained in archive to forum root. Keep folder structure intact.


#
#---------[ 3. SET PERMISSIONS ]-------------------------------------------------
#

Set /uploads and /uploads/thumbs folders to have write/execute permissions (CHMOD to 777)


#
#---------[ 4. ADD ADDITIONAL MENU ITEM ]-------------------------------------------------
#

Login as administrator to your punbb forum and go to Administration->Options and then under 'Additional menu items' insert the following into the box: 

X = <a href="uploadimg.php">Upload image</a>

where X is the position at which the link should be inserted (recommended: Use X=3)
