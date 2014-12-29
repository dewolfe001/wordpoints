<?php

/**
 * Base class providing a bootstrap for widgets.
 *
 * @package WordPoints
 * @since 1.9.0
 */

/**
 * WordPoints widget template.
 *
 * This class was introduced to provide a bootstrap for the plugin's widgets. It
 * implements a widget() method that takes care of displaying the widget title and
 * other common widget code, so that the extending classes just need to implement a
 * widget_body() method to display the main contents of the widget. It also provides
 * an API for verifying an instance of the widget's settings for display, and showing
 * errors to appropriate users when there is a problem.
 *
 * @since 1.9.0
 */
abstract class WordPoints_Widget extends WP_Widget {

	/**
	 * Display an error to the user if they have sufficient capabilities.
	 *
	 * If the user doesn't have the capabilities to edit the widget, we don't
	 * do anything.
	 *
	 * @since 1.9.0
	 *
	 * @param WP_Error|string $message The error message to display.
	 */
	public function wordpoints_widget_error( $message, $args ) {

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		if ( is_wp_error( $message ) ) {
			$message = $message->get_error_message();
		}

		echo $args['before_widget']; // XSS OK here, WPCS.

		?>

		<div class="wordpoints-widget-error" style="background-color: #fe7777; color: #fff; padding: 5px; border: 2px solid #f00;">
			<p>
				<?php

				echo wp_kses(
					sprintf(
						esc_html__( 'The &#8220;%1$s&#8221; widget could not be displayed because of an error: %2$s', 'wordpoints' )
						, esc_html( $this->name )
						,  $message
					)
					, 'wordpoints_widget_error'
				);

				?>
			</p>
		</div>

		<?php

		echo $args['after_widget']; // XSs OK here too, WPCS.
	}

	/**
	 * Verify an instance's settings.
	 *
	 * This function is called by the widget() method to verify the settings of an
	 * instance before it is displayed.
	 *
	 * You can override this in your child class, but it's recommended that you
	 * return parent::verify_settings().
	 *
	 * @since 1.9.0
	 *
	 * @param array $instance The settings for an instance.
	 */
	protected function verify_settings( $instance ) {

		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = '';
		}

		return $instance;
	}

	/**
	 * Display the widget.
	 *
	 * @since 1.9.0
	 *
	 * @param array $args     Arguments for widget display.
	 * @param array $instance The settings for this widget instance.
	 */
	public function widget( $args, $instance ) {

		$instance = $this->verify_settings( $instance );

		if ( is_wp_error( $instance ) ) {
			$this->wordpoints_widget_error( $instance, $args );
			return;
		}

		echo $args['before_widget']; // XSS OK here, WPCS.

		/**
		 * The widget's title.
		 *
		 * @since 1.0.0
		 *
		 * @param string $title The widget title.
		 */
		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( ! empty( $title ) ) {

			echo $args['before_title'] . $title . $args['after_title']; // XSS OK, WPCS.
		}

		$widget_slug = $this->widget_options['wordpoints_hook_slug'];

		/**
		 * Before a WordPoints widget.
		 *
		 * @since 1.9.0
		 *
		 * @param array $instance The settings for this widget instance.
		 */
		do_action( "wordpoints_{$widget_slug}_widget_before", $instance );

		$this->widget_body( $instance );

		/**
		 * After a WordPoints widget.
		 *
		 * @since 1.9.0
		 *
		 * @param array $instance The settings for this widget instance.
		 */
		do_action( "wordpoints_{$widget_slug}_widget_after", $instance );

		echo $args['after_widget']; // XSS OK here too, WPCS.
	}

	/**
	 * Display the main body of the widget.
	 *
	 * This function will be called in the widget() method to display the main body
	 * of the widget. That method displays the widget title and before and after
	 * content, this function just needs to display the widget's main contents.
	 *
	 * When implementing this method, you need to define the wordpoints_hook_slug
	 * widget option. (The widget options are an array, including the 'description',
	 * that are passed as the thrid argument when calling parent::__construct()).
	 *
	 * @since 1.9.0
	 *
	 * @param array $instance The settings of the widget instance to display.
	 */
	protected function widget_body( $instance ) {}

}

// EOF