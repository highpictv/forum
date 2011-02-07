<?php

  /**
   * Automatic Image Upload with Thumbnails - uploadimg.php
   * 
   * @author : Koos
   * @email  : pampoen10@yahoo.com
   * @version 1.3.7
   * @release date : 2009-08-19
   */

  /* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY
   * OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
   * LIMITED   TO  THE WARRANTIES  OF  MERCHANTABILITY,
   * FITNESS    FOR    A    PARTICULAR    PURPOSE   AND
   * NONINFRINGEMENT.  IN NO EVENT SHALL THE AUTHORS OR
   * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES
   * OR  OTHER  LIABILITY,  WHETHER  IN  AN  ACTION  OF
   * CONTRACT,  TORT OR OTHERWISE, ARISING FROM, OUT OF
   * OR  IN  CONNECTION WITH THE SOFTWARE OR THE USE OR
   * OTHER DEALINGS IN THE SOFTWARE.
   */
   
   

include "uploadimg_config.php";



define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

// Load the uploadimg.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/uploadimg.php';



// Detect two byte character sets
$multibyte = (isset($lang_common['lang_multibyte']) && $lang_common['lang_multibyte']) ? true : false;



$page_title = array(pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_uploadimg['Upload image']);


require PUN_ROOT.'header.php';

// Do we have permission to upload images?
if ($pun_user['is_guest'])
	message($lang_common['Not logged in']);

if (!in_array($pun_user['g_title'], $Allow_Uploads))
	message($lang_uploadimg['No permission']);


//****
$check = $allow_jpg_uploads + $allow_png_uploads + $allow_gif_uploads;

	$i = 0;

	if ($allow_jpg_uploads == "1")
	{
		$type_array[$i]= "JPEG";
		$i = $i + 1;
	}

	if ($allow_png_uploads == "1")
	{
		$type_array[$i]= "PNG";
		$i = $i + 1;
	}

	if ($allow_gif_uploads == "1")
	{
		$type_array[$i]= "GIF";
		$i = $i + 1;
	}

if ($check == 0)
{
	$message1 = $lang_uploadimg['Upload disabled'];
	$message2 = "";
}

elseif ($check == 1)
{
	$message1 = str_replace('<type1>', $type_array[0], $lang_uploadimg['Can only upload1']);
	$message2 = str_replace('<extension1>', $type_array[0], $lang_uploadimg['Has to be1']);
	$message2 = " ".$message2;
}

elseif ($check == 2)
{
	$message1 = str_replace('<type1>', $type_array[0], $lang_uploadimg['Can only upload2']);
	$message1 = str_replace('<type2>', $type_array[1], $message1);
	$message2 = str_replace('<extension1>', $type_array[0], $lang_uploadimg['Has to be2']);
	$message2 = str_replace('<extension2>', $type_array[1], $message2);
	$message2 = " ".$message2;
}

elseif ($check == 3)
{
	$message1 = str_replace('<type1>', $type_array[0], $lang_uploadimg['Can only upload3']);
	$message1 = str_replace('<type2>', $type_array[1], $message1);
	$message1 = str_replace('<type3>', $type_array[2], $message1);
	$message2 = str_replace('<extension1>', $type_array[0], $lang_uploadimg['Has to be3']);
	$message2 = str_replace('<extension2>', $type_array[1], $message2);
	$message2 = str_replace('<extension3>', $type_array[2], $message2);
	$message2 = " ".$message2;
}

if ($size_limit != "yes")
	$message3 = $lang_uploadimg['No size limit'];
else
	$message3 = str_replace('<MAX_SIZE>', $limit_size, $lang_uploadimg['Size limit']);

