<?php

class Logic {
    
    public static function GetContent()
    {
        echo 'Hello';
    }
    
    public static function GetToDb($limit=5) {
		global $wpdb;
		$query = "SELECT c.comment_author, c.comment_content, c.comment_date, c.comment_ID, p.post_title, p.ID FROM $wpdb->comments c 
        JOIN $wpdb->posts p  ON c.comment_post_ID=p.ID GROUP BY c.comment_date DESC LIMIT $limit";
		$result = $wpdb->get_results($query, ARRAY_A)or die(mysql_error());
        return $result;	
    }
    

    
    
}

