=== Index Autoload ===

Contributors: littlebizzy
Tags: index, autoload, database, mysql, options, wp_options
Requires at least: 4.4
Tested up to: 4.8
Requires PHP: 7.0
Stable tag: 1.0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds an index to the autoload in wp_options table via WP-Cron on a daily basis, resulting in a more efficient database and faster site performance.

== Description ==

Adds an index to the autoload in wp_options table via WP-Cron on a daily basis, resulting in a more efficient database and faster site performance.

This function will only "fire" if the database is running > MySQL 5.5 and InnoDB engine is active on the `wp_options` table to avoid messing up MyISAM databases (see reference links).

#### Compatibility ####

This plugin has been designed for use on LEMP (Nginx) web servers with PHP 7.0 and MySQL 5.7 to achieve best performance. All of our plugins are meant for single site WordPress installs only; for performance and security reasons, we highly recommend against using WordPress Multi-Site for the vast majority of projects.

#### Plugin Features ####

* Settings Page: No
* Upgrade Available: No
* Includes Media: No
* Includes CSS: No
* Database Storage: No
  * Transients: No
  * Options: No
* Database Queries: No
* Must-Use Support: Yes
* Multi-site Support: No
* Uninstalls Data: N/A

#### Code Inspiration ####

This plugin was partially inspired either in "code or concept" by the open-source software and discussions mentioned below:

* [Trac #24044](https://core.trac.wordpress.org/ticket/24044)
* [StackExchange #98284](https://wordpress.stackexchange.com/questions/98284/how-come-wp-options-table-does-not-have-an-index-on-autoload)
* [StackExchange #83767](https://wordpress.stackexchange.com/questions/83767/performance-with-autoload-and-the-options-table)
* [StackOverflow #30879308](https://stackoverflow.com/questions/30879308/rebuild-index-on-innodb)
* [rtCamp #6108](http://community.rtcamp.com/t/woocommerce-backend-depressingly-slow-even-though-front-end-is-blazing-fast/6108)
* [Sysadmins Of The North](https://www.saotn.org/wordpress-wp-options-table-autoload-micro-optimization/)
* [Percona](https://www.percona.com/blog/2010/12/09/mysql-optimize-tables-innodb-stop/)
* [Hyperborea](https://www.hyperborea.org/journal/2013/11/sqltune/)

#### Recommended Plugins ####

We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Server Status](https://wordpress.org/plugins/server-status-littlebizzy/)
* [View Defined Constants](https://wordpress.org/plugins/view-defined-constants-littlebizzy/)
* [Export Database](https://wordpress.org/plugins/export-database-littlebizzy/)

#### Special Thanks ####

We thank the following groups for their generous contributions to the WordPress community which have particularly benefited us in developing our own free plugins and paid services:

* [Automattic](https://automattic.com)
* [Delicious Brains](https://deliciousbrains.com)
* [Roots](https://roots.io)
* [rtCamp](https://rtcamp.com)
* [WP Tavern](https://wptavern.com)

#### Disclaimer ####

We released this plugin in response to our managed hosting clients asking for better access to their server, and our primary goal will remain supporting that purpose. Although we are 100% open to fielding requests from the WordPress community, we kindly ask that you consider the above mentioned goals in mind, thanks!

== Installation ==

1. Upload to `/wp-content/plugins/index-autoload-littlebizzy` directory
2. Activate the plugin in WP Admin > Plugins
3. Review your logs/database to confirm index is being added

== Changelog ==

= 1.0.2 =
* index is now dropped before being (re)added as recommended by Percona and to avoid error log buildup

= 1.0.1 =
* defined constant `IDXAUTOLOAD_SCHEDULE` (optional)
* check MySQL > 5.5 and InnoDB before run

= 1.0.0 =
* initial release
