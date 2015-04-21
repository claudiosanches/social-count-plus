=== Social Count Plus ===
Contributors: claudiosanches, felipesantana
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y8HP99ZJ5Z59L
Tags: facebook, twitter, youtube, google, instagram, soundcloud, steam, counter, widget, shortcode
Requires at least: 3.8
Tested up to: 4.2
Stable tag: 3.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display the counting data of Twitter, Facebook, Google+, YouTube, Instagram, Steam Community, SoundCloud posts and comments.

== Description ==

The Social Count Plus performs counting Twitter followers, Facebook fans, YouTube subscribers, Google+ page/profile followers, Instagram followers, Steam Community group members, SoundCloud follwers, number of posts and comments.

You can view this information by a widget (with account options models icons) or Shortcodes (to be used in posts and pages) or PHP functions in your theme.

The results of the counters are cached and new values ​​are checked only once a day. This cache can be wiped when published a new post.

The cache avoids not only that your blog be seeking new results every time a page is loaded, but also prevents collapse of services from Twitter and Facebook, if one of these services does not respond, the counter displays the last count it was successful.

#### Shortcodes ####

Displays only the count in plain text:

* Twitter: `[scp code="twitter"]`
* Facebook: `[scp code="facebook"]`
* YouTube: `[scp code="youtube"]`
* Google Plus: `[scp code="googleplus"]`
* Instagram: `[scp code="instagram"]`
* Steam: `[scp code="steam"]`
* SoundCloud: `[scp code="soundcloud"]`
* Posts: `[scp code="posts"]`
* Comments: `[scp code="comments"]`

#### Functions ####

Displays only the count in plain text:

* Twitter: `<?php echo get_scp_twitter(); ?>`
* Facebook: `<?php echo get_scp_facebook(); ?>`
* YouTube: `<?php echo get_scp_youtube(); ?>`
* Google Plus: `<?php echo get_scp_googleplus(); ?>`
* Instagram: `<?php echo get_scp_instagram(); ?>`
* Steam: `<?php echo get_scp_steam(); ?>`
* SoundCloud: `<?php echo get_scp_soundcloud(); ?>`
* Posts: `<?php echo get_scp_posts(); ?>`
* Comments: `<?php echo get_scp_comments(); ?>`

Displays the widget with icons:

* Widget: `<?php echo get_scp_widget(); ?>`

#### Translate ####

