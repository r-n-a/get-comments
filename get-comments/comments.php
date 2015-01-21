<?php

class Get_comments extends WP_Widget {
	
	public $name = 'Get Comments';
	public $widget_desc = 'Get list of separeyted comment';
	public $control_options = array();
	
	static function register_this_widget()
	{
		register_widget(__CLASS__);
	}
    
	function __construct() {
        $widget_options = array(
			'classname' => __CLASS__,
			'description' => $this->widget_desc,
			);
		parent::__construct( __CLASS__, $this->name, $widget_options, $this->control_options);
    } 
 
    function widget($args, $instance) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        if(!get_option('get_c'))
        add_option('get_c', 5);
        $limit = get_option('get_c');
        $result = Logic::GetToDb($limit);
        $count = count($result);
        for($i=0; $i<$count; $i++)
        {
            $cutComment = $result[$i]['comment_content'];
            $cutPost = $result[$i]['post_title'];
            if(strlen($cutComment)>50)
            $cutComment = ltrim(mb_substr($cutComment, 0, 50)).'...';
            if(strlen($cutPost)>30)
             $cutPost = ltrim(mb_substr($cutPost, 0, 30)).'...';
            $postUrl = '<a href="'.get_site_url().'/?p='.$result[$i]['ID'].'" >'.$cutPost.'</a>';
            $commUrl = '<a href="'.get_site_url().'/?p='.$result[$i]['ID'].'#comment-'.$result[$i]['comment_ID'].'" >'.$cutComment.'</a>';
             echo $result[$i]['comment_author'].' ('.$result[$i]['comment_date'].') <br/>'.
                 $postUrl.'<br/> >>'.
                 $commUrl.'<br/><br/>';
        }
        echo $args['after_widget'];   
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
 
    function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wpb_widget_domain' );
            
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
	   }
    }   
    static function admin_this_widget() {
       add_options_page('Get comments', 'Get comments', 'edit_pages', basename(__FILE__), 'get_comments_form');
    }

}

function get_comments_form() {
        ?>
        <div class="wrap">
        <h2>Get comments</h2>
        <form method="post" action="">
        <h3>Enter number of comments</h3>
        <input type="text" name="get_count" value="<?php echo get_option('get_c') ?>" /><br/><br/>
	    <input type="submit" name="update" value="Save" />
        </form>
        </div>  
<?php 
        if(isset($_POST['get_count']))  
        {
            update_option('get_c', $_POST['get_count']);
        }
    }
