<?php
/*
Plugin Name: Piwik
Plugin URI: http://www.github.com/interfasys/piwik-yourls
Description: Logs all requests with <a href="http://piwik.org/">Piwik</a>. Tracks IP and custom variables. Includes "Don't Log Bots" from OZH
Version: 1.1
Author: interfaSys s&agrave;rl
Author URI: http://www.interfasys.ch
*/

// No direct call
if (!defined('YOURLS_ABSPATH')) die();

require(__DIR__ . '/vendor/autoload.php');

/**********************
 * ADMIN SECTION
 *********************/

// Once the plugins have been loaded, register ours
yourls_add_action('plugins_loaded', 'itfs_piwik_register_plugin_page');

/**
 * Registers our configuration page with YOURLS
 */
function itfs_piwik_register_plugin_page() {
	// Parameters: page slug, page title, and function that will display the page itself
	yourls_register_plugin_page('itfs_piwik_admin', 'Piwik', 'itfs_piwik_admin_settings');
}

/**
 * Displays the plugin's configuration page
 */
function itfs_piwik_admin_settings() {

	// Check if an update to the configuration was submitted
	if (isset($_POST['piwik_config'])) {
		itfs_piwik_admin_settings_update();
	}

	// Get current configuration from database
	$piwik_config = yourls_get_option('piwik_config');

	$pluginurl = YOURLS_PLUGINURL . '/'.yourls_plugin_basename( dirname(__FILE__) );

	?>
	<link rel="stylesheet" href="<?php echo $pluginurl ?>/themes/default/css/uniform.default.min.css"
		  type="text/css" media="screen" charset="utf-8" xmlns="http://www.w3.org/1999/html"/>
	<link rel="stylesheet" href="<?php echo $pluginurl ?>/css/form.css" type="text/css"
		  media="screen"
		  charset="utf-8"/>
	<script type="text/javascript" src="<?php echo $pluginurl ?>/js/jquery.uniform.min.js"></script>
	<script type='text/javascript' src="<?php echo $pluginurl ?>/js/form.js"></script>
	<div id="piwik">
		<div id="piwik_config">
			<h2>Piwik plugin settings</h2>

			<form method="post" id="piwik_config_form">
				<div class="piwik_config_zone">
					<h3>Basic settings</h3>

					<div>
						<label for="piwik_url">Piwik URL
							<span class="required">*</span></label>
						<input type="text" id="piwik_url"
							   name="piwik_config[piwik_url]"
							   size="40"
							   value="<?php echo $piwik_config[piwik_url] ?>"/>
					</div>
					<div>
						<label for="site_id">Site ID
							<span class="required">*</span></label>
						<input type="text" id="site_id"
							   name="piwik_config[site_id]"
							   size="2"
							   value="<?php echo $piwik_config[site_id] ?>"/>
					</div>
					<div>
						<p class="checkbox_description">You can disable the built-in stats system by ticking the box
							below</p>
						<label for="disable_stats" class="piwik_config_checkbox">Disable built-in stats</label>
						<input type="checkbox" <?php echo($piwik_config[disable_stats] ? 'checked="checked"' : '') ?>
							   id="disable_stats" name="piwik_config[disable_stats]"/>

						<p>
							<small>Clicks will still be counted locally</small>
						</p>
					</div>
					<div>
						<p class="checkbox_description">You can stop tracking visits from bots by ticking the box
							below</p>
						<label for="remove_bots" class="piwik_config_checkbox">Stop tracking bots</label>
						<input type="checkbox" <?php echo($piwik_config[remove_bots] ? 'checked="checked"' : '') ?>
							   id="remove_bots" name="piwik_config[remove_bots]"/>
					</div>
					<p>
						<span class="required">* Required fields</span>
					</p>
				</div>
				<div id='options'>
					<div class="piwik_config_zone">
						<h3><a href="#authentication">Authentication</a></h3>

						<div class='parameter' id='authentication'>
							<p>This is required if you want to be able to track you visitors' IPs<br/>
								This must be an admin token (read/write access)</p>

							<div>
								<label for="token">Auth token</label>
								<input type="text" id="token" name="piwik_config[token]" size="40"
									   value="<?php echo $piwik_config[token] ?>"/>
							</div>
						</div>
					</div>
					<div class="piwik_config_zone">
						<h3><a href="#customVariable">Custom Variable</a></h3>

						<div class='parameter' id='customVariable'>
							<p>You can set an optional <a href="http://piwik.org/docs/custom-variables/"
														  rel="external">custom
									variable</a> if you have the use for it</p>

							<div>
								<label for="customvar_name">Variable name</label>
								<input type="text"
									   id="customvar_name"
									   name="piwik_config[customvar_name]"
									   value="<?php echo $piwik_config[customvar_name] ?>"/>
							</div>
							<div>
								<label for="customvar_value">Variable value</label>
								<input type="text"
									   id="customvar_value"
									   name="piwik_config[customvar_value]"
									   value="<?php echo $piwik_config[customvar_value] ?>"/>
							</div>
							<div>
								<label>Variable scope</label>
								<select name="piwik_config[customvar_scope]">
									<option
										value="visit" <?php echo($piwik_config[customvar_scope] == "visit" ? 'selected="selected"' : '') ?>/>
									visit</option>
									<option
										value="page" <?php echo($piwik_config[customvar_scope] == "page" ? 'selected="selected"' : '') ?>/>
									page</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="piwik_config_submit">
					<input type="submit" value="Save settings"/>
				</div>
			</form>
		</div>
		<div id="piwik_support">
			<h2>Support developpement</h2>

			<p>This plugin was developed by <a href="http://www.interfasys.ch" rel="external">interfaSys</a> and you
				can support its development by making a donation below.</p>

			<p>Even $2 makes a difference by showing your appreciation ;)</p>

			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="9J6VKYC45QG46">
				<input type="image" src="https://www.paypalobjects.com/en_US/CH/i/btn/btn_donateCC_LG.gif" border="0"
					   name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<h2>Project homepage</h2>

			<p>You can find the latest version of the plugin on <a href="https://github.com/interfasys/piwik-yourls"
																   rel="external">GitHub</a>.</p>

			<h3>License</h3>

			<p>Copyright 2012-2015 - interfaSys sàrl - <a href="http://www.interfasys.ch"
													 rel="external">www.interfasys.ch</a><br/><br/>
				Licensed under the GNU Affero General Public License, version 3 (AGPLv3) (the "License"); you may not
				use
				this file except in compliance with the License. You may obtain a copy of the License at<br/><br/>
				<a href="http://www.gnu.org/licenses/agpl-3.0.html"
				   rel="external">http://www.gnu.org/licenses/agpl-3.0.html</a>
			</p>
		</div>
		<div id="reset"></div>
	</div>
	<?php
}

