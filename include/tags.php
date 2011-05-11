<?php
/**
 * tagManager
 * ----------
 * Implements tags lists to put ahead of post subject
 * --------------------------------------------------
 * License :
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License, version 3 or above.
 *    If you don't know what that means take a look at:
 *       http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @version 0.8
 * @date 2011-03-22
 * @author Charlie Merland
 */
class tagManager
{
    // will contain all tags
    private $tags;
    // will contain the post's subject
    private $subject;
    // will contain the tags used in subject
    private $tag;
    // will contain forum id for specific tags
    private $forum_id;
    // will contain the forum that will show types 
    private $specific_forum;
    // will contain the forum that will show tags 
    private $basic_forum;

    /**
     * Class constructor
     *
     * @param string $subject of the topic
     * @param string $tag1 specific tag, if used
     * @param string $tag2 basic tag, if used
     * @param string $forum_id if of current forum, used to show (or not) specific tags
     */
    public function __construct($subject,$tag1,$tag2,$forum_id)
    {
        // forum containing our post
        $this->forum_id = $forum_id;
        
        // will contain all tag lists
        $this->tags = array();
    
        // topic's subject
        $this->subject = $subject;
    
        // collect tags used
        $this->tag[1] = $tag1;
        $this->tag[2] = $tag2;
        
        /********************************************************************/
        /*                        Add tag lists here                        */
        /********************************************************************/
        $achat_vente = array("[Achat]" ,
                             "[Acheté]" ,
                             "[Annulé]" ,
                             "[Bon plan hors RL]" ,
                             "[Vente]" ,
                             "[Vendu]" ,
                             "[Don]",
                             "[Donné]",
                             "[Troc]",
                             "[Troqué]",
                             "[En cours]");
        
        $tags_basiques = array("[Abri]",
                               "[Alimentation]",
                               "[Autre]",
                               "[Bâtons]",
                               "[Cartographie]",
                               "[Chaussures]",
                               "[Couchage]",
                               "[Couteau]",
                               "[Couture]",
                               "[Electricité]",
                               "[Hamac]",
                               "[Hygiène]",
                               "[Lampe]",
                               "[Liste prévisionnelle]",
                               "[Matelas]",
                               "[Matériaux]",
                               "[Montre]",
                               "[Photo]",
                               "[Popote]",
                               "[Questions multiples]",
                               "[Réchaud]",
                               "[Sac à dos]",
                               "[Sursac]",
                               "[Vêtements]");
        
        $conseils = array("[Récit + liste]");
        
        // main tags list: contains association between forum ids and various tag lists
        $this->tags = array( 7 => $conseils,
							 3 => $tags_basiques,
							 5 => $tags_basiques,
							 20 => $tags_basiques,
							 30 => $tags_basiques,
                             11 => array($achat_vente, $tags_basiques));
        
        // showing lists
        $this->showTagsList();
    }

    /**
     * Cleans given tag to display textonly version
     * Delete [, ] and _
     * 
     * @param string $tag to clean
     * @return cleaned tag
     */

    function clean($tag)
    {
        // backup
        $tag_propre = $tag;
        // cleaning
        $tag_propre = str_replace("[","", $tag_propre);
        $tag_propre = str_replace("]","", $tag_propre);
        $tag_propre = str_replace("_"," ", $tag_propre);
        // returning
        return $tag_propre;
    }

    /**
     * Show tags list.
     * Dirty way due to the way of listing tags, have to double the foreach...
     * Delete [, ] and _
     * To avoid repetitions we clean the subject first, and add the tags again
     * 
     * @param string $subject the post's subject
     * @param string $tag1 the first tag in the subject
     * @param string $tag2 the second tag in the subject
     */
    public function showTagsList()
    {
        // finding all tags in the subject
        preg_match_all("(\[(.*?)\])",$this->subject,$matches);
        
        // if there's no tags posted, try to get them from the subject
        if($this->tag[1] == "")
            $this->tag[1] = $matches[0][0];
        if($this->tag[2] == null)
            $this->tag[2] = $matches[0][1];
        
        // will contain all usable tags
        $list = $this->tags;
        // will contain key: which tag list do we use?
        $cle = $this->forum_id;

        // Is current forum allowed to use basic tags
        $use_tag = in_array($this->forum_id,array_keys($this->tags));
        
        if($use_tag)
        {
            if(is_array($list[$cle]) && count($list[$cle])==2)
            {
                printf("<select name=\"tag1\">\n");
                $this->generatOptionTags($list[$cle][0],$this->tag[1]);
                printf("</select>\n");
                printf("<select name=\"tag2\">\n");
                $this->generatOptionTags($list[$cle][1],$this->tag[2]);
                printf("</select>\n");
                
            }
            else
            {
                printf("<select name=\"tag1\">\n");
                $this->generatOptionTags($list[$cle],$this->tag[1]);
                printf("</select>\n");
            }
        }
    }
    
    /**
     * Generates the <option> list
     * We check each tag in the list for the one used in the subject
     * this one will be the default choice to be displayed.
     * 
     * @param string $list the list of tags to show
     * @param string $test the tag already in use
     */
    private function generatOptionTags($list,$test)
    {
        printf("<option value=\"\">- Choisir un tag -</option>\n");
        print_r($list);
        
        foreach($list as $element)
        {
            // not always needed, depending on character encoding used to edit this file
            // I use UTF8 and need this to avoid getting ugly accent...
            // won't be of any use if you're not using accents, anyway.
            // $element = utf8_decode($element);
            // getting a clean name for display
            $clean_element = $this->clean($element);
            // debug
            //echo "<!-- $test ?= $element -->";
            // printing tag
            printf("<option value=\"".$element."\"");
            // if $element is the tag used in the subject, we put it selected
            if($test == $element && $_POST['preview'] != "Preview")
                printf(" selected=\"selected\"");
            // else, ending
            printf(">".$clean_element."</option>\n");
        }
    }
    
    /**
     * Simple accessaccessor
     * 
     * @param boolean $show_tags do we show the tags in the subject?
     * @return the post's subject, with or without tags, default with.
     */
    public function getSubject($show_tags)
    {
        if($show_tags)
            return $this->subject;
        else if(!$show_tags)
            return $this->subject = trim(preg_replace("(\[(.*?)\])", "$2", $this->subject));
        else
            return $this->subject;
    }
}
?>