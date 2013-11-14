=== Social Count Plus ===
Contributors: claudiosanches, felipesantana
Donate link: http://claudiosmweb.com/doacoes/
Tags: facebook, twitter, youtube, google, instagram, soundcloud, steam, counter, widget, shortcode
Requires at least: 3.5
Tested up to: 3.7.1
Stable tag: 2.7.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display the counting data of Twitter, Facebook, YouTube, Instagram, Steam Community, SoundCloud posts and comments.

== Description ==

The Social Count Plus performs counting Twitter followers, Facebook fans, YouTube subscribers, Google Plus page followers, Instagram followers, Steam Community group members, SoundCloud follwers, number of posts and comments.

You can view this information via a widget (with account options models icons) or Shortcodes (to be used in posts and pages) or by functions in PHP.

The results of the counters are cached and new values ​​are checked only once a day. This cache can be wiped when published a new post.

The cache avoids not only that your blog be seeking new results every time a page is loaded, but also prevents collapse of services from Twitter and Facebook, if one of these services does not respond, the counter displays the last count it was successful.

#### Shortcodes ####

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

* Twitter: `<?php echo get_scp_twitter(); ?>`
* Facebook: `<?php echo get_scp_facebook(); ?>`
* YouTube: `<?php echo get_scp_youtube(); ?>`
* Google Plus: `<?php echo get_scp_googleplus(); ?>`
* Instagram: `<?php echo get_scp_instagram(); ?>`
* Steam: `<?php echo get_scp_steam(); ?>`
* SoundCloud: `<?php echo get_scp_soundcloud(); ?>`
* Posts: `<?php echo get_scp_posts(); ?>`
* Comments: `<?php echo get_scp_comments(); ?>`
* Widget: `<?php echo get_scp_widget(); ?>`

#### Contribute ####

