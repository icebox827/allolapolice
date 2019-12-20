<?php
defined( 'ABSPATH' ) || exit;

$dummy_status = new The7_Demo_Content_PHPStatus( array(
	'max_execution_time'  => array(
		'value' => '300',
		'type'  => 'seconds',
	),
	'memory_limit'        => array(
		'value' => '256M',
		'type'  => 'bytes',
	),
) );
?>
<div style="display: inline-block">
	<p><?php esc_html_e( 'Import Fail!', 'the7mk2' ); ?></p>

	<?php if ( ! $dummy_status->check_requirements() ) : ?>
		<p><?php esc_html_e( 'Your server configuration does not meet our recommendations. Demo content import may not work correctly. Please apply:', 'the7mk2' ); ?></p>
		<table class="dt-dummy-php-status widefat">
			<thead>
			<tr>
				<th colspan="2" data-export-label="<?php esc_attr_e( 'Server Environment', 'the7mk2' ); ?>">
					<h2><?php esc_html_e( 'Server Environment', 'the7mk2' ); ?></h2>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$strings        = array(
				'max_execution_time'  => __( 'PHP Time Limit', 'the7mk2' ),
				'memory_limit'        => __( 'PHP Memory Limit', 'the7mk2' ),
			);
			$status_report  = $dummy_status->get_ini_entries();
			foreach ( $status_report as $entry_name => $entry ):
				$required_value = '';
				$mark_class = 'yes';
				if ( ! $entry['good'] ) {
					$required_value = '&nbsp;' . sprintf( __( '(%s recommended)', 'the7mk2' ), $entry['required_value'] );
					$mark_class     = 'error';
				}
				?>
				<tr>
					<td data-export-label="<?php echo esc_attr( $strings[ $entry_name ] ); ?>"><?php echo esc_html( $strings[ $entry_name ] ); ?>:</td>
					<td>
						<mark class="<?php echo esc_attr( $mark_class ); ?>"><?php echo esc_html( $entry['value'] . $required_value ); ?></mark>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			<?php esc_html_e( 'How to:', 'the7mk2' ); ?>
			<a href="http://support.dream-theme.com/knowledgebase/allowed-memory-size-error/" target="_blank"><?php esc_html_e( 'tutorials', 'the7mk2' ); ?></a>
		</p>
	<?php endif; ?>
</div>
