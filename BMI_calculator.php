<?php
/**
 * Plugin Name: Protech BMI calculator
 * Plugin URI: http://protech.mk/widgets
 * Description: A widget which calculate Body Mass Index
 * Version: 1.5
 * Author: Protech
 * Author URI: http://protech.mk/
 *
 */

add_action( 'widgets_init', 'bmi_calc_load_widgets' );

function bmi_calc_load_widgets() {
	register_widget( 'BMI_calculator' );
}

class BMI_calculator extends WP_Widget {

	function BMI_calculator() {
	
		$widget_ops = array( 'classname' => 'bmi_calculator', 'description' => __('A widget which calculate Body Mass Index', 'bmi_calculator') );

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bmi-calculator-widget' );

		$this->WP_Widget( 'bmi-calculator-widget', __('BMI calculator', 'bmi_calculator'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$weight= $instance['weight'];
		$height = $instance['height'];
		$calculate = $instance['calculate'];
		$yourbmi= $instance['yourbmi'];
		$bgr= $instance['bgr'];
		$calculate_again = $instance['calculate_again'];
		$show_logo =  $instance['show_logo'];
		//Messages
		$msg1= $instance['msg_1'];
		$msg2= $instance['msg_2'];
		$msg3= $instance['msg_3'];
		$msg4= $instance['msg_4'];
		$msg5= $instance['msg_5'];
		$msg_err= $instance['msg_err'];
	
		echo $before_widget;
		$bmi_content = '';
			echo $before_title . $title . $after_title;
			echo '<div id="bmi_wrapper" style="background-color:'.$bgr.';color: #464646;text-shadow: white 0 1px 0;padding:10px 0 0 0;"><table border="0" style="border:none!important;border:1px solid #ccc;" width="100%">';
			printf( '<tr><td style="border:none;"><label for="bmi_weight">' . __('%1$s', 'bmi_calculator') . ':</label></td><td style="border:none;"><input style="width:180px;padding:5px;" type="text" name="bmi_weight" id="bmi_weight" /></td></tr>', $weight);
			printf( '<tr><td style="border:none;"><label for="bmi_height">' . __('%1$s', 'bmi_calculator') . ':</label></td><td style="border:none;"><input style="width:180px;padding:5px;" type="text" name="bmi_height" id="bmi_height" /></td></tr>', $height );
			printf( '<tr style="border:none;"><td colspan="2" style="border:none;height:3px;padding:0px;">&nbsp;</td></tr><tr><td style="border-top:1px solid #ccc;border-bottom:none;border-left:none;border-right:none;">');
			if($show_logo == 'yes')
			echo '<a href="http://protech.mk" target="_blank"><img src="http://protech.mk/images/widget_logo.png" width="65" alt="protech" /></a>';
			printf( '</td><td style="border-top:1px solid #ccc;border-bottom:none;border-left:none;border-right:none;text-align:right;" align="right"><button onclick="calc_bmi()" name="bmi_calculate" id="bmi_calculate" style="padding:3px;background-image:-webkit-linear-gradient(top,#f2f2f2,#d2d2d2);background-image:-moz-linear-gradient(top,#f2f2f2,#d2d2d2);background-image:-ms-linear-gradient(top,#f2f2f2,#d2d2d2);background-image:-o-linear-gradient(top,#f2f2f2,#d2d2d2);background-image:linear-gradient(top,#f2f2f2,#d2d2d2);background-color:#f2f2f2;color:#333333;cursor:pointer;font-weight:normal;text-shadow:rgba(0,0,0,0.1) 0 0 1px;background-image:linear-gradient(top,#f2f2f2,#d2d2d2);border:1px solid #cccccc;-moz-border-radius:5px;border-radius:5px;-webkit-border-radius:5px">' . __('%1$s', 'bmi_calculator') . '</button></td></tr>', $calculate );
			echo '</table></div>';
			?>
<script type="text/javascript">
var bmi_default_wrapper = document.getElementById('bmi_wrapper').innerHTML;
function reset_calc()
{
	document.getElementById('bmi_wrapper').innerHTML = bmi_default_wrapper;
}
function calc_bmi()
{
var bmi_wrapper = document.getElementById('bmi_wrapper');
var weight = document.getElementById('bmi_weight').value;
var height = document.getElementById('bmi_height').value/100;
var bmi = (weight/(height*height));
var msg = '';
if(bmi < 16)
{
msg = '<?php printf( __('%1$s', 'bmi_calculator'),$msg1); ?>';
}else if(bmi > 16 && bmi < 18.5)
{
msg = '<?php printf( __('%1$s', 'bmi_calculator'),$msg2); ?>';
}else if(bmi > 18.5 && bmi < 25)
{
msg = '<?php printf( __('%1$s', 'bmi_calculator'),$msg3); ?>';
}else if(bmi > 25 && bmi < 30)
{
msg = '<?php printf( __('%1$s', 'bmi_calculator'),$msg4); ?>';
}else{
msg = '<?php printf( __('%1$s', 'bmi_calculator'),$msg5); ?>';
}
if(height!=null && height>0 && weight!=null && weight>0)
{
	bmi_wrapper.innerHTML = '<p><?php printf( __('%1$s', 'bmi_calculator'),$yourbmi); ?>: <b>'+bmi.toFixed(2)+'</b></p><p style="font-size:1.2em;"><b>'+msg+'</b></p><p style="text-align:right;border-top:1px solid #CCC;padding:5px 0;"><a href="javascript:void(0);" onclick="reset_calc()"><?php printf(  __('%1$s', 'bmi_calculator') ,$calculate_again);  ?></a>&nbsp;&nbsp;</p>';
}else
{
alert('<?php printf( __('%1$s', 'bmi_calculator'),$msg_err); ?>');
}
}
</script>
			<?
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['weight'] = strip_tags( $new_instance['weight'] );
		$instance['height'] = $new_instance['height'];
		$instance['bgr'] = $new_instance['bgr'];
		
		$instance['calculate'] = $new_instance['calculate'];
		$instance['calculate_again'] = $new_instance['calculate_again'];
		$instance['yourbmi'] = $new_instance['yourbmi'];

		$instance['msg_1'] = $new_instance['msg_1']; //Severely underweight	
		$instance['msg_2'] = $new_instance['msg_2']; //Underweight
		$instance['msg_3'] = $new_instance['msg_3']; //Normal
		$instance['msg_4'] = $new_instance['msg_4']; //Overweight
		$instance['msg_5'] = $new_instance['msg_5']; //Severely overweight

		$instance['msg_err'] = $new_instance['msg_err']; //Error alert
		$instance['show_logo'] = $new_instance['show_logo'];
		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('BMI Calculator', 'bmi_calculator'), 'weight' => 'Weight', 'height' => 'Height', 'calculate' => 'Calculate', 'calculate_again' => 'Calculate again', 'msg_1' => 'Severely underweight', 'msg_2' => 'Underweight', 'msg_3' => 'Normal', 'msg_4' => 'Overweight', 'msg_5' => 'Severely overweight', 'yourbmi' => 'Your BMI is', 'msg_err' => 'Please enter valid data!', 'bgr' => '#eeeff4', 'show_logo' => 'Yes' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'bgr' ); ?>"><?php _e('Background color:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'bgr' ); ?>" name="<?php echo $this->get_field_name( 'bgr' ); ?>" value="<?php echo $instance['bgr']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'weight' ); ?>"><?php _e('Weight:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'weight' ); ?>" name="<?php echo $this->get_field_name( 'weight' ); ?>" value="<?php echo $instance['weight']; ?>" style="width:100%;" />
		</p>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" style="width:100%;" />
		</p>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'calculate' ); ?>"><?php _e('Calculate:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'calculate' ); ?>" name="<?php echo $this->get_field_name( 'calculate' ); ?>" value="<?php echo $instance['calculate']; ?>" style="width:100%;" />
		</p> 

		<p>
			<label for="<?php echo $this->get_field_id( 'calculate_again' ); ?>"><?php _e('Calculate again:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'calculate_again' ); ?>" name="<?php echo $this->get_field_name( 'calculate_again' ); ?>" value="<?php echo $instance['calculate_again']; ?>" style="width:100%;" />
		</p>   
		<p>
			<label for="<?php echo $this->get_field_id( 'yourbmi' ); ?>"><?php _e('Your BMI is:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'yourbmi' ); ?>" name="<?php echo $this->get_field_name( 'yourbmi' ); ?>" value="<?php echo $instance['yourbmi']; ?>" style="width:100%;" />
		</p>
	<p style="border-bottom:1px solid #ccc;">Messages</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'msg_err' ); ?>"><?php _e('Please enter valid data:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'msg_err' ); ?>" name="<?php echo $this->get_field_name( 'msg_err' ); ?>" value="<?php echo $instance['msg_err']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'msg_1' ); ?>"><?php _e('Severely underweight:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'msg_1' ); ?>" name="<?php echo $this->get_field_name( 'msg_1' ); ?>" value="<?php echo $instance['msg_1']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'msg_2' ); ?>"><?php _e('Underweight:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'msg_2' ); ?>" name="<?php echo $this->get_field_name( 'msg_2' ); ?>" value="<?php echo $instance['msg_2']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'msg_3' ); ?>"><?php _e('Normal:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'msg_3' ); ?>" name="<?php echo $this->get_field_name( 'msg_3' ); ?>" value="<?php echo $instance['msg_3']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'msg_4' ); ?>"><?php _e('Overweight:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'msg_4' ); ?>" name="<?php echo $this->get_field_name( 'msg_4' ); ?>" value="<?php echo $instance['msg_4']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'msg_5' ); ?>"><?php _e('Severely overweight:', 'bmi_calculator'); ?></label>
			<input id="<?php echo $this->get_field_id( 'msg_5' ); ?>" name="<?php echo $this->get_field_name( 'msg_5' ); ?>" value="<?php echo $instance['msg_5']; ?>" style="width:100%;" />
		</p>
<p>
			<label for="<?php echo $this->get_field_id( 'show_logo' ); ?>">Show developer logo:</label>
			<select id="<?php echo $this->get_field_id( 'show_logo' ); ?>" name="<?php echo $this->get_field_name( 'show_logo' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'yes' == $instance['show_logo'] ) echo 'selected="selected"'; ?> value="yes">yes</option>
				<option <?php if ( 'no' == $instance['show_logo'] ) echo 'selected="selected"'; ?> value="no">no</option>
			</select>
		</p>
	<?php
	}
}

?>