You can contribute to the source code in our [GitHub](https://github.com/claudiosmweb/social-count-plus) page.

#### Credits ####

* Flat icons set, Instagram, SoundCloud and Steam icons by [Felipe Santana](http://wordpress.org/support/profile/felipesantana)
* Steam counter by [Tadas Krivickas](http://wordpress.org/support/profile/tkrivickas)
* Instagram access token generator by [Pedro Rogério](http://www.pinceladasdaweb.com.br/)

### Descrição em Português: ###

O Social Count Plus faz a contagem de seguidores no Twitter, fãs no Facebook, assinantes do YouTube, seguidores em páginas do Google Plus, seguidores no Instagram, membros em grupos do Steam Community, seguidores no SoundCloud, total de posts e comentários.

Você pode exibir estas contagens através de um widget, com Shortcodes ou por funções em PHP.

Os resultados dos contadores são armazenados em cache e os novos valores são verificados apenas uma vez por dia. Este cache pode ser limpo quando publicado um novo post.

O cache não só evita que o seu blog estar buscando novos resultados cada vez que uma página é carregada, mas também impede o colapso dos serviços do Twitter e Facebook, se um desses serviços não responder, o contador exibe a última contagem que foi bem sucedida.

#### Shortcodes ####

* Twitter: `[scp code="twitter"]`
* Facebook: `[scp code="facebook"]`
* YouTube: `[scp code="youtube"]`
* Google Plus: `[scp code="googleplus"]`
* Instagram: `[scp code="instagram"]`
* Steam: `[scp code="steam"]`
* SoundCloud: `[scp code="soundcloud"]`
* Posts: `[scp code="posts"]`
* Comments: `[scp code="comments"]`

#### Funções ####

* Twitter: `<?php echo get_scp_twitter(); ?>`
* Facebook: `<?php echo get_scp_facebook(); ?>`
* YouTube: `<?php echo get_scp_youtube(); ?>`
* Google Plus: `<?php echo get_scp_googleplus(); ?>`
* Instagram: `<?php echo get_scp_instagram(); ?>`
* Steam: `<?php echo get_scp_steam(); ?>`
* SoundCloud: `<?php echo get_scp_soundcloud(); ?>`
* Posts: `<?php echo get_scp_posts(); ?>`
* Comments: `<?php echo get_scp_comments(); ?>`
* Widget: `<?php echo get_scp_widget(); ?>`

#### Coloborar ####

Você pode contribuir com código-fonte em nossa página no [GitHub](https://github.com/claudiosmweb/social-count-plus).

#### Créditos ####

* Pacote de icons flat, Icones do Instagram, SoundCloud e Steam por [Felipe Santana](http://wordpress.org/support/profile/felipesantana)
* Contador do Steam por [Tadas Krivickas](http://wordpress.org/support/profile/tkrivickas)
* Gerador de Access Token do Instagram por [Pedro Rogério](http://www.pinceladasdaweb.com.br/)

== Installation ==

* Upload plugin files to your plugins folder, or install using WordPress built-in Add New Plugin installer;
* Activate the plugin;
* Navigate to Settings -> Social Count Plus and fill the plugin options.

### Instalação em Português: ###

* Envie arquivos do plugin para a pasta de plugins, ou instale usando o o instalador do WordPress em Plugins -> Adicionar Novo;
* Ative o plugin;
* Navegue até Configurações -> Social Count Plus e preencha as opções do plugin.

== Frequently Asked Questions ==

= What is the plugin license? =

* This plugin is released under a GPL license.

= Why the counter Facebook does not leave the ground? =

* Because you need to have a fan page with more than 15 people in it to run the Facebook API.

= How to changing the amount of times the counter is updated daily? =

* You can change using the filter `social_count_plus_transient_time`.  Example:

    function social_count_plus_custom_transient_time( $time ) {
        return 43200; // 12 hours in seconds.
    }

    add_filter( 'social_count_plus_transient_time', 'social_count_plus_custom_transient_time' );

### FAQ em Português: ###

= Qual é a licença do plugin? =

* Este plugin esta licenciado como GPL.

= Porque o contador do Facebook não sai do zero? =

* Porque você precisa ter uma fã page com mais de 15 pessoas nela para funcionar a API do Facebook.

= Como alterar a quantidade de vezes que o contador é atualizado por dia? =

* Você pode modificar usando o filtro `social_count_plus_transient_time`.  Exemplo:

    function social_count_plus_custom_transient_time( $time ) {
        return 43200; // 12 horas em segundos.
    }

    add_filter( 'social_count_plus_transient_time', 'social_count_plus_custom_transient_time' );

== Screenshots ==

1. Plugin settings.
2. Widget models.
3. Shortcodes and Functions API page.
4. Widget.

== Changelog ==

= 2.7.5 - 13/11/2013 =

* Fixed SimpleXMLElement errors.

= 2.7.4 - 02/11/2013 =

* Added Albanian translation by Lorenc.

= 2.7.3 - 31/10/2013 =

* Added Russian translation by [Elvisrk](http://wordpress.org/support/profile/elvisrk).

= 2.7.2 - 26/10/2013 =

* Fixed the textdomain for new WordPress 3.7 standard.
* Fixed the icons padding.

= 2.7.1 - 06/09/2013 =

* Fixed icons order.

= 2.7.0 - 06/09/2013 =

* Added Intagram counter.
* Added Steam counter.
* Added SoundCloud counter.
* Added `social_count_plus_transient_time` filter.
* Added flat icons.

= 2.6.0 - 21/06/2013 =

* Added uninstall file.

= 2.5.0 - 21/06/2013 =

* Added option to change the text color of the widget.

= 2.4.0 - 21/06/2013 =

* Added Google Plus counter.

= 2.3.0 - 20/06/2013 =

* Updated the Twitter API to 1.1 version.

= 2.2 - 19/04/2013 =

* Added `social_count_plus_number_format` filter.

= 2.1.1 - 22/01/2013 =

* Removed cleaning transients to save a post.

= 2.1 - 18/01/2013 =

* Fixed a bug that was generated by adding an incorrect user the option of YouTube.

= 2.0.1 - 14/01/2013 =

* Fixed styles.
* Fixed YouTube widget icon.

= 2.0 - 14/01/2013 =

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

== License ==

Social Count Plus is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published
by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Social Count Plus is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Social Count Plus. If not, see <http://www.gnu.org/licenses/>.
