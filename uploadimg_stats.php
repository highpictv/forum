<?php

  /**
   * Automatic Image Upload with Thumbnails - uploadimg_stats.php
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




$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_uploadimg['Upload image'];



require PUN_ROOT.'header.php';


	if ($pun_user['is_guest'])
		message($lang_common['Not logged in']);
		
		
	if (!in_array($pun_user['g_title'], $Allow_Stats))
		message($lang_common['No permission']);
            


$file_prefix = $pun_user['id']."_"; // the pun user id is used as the prefix for all uploaded files
$prefix_length = strlen($file_prefix);

  // Find forumurl
  $domain = $_SERVER['HTTP_HOST']; // find out the domain:
  $path = $_SERVER['SCRIPT_NAME']; // find out the path to the current file:
  $urltemp = "http://" . $domain . $path ; // put it all together:
  $parts = Explode('/', $path);
  $currentFile = end($parts);
  $forumurl = substr($urltemp, 0, strpos($urltemp, "$currentFile"));

  $nuwearray = array();
  $tmp_array = array();



function prefix( $word, $prefix)
{
        if ( strlen($word) < strlen($prefix))
        {
                $tmp = $prefix;
                $prefix = $word;
                $word = $tmp;
        }

        $word = substr($word, 0, strlen($prefix));

        if ($prefix == $word)
        {
                return 1;
        }

        return 0;
}




// Color of alternate rows on the index page.  

//$RowColor = "#e9e9e9";



$Exclude_File = array();
//
// Listed below are two file names that are automatically excluded from the listings.  
// 
$Exclude_File[] = ".htaccess";
$Exclude_File[] = "index.php";
$Exclude_File[] = "readme.txt";



$Exclude_Folder = array();
//
// Listed below is a folder name that is automatically excluded from the listings.  
//
// $Exclude_Folder[] = "MY_FOLDER";
//
$Exclude_Folder[] = "Restricted";



$Exclude_Extension = array();
//
// Listed below is an extension that automatically excludes ANY file with this extension from the listings.  
//
// $Exclude_Extension[] = "MY_EXTENSION";
//
$Exclude_Extension[] = "hidden";



// set all GET/POST vars
if($_GET) 
{ 
	foreach($_GET as $key => $val) 
	{ 
		$$key = $val;
	}
}
// Get all vars from the POST method.  Assign variable and value
if($_POST) 
{ 
	foreach($_POST as $key => $val) 
	{ 
		$$key = $val;
	}
}

// get file extension
function GetExt($val) {
	
	$val = strtolower($val);
	switch($val) {
	case "gif";
		$type = "GIF Image";
		$image = "uploadimg_icon.gif";
		break;
	case "jpg";
		$type = "JPEG Image";
		$image = "uploadimg_icon.gif";
		break;
	case "jpeg";
		$type = "JPEG Image";
		$image = "uploadimg_icon.gif";
		break;
    case "png";
		$type = "PNG Image";
		$image = "uploadimg_icon.gif";
		break;
	//--- New Here---//
	default:
		$type = "Unknown Type";
		$image = "uploadimg_icon.gif";
	}
	// return both values (to be split)
	return $type."?".$image;
}



// Path to icon folder with ending slash
$iconfolder = $forumurl;

$_GLOBAL['image'] = "";

// Open images directory
if(!isset($fdir)) {
	$fdir = "./".$idir;
}
$fdir = str_replace("../", "", $fdir);

// Open thumbs directory
if(!isset($fdir2)) {
	$fdir2 = "./".$tdir;
}
$fdir2 = str_replace("../", "", $fdir2);

// check to see if still inside directory boundry
$check = substr($fdir, 0, 2);
if($check != "./") {
	$fdir = "./";
}

$check = substr($fdir2, 0, 2);
if($check != "./") {
	$fdir2 = "./";
}

// setup file properties class
class File_Properties
{
	var $file_name;		// just the file name
	var $file_ext;		// file extension
	var $file_size;		// size of file
	var $file_date;		// date modified
	var $file_icon;		// icon for file type
	var $file_type;		// short description for file type

	// constructor method - build object
	function Build($file)
	{
		$this->setFname($file);
		$this->setFext($file);
		$this->setFsize($file);
		$this->setFdate($file);
		$this->setFicon_type();
	}

	// Set file name
	function setFname($file)
	{
		$this->file_name = basename($file);
	}
	// set file extension
	function setFext($file)
	{
		$this->file_ext = array_pop(explode('.', $file));
	}
	// set file size
	function setFsize($file)
	{
		$kbs = filesize($file) / 1024;
		$this->file_size = round($kbs, 2);
	}
	// set date modified
	function setFdate($file)
	{
		$modified = filectime($file);
		$this->file_date = date("M jS Y, H:i A", $modified);
	}
	// set file type
	function setFicon_type()
	{
		list($this->file_type, $this->file_icon) = split("\?", GetExt($this->file_ext), 2);
	}

	// setup all get/return methods for class vars
	function getFname()
	{
		return $this->file_name;
	}
	function getFext()
	{
		return $this->file_ext;
	}
	function getFsize()
	{
		return $this->file_size;
	}
	function getFdate()
	{
		return $this->file_date;
	}
	function getFicon()
	{
		return $this->file_icon;
	}
	function getFtype()
	{
		return $this->file_type;
	}
}



// initialize file and folder arrays
$file_array = array();
$dir_array = array();
$Fname_array = array();
$Dname_array = array();

// open images directory
$dir = opendir($fdir);

// Read image files into array
while(false !== ($file = readdir($dir))) 
{	
  	    $parts = Explode('_', $file);
	    $dienr = $parts[0];
	if($file != "." && $file != ".." && is_numeric($dienr)) 
	{	
		$type = filetype($fdir.$file);
		$info = pathinfo($file);
		if($type != "dir")
		{
			if(isset($info["extension"]))
			{
				$file_extension = $info["extension"];
			}
		}
		

		if($type == "file" && !in_array($file, $Exclude_File) && !in_array($file_extension, $Exclude_Extension))
		{
			// setup file object
			$This_File = new File_Properties;
			$This_File->Build($fdir.$file);
			$file_array[] = $This_File;
		}
	}
}
closedir($dir);

// open thumbs directory
$dir2 = opendir($fdir2);

// Read thumbnail files into array
while(false !== ($file = readdir($dir2))) 
{	
  	    $parts = Explode('_', $file);
	    $dienr = $parts[0];
	if($file != "." && $file != ".." && is_numeric($dienr)) 
	{	
		$type = filetype($fdir2.$file);
		$info = pathinfo($file);
		if($type != "dir")
		{
			if(isset($info["extension"]))
			{
				$file_extension = $info["extension"];
			}
		}
		

		if($type == "file" && !in_array($file, $Exclude_File) && !in_array($file_extension, $Exclude_Extension))
		{
			// setup file object
			$This_File = new File_Properties;
			$This_File->Build($fdir2.$file);
			$file_array[] = $This_File;
		}
	}
}
closedir($dir2);

// Set default sort by method
if(!isset($SortBy) || $SortBy != 0 && $SortBy != 1)
{
	$SortBy = 1;
}

// Number of the column to sort by (0-3) set default to 0
if(!isset($NumSort) || $NumSort != 0 && $NumSort != 1 && $NumSort != 2 && $NumSort != 3)
{
	$NumSort = 0;
}

// determin object sorting methods
switch($NumSort) 
{
	case 0;
		$Fsort_method = "file_name";
		$Dsort_method = "dir_name";
	break;
	case 1;
		$Fsort_method = "file_size";
		$Dsort_method = "dir_name";
	break;
	case 2;
		$Fsort_method = "file_type";
		$Dsort_method = "dir_name";
	break;
	case 3;
		$Fsort_method = "file_date";
		$Dsort_method = "dir_date";
	break;
	default:
		$Fsort_method = "file_name";
		$Dsort_method = "dir_name";
}

// object sorting functions
function ASC_sort_file_objects($a, $b) 
{
	global $Fsort_method;
	$obj1 = strtolower($a->$Fsort_method);
	$obj2 = strtolower($b->$Fsort_method);
   	if ($obj1 == $obj2) return 0;
    return ($obj1 < $obj2) ? -1 : 1;
}
function ASC_sort_dir_objects($a, $b) 
{
	global $Dsort_method;
	$obj1 = strtolower($a->$Dsort_method);
	$obj2 = strtolower($b->$Dsort_method);
   	if ($obj1 == $obj2) return 0;
   	return ($obj1 < $obj2) ? -1 : 1;
}
function DESC_sort_file_objects($a, $b) 
{
	global $Fsort_method;
	$obj1 = strtolower($a->$Fsort_method);
	$obj2 = strtolower($b->$Fsort_method);
   	if ($obj1 == $obj2) return 0;
    return ($obj1 > $obj2) ? -1 : 1;
}
function DESC_sort_dir_objects($a, $b) 
{
	global $Dsort_method;
	$obj1 = strtolower($a->$Dsort_method);
	$obj2 = strtolower($b->$Dsort_method);
   	if ($obj1 == $obj2) return 0;
   	return ($obj1 > $obj2) ? -1 : 1;
}

// sort ascending
if($SortBy == 0)
{
	// sort arrays (ASCENDING)
	usort($file_array, 'ASC_sort_file_objects');
	usort($dir_array, 'ASC_sort_dir_objects');
	
	$arrow = "&#9650;";
	$SortBy = 1;
}
// sort descending
else
{
	// sort arrays (DESCENDING)
	usort($file_array, 'DESC_sort_file_objects');
	usort($dir_array, 'DESC_sort_dir_objects');
	
	$arrow = "&#9660;";
	$SortBy = 0;
}





$othernum = 0;


// alternate row counter
$count = 0;

$countj = 1;

$kode = "";

// output file info
for($y = 0; $y < count($file_array); $y++)
//while (list($key, $val) = each($Fname_array))
{



	// alternate row colors
	if($count % 2 != 0)
	{
		$special = "bgcolor='$RowColor'";
	}
	else
	{
		$special = "";
	}
	$count++;

//============= STATS CODE START =============

        $fnf = $file_array[$y]->getFname();
	    $partss = Explode('_', $fnf);
	    
	    //initialize
	    if ($kode != $partss[0]) {
	    
	    $kode = $partss[0];
	    $countj = $countj + 1;

	    $nuwearray[$countj]["id"] = $kode;
	    $nuwearray[$countj]["size"] = $file_array[$y]->getFsize();
	    $nuwearray[$countj]["count"] = 1;
	    
	    $result7 = $db->query('SELECT id, username, num_posts FROM '.$db->prefix.'users WHERE id = '.intval($kode));
        $krydit = $db->fetch_assoc($result7);
        $hierisdit = $krydit['username'];
        $hierisposts = $krydit['num_posts'];
        $result9 = $db->query('SELECT u.id, u.username, u.title, u.num_posts, u.registered, g.g_id, g.g_user_title FROM '.$db->prefix.'users AS u LEFT JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id WHERE u.id = '.intval($kode));

		$user_data = $db->fetch_assoc($result9);
        $hieristitle = get_title($user_data);
        
        $nuwearray[$countj]["title"] = $hieristitle;
        
		if (empty($hierisdit))
		{
			$hierisdit = $lang_uploadimg['Deleted user'];
			$nuwearray[$countj]["title"] = $lang_uploadimg['Deleted user'];
		}
        
        if (empty($hierisposts))
        {
			$hierisposts = "0";
        }
        
        $nuwearray[$countj]["name"] = $hierisdit;
        $nuwearray[$countj]["posts"] = $hierisposts;
	    
	    
	    } 
	    //initialize end
	    
		else
		{
			$nuwearray[$countj]["size"] = $nuwearray[$countj]["size"] + $file_array[$y]->getFsize();
			$nuwearray[$countj]["count"] = $nuwearray[$countj]["count"] + 1;
		}



//============= STATS CODE END =============



}


	
	$sortthis = $_GET['sortthis'];
	if (empty($sortthis))
	{
		$sortthis = 'count';
		$orde = "1";
	}
	
	// sort by ?
    foreach ($nuwearray as $pos => $val)
    {
		$tmp_array[$pos] = $val[$sortthis];
			if ($orde == "1")
			{
				arsort($tmp_array);
			}
			
			elseif ($orde == "0")
			{
				asort($tmp_array);
			}
    }
    
	if ($orde == "1")
	{
		$orde = "0";
	}
	
	elseif ($orde == "0")
	{
		$orde = "1";
    }


	
	?>
	

<div class="blocktable">
	<h2><span><?php echo $lang_uploadimg['Upload statistics']; ?></span></h2>
	<div class="box">
		<div class="inbox">

	<?php
echo "
	<table cellspacing='0'>
		<thead>
		
			<tr>
				<th class='tcr' scope='col'><a href='uploadimg_stats.php?orde=$orde&amp;sortthis=name'>".$lang_common['Username']."</a></th>
				<th class='tcr' scope='col'><a href='uploadimg_stats.php?orde=$orde&amp;sortthis=title'>".$lang_common['Title']."</a></th>
				<th class='tc3' scope='col'><a href='uploadimg_stats.php?orde=$orde&amp;sortthis=count'>".$lang_uploadimg['Uploads']."</a></th>
				<th class='tc3' scope='col'><a href='uploadimg_stats.php?orde=$orde&amp;sortthis=size'>".$lang_uploadimg['Megabyte']."</a></th>
				<th class='tc3' scope='col'><a href='uploadimg_stats.php?orde=$orde&amp;sortthis=posts'>".$lang_common['Posts']."</a></th>
			</tr>
			
";

?>
			
			
			
			
		</thead>
	    
		<tbody>
		<?php 
	    
	        // display however you want
            foreach ($tmp_array as $pos => $val)
            {
            $summb = $summb + $nuwearray[$pos]["size"];
            $sumuploads = $sumuploads + round(($nuwearray[$pos]["count"]/2),0);
            $sumposts = $sumposts + $nuwearray[$pos]["posts"];
            $uploaderscount = $uploaderscount + 1;

	    
		?>
	           <tr>
					<td class="tcr"><a href="uploadimg_view.php?view=gallery&amp;id=<?php echo $nuwearray[$pos]["id"] ?>"><?php echo pun_htmlspecialchars($nuwearray[$pos]["name"]) ?></a></td>
				    <td class="tcr"><?php echo $nuwearray[$pos]["title"]; ?></td>
                    <td class="tc3"><?php echo round(($nuwearray[$pos]["count"]/2),0); ?></td>
                    <td class="tc3"><?php echo round(($nuwearray[$pos]["size"]/1024),2); ?></td>
                    <td class="tc3"><?php echo $nuwearray[$pos]["posts"]; ?></td>
				</tr>
				
		<?php
				}
				
				$summb = round(($summb/1024),2);
				
		?>
				
			<tr>
				<th class='tcr' scope='col'><?php echo $lang_uploadimg['Totals']."&nbsp;&nbsp;".$uploaderscount." ".$lang_uploadimg['Uploaders']; ?></th>
				<th class='tcr' scope='col'>&nbsp;</th>
				<th class='tc3' scope='col'><?php echo $sumuploads; ?></th>
				<th class='tc3' scope='col'><?php echo $summb; ?></th>
				<th class='tc3' scope='col'><?php echo $sumposts; ?></th>
			</tr>
				
				
		</tbody>
		</table>
	</div>
	</div>
	</div>
	
	
	
	

<?php

require PUN_ROOT.'footer.php';

?>