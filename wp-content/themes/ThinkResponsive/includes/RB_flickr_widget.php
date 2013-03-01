<?php
/*
Plugin Name: RenkliBeyaz Flickr
Description: This widgets gets images from Flickr which is a bundle of a Theme on Themeforest.net
Version: 1.0
Author: RenkliBeyaz
Author URI: http://themeforest.net/user/RenkliBeyaz
*/
add_action('widgets_init','RB_Flickr_Register');
function RB_Flickr_Register()
{
	register_widget('RB_Flickr_Widget');
}
class RB_Flickr_Widget extends WP_Widget 
{
	function RB_Flickr_Widget() 
	{
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'RB_Flickr_Widget', 'description' => 'Flickr images' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'rb-flickr' );

		/* Create the widget. */
		$this->WP_Widget( 'rb-flickr', 'RB Flickr Widget', $widget_ops, $control_ops );
	}
	function widget($args, $instance) 
	{
		extract($args, EXTR_SKIP);	
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$user = empty($instance['user']) ? '50226652%40N00' : apply_filters('widget_user', $instance['user']);
		$userType = empty($instance['userType']) ? 'user' : apply_filters('widget_userType', $instance['userType']);
		$count = empty($instance['count']) ? 6 : apply_filters('widget_count', $instance['count']);
		
		if(!empty($title))
		{ 
			echo $before_title . $title . $after_title; 
		}
		echo getFlickr(array('sourceType'=>$userType, 'user'=>$user, 'count'=>$count, 'size'=>'s'));
		echo $after_widget;
	}
	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['user'] = strip_tags($new_instance['user']);
		$instance['userType'] = strip_tags($new_instance['userType']);
		$instance['count'] = strip_tags($new_instance['count']);
		return $instance;
	}
	function form($instance) 
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'user' => '', 'userType' => '', 'count' => ''));
		$title = strip_tags($instance['title']);
		$user = strip_tags($instance['user']);
		$userType = strip_tags($instance['userType']);
		$count = strip_tags($instance['count']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('user'); ?>">User: <input class="widefat" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo $user; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('userType'); ?>">Type: 
			<select class="widefat" id="<?php echo $this->get_field_id('userType'); ?>" name="<?php echo $this->get_field_name('userType'); ?>">
				<option value="user" <?php echo ($userType=='' || $userType=='user')?'selected':''; ?>>User</option>
				<option value="group" <?php echo ($userType=='group')?'selected':''; ?>>Group</option>
			</select>
			</label>
		</p>
		<p><label for="<?php echo $this->get_field_id('count'); ?>">Count of Images: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
		<?php
	}
}
?>