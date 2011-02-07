<?php

/**
 * Copyright (C) 2008-2011 Jojaba
 * see CREDITS file to learn more about this page
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define('PUN_PLUGIN_LOADED', 1);

/* ******************************** */
/* Core of the EZBBC Toolbar Plugin */
/* ******************************** */

// Language file load
$ezbbc_language_folder = file_exists('./plugins/ezbbc/lang/'.$admin_language.'/ezbbc_plugin.php') ? $admin_language : 'English';    
require './plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';

// Getting the config data
$plugin_version = "1.2.2";
$config_content = trim(file_get_contents('./plugins/ezbbc/config.php'));
$config_item = explode(";", $config_content);
$ezbbc_install = $config_item[0];
$ezbbc_status = $config_item[1];
$ezbbc_style_folder = $config_item[2];
$ezbbc_smilies_set = $config_item[3];
if ($ezbbc_install != 0) {
        $first_install = false;
        $ezbbc_install_date = date($lang_ezbbc['Date format'], $config_item[0]);
}
else { 
        $first_install = true;
}
if ($ezbbc_status == 0) {
        $ezbbc_plugin_status = '<span style="color: red; font-weight: bold;">'.$lang_ezbbc['Plugin disabled'].'</span>';
} else { // Looking first if all is really installed and updated
        $header_file_content = file_get_contents('header.php');
        $viewtopic_file_content = file_get_contents('viewtopic.php');
        $post_file_content = file_get_contents('post.php');
        $edit_file_content = file_get_contents('edit.php');
        $parser_file_content = file_get_contents('include/parser.php');
        // Modifying included code if old version uppdate (version < 1.2.1)
        if (strpos($header_file_content, "PUN_ROOT.'plugins/ezbbc/") !== false) {
                $header_file_content = str_replace("PUN_ROOT.'plugins/ezbbc/", "'plugins/ezbbc/", $header_file_content);
                $fp = fopen ('header.php', 'wb');
	        fwrite ($fp, $header_file_content);
	        fclose ($fp);
	}
	if (strpos($viewtopic_file_content, "PUN_ROOT.'plugins/ezbbc/") !== false) {
                $viewtopic_file_content = str_replace("PUN_ROOT.'plugins/ezbbc/", "'plugins/ezbbc/", $viewtopic_file_content);
                $fp = fopen ('viewtopic.php', 'wb');
	        fwrite ($fp, $viewtopic_file_content);
	        fclose ($fp);
	}
        if (strpos($post_file_content, "PUN_ROOT.'plugins/ezbbc/") !== false) {
                $post_file_content = str_replace("PUN_ROOT.'plugins/ezbbc/", "'plugins/ezbbc/", $post_file_content);
                $fp = fopen ('post.php', 'wb');
	        fwrite ($fp, $post_file_content);
	        fclose ($fp);
	}
        if (strpos($edit_file_content, "PUN_ROOT.'plugins/ezbbc/") !== false) {
                $edit_file_content = str_replace("PUN_ROOT.'plugins/ezbbc/", "'plugins/ezbbc/", $edit_file_content);
                $fp = fopen ('edit.php', 'wb');
	        fwrite ($fp, $edit_file_content);
	        fclose ($fp);
	}
        if (strpos($parser_file_content, "PUN_ROOT.'plugins/ezbbc/") !== false) {
                $parser_file_content = str_replace("PUN_ROOT.'plugins/ezbbc/", "'./plugins/ezbbc/", $parser_file_content);
                $fp = fopen ('include/parser.php', 'wb');
	        fwrite ($fp, $parser_file_content);
	        fclose ($fp);
	}
        // looking if the right code is in all modified files
	if (strpos($header_file_content, "<?php require 'plugins/ezbbc/ezbbc_head.php'; ?>") === false || strpos($viewtopic_file_content, "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>") === false || strpos($post_file_content, "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>") === false || strpos($edit_file_content, "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>") === false || strpos($parser_file_content, "require './plugins/ezbbc/ezbbc_smilies1.php';") === false || strpos($parser_file_content, "require './plugins/ezbbc/ezbbc_smilies2.php';") === false) {
	        $ezbbc_plugin_status = '<span style="color: orange; font-weight: bold;">'.$lang_ezbbc['Plugin wrong installation'].'</span>';
	}
	else {
	        $ezbbc_plugin_status = '<span style="color: green; font-weight: bold;">'.$lang_ezbbc['Plugin in action'].'</span>';
	}
}

