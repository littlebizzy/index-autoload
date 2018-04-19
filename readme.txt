=== Index Autoload ===

Contributors: littlebizzy
Donate link: https://www.patreon.com/littlebizzy
Tags: index, autoload, options, wp_options, database
Requires at least: 4.4
Tested up to: 4.9
Requires PHP: 7.0
Multisite support: No
Stable tag: 1.0.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Prefix: IDXALD

Adds an index to the autoload in wp_options table and verifies it exists on a daily basis (using WP Cron), resulting in a more efficient database.

== Description ==

Adds an index to the autoload in wp_options table and verifies it exists on a daily basis (using WP Cron), resulting in a more efficient database.

* [**Patreon (support us with $1/mo)**](https://www.patreon.com/littlebizzy)
* [Plugin Homepage](https://www.littlebizzy.com/plugins/index-autoload)
* [Plugin GitHub](https://github.com/littlebizzy/index-autoload)
* [SlickStack](https://slickstack.io)
* [Starter](https://starter.littlebizzy.com)

#### The Long Version ####

This issue has been debated for several years, and the WP Core team has opted to not include an index in `wp_options` table for the autoload options for various reasons. Still, many teams have found the index to result in much better database performance, especially for large databases.

VERSION 1.0.3 UPDATE:

As of version 1.0.3, this plugin now works with MyISAM (not only InnoDB) and no longer performs MySQL version check (previously only fired if version was 5.5 or higher). The point is that we assume by installing this plugin you know what you are doing, so only install if you have backed up your database and realize that certain MyISAM database have seen issues when dealing with indexes, etc. This plugin will be most effective for large tables using about 50% (or less) of autoloaded options, both for MyISAM or INNODB engines. For small options tables (most of them) there are no significant differences and this plugin does not have to be installed, although in the vast majority of cases it shouldn't hurt anything.

Default behavior (after version 1.0.3) is that an index is added upon plugin activation. Then, using WP Cron this plugin will check 1x daily that the index still exists, if not it will be added. The idea here is that rather than worrying about a client or team member messing up your database, you can install this plugin to ensure the index is always there. You can even hide this plugin from a client (etc) by using as a Must Use plugin instead, or include as part of your automated WP installations to avoid having to run manual SQL queries on your project.

Note: uninstalling this plugin will remove the index from your autoload options.

Lastly, if you want to force the index to `DROP` and then `ADD` again each day, enable this constant (keep in mind that no other query is performed, such as OPTIMIZE or etc, it is currently just DROP and then ADD again).

    define('INDEX_AUTOLOAD_REGENERATE', true);

Please note that the original defined constant no longer works, which allowed you to defined how often the index would be regenerated. This is because 1x daily seems more than enough, and not too often to cause issues. However if you have feedback on these changes, please post on the wp.org forums and tag this plugin in your post.

#### Compatibility ####

This plugin has been designed for use on LEMP (Nginx) web servers with PHP 7.0 and MySQL 5.7 to achieve best performance. All of our plugins are meant for single site WordPress installations only; for both performance and security reasons, we highly recommend against using WordPress Multisite for the vast majority of projects.

#### Plugin Features ####

* Settings Page: No
* Premium Version Available: Yes ([Speed Demon](https://www.littlebizzy.com/plugins/speed-demon))
* Includes Media (Images, Icons, Etc): No
* Includes CSS: No
* Database Storage: Yes
  * Transients: No
  * Options: Yes
  * Creates New Tables: No
* Database Queries: Backend Only (Options API) + SQL Lookup Cron
* Must-Use Support: Yes (Use With [Autoloader](https://github.com/littlebizzy/autoloader))
* Multisite Support: No
* Uninstalls Data: Yes

#### WP Admin Notices ####

This plugin generates multiple [Admin Notices](https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices) in the WP Admin dashboard. The first is a notice that fires during plugin activation which recommends several related free plugins that we believe will enhance this plugin's features; this notice will re-appear approximately once every 6 months as our code and recommendations evolve. The second is a notice that fires a few days after plugin activation which asks for a 5-star rating of this plugin on its WordPress.org profile page. This notice will re-appear approximately once every 9 months. These notices can be dismissed by clicking the **(x)** symbol in the upper right of the notice box. These notices may annoy or confuse certain users, but are appreciated by the majority of our userbase, who understand that these notices support our free contributions to the WordPress community while providing valuable (free) recommendations for optimizing their website.

If you feel that these notices are too annoying, than we encourage you to consider one or more of our upcoming premium plugins that combine several free plugin features into a single control panel, or even consider developing your own plugins for WordPress, if supporting free plugin authors is too frustrating for you. A final alternative would be to place the defined constant mentioned below inside of your `wp-config.php` file to manually hide this plugin's nag notices:

    define('DISABLE_NAG_NOTICES', true);

Note: This defined constant will only affect the notices mentioned above, and will not affect any other notices generated by this plugin or other plugins, such as one-time notices that communicate with admin-level users.

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

* [404 To Homepage](https://wordpress.org/plugins/404-to-homepage-littlebizzy/)
* [CloudFlare](https://wordpress.org/plugins/cf-littlebizzy/)
* [Delete Expired Transients](https://wordpress.org/plugins/delete-expired-transients-littlebizzy/)
* [Disable Author Pages](https://wordpress.org/plugins/disable-author-pages-littlebizzy/)
* [Disable Cart Fragments](https://wordpress.org/plugins/disable-cart-fragments-littlebizzy/)
* [Disable Embeds](https://wordpress.org/plugins/disable-embeds-littlebizzy/)
* [Disable Emojis](https://wordpress.org/plugins/disable-emojis-littlebizzy/)
* [Disable Empty Trash](https://wordpress.org/plugins/disable-empty-trash-littlebizzy/)
* [Disable Image Compression](https://wordpress.org/plugins/disable-image-compression-littlebizzy/)
* [Disable jQuery Migrate](https://wordpress.org/plugins/disable-jq-migrate-littlebizzy/)
* [Disable Search](https://wordpress.org/plugins/disable-search-littlebizzy/)
* [Disable WooCommerce Status](https://wordpress.org/plugins/disable-wc-status-littlebizzy/)
* [Disable WooCommerce Styles](https://wordpress.org/plugins/diable-wc-styles-littlebizzy/)
* [Disable XML-RPC](https://wordpress.org/plugins/disable-xml-rpc-littlebizzy/)
* [Download Media](https://wordpress.org/plugins/download-media-littlebizzy/)
* [Download Plugin](https://wordpress.org/plugins/download-plugin-littlebizzy/)
* [Download Theme](https://wordpress.org/plugins/download-theme-littlebizzy/)
* [Duplicate Post](https://wordpress.org/plugins/duplicate-post-littlebizzy/)
* [Export Database](https://wordpress.org/plugins/export-database-littlebizzy/)
* [Force HTTPS](https://wordpress.org/plugins/force-https-littlebizzy/)
* [Force Strong Hashing](https://wordpress.org/plugins/force-strong-hashing-littlebizzy/)
* [Google Analytics](https://wordpress.org/plugins/ga-littlebizzy/)
* [Index Autoload](https://wordpress.org/plugins/index-autoload-littlebizzy/)
* [Maintenance Mode](https://wordpress.org/plugins/maintenance-mode-littlebizzy/)
* [Profile Change Alerts](https://wordpress.org/plugins/profile-change-alerts-littlebizzy/)
* [Remove Category Base](https://wordpress.org/plugins/remove-category-base-littlebizzy/)
* [Remove Query Strings](https://wordpress.org/plugins/remove-query-strings-littlebizzy/)
* [Server Status](https://wordpress.org/plugins/server-status-littlebizzy/)
* [StatCounter](https://wordpress.org/plugins/sc-littlebizzy/)
* [View Defined Constants](https://wordpress.org/plugins/view-defined-constants-littlebizzy/)
* [Virtual Robots.txt](https://wordpress.org/plugins/virtual-robotstxt-littlebizzy/)

#### Premium Plugins ####

We invite you to check out a few premium plugins that our team has also produced that you may find especially useful:

* [Speed Demon](https://www.littlebizzy.com/plugins/speed-demon)
* [SEO Genius](https://www.littlebizzy.com/plugins/seo-genius)
* [Great Migration](https://www.littlebizzy.com/plugins/great-migration)
* [Security Guard](https://www.littlebizzy.com/plugins/security-guard)
* [Genghis Khan](https://www.littlebizzy.com/plugins/genghis-khan)

#### Special Thanks ####

We thank the following groups for their generous contributions to the WordPress community which have particularly benefited us in developing our own free plugins and paid services:

* [Automattic](https://automattic.com)
* [Brad Touesnard](https://bradt.ca)
* [Daniel Auener](http://www.danielauener.com)
* [Delicious Brains](https://deliciousbrains.com)
* [Greg Rickaby](https://gregrickaby.com)
* [Matt Mullenweg](https://ma.tt)
* [Mika Epstein](https://halfelf.org)
* [Samuel Wood](http://ottopress.com)
* [Scott Reilly](http://coffee2code.com)
* [Jan Dembowski](https://profiles.wordpress.org/jdembowski)
* [Jeff Starr](https://perishablepress.com)
* [Jeff Chandler](https://jeffc.me)
* [Jeff Matson](https://jeffmatson.net)
* [John James Jacoby](https://jjj.blog)
* [Leland Fiegel](https://leland.me)
* [Rahul Bansal](https://profiles.wordpress.org/rahul286)
* [Roots](https://roots.io)
* [rtCamp](https://rtcamp.com)
* [WP Chat](https://wpchat.com)
* [WP Tavern](https://wptavern.com)

#### Disclaimer ####

We released this plugin in response to our managed hosting clients asking for better access to their server, and our primary goal will remain supporting that purpose. Although we are 100% open to fielding requests from the WordPress community, we kindly ask that you keep the above mentioned goals in mind, thanks!

== Installation ==

1. Upload to `/wp-content/plugins/index-autoload-littlebizzy` directory
2. Activate via WP Admin > Plugins
3. Review your database to confirm index exists

== Changelog ==

= 1.0.6 =
* constant spelling is now define('INDEX_AUTOLOAD_REGENERATE', true);
* (old spelling no longer supported: `IDXALD_REGENERATE`)
* added warning to Multisite installations
* updated recommended plugins

= 1.0.5 =
* updated recommended plugins

= 1.0.4 =
* tested with WP 4.9
* added recommended plugins notice
* added rating request notice
* added support for `define('DISABLE_NAG_NOTICES', true);`

= 1.0.3 =
* (once) delete old option `index_autoload_active`
* (once) remove WP Cron scheduled hook `index_autoload_cron`
* added supported for `define('IDXALD_REGENERATE', true);`
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
* added support for defined constant `IDXAUTOLOAD_SCHEDULE`
* check MySQL > 5.5 and InnoDB before run

= 1.0.0 =
* initial release