//****
		
		
		
		#######################################################
		###//==============//================//=============//#
		##//==============// Image uploaded //=============//##
		#//==============//================//=============//###
		#######################################################
		if(isset($_POST['form_sent']))
		{

 
			if($_FILES['imagefile']['name'] == null) 
			{
			
				$warning_upload = "<font color=\"#FF0000\">".$lang_uploadimg['Unable to upload']."</font>"; // Error Message If Upload Failed
				message($warning_upload);	
			
			}
               
			else
			{
		#######################################################
		###//===========//=====================//===========//#
		##//===========// Image upload script //===========//##
		#//===========//=====================//===========//###
		#######################################################
        

	$limit_sizef = $limit_size*1024; // convert Kilobytes to bytes
	$file_prefix = $pun_user['id']."_"; // the pun user id is used as the prefix for all uploaded files
	$absolute_path_images = dirname(__FILE__) . "/" . substr_replace($idir,"",-1);
	$absolute_path_thumbs = dirname(__FILE__) . "/" . substr_replace($tdir,"",-1);

	// Find forumurl
	$domain = $_SERVER['HTTP_HOST']; // find out the domain:
	$path = $_SERVER['SCRIPT_NAME']; // find out the path to the current file:
	$urltemp = "http://" . $domain . $path ; // put it all together:
	$parts = Explode('/', $path);
	$currentFile = end($parts);
	$forumurl = substr($urltemp, 0, strpos($urltemp, "$currentFile"));


	function strip_ext($name)
	{
		$ext = strrchr($name, '.');
			if($ext !== false)
			{
				$name = substr($name, 0, -strlen($ext));
			}
		return $name;
	}
     
	?>
<script type="text/javascript">

function highlight(field) {
        field.focus();
        field.select();
}

</script>
	<?php
     


	$imagefilename = $_FILES['imagefile']['name'];
	$imagefilename_rl = strip_ext($imagefilename);
	$imagefilename_ext = strtolower(end(explode('.',$imagefilename))); // get the file extension
  
	// Transliterate all characters with accents,umlauts,ligatures and runes known to ISO-8859-1
	$imagefilename_rl = strtr($imagefilename_rl,"\xA1\xAA\xBA\xBF\xC0\xC1\xC2\xC3\xC5\xC7\xC8\xC9\xCA\xCB\xCC\xCD\xCE\xCF\xD0\xD1\xD2\xD3\xD4\xD5\xD8\xD9\xDA\xDB\xDD\xE0\xE1\xE2\xE3\xE5\xE7\xE8\xE9\xEA\xEB\xEC\xED\xEE\xEF\xF0\xF1\xF2\xF3\xF4\xF5\xF8\xF9\xFA\xFB\xFD\xFF","!ao?AAAAACEEEEIIIIDNOOOOOUUUYaaaaaceeeeiiiidnooooouuuyy");   
	$imagefilename_rl = strtr($imagefilename_rl, array("\xC4"=>"Ae", "\xC6"=>"AE", "\xD6"=>"Oe", "\xDC"=>"Ue", "\xDE"=>"TH", "\xDF"=>"ss", "\xE4"=>"ae", "\xE6"=>"ae", "\xF6"=>"oe", "\xFC"=>"ue", "\xFE"=>"th"));
  
	// Strip all non-alphanumeric characters (except _ -) from string and replace all spaces with _ (underscore)
	$find = array("/[^a-zA-Z0-9\-\_\s]/","/\s+/");
	$replace = array("","_");
	$imagefilename_rl = strtolower(preg_replace($find,$replace,$imagefilename_rl));
	
	// Truncate filename if longer than 100 characters
	$imagefilename_rl = (strlen($imagefilename_rl) > 100) ? substr($imagefilename_rl, 0 , 100) : $imagefilename_rl;
	
	$imagefilename = $imagefilename_rl.".".$imagefilename_ext;
	$url = $file_prefix . $imagefilename;   // Set $url To Equal The Filename For Later Use
	$getcode = "[url=".$forumurl.$idir.$file_prefix.$imagefilename."][img]".$forumurl.$tdir.$file_prefix.$imagefilename."[/img][/url]";
	$getimg = "[img]".$forumurl.$idir.$file_prefix.$imagefilename."[/img]";
	$boxwidth = $twidth - 4;
  


		// Determine whether file is correct filetype
		if (!((($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg") && ($imagefilename_ext == "jpg" || $imagefilename_ext == "jpeg") && ($allow_jpg_uploads == "1")) || (($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png") && ($imagefilename_ext == "png") && ($allow_png_uploads == "1")) || (($_FILES['imagefile']['type'] == "image/gif") && ($imagefilename_ext == "gif") && ($allow_gif_uploads == "1"))))
		{
			$warning_filetype = "<font color=\"#FF0000\">".$lang_uploadimg['Wrong filetype'].$message2.". ".$lang_uploadimg['Yours is']." "."<strong>".$_FILES['imagefile']['type']."</strong></font>"; // Error Message If Filetype Is Wrong
			message($warning_filetype);
		}


		// Check if the file exists
		$nameoffile = $file_prefix.$imagefilename;
		if(file_exists("$absolute_path_images/$nameoffile"))
		{

		?>
		<div class="blockform">
			<h2><span><?php echo $lang_uploadimg['Upload image'] ?></span></h2>
			<div class="box">
				<form action="uploadimg.php">
					<div class="inform">
						<fieldset>
							<legend><?php echo $lang_uploadimg['Result'] ?></legend>
							<div class="infldset">
	
<?php

echo $lang_uploadimg['File exists']."<br />";   

echo "<br />".$lang_uploadimg['Exist message']." <strong>".$_FILES['imagefile']['name']."</strong><br />\n";

?>



<div style="padding: 5px 6px">
<?php

//----------DISPLAY START0----------

            echo '<table cellpadding="0"><tr>';

            if ($display_img_box == "0") {
            //display Thumb code only start
			echo "<td style=\"border: 0px;\">";
             
          echo "
            <a href=\""."$forumurl$idir$file_prefix$imagefilename"."\"><img src=\""."$forumurl$tdir$file_prefix$imagefilename"."\" alt=\"\" /></a><br /><input onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0; width: ".$boxwidth."px;\" value=\"".$getcode."\" /><br /><br /></td>"; 
            //display Thumb code only end
            }
            else {
            //display Thumb and Image code start
            echo "<td style=\"border: 0px;\">";
            
          echo "
            <a href=\""."$forumurl$idir$file_prefix$imagefilename"."\"><img src=\""."$forumurl$tdir$file_prefix$imagefilename"."\" alt=\"\" /></a><br /><table style=\"width: 10%\"><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><strong>".$lang_uploadimg['Thumb'].":&nbsp;</strong></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><input onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getcode."\" /></td></tr><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><strong>".$lang_uploadimg['Image'].":</strong></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><input onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getimg."\" /></td></tr></table><br /><br /></td>";
            //display Thumb and Image code end
            }
            
            echo '</tr></table>';

//----------DISPLAY END0----------

?>
</div>


					</div>
				</fieldset>
					</div>
					<p style="text-align: right"><a href="javascript: history.go(-1)"><?php echo $lang_uploadimg['Back'] ?></a></p>
				</form>
			</div>
		</div>
		<?php
		require PUN_ROOT.'footer.php';
		}


		// Check if filesize is not too big
		if (($size_limit == "yes") && ($limit_sizef < $_FILES['imagefile']['size'])) 
		{
			$warning_filesize = "<font color=\"#FF0000\">".str_replace('<MAX_SIZE>', $limit_size, $lang_uploadimg['Too big'])."</font>";
			message($warning_filesize.$lang_uploadimg['link to resize']);
		}


		// Allocate all necessary memory for the image
		ini_set('memory_limit', '-1');


		// Can the file be uploaded?
		if (empty($_FILES['imagefile']['tmp_name']))
		{
			$warning_upload = "<font color=\"#FF0000\">".$lang_uploadimg['Unable to upload']."</font>"; // Error Message If Upload Failed 
			message($warning_upload);
		}
    
    
//==========Everything OK - can now proceed to upload image==========

      
		if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg")
		{
		$simg = @imagecreatefromjpeg($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbnail From
		}
		elseif ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png")
		{
		$simg = @imagecreatefrompng($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbnail From
		}
		elseif ($_FILES['imagefile']['type'] == "image/gif")
		{
		$simg = @imagecreatefromgif($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbnail From
		}
      
		$currwidth = @imagesx($simg);   // Current Image Width
		$currheight = @imagesy($simg);   // Current Image Height
      
      
      
		$zoomw = $currwidth/$twidth;
		$zoomh = $currheight/$theight;

			
			$zoom = ($zoomw > $zoomh) ? $zoomw : $zoomh;

           
			if ($currwidth < $twidth && $currheight < $theight)
			{
				$newwidth = $currwidth;
				$newheight = $currheight;
			}
			
			else
			{
				$newwidth = $currwidth/$zoom;
				$newheight = $currheight/$zoom;
			}


		$dimg = @imagecreatetruecolor( $newwidth, $newheight );   // Make New Image For Thumbnail

		if (!$dimg)
			$dimg = @imagecreate( $newwidth, $newheight ); 


			// If it's a PNG or GIF image
			if ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png" || $_FILES['imagefile']['type'] == "image/gif")
			{
				@imagetruecolortopalette($simg, true, 256); // convert to 256 colors
				$trnprt_indx = @imagecolortransparent($simg);

				// If we have a specific transparent color
				if ($trnprt_indx >= 0)
				{
					$trnprt_color = @imagecolorsforindex($simg, $trnprt_indx);
					$trnprt_indx = @imagecolorallocate($dimg, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					@imagefill($dimg, 0, 0, $trnprt_indx);
					@imagecolortransparent($dimg, $trnprt_indx);
				}
				elseif ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png")
				{
					@imagealphablending($dimg, false);
					$color = @imagecolorallocatealpha($dimg, 0, 0, 0, 127);
					@imagefill($dimg, 0, 0, $color);
					@imagesavealpha($dimg, true);
				}
			}


			@imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight);   // Copy Resized Image To The New Image (So We Can Save It)


      if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg")
      {
      @imagejpeg($dimg, "$tdir" . $url, 75);   // Saving The Image
      }
      elseif ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png")
      {
      @imagejpeg($dimg, "$tdir" . $url, 75);   // Saving The Image
      }
      elseif ($_FILES['imagefile']['type'] == "image/gif")
      {
      @imagejpeg($dimg, "$tdir" . $url, 75);   // Saving The Image
      }
      

				// Exit if thumb was not created
				if(!file_exists("$absolute_path_thumbs/$nameoffile"))
				{
					$warning_upload = "<font color=\"#FF0000\">".$lang_uploadimg['Unable to upload']."</font>"; // Error Message If Upload Failed
					message($warning_upload);
				}


  
			if (($resize_images_above_limit == "yes") && ($limit_sizef < $_FILES['imagefile']['size']) && (!isset($_POST['resizeimage'])))
			{
				if ($currwidth > $currheight)
				{
					$jwidth = "640";   // Maximum Width For Resized Images
					$jheight = "480";   // Maximum Height For Resized Images
				}
				else
				{
					$jwidth = "480";   // Maximum Width For Resized Images
					$jheight = "640";   // Maximum Height For Resized Images
				}   
			}
      
      
	if (isset($_POST['resizeimage']))
	{
   
		$dimparts = Explode(' ', $_POST['resizeoption']);
		$resizedim = $dimparts [0];
            
				if ($resizedim == "100x75")
				{
						if ($currwidth > $currheight)
						{
							$jwidth = "100";   // Maximum Width For Resized Images
							$jheight = "75";   // Maximum Height For Resized Images
						}
						else
						{
							$jwidth = "75";   // Maximum Width For Resized Images
							$jheight = "100";   // Maximum Height For Resized Images
						}
				}
				
				if ($resizedim == "160x120")
				{
						if ($currwidth > $currheight)
						{
							$jwidth = "160";   // Maximum Width For Resized Images
							$jheight = "120";   // Maximum Height For Resized Images
						}
						else
						{
							$jwidth = "120";   // Maximum Width For Resized Images
							$jheight = "160";   // Maximum Height For Resized Images
						}
				}

				if ($resizedim == "320x240")
				{
						if ($currwidth > $currheight)
						{
							$jwidth = "320";   // Maximum Width For Resized Images
							$jheight = "240";   // Maximum Height For Resized Images
                                   }
						else
						{
							$jwidth = "240";   // Maximum Width For Resized Images
							$jheight = "320";   // Maximum Height For Resized Images
						}
				}
				
				if ($resizedim == "640x480")
				{
						if ($currwidth > $currheight)
						{
							$jwidth = "640";   // Maximum Width For Resized Images
							$jheight = "480";   // Maximum Height For Resized Images
						}
						else
						{
							$jwidth = "480";   // Maximum Width For Resized Images
							$jheight = "640";   // Maximum Height For Resized Images
						}
				}
	}
			


//============= RESIZE IMAGE CODE START =============
	if (isset($jwidth)) 
	{
      
		//----create resized image start
      
		$zoomw = $currwidth/$jwidth;
		$zoomh = $currheight/$jheight;


			$zoom = ($zoomw > $zoomh) ? $zoomw : $zoomh;
            
			if (($currwidth < $jwidth) && ($currheight < $jheight))
				$zoom = "1";  

			$newwidth = $currwidth/$zoom;
			$newheight = $currheight/$zoom;


			$jdimg = @imagecreatetruecolor( $newwidth, $newheight );   // Make New Image
			$gd_flag = "0";
			

			if (!$jdimg)
			{ 
				$jdimg = @imagecreate( $newwidth, $newheight );
				$gd_flag = "1";
			}
			
			
			// If it's a PNG or GIF image
			if ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png" || $_FILES['imagefile']['type'] == "image/gif")
			{
				@imagetruecolortopalette($simg, true, 256); // convert to 256 colors
				$trnprt_indx = @imagecolortransparent($simg);

				// If we have a specific transparent color
				if ($trnprt_indx >= 0)
				{
					$trnprt_color = @imagecolorsforindex($simg, $trnprt_indx);
					$trnprt_indx = @imagecolorallocate($jdimg, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					@imagefill($jdimg, 0, 0, $trnprt_indx);
					@imagecolortransparent($jdimg, $trnprt_indx);
				}
				elseif ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png")
				{
					@imagealphablending($jdimg, false);
					$color = @imagecolorallocatealpha($jdimg, 0, 0, 0, 127);
					@imagefill($jdimg, 0, 0, $color);
					@imagesavealpha($jdimg, true);
				}
			}

			@imagecopyresampled($jdimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight);



			if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg")
			{
				@imagejpeg($jdimg, "$idir" . $url, 75);   // Saving The Image
			}

			elseif ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png")
			{
				if ($gd_flag != "1")
					@imagetruecolortopalette($jdimg, true, 256);  // convert to 256 colors
			
				@imagepng($jdimg, "$idir" . $url);   // Saving The Image
			}
		
			elseif ($_FILES['imagefile']['type'] == "image/gif")
			{
				if ($gd_flag != "1")
					@imagetruecolortopalette($jdimg, true, 256);  // convert to 256 colors
			
				@imagegif($jdimg, "$idir" . $url);   // Saving The Image
			}


		imagedestroy($jdimg);   // Destroying The Temporary Image
      
		//----create resized image end
    
	}
      
	else
	{
		$copy = move_uploaded_file($_FILES['imagefile']['tmp_name'], "$idir" . $file_prefix . $imagefilename);   // Move Image From Temporary Location To Permanent Location
	}
      
//============= RESIZE IMAGE CODE END =============
      
      
		imagedestroy($simg);   // Destroying The Temporary Image
		imagedestroy($dimg);   // Destroying The Other Temporary Image
      
      
		// Only delete image if thumb doesn't exist
		if ((file_exists("$absolute_path_images/$nameoffile")) && (!file_exists("$absolute_path_thumbs/$nameoffile")))
		{
			unlink($idir.$nameoffile);
			$warning_upload = "<font color=\"#FF0000\">".$lang_uploadimg['Unable to upload']."</font>"; // Error Message If Upload Failed
			message($warning_upload);
		}
               
               
		// Only delete thumb if image doesn't exist
		if ((file_exists("$absolute_path_thumbs/$nameoffile")) && (!file_exists("$absolute_path_images/$nameoffile")))
		{
			unlink($tdir.$nameoffile);
			$warning_upload = "<font color=\"#FF0000\">".$lang_uploadimg['Unable to upload']."</font>"; // Error Message If Upload Failed 
			message($warning_upload);
		}


//=======Show results start=======
	
?>
<div class="blockform">
	<h2><span><?php echo $lang_uploadimg['Upload image'] ?></span></h2>
	<div class="box">
		<form action="uploadimg.php">
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_uploadimg['Result'] ?></legend>
					<div class="infldset">
	
	<?php
      echo $lang_uploadimg['Successful upload']."<br />";   // Was Able To Successfully Upload Image
      echo $lang_uploadimg['Successful thumbnail']."<br />";   // Resize successful
    ?>
      

<div style="padding: 5px 6px">
<?php
//----------DISPLAY START----------

            echo '<table cellpadding="0"><tr>';

            if ($display_img_box == "0") {
            //display Thumb code only start
			echo "<td style=\"border: 0px;\">";
             
          echo "
            <a href=\""."$forumurl$idir$file_prefix$imagefilename"."\"><img src=\""."$forumurl$tdir$file_prefix$imagefilename"."\" alt=\"\" /></a><br /><input onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0; width: ".$boxwidth."px;\" value=\"".$getcode."\" /><br /><br /></td>"; 
            //display Thumb code only end
            }
            else {
            //display Thumb and Image code start
            echo "<td style=\"border: 0px;\">";
            
          echo "
            <a href=\""."$forumurl$idir$file_prefix$imagefilename"."\"><img src=\""."$forumurl$tdir$file_prefix$imagefilename"."\" alt=\"\" /></a><br /><table style=\"width: 10%\"><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><strong>".$lang_uploadimg['Thumb'].":&nbsp;</strong></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><input onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getcode."\" /></td></tr><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><strong>".$lang_uploadimg['Image'].":</strong></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><input onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getimg."\" /></td></tr></table><br /><br /></td>";
            //display Thumb and Image code end
            }
            
            echo '</tr></table>';

//----------DISPLAY END----------
?>
</div>

						
					</div>
				</fieldset>
			</div>
			<p style="text-align: right"><a href="javascript: history.go(-1)"><?php echo $lang_uploadimg['Back'] ?></a></p>
		</form>
	</div>
</div>
<?php

require PUN_ROOT.'footer.php';


//=======Show results end=======
       
			}
               
      


		}
       
        else
        {
		#######################################################
		###//=============//==================//============//#
		##//=============// Main upload page //============//##
		#//=============//==================//============//###
		#######################################################


?>


<div class="blockform">
	<h2><span><?php echo $lang_uploadimg['Upload image'] ?></span></h2>
	<div class="box">
		<form id="uploadimg" method="post" action="uploadimg.php?subpage=upload" enctype="multipart/form-data">
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_uploadimg['Select image'] ?></legend>
					<div class="infldset">

 <p><?php echo $lang_uploadimg['Upload message'] ?>
 </p>
  <p>
  <br /><strong><?php echo $lang_uploadimg['Restrictions'] ?></strong>
  <br /><?php echo $message1 ?>
	<?php 
		if ($resize_images_above_limit == "yes" && $size_limit == "no")
			echo "<br />".str_replace('<MAX_SIZE>', $limit_size, $lang_uploadimg['Images above']);
		else
			echo "<br />".$message3.$lang_uploadimg['link to resize'];
	?>
  
  <br />
  </p>
  <p>
  <br /></p>
  
  <?php echo $lang_uploadimg['File'] ?><br />
  <input type="hidden" name="form_sent" value="1" />
  <input type="file" name="imagefile" class="form" />
  
	<?php if ($allow_resize_option == "1") { ?>
	<br /><br />
	<input type="checkbox" name="resizeimage" value="ON" />&nbsp;<?php echo $lang_uploadimg['Resize image'] ?>
	<select size="1" name="resizeoption">
	<option>100x75 (<?php echo $lang_uploadimg['Avatar'] ?>)</option>
	<option>160x120 (<?php echo $lang_uploadimg['Thumbnail'] ?>)</option>
	<option selected="selected">320x240 (<?php echo $lang_uploadimg['Websites and email'] ?>)</option>
	<option>640x480 (<?php echo $lang_uploadimg['Message boards'] ?>)</option>
	</select>
	<?php } ?>



  <br /><br />
  <input type="submit" name="uploadimg" value="<?php echo $lang_common['Submit'] ?>" accesskey="s" />
  <br />

  
  
	<p>
	
	</p>

						
					</div>
				</fieldset>
			</div>
			
			

			<p style="text-align: right"><a href="uploadimg_view.php?view=gallery"><?php echo $lang_uploadimg['My uploads'] ?></a></p>
			
			<?php 
			if (in_array($pun_user['g_title'], $Allow_Stats))
			{
			?>
				<p style="text-align: right"><a href="uploadimg_stats.php"><?php echo $lang_uploadimg['Upload statistics'] ?></a></p>
			<?php 
			}
			?>
			

			
		
		</form>
	</div>
</div>
<?php

require PUN_ROOT.'footer.php';

		}
?>
