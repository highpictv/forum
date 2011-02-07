<!-- EZBBC Toolbar -->
<?php // Retrieving style folder
$config_content = trim(file_get_contents('plugins/ezbbc/config.php'));
$config_item = explode(";", $config_content);
$ezbbc_style_folder = $config_item[2];
$ezbbc_smilies_set = $config_item[3];
$smilies_path = ($ezbbc_smilies_set == 'fluxbb_default_smilies') ? 'img/smilies/' : 'plugins/ezbbc/style/smilies/'; 
?>
<span id="ezbbctoolbar">
<!-- text style -->
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/bold.png" title="<?php echo $lang_ezbbc['Bold'] ?>" alt="<?php echo $lang_ezbbc['Bold'] ?>" onclick="insertTag('[b]','[/b]','')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/underline.png" title="<?php echo $lang_ezbbc['Underline'] ?>" alt="<?php echo $lang_ezbbc['Underline'] ?>" onclick="insertTag('[u]','[/u]','')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/italic.png" title="<?php echo $lang_ezbbc['Italic'] ?>" alt="<?php echo $lang_ezbbc['Italic'] ?>" onclick="insertTag('[i]','[/i]','')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/strike-through.png" title="<?php echo $lang_ezbbc['Strike-through'] ?>" alt="<?php echo $lang_ezbbc['Strike-through'] ?>" onclick="insertTag('[s]','[/s]','')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/delete.png" title="<?php echo $lang_ezbbc['Delete'] ?>" alt="<?php echo $lang_ezbbc['Delete'] ?>" onclick="insertTag('[del]','[/del]','')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/insert.png" title="<?php echo $lang_ezbbc['Insert'] ?>" alt="<?php echo $lang_ezbbc['Insert'] ?>" onclick="insertTag('[ins]','[/ins]','')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/emphasis.png" title="<?php echo $lang_ezbbc['Emphasis'] ?>" alt="<?php echo $lang_ezbbc['Emphasis'] ?>" onclick="insertTag('[em]','[/em]','')" />
&#160;

<!-- Color and heading -->
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/color.png" title="<?php echo $lang_ezbbc['Colorize'] ?>" alt="<?php echo $lang_ezbbc['Colorize'] ?>" onclick="insertTag('[color]','[/color]','color')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/heading.png" title="<?php echo $lang_ezbbc['Heading'] ?>" alt="<?php echo $lang_ezbbc['Heading'] ?>" onclick="insertTag('[h]','[/h]','heading')" />	
&#160;

<!-- Links and images -->
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/link.png" title="<?php echo $lang_ezbbc['URL'] ?>" alt="<?php echo $lang_ezbbc['URL'] ?>" onclick="insertTag('[url]','[/url]','link')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/email.png" title="<?php echo $lang_ezbbc['E-mail'] ?>" alt="<?php echo $lang_ezbbc['E-mail'] ?>" onclick="insertTag('[email]','[/email]','email')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/image.png" title="<?php echo $lang_ezbbc['Image'] ?>" alt="<?php echo $lang_ezbbc['Image'] ?>" onclick="insertTag('[img]','[/img]','img')" />
&#160;

<!-- Quote and code -->
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/quote.png" title="<?php echo $lang_ezbbc['Quote'] ?>" alt="<?php echo $lang_ezbbc['Quote'] ?>" onclick="insertTag('[quote]\n','\n[/quote]','quote')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/code.png" title="<?php echo $lang_ezbbc['Code'] ?>" alt="<?php echo $lang_ezbbc['Code'] ?>" onclick="insertTag('[code]\n','\n[/code]','code')" />
&#160;

