SOURCE: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/

=== Responsive Viewport Units ===
Contributors: clintongallagher@live.com, Clinton Gallagher
Tags: responsive, design, css, layout, test, testing, debug, php, developer
Donate link: http://clintongallagher.com
Requires at least: 3.5
Tested up to: 4.9
Requires PHP: 3.5
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Responsive Viewport Units dynamically displays viewport units each time the browser is resized.

== Description ==
Responsive Viewport Units provides real-time review and confirmation of elements positioned within a page supporting the confirmation of responsive design conformance to media query declarations or the unit values needed to code new media query breakpoints. Viewport units dynamically update each time the browser is resized. This plugin uses window.innerWidth and window.innerHeight properties of the viewport to display height and width of the viewport in both pixel and rem unit values. The units are displayed in a configurable <div> container which appears in each publically viewable page of the website while the plugin remains activated.  A static example of the configurable output is displayed in the admin settings page.

== Installation ==
This plugin can be installed by following the typical options:

* Use WordPress to browse an accessible file system and allow WordPress to upload the plugin's zip file.
* FTP the plugin's zip file into the website's '/wp-content/plugins/' directory.
* Manually copy the plugin's zip file into the website's '/wp-content/plugins/' directory.
* Use WordPress to install the plugin from the WordPress Plugin Directory.


== Frequently Asked Questions ==
Q.) Are there any dependencies to use this plugin?
A.) Yes, the following dependencies are required:

1. The plugin uses localStorage and a cookie to maintain state so a browser that supports Web Storage is required.

2. The plugin uses wp_footer() which must be supported in the footer.php file.
Check your 3rd party theme for compliance as some themes are not coded to support wp_footer() which must then be added manually.


== Screenshots ==
1. Viewport Units as Displayed in Page

== Changelog ==
1.0
List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==
This plugin requires no upgrades to maintain its functionality..