/**
 * Updates the configuration in the YOURLS database
 */
function itfs_piwik_admin_settings_update() {
	//We make sure we've received a configuration update
	if (isset($_POST['piwik_config'])) {
		$piwik_config = [];

		/**
		 * There will be 2 additional modules. One for people who have donated above a certain amount and a professional version
		 */
		if (file_exists(dirname(__FILE__) . '/donations.php')) {
			$piwik_config[SKU] = 'donations';
		} else if (file_exists(dirname(__FILE__) . '/pro.php')) {
			$piwik_config[SKU] = 'pro';
		} else {
			$piwik_config[SKU] = 'free';
		}

		// We sanitize each parameter.
		if (is_array($_POST['piwik_config'])) {
			foreach ($_POST['piwik_config'] as $k => $v) {
				if ($k == 'site_id') {
					$piwik_config[$k] = @intval($v);
				} else if ($k == 'piwik_url') {
					// Site URL must end with a slash. Stolen as-is from wp-piwik
					if (substr($v, -1, 1) != '/' && substr($v, -10, 10) != '/index.php') {
						$v .= '/';
					}
					$piwik_config[$k] = yourls_sanitize_url($v);
				} else {
					$piwik_config[$k] = yourls_sanitize_title($v);
				}
			}

			try {
				yourls_update_option('piwik_config', $piwik_config);
			} catch (Exception $e) {
				$message = "ITFS_PIWIK: Error when trying to save settings. " . $e->getMessage();
				error_log($message, 0);
				yourls_add_notice($message, 'message_error');
				return false;
			}
		}
	}
}