/* If the change style button was clicked */
/* ************************************** */
if (isset($_POST['style_change'])) {
                $new_style = $_POST['ezbbc_style'];
                $new_smilies_set = $_POST['ezbbc_smilies_set'];
                $ezbbc_style_folder = $new_style;
                $ezbbc_smilies_set = $new_smilies_set;
                // Changing config data
                $config_content = trim(file_get_contents('plugins/ezbbc/config.php'));
                $config_item = explode(";", $config_content);
                $ezbbc_install = $config_item[0];
                $ezbbc_status = $config_item[1];
                $config_new_content = $ezbbc_install.';'.$ezbbc_status.';'.$new_style.';'.$new_smilies_set;
                $fp = fopen('plugins/ezbbc/config.php', 'wb');
                fwrite($fp, $config_new_content);
                fclose($fp);
                // Message to display
                 $ezbbc_style_changed = '<span style="color: green;">'.$lang_ezbbc['Style changed'].'</span>';
}               

/* If the install button was clicked or the plugin was newly installed */
/* ******************************************************************* */
if (isset($_POST['enable']) || $first_install){
/* First looking if the files are writable */
if (is_writable('header.php') && is_writable('post.php') && is_writable('edit.php') && is_writable('viewtopic.php') && is_writable('include/parser.php') && is_writable('plugins/ezbbc/config.php')):
        /* Getting the content of the header.php file */
	$file_content = file_get_contents('header.php');
	if (strpos($file_content, "<?php require 'plugins/ezbbc/ezbbc_head.php'; ?>") === false) {
	        //Inserting the EZBBC code by replacing an existing line
	        $search = '<link rel="stylesheet" type="text/css" href="style/<?php echo $pun_user[\'style\'].\'.css\' ?>" />';
	        $insert = "<?php require 'plugins/ezbbc/ezbbc_head.php'; ?>";
	        $replacement = $search."\n".$insert;
	        $file_content = str_replace ($search, $replacement, $file_content);
	        $fp = fopen ('header.php', 'wb');
	        fwrite ($fp, $file_content);
	        fclose ($fp);
	}
	
	/* Getting the content of the post.php file */
	$file_content = file_get_contents('./post.php');
	if (strpos($file_content, "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>") === false) {
	        //Inserting the EZBBC code by replacing an existing line
	        $search = '<label class="required"><strong><?php echo $lang_common[\'Message\'] ?> <span><?php echo $lang_common[\'Required\'] ?></span></strong><br />';
	        $insert = "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>";
	        $replacement = $search."\n".$insert;
	        $file_content = str_replace ($search, $replacement, $file_content);
	        $fp = fopen ('post.php', 'wb');
	        fwrite ($fp, $file_content);
	        fclose ($fp);
	}
	
	/* Getting the content of the edit.php file */
	$file_content = file_get_contents('./edit.php');
	if (strpos($file_content, "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>") === false) {
	        //Inserting the EZBBC code by replacing an existing line
	        $search = '<textarea name="req_message" rows="20" cols="95" tabindex="<?php echo $cur_index++ ?>"><?php echo pun_htmlspecialchars(isset($_POST[\'req_message\']) ? $message : $cur_post[\'message\']) ?></textarea>';
	        $insert = "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>";
	        $replacement = $insert."\n".$search;
	        $file_content = str_replace ($search, $replacement, $file_content);
	        $fp = fopen ('edit.php', 'wb');
	        fwrite ($fp, $file_content);
	        fclose ($fp);
	}
	
	/* Getting the content of the viewtopic.php file */
	$file_content = file_get_contents('./viewtopic.php');
	if (strpos($file_content, "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>") === false) {
	        //Inserting the EZBBC code by replacing an existing line
	        $search = '<textarea name="req_message" rows="7" cols="75" tabindex="1"></textarea>';
	        $insert = "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>";
	        $replacement = $insert."\n".$search;
	        $file_content = str_replace ($search, $replacement, $file_content);
	        $fp = fopen ('viewtopic.php', 'wb');
	        fwrite ($fp, $file_content);
	        fclose ($fp);
	}
	
	/* Getting the content of the include/parser.php file */ 
	$file_content = file_get_contents('./include/parser.php');  
	if (strpos($file_content, "require './plugins/ezbbc/ezbbc_smilies1.php';") === false || strpos($file_content, "require './plugins/ezbbc/ezbbc_smilies2.php';") === false) {  
	        //Inserting the EZBBC code by replacing several existing lines  
                $search=array('~\$smilies\s*=\s*array\(.*?\);~si','~\$text.*/img/smilies/.*\$text\);~');  
                $replacement=array("require './plugins/ezbbc/ezbbc_smilies1.php';", "require './plugins/ezbbc/ezbbc_smilies2.php';");  
                $file_content = preg_replace ($search, $replacement, $file_content);  
                $fp = fopen ('include/parser.php', 'wb');  
                fwrite ($fp, $file_content);  
                fclose ($fp);                    
        }
        
        /* Updating config and display datas */
        if ($first_install) {
                $ezbbc_install = time();
                $ezbbc_install_date = date($lang_ezbbc['Date format'], $ezbbc_install);
        }
        
	// Adding new data to config file
        $config_new_content = $ezbbc_install.';1;'.$ezbbc_style_folder.';'.$ezbbc_smilies_set;
        $fp = fopen('plugins/ezbbc/config.php', 'wb');
	fwrite($fp, $config_new_content);
	fclose($fp);
	// New status message
	$ezbbc_plugin_status = '<span style="color: green; font-weight: bold;">'.$lang_ezbbc['Plugin in action'].'</span>';
else:
        $ezbbc_plugin_status = '<span style="color: red; font-weight: bold;">'.$lang_ezbbc['Not writable'].'</span>';
endif;
}

