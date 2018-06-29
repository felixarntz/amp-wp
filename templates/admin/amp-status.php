<?php
/**
 * AMP status option in the submit meta box.
 *
 * @package AMP
 */

// Check referrer.
if ( ! ( $this instanceof AMP_Post_Meta_Box ) ) {
	return;
}

/**
 * Inherited template vars.
 *
 * @var array  $labels Labels for enabled or disabled.
 * @var string $status Enabled or disabled.
 * @var array  $errors Support errors.
 */
?>
<div class="misc-pub-section misc-amp-status">
	<span class="amp-icon"></span>
	<?php esc_html_e( 'AMP:', 'amp' ); ?>
	<strong class="amp-status-text"><?php echo esc_html( $labels[ $status ] ); ?></strong>
	<a href="#amp_status" class="edit-amp-status hide-if-no-js" role="button">
		<span aria-hidden="true"><?php esc_html_e( 'Edit', 'amp' ); ?></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Edit Status', 'amp' ); ?></span>
	</a>
	<div id="amp-status-select" class="hide-if-js" data-amp-status="<?php echo esc_attr( $status ); ?>">
		<?php if ( empty( $errors ) ) : ?>
			<fieldset>
				<input id="amp-status-enabled" type="radio" name="<?php echo esc_attr( self::STATUS_INPUT_NAME ); ?>" value="<?php echo esc_attr( self::ENABLED_STATUS ); ?>" <?php checked( self::ENABLED_STATUS, $status ); ?>>
				<label for="amp-status-enabled" class="selectit"><?php echo esc_html( $labels['enabled'] ); ?></label>
				<br />
				<input id="amp-status-disabled" type="radio" name="<?php echo esc_attr( self::STATUS_INPUT_NAME ); ?>" value="<?php echo esc_attr( self::DISABLED_STATUS ); ?>" <?php checked( self::DISABLED_STATUS, $status ); ?>>
				<label for="amp-status-disabled" class="selectit"><?php echo esc_html( $labels['disabled'] ); ?></label>
				<br />
				<?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?>
			</fieldset>
		<?php else : ?>
			<div class="inline notice notice-warning notice-alt">
				<p>
					<?php
					$error_messages = array();
					if ( in_array( 'template-unavailable', $errors, true ) ) {
						/* translators: %s is URL to AMP settings screen */
						$error_messages[] = wp_kses_post( sprintf( __( 'There are no <a href="%s">supported templates</a> to display this in AMP.', 'amp' ), esc_url( admin_url( 'admin.php?page=' . AMP_Options_Manager::OPTION_NAME ) ) ) );
					}
					if ( in_array( 'password-protected', $errors, true ) ) {
						$error_messages[] = __( 'AMP cannot be enabled on password protected posts.', 'amp' );
					}
					if ( in_array( 'post-type-support', $errors, true ) ) {
						/* translators: %s is URL to AMP settings screen */
						$error_messages[] = wp_kses_post( sprintf( __( 'AMP cannot be enabled because this <a href="%s">post type does not support it</a>.', 'amp' ), esc_url( admin_url( 'admin.php?page=' . AMP_Options_Manager::OPTION_NAME ) ) ) );
					}
					if ( in_array( 'skip-post', $errors, true ) ) {
						$error_messages[] = __( 'A plugin or theme has disabled AMP support.', 'amp' );
					}
					if ( count( array_diff( $errors, array( 'page-on-front', 'page-for-posts', 'password-protected', 'post-type-support', 'skip-post', 'template-unavailable' ) ) ) > 0 ) {
						$error_messages[] = __( 'Unavailable for an unknown reason.', 'amp' );
					}
					echo implode( ' ', $error_messages ); // WPCS: xss ok.
					?>
				</p>
			</div>
		<?php endif; ?>
		<div class="amp-status-actions">
			<?php if ( empty( $errors ) ) : ?>
				<a href="#amp_status" class="save-amp-status hide-if-no-js button"><?php esc_html_e( 'OK', 'amp' ); ?></a>
			<?php endif; ?>
			<a href="#amp_status" class="cancel-amp-status hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'amp' ); ?></a>
		</div>
	</div>
</div>
