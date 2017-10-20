=== Index Autoload ===

Contributors: littlebizzy
Tags: index, autoload, database, mysql, options, wp_options
Requires at least: 4.4
Tested up to: 4.8
Requires PHP: 7.0
Stable tag: 1.0.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Prefix: IDXALD

Adds an index to the autoload in wp_options table and verifies it exists on a daily basis (using WP Cron), resulting in a more efficient database.

== Description ==

Adds an index to the autoload in wp_options table and verifies it exists on a daily basis (using WP Cron), resulting in a more efficient database.

This issue has been debated for several years, and the WP Core team has opted to not include an index in `wp_options` table for the autoload options for various reasons. Still, many teams have found the index to result in much better database performance, especially for large databases.

VERSION 1.0.3 UPDATE:

As of version 1.0.3, this plugin now works with MyISAM (not only InnoDB) and no longer performs MySQL version check (previously only fired if version was 5.5 or higher). The point is that we assume by installing this plugin you know what you are doing, so only install if you have backed up your database and realize that certain MyISAM database have seen issues when dealing with indexes, etc. This plugin will be most effective for large tables using about 50% (or less) of autoloaded options, both for MyISAM or INNODB engines. For small options tables (most of them) there are no significant differences and this plugin does not have to be installed, although in the vast majority of cases it shouldn't hurt anything.

Default behavior (after version 1.0.3) is that an index is added upon plugin activation. Then, using WP Cron this plugin will check 1x daily that the index still exists, if not it will be added. The idea here is that rather than worrying about a client or team member messing up your database, you can install this plugin to ensure the index is always there. You can even hide this plugin from a client (etc) by using as a Must Use plugin instead, or include as part of your automated WP installations to avoid having to run manual SQL queries on your project.

Note: uninstalling this plugin will remove the index from your autoload options.

Lastly, if you want to force the index to `DROP` and then `ADD` again each day, enable this constant (keep in mind that no other query is performed, such as OPTIMIZE or etc, it is currently just DROP and then ADD again).

    define('IDXALD_REGENERATE', true);

Please note that the original defined constant no longer works, which allowed you to defined how often the index would be regenerated. This is because 1x daily seems more than enough, and not too often to cause issues. However if you have feedback on these changes, please post on the wp.org forums and tag this plugin in your post.

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
* Database Queries: 1x daily via WP Cron
* Must-Use Support: Yes
* Multi-site Support: No
* Uninstalls Data: Yes, removes the autoload index

#### Code Inspiration ####

This plugin was partially inspired either in "code or concept" by the open-source software and discussions mentioned below:

* [Trac #24044](https://core.trac.wordpress.org/ticket/24044)
* [Trac #24044 jrchamp MyISAM snippet](https://core.trac.wordpress.org/attachment/ticket/24044/wp_options_test_index_options.php)
* [Trac #24044 jrchamp MyISAM results](https://core.trac.wordpress.org/attachment/ticket/24044/wp_options_test_index_options.results)
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
2. Activate via WP Admin > Plugins
3. Review your database to confirm index exists

== Changelog ==

= 1.0.3 =
* (once) delete old option `index_autoload_active`
* (once) remove WP Cron scheduled hook `index_autoload_cron`
* no longer uses `IDXAUTOLOAD_SCHEDULE` constant
* fix bug calling `wp_unschedule_event`
* fix bug using constant `IDXAUTOLOAD_SCHEDULE` without checking if defined or not
* fix compatibility with WPSEO plugin (Yoast) avoiding a fatal error
* fix `DROP` query (the last query failed cause `DROP` queries does not have the " (autoload)" part, just need the index name
* no longer checks for MySQL > 5.5 or InnoDB, works with all engine types
* should now work better (uninstall properly) with PHP 7.1

= 1.0.2 =
* index is now dropped before being (re)added as recommended by Percona and to avoid error log buildup

= 1.0.1 =
* defined constant `IDXAUTOLOAD_SCHEDULE` (optional)
* check MySQL > 5.5 and InnoDB before run

= 1.0.0 =
* initial release