/* If the remove button was clicked */
/* ******************************** */
if (isset($_POST['disable'])){
/* First looking if the files are writable */
if (is_writable('header.php') && is_writable('post.php') && is_writable('edit.php') && is_writable('viewtopic.php') && is_writable('include/parser.php') && is_writable('plugins/ezbbc/config.php')):	
        /* Getting the content of the header.php file */
	$file_content = file_get_contents('header.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = "\n<?php require 'plugins/ezbbc/ezbbc_head.php'; ?>";
	$replacement = '';
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen ('header.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	/* Getting the content of the post.php file */
	$file_content = file_get_contents('./post.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>\n";
	$replacement = '';
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen ('post.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	/* Getting the content of the edit.php file */
	$file_content = file_get_contents('./edit.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>\n";
	$replacement = '';
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen ('edit.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	/* Getting the content of the viewtopic.php file */
	$file_content = file_get_contents('./viewtopic.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = "<?php require 'plugins/ezbbc/ezbbc_toolbar.php'; ?>\n";
	$replacement = '';
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen ('viewtopic.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	/* Getting the content of the include/parser.php file */
	$file_content = file_get_contents('./include/parser.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = array("require './plugins/ezbbc/ezbbc_smilies1.php';","require './plugins/ezbbc/ezbbc_smilies2.php';");
	$replacement = array("\$smilies = array(
	':)' => 'smile.png',
	'=)' => 'smile.png',
	':|' => 'neutral.png',
	'=|' => 'neutral.png',
	':(' => 'sad.png',
	'=(' => 'sad.png',
	':D' => 'big_smile.png',
	'=D' => 'big_smile.png',
	':o' => 'yikes.png',
	':O' => 'yikes.png',
	';)' => 'wink.png',
	':/' => 'hmm.png',
	':P' => 'tongue.png',
	':p' => 'tongue.png',
	':lol:' => 'lol.png',
	':mad:' => 'mad.png',
	':rolleyes:' => 'roll.png',
	':cool:' => 'cool.png');",
	'$text = preg_replace("#(?<=[>\s])".preg_quote($smiley_text, \'#\')."(?=\W)#m", \'<img src="\'.$pun_config[\'o_base_url\'].\'/img/smilies/\'.$smiley_img.\'" width="15" height="15" alt="\'.substr($smiley_img, 0, strrpos($smiley_img, \'.\')).\'" />\', $text);');
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen ('include/parser.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	 // Adding new data to config file
        $config_new_content = $ezbbc_install.';0;'.$ezbbc_style_folder.';'.$ezbbc_smilies_set;
        $fp = fopen('plugins/ezbbc/config.php', 'wb');
	fwrite($fp, $config_new_content);
	fclose($fp);
	// New status message
	$ezbbc_plugin_status = '<span style="color: red; font-weight: bold;">'.$lang_ezbbc['Plugin disabled'].'</span>';
else:
        $ezbbc_plugin_status = '<span style="color: red; font-weight: bold;">'.$lang_ezbbc['Not writable'].'</span>';
endif;	
}

/* Display the admin navigation menu */
/* ********************************* */
	generate_admin_menu($plugin);

/* Display the EZBBC Tolbar admin page */
/* ************************************** */
?>
	<div id="ezbbc" class="plugin blockform">
		<h2><span><?php echo $lang_ezbbc['Plugin title'] ?></span></h2>
		<h3><span><?php echo $lang_ezbbc['Description title'] ?></span></h3>
		<div class="box">
		<?php //Retrieving language file folder
		$ezbbc_lang_folder = file_exists ('plugins/ezbbc/lang/'.$ezbbc_language_folder.'/help.php') ? $ezbbc_language_folder : 'English';
		$help_file_path = 'plugins/ezbbc/lang/'.$ezbbc_lang_folder.'/help.php';
		?>
		<p>
		<?php echo ($lang_ezbbc['Explanation']) ?><br />
		<img src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/help.png" alt="<?php echo $lang_ezbbc['Toolbar help'] ?>" /> <a class="toolbar_help" href="<?php echo $help_file_path ?>" title="<?php echo $lang_ezbbc['Toolbar help'] ?>" onclick="window.open(this.href, 'Toolbar_help', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=yes, location=no, resizable=yes, scrollbars=yes, status=no'); return false;"><?php echo $lang_ezbbc['Toolbar help'] ?></a>
		</p>
		</div>

		<h3><span><?php echo $lang_ezbbc['Form title'] ?></span></h3>
		<div class="box">
			<form id="ezbbcform" method="post" action="<?php echo pun_htmlspecialchars($_SERVER['REQUEST_URI']) ?>#ezbbcform">
				<div class="inform">
				        
					<fieldset>
						<legend><?php echo $lang_ezbbc['Legend status'] ?></legend>
						<div class="infldset">
						<ul>
						        <li><?php echo $lang_ezbbc['Plugin version'].' '.$plugin_version ?></li>
							<li><?php echo $lang_ezbbc['Installation date'] ?> <?php echo $ezbbc_install_date ?></li>
							<li><?php echo $lang_ezbbc['Available languages'] ?> 
							<?php //retrieving the language folder name and flags
							$lang_folders = opendir('plugins/ezbbc/lang');
							while(false !== ($lang_folder = readdir($lang_folders))) {
							        if ($lang_folder != '.' && $lang_folder != '..' && is_dir('plugins/ezbbc/lang/'.$lang_folder)) {
							                $lang_flag_path = file_exists('plugins/ezbbc/style/flags/'.strtolower($lang_folder).'.png') ? 'plugins/ezbbc/style/flags/'.strtolower($lang_folder).'.png' : 'plugins/ezbbc/style/flags/no_flag.png';
							                $lang_folder = ($lang_folder == $ezbbc_lang_folder) ? '<strong>'.$lang_folder.'</strong>' : $lang_folder;
							                echo '<img src="'.$lang_flag_path.'" alt="'.$lang_folder.' flag" /> '.$lang_folder.' ';
							        }
							}
							closedir($lang_folders);
							?>
							</li>
							<li><?php echo $lang_ezbbc['Plugin status'] ?> <?php echo $ezbbc_plugin_status ?></li>
						</ul>
						<p><input type="submit" name="enable" value="<?php echo $lang_ezbbc['Enable'] ?>" /><input type="submit" name="disable" value="<?php echo $lang_ezbbc['Disable'] ?>" /></p>
						</div>
					</fieldset>
					
					<fieldset>
						<legend><?php echo $lang_ezbbc['Legend style'] ?></legend>
						<div class="infldset">
						<p>
						 <input type="submit" name="style_change" value="<?php echo $lang_ezbbc['Change style'] ?>" />
						 </p>
						<?php //Displaying the current style
						$smilies_style = ($ezbbc_smilies_set == "ezbbc_smilies") ? $lang_ezbbc['EZBBC smilies'] : $lang_ezbbc['Default smilies'];
						echo '<p style="text-align: center; border: #DDD 1px solid; background: #FFF;">'.$lang_ezbbc['Current style'].' <span style="color: green; font-weight: bold;">'.$ezbbc_style_folder.'</span> ['.$lang_ezbbc['Buttons'].'] - <span style="color: green;font-weight: bold;">'.$smilies_style.'</span></p>';
						?>
						<h4 style="padding-bottom: 0; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Buttons'] ?></h4>
						<?php
						$style_folders = opendir('plugins/ezbbc/style');
						while(false !== ($style_folder = readdir($style_folders))) {
						        if ($style_folder != '.' && $style_folder != '..' && file_exists('plugins/ezbbc/style/'.$style_folder.'/ezbbc.css')) {
								echo '<dl>'."\n";
						                if ($style_folder == $ezbbc_style_folder) {
						                        echo '<dt><input type="radio" value="'.$style_folder.'" name="ezbbc_style" checked="checked" /><strong>'.$style_folder.'</strong></dt>'."\n";
						                } else {
						                        echo '<dt><input type="radio" value="'.$style_folder.'" name="ezbbc_style" /><span style="color: grey;">'.$style_folder.'</span></dt>'."\n";
						                }
						                if (file_exists('plugins/ezbbc/style/'.$style_folder.'/images/preview.png')) {// Preview screenshot available ?
						                        echo '<dd><img src="plugins/ezbbc/style/'.$style_folder.'/images/preview.png" alt="'.$lang_ezbbc['Toolbar preview'].'" style="width: 520px; border: #DDD 1px groove;"/></dd>'."\n";
						                } else {
						                        echo '<dd>'.$lang_ezbbc['No preview'].'</dd>'."\n";
						                }
						                echo '</dl>'."\n";
						        }
						}
						closedir($style_folders);
						?>
						
						<h4 style="padding-bottom: 0; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Smilies'] ?></h4>
						<?php
						// Retrieving the smilies icons and defining the image list for each set
						//Default FluxBB smilies
						$default_smilies_images = '';
						$icons = opendir('img/smilies');
						while(false !== ($icon = readdir($icons))) {
						        if ($icon != '.' && $icon != '..' && substr($icon, -3) == 'png') {
						        $icon_path = 'img/smilies/'.$icon;
						        $default_smilies_images .= '<img src="'.$icon_path.'" alt="'.$lang_ezbbc['Smiley'].'" /> ';
						        }
						}
						closedir($icons);
						//EZBBC smilies
						$ezbbc_smilies_images = '';
						$icons = opendir('plugins/ezbbc/style/smilies');
						while(false !== ($icon = readdir($icons))) {
						        if ($icon != '.' && $icon != '..' && substr($icon, -3) == 'png') {
						                $icon_path = 'plugins/ezbbc/style/smilies/'.$icon;
						                $ezbbc_smilies_images .= '<img src="'.$icon_path.'" alt="'.$lang_ezbbc['Smiley'].'" /> ';
						        }
						}
						closedir($icons);
						//Displaying the two sets
						 if ($ezbbc_smilies_set == "fluxbb_default_smilies") {
						         echo '<dl>'."\n";
                                                         echo '<dt><input type="radio" value="fluxbb_default_smilies" name="ezbbc_smilies_set" checked="checked" /><strong>'.$lang_ezbbc['Default smilies'].'</strong></dt>'."\n";
                                                         echo '<dd>'.$default_smilies_images.'</dd>'."\n";
                                                         echo '<dt><input type="radio" value="ezbbc_smilies" name="ezbbc_smilies_set" /><strong>'.$lang_ezbbc['EZBBC smilies'].'</strong></dt>'."\n";
                                                         echo '<dd>'.$ezbbc_smilies_images.'</dd>'."\n";
                                                         echo '</dl>'."\n";
                                                 } else {
						         echo '<dl>'."\n";
                                                         echo '<dt><input type="radio" value="fluxbb_default_smilies" name="ezbbc_smilies_set"  /><strong>'.$lang_ezbbc['Default smilies'].'</strong></dt>'."\n";
                                                         echo '<dd>'.$default_smilies_images.'</dd>'."\n";
                                                         echo '<dt><input type="radio" value="ezbbc_smilies" name="ezbbc_smilies_set" checked="checked" /><strong>'.$lang_ezbbc['EZBBC smilies'].'</strong></dt>'."\n";
                                                         echo '<dd>'.$ezbbc_smilies_images.'</dd>'."\n";
                                                         echo '</dl>'."\n";
                                                 }
						?>
						<?php //Displaying the current style
						$smilies_style = ($ezbbc_smilies_set == "ezbbc_smilies") ? $lang_ezbbc['EZBBC smilies'] : $lang_ezbbc['Default smilies'];
						echo '<p style="text-align: center; border: #DDD 1px solid; background: #FFF;">'.$lang_ezbbc['Current style'].' <span style="color: green; font-weight: bold;">'.$ezbbc_style_folder.'</span> ['.$lang_ezbbc['Buttons'].'] - <span style="color: green;font-weight: bold;">'.$smilies_style.'</span></p>';
						?>
						 <p>
						 <input type="submit" name="style_change" value="<?php echo $lang_ezbbc['Change style'] ?>" />
						 </p>
						 </div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
<?php

// Note that the script just ends here. The footer will be included by admin_loader.php
