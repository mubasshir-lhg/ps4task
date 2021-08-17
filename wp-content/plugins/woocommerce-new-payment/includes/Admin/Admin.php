<?php 

namespace MyApp\Admin;

class Admin {
	private $stripe_setting_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'stripe_setting_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'stripe_setting_page_init' ) );
		
	}

	public function stripe_setting_add_plugin_page() {
		add_menu_page(
			'Stripe Setting', // page_title
			'Stripe Setting', // menu_title
			'manage_options', // capability
			'stripe-setting', // menu_slug
			array( $this, 'stripe_setting_create_admin_page' ), // function
			'dashicons-admin-settings', // icon_url
			2 // position
		);
	}

	public function stripe_setting_create_admin_page() {
		$this->stripe_setting_options = get_option( 'stripe_setting_option_name' ); ?>

		<div class="wrap">
			<h2>Stripe Setting</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'stripe_setting_option_group' );
					do_settings_sections( 'stripe-setting-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function stripe_setting_page_init() {
		register_setting(
			'stripe_setting_option_group', // option_group
			'stripe_setting_option_name', // option_name
			array( $this, 'stripe_setting_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'stripe_setting_setting_section', // id
			'Settings', // title
			array( $this, 'stripe_setting_section_info' ), // callback
			'stripe-setting-admin' // page
		);

		add_settings_field(
			'enabled_0', // id
			'Enabled', // title
			array( $this, 'enabled_0_callback' ), // callback
			'stripe-setting-admin', // page
			'stripe_setting_setting_section' // section
		);

		add_settings_field(
			'payment_type_1', // id
			'Payment Type', // title
			array( $this, 'payment_type_1_callback' ), // callback
			'stripe-setting-admin', // page
			'stripe_setting_setting_section' // section
		);

		add_settings_field(
			'publish_key_2', // id
			'Publish Key', // title
			array( $this, 'publish_key_2_callback' ), // callback
			'stripe-setting-admin', // page
			'stripe_setting_setting_section' // section
		);

		add_settings_field(
			'publish_key_3', // id
			'Stripe Key', // title
			array( $this, 'publish_key_3_callback' ), // callback
			'stripe-setting-admin', // page
			'stripe_setting_setting_section' // section
		);

		add_settings_field(
			'email_4', // id
			'Email', // title
			array( $this, 'email_4_callback' ), // callback
			'stripe-setting-admin', // page
			'stripe_setting_setting_section' // section
		);
	}

	public function stripe_setting_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['enabled_0'] ) ) {
			$sanitary_values['enabled_0'] = $input['enabled_0'];
		}

		if ( isset( $input['payment_type_1'] ) ) {
			$sanitary_values['payment_type_1'] = $input['payment_type_1'];
		}

		if ( isset( $input['publish_key_2'] ) ) {
			$sanitary_values['publish_key_2'] = sanitize_text_field( $input['publish_key_2'] );
		}

		if ( isset( $input['publish_key_3'] ) ) {
			$sanitary_values['publish_key_3'] = sanitize_text_field( $input['publish_key_3'] );
		}

		if ( isset( $input['email_4'] ) ) {
			$sanitary_values['email_4'] = sanitize_text_field( $input['email_4'] );
		}

		return $sanitary_values;
	}

	public function stripe_setting_section_info() {
		
	}

	public function enabled_0_callback() {
		printf(
			'<input type="checkbox" name="stripe_setting_option_name[enabled_0]" id="enabled_0" value="enabled_0" %s>',
			( isset( $this->stripe_setting_options['enabled_0'] ) && $this->stripe_setting_options['enabled_0'] === 'enabled_0' ) ? 'checked' : ''
		);
	}

	public function payment_type_1_callback() {
		?> <fieldset><?php $checked = ( isset( $this->stripe_setting_options['payment_type_1'] ) && $this->stripe_setting_options['payment_type_1'] === 'live' ) ? 'checked' : '' ; ?>
		<label for="payment_type_1-0"><input type="radio" name="stripe_setting_option_name[payment_type_1]" id="payment_type_1-0" value="live" <?php echo $checked; ?>> Live</label><br>
		<?php $checked = ( isset( $this->stripe_setting_options['payment_type_1'] ) && $this->stripe_setting_options['payment_type_1'] === 'sandbox' ) ? 'checked' : '' ; ?>
		<label for="payment_type_1-1"><input type="radio" name="stripe_setting_option_name[payment_type_1]" id="payment_type_1-1" value="sandbox" <?php echo $checked; ?>> Sandbox</label></fieldset> <?php
	}

	public function publish_key_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="stripe_setting_option_name[publish_key_2]" id="publish_key_2" value="%s">',
			isset( $this->stripe_setting_options['publish_key_2'] ) ? esc_attr( $this->stripe_setting_options['publish_key_2']) : ''
		);
	}

	public function publish_key_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="stripe_setting_option_name[publish_key_3]" id="publish_key_3" value="%s">',
			isset( $this->stripe_setting_options['publish_key_3'] ) ? esc_attr( $this->stripe_setting_options['publish_key_3']) : ''
		);
	}

	public function email_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="stripe_setting_option_name[email_4]" id="email_4" value="%s">',
			isset( $this->stripe_setting_options['email_4'] ) ? esc_attr( $this->stripe_setting_options['email_4']) : ''
		);
	}
    public function connect_stripe()
    {
        $stripe_setting_options = get_option( 'stripe_setting_option_name' );
        if($stripe_setting_options['enabled_0']=='enabled_0'){
			try {
				$stripe = new \Stripe\StripeClient( $stripe_setting_options['publish_key_3']);
				$stripe->charges->create([
				"amount" => 2000,
				"currency" => "usd",
				"source" => "tok_amex"
				]);
			  } catch(\Stripe\Exception\ApiErrorException  $e) {
				// echo 'Status is:' . $e->getHttpStatus() . '\n';
				
			}

		}
    }

}
?>