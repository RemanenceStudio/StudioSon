<?php
/*
Plugin Name: RenkliBeyaz Twitter
Description: This wiget bundle of a Theme on Themeforest.net
Version: 1.0
Author: RenkliBeyaz
Author URI: http://themeforest.net/user/RenkliBeyaz
*/
add_action('widgets_init','RB_Twitter_Register');
function RB_Twitter_Register()
{
	register_widget('RB_Twitter_Widget');
}
class RB_Twitter_Widget extends WP_Widget 
{
	function RB_Twitter_Widget() 
	{
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'RB_Twitter_Widget', 'description' => 'Last tweets from Twitter' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'rb-twitter' );

		/* Create the widget. */
		$this->WP_Widget( 'rb-twitter', 'RB Twitter Widget', $widget_ops, $control_ops );
	}
	function widget($args, $instance) 
	{
		extract($args, EXTR_SKIP);	
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$username = empty($instance['username']) ? ' ' : apply_filters('widget_username', $instance['username']);
		$number = empty($instance['number']) ? ' ' : apply_filters('widget_number', $instance['number']);
		if(!empty($title))
		{ 
			echo $before_title . $title . $after_title; 
		}
		if(get_option('twTime')=='')
		{
			$content = getTweets($username, $number);
			update_option('twContent', $content);
			update_option('twTime', time());
		}else{
			$time = get_option('twTime');
			if(($time+(60*30))>time())
			//if(false)
			{
				$content = get_option('twContent');
			}
			else
			{
				$content = getTweets($username, $number);
				update_option('twContent', $content);
				update_option('twTime', time());
			}
		}
		
		$re = '';
		$re .= preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a    href=\"\\2\" target=\"_blank\">\\2</a>", $content);
		//$re .= $content;
		echo do_shortcode($re); 
		echo $after_widget;
	}
	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}
	function form($instance) 
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'username' => '', 'number' => '' ) );
		$title = strip_tags($instance['title']);
		$username = strip_tags($instance['username']);
		$number = strip_tags($instance['number']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('username'); ?>">Username: <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>">Number of Tweets: <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label></p>
		<?php
	}
}
?>