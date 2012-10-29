# PIWIK-YOURLS

A [Piwik](http://piwik.org/) plugin for [YOURLS](http://yourls.org)

## Features

* Logs all requests with Piwik
* Tracks IP and custom variables
* Lets you disable local tracking/stats
* Includes "Don't Log Bots" from OZH


## Requirements

* PHP 5.3
* PiwikTracker.php from your Piwik installation

## Use

* Pull the files to <yourls_root>/user/plugins/piwik
* Place PiwikTracker.php into the <yourls_root>/user/plugins/piwik/libs/Piwik folder
* Activate the plugin in the admin zone of YOURLS
* Go to the plugin page and fill in the required fields

## Inspiration

 * Piwik plugin thread: https://code.google.com/p/yourls/issues/detail?id=661
 * Google Analytics plugin: http://www.seodenver.com/yourls-analytics/
 * WP-Piwik Wordpress plugin: http://wordpress.org/extend/plugins/wp-piwik/

## License

Copyright 2012 - interfaSys sàrl - www.interfasys.ch

Licensed under the GNU Affero General Public License, version 3 (AGPLv3) (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

`http://www.gnu.org/licenses/agpl-3.0.html`

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.