yourls_add_action('admin_init', 'itfs_piwik_admin_messages');

/**
 * Displays an error message in case of missing required variables
 *
 * TODO: Needs more testing
 */
function itfs_piwik_admin_messages() {
	if (!isset($_POST['piwik_config'])) {
		return;
	}
	$error_message = '';
	if (empty($_POST['piwik_config']['piwik_url'])) {
		$error_message .= '<p><label for="piwik_url" class="borderbottom">Piwik URL</label> is a required field.</p>';
	}
	if (empty($_POST['piwik_config']['site_id'])) {
		$error_message .= '<p><label for="site_id" class="borderbottom">Site ID</label> is a required field.</p>';
	}

	if (!empty($error_message)) {
		yourls_add_notice($error_message, 'message_error');
	} else {
		yourls_add_notice('Settings have been saved', 'message_success');
	}
}

yourls_add_filter('table_add_row_action_array', 'itfs_piwik_edit_stats_link');

/**
 * Switches the internal link to stats to the Piwik one
 * @param array $actions
 * @return array
 */
function itfs_piwik_edit_stats_link($actions) {

	// Get current configuration from database
	$piwik_config = yourls_get_option('piwik_config');

	// If we don't log stats locally
	if ($piwik_config[disable_stats]) {

		// If we're not using the free version of the plugin
		if ($piwik_config[SKU] !== "free") {

			// Replace each link with a link to the Piwik installation
			foreach ($actions as $k => &$action) {
				if ($k == "stats") {
					$action['href'] = $piwik_config[piwik_url];
				}
			}
		}
	}

	return $actions;
}

yourls_add_action('load_template_infos', 'itfs_piwik_disable_stats');

/**
 * Disables the stats page and redirects the user to the long URL instead
 * @param array $keyword
 */
function itfs_piwik_disable_stats($keyword) {
	// Get current configuration from database
	$piwik_config = yourls_get_option('piwik_config');

	// We don't display the stats page in the free version if you don't log locally
	if ($piwik_config[disable_stats] && $piwik_config[SKU] === "free") {
		$keyword = $keyword[0];

		// This redirects users to the destination url instead of the stats page
		include(YOURLS_ABSPATH . '/yourls-go.php');
		exit;
	}
}

/**********************
 * TRACKING SECTION
 *********************/

// We hook into the internal logging function
yourls_add_filter('shunt_log_redirect', 'itfs_piwik_log_request');

/**
 * Sends the keyword and destination URL to Piwik
 *
 * @param bool $return The value to return. Defaults to false with doesn't enable the filter
 * @param string $keyword The requested keyword
 * @return bool
 */
