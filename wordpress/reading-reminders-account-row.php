<?php
/**
 * MarkU Reading Reminders — Account Row v1.0
 * Adds a "Reading reminders" settings row at the top of the My Account page (logged-in readers only).
 * Shows live status: "On · 8:00 PM" or "Off". Tapping it opens /reading-reminders/.
 * Read-only: it only reads marku_push_preferences. Switch off any time in Code Snippets.
 */
if ( ! defined( 'ABSPATH' ) ) { return; }

add_filter( 'the_content', function ( $content ) {
	if ( ! is_user_logged_in() || ! is_page( 'my-account' ) || ! in_the_loop() || ! is_main_query() ) { return $content; }
	$path = untrailingslashit( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ) );
	if ( '/my-account' !== $path ) { return $content; } // main Account screen only, not sub-pages

	$p  = get_user_meta( get_current_user_id(), 'marku_push_preferences', true );
	$on = is_array( $p ) && ! empty( $p['reading_enabled'] );
	$tm = $on ? date_i18n( 'g:i A', strtotime( '2000-01-01 ' . ( $p['reminder_time'] ?? '20:00' ) ) ) : '';
	$status = $on ? 'On · ' . $tm : 'Off';

	ob_start(); ?>
<a class="mk-acc-rr" href="<?php echo esc_url( home_url( '/reading-reminders/' ) ); ?>">
	<span class="mk-acc-rr-ic" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 16V11a6 6 0 0 1 12 0v5l1.5 2h-15z"/><path d="M10 20a2 2 0 0 0 4 0"/></svg></span>
	<span class="mk-acc-rr-tx"><strong>Reading reminders</strong><span>A gentle daily nudge, at your time.</span></span>
	<span class="mk-acc-rr-st<?php echo $on ? ' is-on' : ''; ?>"><?php echo esc_html( $status ); ?></span>
	<svg class="mk-acc-rr-ch" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
</a>
<style>
.mk-acc-rr{display:flex;align-items:center;gap:12px;max-width:640px;margin:0 auto 18px;padding:14px 16px;background:#fff;border:1px solid #d9efec;border-radius:16px;color:#0f2a2e;text-decoration:none;font-family:Montserrat,system-ui,sans-serif;box-shadow:0 6px 18px rgba(14,143,132,.10)}
.mk-acc-rr:active{transform:scale(.99)}
.mk-acc-rr-ic{flex:none;width:40px;height:40px;border-radius:12px;background:#e6f7f5;color:#0e8f84;display:grid;place-items:center}
.mk-acc-rr-tx{flex:1;min-width:0;display:flex;flex-direction:column;gap:2px;font-size:12.5px;line-height:1.4;color:#4b6568}
.mk-acc-rr-tx strong{font-size:15px;color:#0f2a2e}
.mk-acc-rr-st{flex:none;font-size:12.5px;font-weight:600;color:#6b7f82;background:#f1f4f4;border-radius:999px;padding:4px 10px}
.mk-acc-rr-st.is-on{color:#0e8f84;background:#e6f7f5}
.mk-acc-rr-ch{flex:none;color:#9aaeb0}
</style>
<?php
	return ob_get_clean() . $content;
}, 20 );
