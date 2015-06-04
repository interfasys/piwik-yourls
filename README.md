# PIWIK-YOURLS

A [Piwik](http://piwik.org/) plugin for [YOURLS](http://yourls.org)

## Features

* Logs all requests with Piwik
* Tracks IP and custom variables
* Lets you disable local tracking/stats
* Includes "Don't Log Bots" from @ozh


## Requirements

* PHP 5.4
* PiwikTracker.php from your Piwik installation

## Setup

### YOURLS

* Install YOURLS v1.7+
* Pull the files to <yourls_root>/user/plugins/piwik
* Activate the plugin in the admin zone of YOURLS
* Go to the plugin page and fill in the required fields

### Piwik

* Create a test "website" and use that at the beginning until you find the right way to log your hits
* Create or assign an admin auth token to that site
* Visit some of your links
* Check the hits on the "Visitors in real-time" widget

## Modifications

If you're not happy with the way hits are tracked, just change the way the plugin does it by editing:

		// This shows up in the visitor logs and identify the source of the data
		$pt->setCustomVariable(1, 'App', 'Piwik plugin for YOURLS', 'visit');

		// Some useful variables
		$pt->setCustomVariable(2, 'Domain landed', $domain_landed, 'page');
		$pt->setCustomVariable(3, 'Keyword', $keyword, 'page');

		// Track the visit in Piwik
		$title = yourls_get_keyword_title($keyword);
		@$pt->doTrackPageView($title);

		// The destination URL will show up as an outlink
		@$pt->doTrackAction($destination, 'link');

in plugin.php, function "itfs_piwik_log_request"


## Inspiration

 * Piwik plugin thread: https://code.google.com/p/yourls/issues/detail?id=661
 * Google Analytics plugin: http://www.seodenver.com/yourls-analytics/
 * WP-Piwik Wordpress plugin: http://wordpress.org/extend/plugins/wp-piwik/

## License

Copyright 2012-2015 - interfaSys sàrl - www.interfasys.ch

Licensed under the GNU Affero General Public License, version 3 (AGPLv3) (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

`http://www.gnu.org/licenses/agpl-3.0.html`

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.