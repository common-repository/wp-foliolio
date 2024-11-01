=== WP Folio ===
Contributors: mikeyotoole87
Tags: portfolio, project, thumbnails, web designer, web developer, designer, developer, websites, custom-post-types, plugins, wordpress portfolio, wp-foliolio
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: 0.2.5

WP-Foliolio enables a Web Developer/Designer to create a Wordpress Portfolio for their work with wp's familiar content creation system.

== Description ==
= About the Plugin =
This plugin is unmaintained, please contact me if you wish to take over maintenance.

== Installation ==

= Instructions =

1. Unzip the plugin archive
2. Upload the entire folder wp-foliolio to your plugins folder (/wp-content/plugins/)
3. Ensure your wordpress uploads directory exists and is writable (/wp-content/uploads/)
4. Activate the plugin through the ‘Plugins’ menu in WordPress
5. A new Projects Admin Menu should appear below Comments
6. Go to Projects -> Options to configure your preferences
8. Place copies of the php files from the /wp-content/plugins/wp-foliolio/views/ folder into your theme folder /wp-content/themes/your_theme_name/portfolio/ folder.
9. Create a new, blank, page selecting the "Projects" page template.
10. (If using a custom menu) Add a link to this page to your menu.  

= Requirements =
*	Only PHP 5+ is supported, although PHP 4 may work.
*	PHP Safe Mode is not supported, you may be able to hack it to work though
*	WordPress 3.x + only

== Support ==
Please contact me through [my website] (http://mjco.me.uk/contact/)

== Frequently Asked Questions ==

= I'm getting 404 errors for my project links =
Should this occur, the easiest solution to this is to visit the permalinks section of your Wordpress admin. This will flush your permalinks settings and should make the site realise the Portfolio plugin is installed.

= The plugin isn't working for me, please help =

I will do my best to answer any comments that are left in the official channels (see support section), but I cannot offer any kind of guaranteed support.

= The Feature I want isn't available =

This is version 0.1 software. Visit the plugin homepage and leave a comment if you have a feature request, I'm not a plugin developer generally but I will do my best to assist.

== Screenshots ==

1. How the Projects Plugin appears in the wordpress admin, very familiar.
2. Example of two listed websites within the Portfolio plugin.
3. How the WP-Foliolio plugin, extends the existing Wordpress Editor.
4. Platform choosing capabilities, works just like standard categories.

== Changelog ==
= 0.1 =
* No Changes as is brand new

= 0.2 =
* Removed <? opening tags from "WPFO_Project.php" due to the requirement to have support defined in php.ini
* Added <?php opening tags to "WPFO_Project.php"
* Removed <? opening tags from "template-tags.php" due to the requirement to have support defined in php.ini
* Added <?php opening tags to "template-tags.php"

= 0.2.5 =
* Added admin option to display "Project" title on Projects Page.
* Added admin option to display "Project" tags or "Platforms" on Projects Page.
* Added admin option to diplsay "Project" information on Projects Page.
* **Corrected error in instructions which gave incorrect instructions for placing template files**

== Upgrade Notice ==

= 0.1 =
First version, tested in own environments but awaiting bugs.

= 0.2 =
Rectifies bugs highlighted by plugin users regarding use of deprecated `<?` opening tags.

= 0.2.5 =
Adds more admininistrative controls to allow greater flexibility.
