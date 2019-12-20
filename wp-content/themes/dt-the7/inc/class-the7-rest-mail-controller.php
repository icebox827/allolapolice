<?php
/**
 * The7 REST mail controller.
 *
 * @since   7.8.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_REST_Mail_Controller
 */
class The7_REST_Mail_Controller {

	/**
	 * REST route namespace.
	 *
	 * @var string
	 */
	protected $namespace;

	/**
	 * The7 ReCaptcha object.
	 *
	 * @var The7_ReCaptcha
	 */
	protected $captcha;

	/**
	 * The7_REST_Mail_Controller constructor.
	 *
	 * @param string         $namespace REST route namespace.
	 * @param The7_ReCaptcha $captcha The7 ReCaptcha object.
	 */
	public function __construct( $namespace, The7_ReCaptcha $captcha ) {
		$this->namespace = $namespace;
		$this->captcha   = $captcha;
	}

	/**
	 * Register REST routs.
	 */
	public function register_routs() {
		register_rest_route(
			$this->namespace,
			'/send-mail',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'send_mail_endpoint' ),
				'args'     => array(
					'security_token' => array(
						'type' => 'string',
					),
					'send_message'   => array(
						'type'              => 'string',
						'sanitize_callback' => array( $this, 'sanitize_send_message' ),
					),
					'fields'         => array(
						'type'              => 'array',
						'sanitize_callback' => array( $this, 'sanitize_fields' ),
					),
					'gcaptcha_token' => array(
						'type' => 'string',
					),
				),
			)
		);
	}

	/**
	 * Send mail endpoint.
	 *
	 * It provide basic security checks, compose and send an email.
	 *
	 * @param WP_REST_Request $request WP REST request object.
	 *
	 * @return WP_REST_Response
	 */
	public function send_mail_endpoint( WP_REST_Request $request ) {
		if ( $request['security_token'] !== of_get_option( 'contact_form_security_token' ) ) {
			return rest_ensure_response(
				array(
					'success' => false,
					'errors'  => _x(
						'Cannot send email. Try to clear browser cache, reload the page and try again.',
						'contact form feedback',
						'the7mk2'
					),
				)
			);
		}

		if ( $request['send_message'] ) {
			return rest_ensure_response(
				array(
					'success' => false,
					'errors'  => _x( 'Sorry, we suspect that you are bot', 'contact form feedback', 'the7mk2' ),
				)
			);
		}

		if ( $this->captcha->is_active() && ! $this->captcha->validate_token( $request['gcaptcha_token'] ) ) {
			return rest_ensure_response(
				array(
					'success' => false,
					'errors'  => _x( 'Captcha token is invalid, please try again.', 'contact form feedback', 'the7mk2' ),
				)
			);
		}

		$send   = false;
		$errors = '';
		if ( $request['fields'] && ! $errors ) {
			$fields  = $request['fields'];
			$em      = apply_filters( 'dt_core_send_mail-to', $this->get_target_email(), $request->get_params() );
			$em      = sanitize_email( $em );
			$headers = array(
				'From: ' . $fields['name'] . ' <' . $em . '>',
				'Reply-To: ' . $fields['email'],
			);
			$headers = apply_filters( 'dt_core_send_mail-headers', $headers, $fields );

			$fields_titles = $this->get_fields_titles();
			$msg_mail      = '';
			foreach ( $fields as $field => $value ) {
				if ( ! isset( $fields_titles[ $field ] ) ) {
					continue;
				}

				$msg_mail .= $fields_titles[ $field ] . ' ' . stripslashes( $value ) . "\n";
			}
			$msg_mail = wp_kses_post( $msg_mail );
			$msg_mail = apply_filters( 'dt_core_send_mail-msg', $msg_mail, $fields );

			$subject = apply_filters(
				'dt_core_send_mail-subject',
				sprintf(
					// translators: %s: blog name.
					_x( '[Feedback from: %s]', 'mail subject', 'the7mk2' ),
					sanitize_text_field( get_option( 'blogname' ) )
				),
				$fields
			);

			$send = wp_mail(
				$em,
				$subject,
				$msg_mail,
				$headers
			);

			if ( $send ) {
				$errors = $this->get_success_message();
			} else {
				$errors = $this->get_error_message();
			}
		}

		return rest_ensure_response(
			array(
				'success' => $send,
				'errors'  => wp_strip_all_tags( $errors ),
			)
		);
	}

	/**
	 * Sanitize fake message argument.
	 *
	 * @param string $val Fake message value.
	 *
	 * @return string
	 */
	public function sanitize_send_message( $val ) {
		return trim( $val );
	}

	/**
	 * Sanitize posted contact form fields.
	 *
	 * @param array           $fields Posted form fields.
	 * @param WP_REST_Request $request WP REST requerst object.
	 *
	 * @return array
	 */
	public function sanitize_fields( $fields, WP_REST_Request $request ) {
		$fields_titles = $this->get_fields_titles();
		$fields        = (array) apply_filters( 'dt_core_send_mail-sanitize_fields', $fields, $fields_titles );
		$fields        = array_intersect_key( $fields, $fields_titles );

		if ( empty( $fields['email'] ) || ! is_email( $fields['email'] ) ) {
			$fields['email'] = apply_filters( 'dt_core_send_mail-to', $this->get_target_email(), $request->get_params() );
		}

		if ( empty( $fields['name'] ) ) {
			$fields['name'] = get_option( 'blogname' );
		}

		foreach ( $fields as $field => $value ) {
			switch ( $field ) {
				case 'email':
					$fields[ $field ] = sanitize_email( $value );
					break;
				case 'message':
					$fields[ $field ] = esc_html( $value );
					break;
				case 'website':
					$fields[ $field ] = esc_url( $value );
					break;
				default:
					$fields[ $field ] = sanitize_text_field( $value );
			}
		}

		return $fields;
	}

	/**
	 * Return supported contact form fields titles.
	 *
	 * @return array
	 */
	protected function get_fields_titles() {
		return array(
			'name'      => _x( 'Name:', 'mail', 'the7mk2' ),
			'email'     => _x( 'E-mail:', 'mail', 'the7mk2' ),
			'telephone' => _x( 'Telephone:', 'mail', 'the7mk2' ),
			'country'   => _x( 'Country:', 'mail', 'the7mk2' ),
			'city'      => _x( 'City:', 'mail', 'the7mk2' ),
			'company'   => _x( 'Company:', 'mail', 'the7mk2' ),
			'website'   => _x( 'Website:', 'mail', 'the7mk2' ),
			'message'   => _x( 'Message:', 'mail', 'the7mk2' ),
		);
	}

	/**
	 * Return admin email.
	 *
	 * @return string
	 */
	protected function get_target_email() {
		$default_email = of_get_option( 'general-contact_form_send_mail_to', '' );
		if ( $default_email ) {
			return $default_email;
		}

		return get_option( 'admin_email' );
	}

	/**
	 * Return success feedback message.
	 *
	 * @return string
	 */
	protected function get_success_message() {
		$message = of_get_option( 'custom_success_messages', '' );
		if ( ! $message ) {
			$message = _x( 'Your message has been sent.', 'contact form feedback', 'the7mk2' );
		}

		return (string) $message;
	}

	/**
	 * Return error feedback message.
	 *
	 * @return string
	 */
	protected function get_error_message() {
		$message = of_get_option( 'custom_error_messages', '' );
		if ( ! $message ) {
			$message = _x( 'The message has not been sent. Please try again.', 'contact form feedback', 'the7mk2' );
		}

		return (string) $message;
	}
}
