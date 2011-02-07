<?php

  /*****************************************************
  ** Script configuration
  *****************************************************/

$idir = "uploads/";   // Path To Images Directory
$tdir = "uploads/thumbs/";   // Path To Thumbnails Directory

$twidth = "150";   // Maximum Width For Thumbnail Images - default = 150
$theight = "150";   // Maximum Height For Thumbnail Images - default = 150
$size_limit = "yes"; // **** if "yes" there will be a file size limit for uploaded files
$limit_size = "200"; // file size limit in KB - default = 200

$allow_resize_option = "1"; // allow = 1 ; disallow = 0

$resize_images_above_limit = "yes"; // if "yes" images exceeding 'limit_size' will be automatically resized to 640x480
                                    // - must set $size_limit = "no" for this to work

$allow_jpg_uploads = "1"; // allow = 1 ; disallow = 0
$allow_png_uploads = "1"; // allow = 1 ; disallow = 0
$allow_gif_uploads = "1"; // allow = 1 ; disallow = 0

// ** Gallery settings
$images_per_page = "20"; // number of images displayed per page in the gallery
$images_per_row = "4"; 
$display_img_box = "1"; // allow = 1 ; disallow = 0


  /*****************************************************
  ** Permission setting
  *****************************************************/

$Allow_Uploads = array();
//
// Listed below are user groups that are are allowed to upload images.
//
// $Allow_Uploads[] = "MY_USERGROUP";
//
$Allow_Uploads[] = "Administrateurs";
$Allow_Uploads[] = "Moderateurs";
$Allow_Uploads[] = "Membres";

/*
The permission setting allows you to have full control over who can upload images.

If you want all members to be able to upload images, just add the following line:
$Allow_Uploads[] = "Members";

To ban a certain user from uploading images, just move the user to an user group not
included in the  $Allow_Uploads array.

For those who do not know how to create new user groups:
Log in as administrator and go to Administration->User groups->Add new group
*/


  /*****************************************************
  ** Statistics setting
  *****************************************************/

$Allow_Stats = array();
//
// Listed below are user groups that are are allowed to view upload statistics.
//
// $Allow_Stats[] = "MY_USERGROUP";
//
$Allow_Stats[] = "Administrateurs";
$Allow_Stats[] = "Moderateurs";
//$Allow_Stats[] = "Uploaders";
//$Allow_Stats[] = "Membres";


  /*****************************************************
  ** Delete setting
  *****************************************************/

$Allow_Delete = array();
//
// Listed below are user groups that are allowed to delete their own uploaded images.
// Note: Only Administrators can delete images of another user
//
// $Allow_Delete[] = "MY_USERGROUP";
//

$Allow_Delete[] = "Administrateurs";
//$Allow_Delete[] = "Moderateurs";
//$Allow_Delete[] = "Uploaders";
//$Allow_Delete[] = "Membres";


?>