function itfs_piwik_log_request($return, $keyword) {

	// Get current configuration from database
	$piwik_config = yourls_get_option('piwik_config');

	// Let's check if the user wants to log bots
	if ($piwik_config[remove_bots]) {
		if (itfs_piwik_is_bot()) {
			return $return;
		}
	}

	// Use this to get the destination
	$destination = yourls_get_keyword_longurl($keyword);

	// Only log a request if we have a destination and the proper Piwik settings
	if ($destination == false) {
		error_log("ITFS_PIWIK: Missing parameters prevented me from logging the request with Piwik", 0);
		error_log("ITFS_PIWIK: Parameters we have: " . $keyword . ', ' . $destination, 0);
		return $return;
	}

	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	//Useful for hosts using one Piwik installation with multiple YOURLS installation
	$domain_landed = $_SERVER['HTTP_HOST'];

	$page_url = $protocol . $domain_landed . "/" . $keyword;

	try {
		$pt = new PiwikTracker($piwik_config[site_id], $piwik_config[piwik_url]);

		// This will be the entry page in Piwik
		$pt->setUrl($page_url);

		// This will fail silently if the token is not valid or if the user doesn't have admin rights
		if (!empty($piwik_config[token])) {
			$pt->setTokenAuth($piwik_config[token]);
		}

		// This shows up in the visitor logs and identify the source of the data
		$pt->setCustomVariable(1, 'App', 'Piwik plugin for YOURLS', 'visit');

		// Some useful variables
		$pt->setCustomVariable(2, 'Domain landed', $domain_landed, 'page');
		$pt->setCustomVariable(3, 'Keyword', $keyword, 'page');

		// User defined custom variable
		if (!empty($piwik_config[customvar_name]) && !empty($piwik_config[customvar_value])) {
			$pt->setCustomVariable(4, $piwik_config[customvar_name], $piwik_config[customvar_value], $piwik_config[customvar_scope]);
		}

		// Track the visit in Piwik
		$title = yourls_get_keyword_title($keyword);
		@$pt->doTrackPageView($title);

		// The destination URL will show up as an outlink
		@$pt->doTrackAction($destination, 'link');

	} catch (Exception $e) {
		error_log("ITFS_PIWIK: Error when trying to log the request with Piwik. " . $e->getMessage(), 0);
		return $return;
	}

	if ($piwik_config[disable_stats]) {
		//error_log("ITFS_PIWIK: NOT logging locally", 0);
		return;
	} else {
		//error_log("ITFS_PIWIK: Logging locally", 0);
		return $return;
	}
}

/**
 * Determines if a visitor is a bot
 * This is an improved version of "Don't Log Bots" from OZH
 * @return bool
 */
function itfs_piwik_is_bot() {
	// Get current User-Agent
	$current = strtolower($_SERVER['HTTP_USER_AGENT']);
	$current_ip = $_SERVER['REMOTE_ADDR'];

	// Array of known bot lowercase strings
	// Example: 'googlebot' will match 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)'
	$bots = [
		// general web bots
		'googlebot', 'yahoo! slurp',
		'dotbot', 'yeti', 'http://help.naver.com/robots/', 'scoutjet',
		'http://yandex.com/bots', 'linkedinbot', 'mj12bot', 'http://www.80legs.com/spider.html',
		'exabot', 'msnbot', 'yacybot', 'www.oneriot.com', 'http://flipboard.com/',
		'baiduspider', 'mxbot', 'bingbot', 'wikiwix-bot', 'voyager', 'http://www.evri.com/evrinid',
		'http://www.videosurf.com/bot.html', 'http://justsignal.com', 'http://labs.topsy.com/butterfly',
		'www.metadatalabs.com/mlbot', 'twingly recon', 'kame-rt', 'urlresolver', 'http://www.twitmunin.com',
		'http://code.google.com/appengine',

		// twitter specific bots
		'http://thinglabs.com', 'js-kit url resolver', 'twitterbot', 'njuicebot', 'postrank.com',
		'tweetmemebot', 'longurl api', 'paperlibot', 'http://postpo.st/crawlers',

		// Facebook
		'facebookexternalhit',

		// URL testers
		'metauri',

		//Undecided
		//      buzzrank.de  Birubot pycurl/7.18.2 may not be a bot
	];

	$bots_ip = [
		'65.52.0.146', '65.52.17.79', '65.52.2.212',
	];


	// Check if the current UA string contains a know bot string
	$is_bot = (str_replace($bots, '', $current) != $current);
	$is_bot_ip = (str_replace($bots_ip, '', $current_ip) != $current_ip);

	$is_bot = $is_bot || $is_bot_ip;

	return $is_bot;
}

/**********************
 * STATS PAGE SECTION
 *********************/

if (file_exists(dirname(__FILE__) . '/donations.php')) {
	require_once dirname(__FILE__) . '/donations.php';
	error_log("ITFS_PIWIK: Loading donations file", 0);
} else if (file_exists(dirname(__FILE__) . '/pro.php')) {
	require_once dirname(__FILE__) . '/pro.php';
}