<!-- Lists -->
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/list-unordered.png" title="<?php echo $lang_ezbbc['Unordered List'] ?>" alt="<?php echo $lang_ezbbc['Unordered List'] ?>" onclick="insertTag('[list=*]','[/list]','unorderedlist')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/list-ordered.png" title="<?php echo $lang_ezbbc['Ordered List'] ?>" alt="<?php echo $lang_ezbbc['Ordered List'] ?>" onclick="insertTag('[list=1]','[/list]','orderedlist')" />
<img class="button" src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/list-ordered-alpha.png" title="<?php echo $lang_ezbbc['Alphabetical Ordered List'] ?>" alt="<?php echo $lang_ezbbc['Alphabetical Ordered List'] ?>" onclick="insertTag('[list=a]','[/list]','alphaorderedlist')" />
<!-- Help link -->
<?php //Retrieving language file folder
$ezbbc_lang_folder = file_exists ('plugins/ezbbc/lang/'.$ezbbc_language_folder.'/help.php') ? $ezbbc_language_folder : 'English';
$help_file_path = 'plugins/ezbbc/lang/'.$ezbbc_lang_folder.'/help.php';
?>
<a class="toolbar_help" href="<?php echo $help_file_path ?>" title="<?php echo $lang_ezbbc['Toolbar help'] ?>" onclick="window.open(this.href, 'Toolbar_help', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=yes, location=no, resizable=yes, scrollbars=yes, status=no'); return false;"><img src="plugins/ezbbc/style/<?php echo $ezbbc_style_folder ?>/images/help.png" alt="<?php echo $lang_ezbbc['Toolbar help'] ?>" /></a>
	
<!-- Smileys -->
<br />
<img class="smiley" src="<?php echo $smilies_path ?>smile.png" title=":)" alt=":)" onclick="insertTag(':)','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>neutral.png" title=":|" alt=":|" onclick="insertTag(':|','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>sad.png" title=":(" alt=":(" onclick="insertTag(':(','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>big_smile.png" title=":D" alt=":D" onclick="insertTag(':D','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>yikes.png" title=":o" alt=":o" onclick="insertTag(':o','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>wink.png" title=";)" alt=";)" onclick="insertTag(';)','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>hmm.png" title=":/" alt=":/" onclick="insertTag(':/','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>tongue.png" title=":p" alt=":p" onclick="insertTag(':p','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>lol.png" title=":lol:" alt=":lol:" onclick="insertTag(':lol:','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>mad.png" title=":mad:" alt=":mad:" onclick="insertTag(':mad:','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>roll.png" title=":rolleyes:" alt=":rolleyes:" onclick="insertTag(':rolleyes:','','smiley')" />
<img class="smiley" src="<?php echo $smilies_path ?>cool.png" title=":cool:" alt=":cool:" onclick="insertTag(':cool:','','smiley')" />
<?php
if ($ezbbc_smilies_set == 'ezbbc_smilies'):
?>
      <img class="smiley" src="<?php echo $smilies_path ?>angel.png" title="O:)" alt="O:)" onclick="insertTag('O:)','','smiley')" />
      <img class="smiley" src="<?php echo $smilies_path ?>cry.png" title="8.(" alt="8.(" onclick="insertTag('8.(','','smiley')" />
      <img class="smiley" src="<?php echo $smilies_path ?>devil.png" title="]:D" alt="]:D" onclick="insertTag(']:D','','smiley')" />
      <img class="smiley" src="<?php echo $smilies_path ?>glasses.png" title="8)" alt="8)" onclick="insertTag('8)','','smiley')" />
      <img class="smiley" src="<?php echo $smilies_path ?>kiss.png" title="{)" alt="{)" onclick="insertTag('{)','','smiley')" />
      <img class="smiley" src="<?php echo $smilies_path ?>monkey.png" title="8o" alt="8o" onclick="insertTag('8o','','smiley')" />
      <img class="smiley" src="<?php echo $smilies_path ?>ops.png" title=":8" alt=":8" onclick="insertTag(':8','','smiley')" />
<?php
endif;
?>
<br />
</span>
<!-- EZBBC Toolbar end -->
