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
 * @version 0.5
 * @date 2010-11-06
 * @author Charlie Merland
 */
class tagManager
{
    // will contain basic tags
    private $basic_tags;
    // will contain more specific tags
    private $specific_tags;
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
        // forums allowed to show specific tags
        $this->specific_forum = array(11);
        // forums to show basic tags
        $this->basic_forum = array(3,5,11,14,20,30);
        // debug
        //echo "<!-- 0/ tags.php : ".$subject." - ".$tag1." - ".$tag2." -->\n";
    
        $this->subject = $subject;
    
        // collect tags used
        $this->tag[1] = $tag1;
        $this->tag[2] = $tag2;
        
        // debug
        //echo "<!-- tags.php : ".$this->subject." - ".$this->tag['types']." - ".$this->tag['tags']." -->\n";

        $this->specific_tags = array("[Achat]" ,
                    "[Acheté]" ,
                    "[Vente]" ,
                    "[Vendu]" ,
                    "[Don]",
                    "[Donné]",
                    "[Troc]",
                    "[Troqué]",
                    "[En cours]");
    
        $this->basic_tags = array(
                    "[Abri]",
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
        // debug
        //echo "<!-- 1/ tags.php : ".$this->subject." - ".$this->tag['types']." - ".$this->tag['tags']." -->\n";
        
        // finding all tags in the subject
        preg_match_all("(\[(.*?)\])",$this->subject,$matches);
        
        // if there's no tags posted, try to get them from the subject
        if($this->tag[1] == "")
            $this->tag[1] = $matches[0][0];
        if($this->tag[2] == null)
            $this->tag[2] = $matches[0][1];
        
        // debug
        //echo "<!-- 2/ tags.php : ".$this->subject." - ".$this->tag[1]." - ".$this->tag[2]." -->\n";

        // Is current forum allowed to use basic tags
        $basic = in_array($this->forum_id,$this->basic_forum);
        // Is current forum allowed to use specific tags
        $spec = in_array($this->forum_id,$this->specific_forum);
        // debug
        //echo "<!-- basic: $basic - spec: $spec -->\n";
        
        if($spec && $basic)
        {
            printf("<select name=\"tag1\">\n");
            $this->generatOptionTags($this->specific_tags,$this->tag[1]);
            printf("</select>\n");
            printf("<select name=\"tag2\">\n");
            $this->generatOptionTags($this->basic_tags,$this->tag[2]);
            printf("</select>\n");
        }
        else if($basic)
        {
            printf("<select name=\"tag2\">\n");
            $this->generatOptionTags($this->basic_tags,$this->tag[1]);
            printf("</select>\n");
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