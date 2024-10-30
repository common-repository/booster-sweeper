=== Booster Sweeper: WordPress Asset Cleanup ===

Contributors: MaxPressy
Tags: speed, performance, pagespeed, dequeue, assets
Tested up to: 6.6
Stable tag: 1.0.5
Requires at least: 6.0
Requires PHP: 7.3.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


== Description ==
Booster Sweeper helps you to optimize the Website speed further over the common caching and code minification plugins. <a href="https://maxpressy.com/booster-sweeper/asset-cleanup-wordpress-plugin-manager/?mtm_campaign=wpPluginPage&mtm_kwd=boostersweeper&mtm_placement=top" target="_blank">Booster Sweeper</a> allows you to dequeue assets, i.e. unload the unused CSS or JavaScript files. These are the files that aren't necessary for certain page.

You see, with the most of the WordPress plugins or even themes, most of the assets are loaded over the whole site, while usually you do not need those resources for certain pages. By unloading those files that aren't necessary you are reducing the overall size of the page and at the same time decreasing the number of http requests. This results in a better performance for the pages and, even if other things are configured well, in a better SEO score for your site.

The most obvious using scenario would be when you have a contact form only on a Contact page. Another example is when you have an e-commerce plugin, e.g. Woocommerce, which loads its files over the whole site, while you may esencially need those files just on product pages. In both these cases, with Booster Sweeper you can stop these assets to appear on the pages that it's not necessary to have them. Of course, you can imagine that you can do the same with other custom post types or plugins that are producing the same issue.

== How Booster Sweeper can be of help? ==
<ul>
 <li>Improve the site’s speed</li>
 <li>Further get better SEO foundation</li>
 <li>Bypass loosing customers due to the slow loading Website</li>
 <li>By reducing the pages size, save in CDN costs</li>
</ul>

== Booster Sweeper is simple to use ==
On each page or post of your WordPress site, from the sidebar settings, you'll be able to notice a Booster Sweeper section. Here, our plugin is automatically detecting the assets that are loaded on the page. CSS and JS files are split in separate sections and when you select a file name, it will be prevented from loading on that page.

== Go Premium ==
Premium Version of Booster Sweeper allows you to:
<ul>
 <li>Dequeue assets for bulk pages, i.e. from the plugin global settings. Instead of doing it individually per page/post, you can select the pages and posts for which you wish certain CSS and JavaScript files that should be prevented from loading.</li>
 <li>Disable the Booster Sweeper's meta box section per post and page, so everything is managed from the global settings (bypass confusion)</li>
</ul>

But that's not all, Pro version gives you ability to control the appearance of the assets based on many conditions:
<ul>
 <li>Post types, e.g. Woocommerce's products</li>
 <li>Archives, i.e. categories, tags or even custom post types specific archive</li>
 <li>Specific pages, like media files, search pages, 404</li>
 <li>By RegEx</li>
</ul>

To go further, with Booster Sweeper Pro, you can also:
<ul>
 <li>Manage the assets on the back-end side of the site. This may be specially important and beneficial for the membership sites</li>
</ul>
Visit <a href="https://maxpressy.com/booster-sweeper/asset-cleanup-wordpress-plugin-manager/?mtm_campaign=wpPluginPage&mtm_kwd=boostersweeper&mtm_placement=bottom" target="_blank">Booster Sweeper Pro page</a> on our site to see all the benefits of the premium version.

== Installation ==
= Automated Installation =
From your WordPress dashboard, navigate to the Plugins -> Add New, then search for the "Booster Sweeper". Activate the plugin.

= Manual Alternative =
Alternatively, install Booster Sweeper by uploading the files manually to your server. Download the plugin here from wordpress.org, upload the files to the plugin directiory of your WordPress installation. Go to the admin dashboard of your site, now. Navigate to the Plugins section and activate Booster Sweeper.

= Usage =
After activating the plugin, in your WordPress Dashboard find the section "Booster Sweeper". There you can set its default settings. Further, while editing each post or page you can disable assets for that page.


== Screenshots ==
1. Booster Sweeper section is located in the right sidebar of the post editing screen
2. The file names you select won't be loaded for the current post/page


== Changelog ==
= 1.0.5 - 2022-11-13 =
* Change the way the plugin version is retrieved and printed

= 1.0.4 - 2022-08-13 =
* Update Fields framework
* Compatibility with WP 6.3

= 1.0.3 - 2022-12-19 =
* Update some option descriptions and UI improvements
* Add documentation section inside the UI

= 1.0.2 - 2022-12-01 =
* Update options fields framework
* Update some option descriptions

= 1.0.1 - 2022-11-03 =
* Fix: Dequeuing on archive if the post appears first
* Update: translation strings

= 1.0.0 - 2022-10-28 =
* Initial release


== Upgrade Notice ==
Make a full site backup before upgrading.