You can contribute to the source code in our [GitHub](https://github.com/claudiosmweb/social-count-plus) page.

#### Contribute ####

You can contribute to the source code in our [GitHub](https://github.com/claudiosmweb/social-count-plus) page.

#### Credits ####

* Flat icons set, Instagram, SoundCloud and Steam icons by [Felipe Santana](http://wordpress.org/support/profile/felipesantana)
* Steam counter by [Tadas Krivickas](http://wordpress.org/support/profile/tkrivickas)
* Instagram access token generator by [Pedro Rogério](http://www.pinceladasdaweb.com.br/)

== Installation ==

* Upload plugin files to your plugins folder, or install using WordPress built-in Add New Plugin installer;
* Activate the plugin;
* Navigate to Settings -> Social Count Plus and fill the plugin options.

== Frequently Asked Questions ==

= What is the plugin license? =

* This plugin is released under a GPL license.

= Google+ is not working? =

You probably have not been able to generate API keys as it should.

You can test the API key with the following link:

	https://www.googleapis.com/plus/v1/people/+ClaudioSanches?key=API_KEY_HERE

The answer must contain the following line:

	"circledByCount": XXX,

If you do not find anything related to `circledByCount` means that your API key is incorrect, but do not worry, just follow the steps in this video to generate an valid API key:

https://www.youtube.com/watch?v=kj078EN_hpU

= Why the counter Facebook does not leave the ground? =

* Because you need to have a fan page with more than 15 people in it to run the Facebook API.

= How to changing the amount of times the counter is updated daily? =

You can change using the filter `social_count_plus_transient_time`.  
Example:


	function social_count_plus_custom_transient_time( $time ) {
		return 43200; // 12 hours in seconds.
	}

	add_filter( 'social_count_plus_transient_time', 'social_count_plus_custom_transient_time' );


= Can I use my own icons? =

Yes, you can!

Select one of the options without icons in "WordPress admin > Social Count Plus > Design" and create your own CSS in your theme or anywhere you prefer.

The CSS classes you will need to use:

	.social-count-plus .custom .count-twitter a {}
	.social-count-plus .custom .count-facebook a {}
	.social-count-plus .custom .count-youtube a {}
	.social-count-plus .custom .count-googleplus a {}
	.social-count-plus .custom .count-instagram a {}
	.social-count-plus .custom .count-steam a {}
	.social-count-plus .custom .count-soundcloud a {}
	.social-count-plus .custom .count-posts a {}
	.social-count-plus .custom .count-comments a {}


== Screenshots ==

1. Settings page.
2. Design page.
3. Shortcodes and Functions API page.
4. System Status page.
5. Widget.

== Changelog ==

= 3.0.3 - 2015/04/21 =

* Fixed errors in HHVM.
* Fixed potential XSS vulnerability with add_query_arg().

= 3.0.2 - 2014/12/30 =

* Fixed the install/update method.

= 3.0.1 - 2014/12/25 =

* Used only HTTPS for the social links.
* Removed rel nofollow and target blank for posts and comments.

= 3.0.0 - 2014/05/24 =

* Refactored all code.
* Improved the admin option screens.
* Added System Status admin screen.
* Added option to display the widget without icons (this way it is simple for you to add your icons in your theme CSS).
* Added option to sort the icons order.

= 2.9.1 - 2014/04/30 =

* Improved the counter styles.
* Changed the default options in plugin install.

= 2.9.0 - 2014/04/05 =

* Added new Google Plus API.
* Added Google Plus API key option.
* Fixed the Google Plus counter, now is possible grab the pages and profiles followers count.

= 2.8.2 - 2014/03/26 =

* Improved the Facebook counter.
* Improved the validation of data for all counters.
* Added a option to enter with you YouTube Channel URL.

= 2.8.1 - 2014/02/05 =

* Added Swedish translation by [Ramrod](http://profiles.wordpress.org/ramrod).

= 2.8.0 - 03/01/2014 =

* Added option to insert `rel="nofollow"` in social URLs.
* Added option to insert `target="_blank"` in social URLs.

= 2.7.9 - 2013/12/29 =

* Added rel="nofollow" in social icons URLs.

= 2.7.8 - 2013/12/17 =

* Fixed get_scp_instagram() function.
* Fixed get_scp_soundcloud() function.

= 2.7.7 - 2013/12/13 =

* Added support to WordPress 3.8.

= 2.7.6 - 2013/11/26 =

* Added fr_FR translation by Gilles Santacreu.

= 2.7.5 - 2013/11/13 =

* Fixed SimpleXMLElement errors.

= 2.7.4 - 2013/11/02 =

* Added Albanian translation by Lorenc.

= 2.7.3 - 2013/10/31 =

* Added Russian translation by [Elvisrk](http://wordpress.org/support/profile/elvisrk).

= 2.7.2 - 2013/10/26 =

* Fixed the textdomain for new WordPress 3.7 standard.
* Fixed the icons padding.

= 2.7.1 - 2013/09/06 =

* Fixed icons order.

= 2.7.0 - 2013/09/06 =

* Added Intagram counter.
* Added Steam counter.
* Added SoundCloud counter.
* Added `social_count_plus_transient_time` filter.
* Added flat icons.

= 2.6.0 - 2013/06/21 =

* Added uninstall file.

= 2.5.0 - 2013/06/21 =

* Added option to change the text color of the widget.

= 2.4.0 - 2013/06/21 =

* Added Google Plus counter.

= 2.3.0 - 2013/06/20 =

* Updated the Twitter API to 1.1 version.

= 2.2 - 2013/04/19 =

* Added `social_count_plus_number_format` filter.

= 2.1.1 - 2013/01/22 =

* Removed cleaning transients to save a post.

= 2.1 - 2013/01/18 =

* Fixed a bug that was generated by adding an incorrect user the option of YouTube.

= 2.0.1 - 2013/01/14 =

* Fixed styles.
* Fixed YouTube widget icon.

= 2.0 - 2013/01/14 =

* Source code reformulation.
* Added YouTube counter.
* Improved performance with fewer options in the database.
* Added Brazilian Portuguese and English languages.

= 1.3 =

* Removed support for Feedburner since Google has disabled the [API](https://developers.google.com/feedburner/).

= 1.2 =

* Free version.

= 1.1 =

* Final configuration of the plugin.

= 1.0 =

* Initial release.

== Upgrade Notice ==

= 3.0.3 =

* Fixed errors in HHVM.
* Fixed potential XSS vulnerability with add_query_arg().

== License ==

Social Count Plus is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published
by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Social Count Plus is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Social Count Plus. If not, see <http://www.gnu.org/licenses/>.
