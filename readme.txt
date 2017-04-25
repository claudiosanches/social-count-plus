=== Social Count Plus ===
Contributors: claudiosanches, felipesantana, deblynprado
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y8HP99ZJ5Z59L
Tags: counter, widget, shortcode, facebook, github, googleplus, instagram, linkedin, pinterest, soundcloud, steam, tumblr, twitch, twitter, vimeo, youtube
Requires at least: 4.0
Tested up to: 4.7
Stable tag: 3.3.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays your number of followers from Facebook, Google+, Instagram, Twitch, Twitter and several other social media websites.

== Description ==

The Social Count Plus performs counting for:

- Comments total
- Facebook page fans
- GitHub followers
- Google+ page/profile followers
- Instagram followers
- LinkedIn company followers
- Pinterest followers
- Posts total
- SoundCloud followers
- Steam Community group members
- Tumblr followers
- Twitch channel followers
- Twitter followers
- Users total
- Vimeo followers

You can display your numbers using a Widget (with links and icons) or Shortcodes (to be used in posts and pages) or PHP functions in your theme.

The results of the counters are cached and new values ​​are checked only once a day. This cache can be wiped when published a new post.

The cache avoids not only that your blog be seeking new results every time a page is loaded, but also prevents collapse of services from Twitter and Facebook, if one of these services does not respond, the counter displays the last count it was successful.

#### Contribute ####

You can contribute to the source code in our [GitHub](https://github.com/claudiosmweb/social-count-plus) page.

#### Credits ####

* Flat icons set, Instagram, SoundCloud and Steam icons by [Felipe Santana](http://wordpress.org/support/profile/felipesantana)
* Steam counter by [Tadas Krivickas](http://wordpress.org/support/profile/tkrivickas)
* `wp_remote_get()` connection test with [httpbin](https://httpbin.org/)

== Installation ==

* Upload plugin files to your plugins folder, or install using WordPress built-in Add New Plugin installer;
* Activate the plugin;
* Navigate to Settings -> Social Count Plus and fill the plugin options.

Some counters depend on third-party APIs to work, follow the next steps to generate API keys for each of them:

= Instagram =

Get your User ID and Access Token in: https://socialcountplus-instagram.herokuapp.com/

= LinkedIn =

Get your Company ID and Access Token in: https://socialcountplus-linkedin.herokuapp.com/

= Facebook =

You must create a Facebook app to use the Facebook Graph API.

Log in https://developers.facebook.com/ and go to "My Apps > Add a New App".

Then follow the steps in this video:

https://www.youtube.com/watch?v=m1QArbW2z4A

= Google+ and YouTube =

It's required a Google API Key for Google+ and YouTube.

Access https://console.developers.google.com/project to create you Google API key following this steps:

https://www.youtube.com/watch?v=KufdCMLMuFs

= Twitter =

You need access https://dev.twitter.com/apps, then create a Twitter App and copy the Consumer key, Consumer secret, Access token and Access token secret:

https://www.youtube.com/watch?v=26dpo-g_jQc

== Frequently Asked Questions ==

= What is the plugin license? =

* This plugin is released under a GPL license.

= Google+ is not working? =

You probably have not been able to generate API keys as it should.

You can test the API key with the following link:

	https://www.googleapis.com/plus/v1/people/+ClaudioSanches?key=API_KEY_HERE

The answer must contain the following line:

	"circledByCount": XXX,

= How to changing the amount of times the counter is updated daily? =

You can change using the filter `social_count_plus_transient_time`.  
Example:


	function social_count_plus_custom_transient_time( $time ) {
		return 43200; // 12 hours in seconds.
	}

	add_filter( 'social_count_plus_transient_time', 'social_count_plus_custom_transient_time' );


= How can I round numbers? =

It's possible to round numbers using the `social_count_plus_number_format` filter.

Example of rounding 1500 to 1.5K or 1000000 to 1M:


	function my_custom_scp_number_format( $total ) {
		if ( $total > 1000000 ) {
			return round( $total / 1000000, 1 ) . 'M';
		} else if ( $total > 1000 ) {
			return round( $total / 1000, 1 ) . 'K';
		}

		return $total;
	}

	add_filter( 'social_count_plus_number_format', 'my_custom_scp_number_format' );


= Can I use my own icons? =

Yes, you can!

Select one of the options without icons in "WordPress admin > Social Count Plus > Design" and create your own CSS in your theme or anywhere you prefer.

The CSS classes you will need to use:

	.social-count-plus .custom .count-comments a {}
	.social-count-plus .custom .count-facebook a {}
	.social-count-plus .custom .count-github a {}
	.social-count-plus .custom .count-googleplus a {}
	.social-count-plus .custom .count-instagram a {}
	.social-count-plus .custom .count-linkedin a {}
	.social-count-plus .custom .count-pinterest a {}
	.social-count-plus .custom .count-posts a {}
	.social-count-plus .custom .count-soundcloud a {}
	.social-count-plus .custom .count-steam a {}
	.social-count-plus .custom .count-tumblr a {}
	.social-count-plus .custom .count-twitch a {}
	.social-count-plus .custom .count-twitter a {}
	.social-count-plus .custom .count-users a {}
	.social-count-plus .custom .count-vimeo a {}


= Having troubles? =

If you have any problems with the numbers, go to the plugin settings and then to the "System Status" tab and click the "Get System Report" button.

Copy the report file content and paste it in [gist.github.com](https://gist.github.com) or [pastebin.com](http://pastebin.com), save and get a link, finally create a topic in our [support forum](https://wordpress.org/support/plugin/social-count-plus).

== Screenshots ==

1. Settings page.
2. Design page.
3. Shortcodes and Functions API page.
4. System Status page.
5. Widget.

== Changelog ==

= 3.3.6 - 2017/04/25 =

* Fixed Facebook integration according with new Facebook API requirements (Thanks to [tc33](https://github.com/claudiosanches/social-count-plus/pull/38)).

= 3.3.5 - 2016/08/20 =

* Update and fixed the Facebook integration.

= 3.3.4 - 2016/06/18 =

* Improved the widget styles, not forcing styles anymore (just select the color as empty). Thanks to Sinisa Nikolic.
* Added `social_count_plus_label` filter.

= 3.3.3 - 2016/04/26 =

* Updated the Facebook API to support APPs v2.5 or later.

= 3.3.2 - 2015/09/28 =

* Restored the `social_count_plus_number_format` filter.

= 3.3.1 - 2015/09/28 =

* Added submenu in settings page.

= 3.3.0 - 2015/09/05 =

* Added option to show all user roles in users integration.
* Fixed errors in PHP 5.2.

== Upgrade Notice ==

= 3.3.6 =

* Fixed Facebook integration according with new Facebook API requirements.
