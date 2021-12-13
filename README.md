![Woody](woody_github_banner.jpg)

![PullRequest Welcome](https://img.shields.io/badge/PR-welcome-brightgreen.svg?style=flat-square)
![Required WP Version](https://img.shields.io/badge/wordpress->=4.8-blue.svg?style=flat-square)
[![Twitter Follow](https://img.shields.io/twitter/follow/raccourciagency.svg?label=Twitter&style=social)](https://twitter.com/raccourciagency)

---

## :fire: Installation & Usage

### Dependencies

Woody is dependent on 2 paid plugins of the wordpress community. To use woody you must absolutely buy and install :

-   Polylang PRO **version 2.9.0**
-   ACF PRO (Advanced Custom Fields PRO) **version 5.9.1**

These plugins must be uploaded to the **web/app/plugins** directory.

> WARNING: If you are using the Woody PRO version, it's possible to install these dependencies by "composer", but this does not mean you do not have to buy these 2 plugins.

### Configuration

Create a configuration file for each of your sites in "config/sites".<br/>
My first project is called "mywebsite", so I create the file **"config/sites/mywebsite/.env"**.<br/>
Some of these settings must be requested from the Raccourci agency, please contact [support@woody-wordpress.com](mailto:support@woody-wordpress.com)<br/>
Here are the available settings

```yml
DB_NAME='wp_mywebsite'
DB_USER='wp_mywebsite'
DB_PASSWORD='mypassword'
DB_HOST='127.0.0.1:3306'

# Use MEMCACHED_SERVERS or MEMCACHED_HOST/MEMCACHED_PORT
MEMCACHED_SERVERS='127.0.0.1:11211;127.0.0.1:11212'
MEMCACHED_HOST='11211'
MEMCACHED_PORT='11211'

WP_ENV='dev'
WP_MEMORY_LIMIT='256M'
WP_MAX_MEMORY_LIMIT='256M'
WP_POST_REVISIONS='3'
WP_HOME='https://www.mywebsite.com'
WP_GIT_REPOSITORY='git@github.com:organization/mywebsite.git'
FORCE_SSL_ADMIN='false'
EMPTY_TRASH_DAYS='30'

AUTH_KEY=''
SECURE_AUTH_KEY=''
LOGGED_IN_KEY=''
NONCE_KEY=''
AUTH_SALT=''
SECURE_AUTH_SALT=''
LOGGED_IN_SALT=''
NONCE_SALT=''

WOODY_MAINTENANCE='false'
WOODY_MAINTENANCE_ADMIN='false'
WOODY_ACCESS_STAGING='false'
WOODY_ACCESS_LOCKED='false'

WOODY_ACF_GOOGLE_MAPS_KEY=''
WOODY_ACF_PRO_KEY='You must purchase an ACF license'
WOODY_ADMIN_EMAIL=''
WOODY_ADMIN_NAME=''
WOODY_API_LOGIN='Provided by Raccourci Agency'
WOODY_API_PASSWORD='Provided by Raccourci Agency'
WOODY_CLOUDFLARE_ENABLE='false'
WOODY_CLOUDFLARE_TOKEN=''
WOODY_CLOUDFLARE_URL=''
WOODY_CLOUDFLARE_ZONE=''
WOODY_GOOGLE_MAPS_API_KEY='Provided by Raccourci Agency'
WOODY_GOOGLE_MAPS_API_KEY_PROD='Provided by Raccourci Agency'
WOODY_GTM=''
WOODY_IGN_MAPS_API_KEY='Provided by Raccourci Agency'
WOODY_IGN_MAPS_API_KEY_PROD='Provided by Raccourci Agency'
WOODY_IMAGE_WEBP_ENABLE='false'
WOODY_LATITUDE='46.1482363'
WOODY_LONGITUDE='-1.1750544'
WOODY_OPTIONS='Provided by Raccourci Agency'
WOODY_PERMALINK_STRUCTURE='/%postname%/'
WOODY_SMTP_PASSWORD='Provided by Raccourci Agency'
WOODY_SMTP_SENDER='Provided by Raccourci Agency'
WOODY_SMTP_SENDER_NAME='Provided by Raccourci Agency'
WOODY_SMTP_USERNAME='Provided by Raccourci Agency'
WOODY_SSO_ADD_URL_TOKEN='Provided by Raccourci Agency'
WOODY_SSO_CLIENT_ID='Provided by Raccourci Agency'
WOODY_SSO_CLIENT_SECRET='Provided by Raccourci Agency'
WOODY_SSO_SECRET_URL='https://connect.studio.raccourci.fr'
WOODY_TIMEZONE='Europe/Paris'
WOODY_TOURISTIC_MAPS_API_KEY='Provided by Raccourci Agency'
WOODY_TOURISTIC_MAPS_API_KEY_PROD='Provided by Raccourci Agency'
WOODY_TWIG_CACHE_DISABLE='false'
WOODY_VARNISH_CACHING_COOKIE=''
WOODY_VARNISH_CACHING_DEBUG='true'
WOODY_VARNISH_CACHING_ENABLE='false'
WOODY_VARNISH_CACHING_FOCUSRANDOM_TTL='86400'
WOODY_VARNISH_CACHING_FOCUSSHEET_TTL='7200'
WOODY_VARNISH_CACHING_IPS='127.0.0.1:80'
WOODY_VARNISH_CACHING_PURGE_KEY=''
WOODY_VARNISH_CACHING_TTL='2592000'
WOODY_VARNISH_CACHING_TTL_FOCUSRANDOM='86400'
WOODY_VARNISH_CACHING_TTL_FOCUSSHEET='43200'
WOODY_VARNISH_CACHING_TTL_LIVEPAGE='900'
WOODY_VARNISH_CACHING_TTL_WEATHERPAGE='21600'
WOODY_VARNISH_CACHING_TTL_HAWWWAI_SHEET='2592000'
WOODY_VARNISH_CACHING_TTL_HAWWWAI_PLAYLIST='43200'
```

First, install Woody Core via the Composer package manager (Version 2):

```bash
composer self-update --2
composer install
```

Run this command to install your site:

```bash
woody deploy:core
woody deploy:site -s mywebsite
```

To reinstall your site from scratch

> WARNING: it's necessary to empty its database before launching this command

```bash
woody deploy:core
woody deploy:site -s mywebsite -o force
```

To execute the command but without the gulp compilation:

```bash
woody deploy:site -s mywebsite -o no-gulp
```

The commands can be combined by doing:

```bash
woody deploy:site -s mywebsite -o force,no-gulp
```

Here is the list of available ordering options:

-   force
-   speed
-   no-gulp
-   no-cache
-   no-twig
-   no-varnish
-   no-cdn
-   no-install
-   no-updb
-   no-acf
-   no-warm
-   no-sso

These two commands produce the same result. "speed" is a shortcut to all these options

```bash
woody deploy:site -s mywebsite -o speed
woody deploy:site -s mywebsite -o no-install,no-updb,no-acf,no-gulp,no-warm,no-varnish,no-cdn,no-sso
```

## :inbox_tray: Updating

If you want to make changes in dependencies, you must install this command beforehand

```bash
composer update --prefer-source
```

Otherwise use this command regularly to update yourself

```bash
composer update
```

## :surfer: Sass & Gulp

Run the following command to launch the "watch" of your files.

```bash
cd /gulp
yarn watch --site mywebsite
```

The following command is used to trigger the build of assets for the production.

```bash
cd /gulp
yarn build --site mywebsite
```

## :construction: Debug PHP

### In the Chrome console (PHP Console)

Install the PHP Console extension for Chrome
[https://chrome.google.com/webstore/detail/php-console/nfhmhhlpfleoednkpnnnkolmclajemef](https://chrome.google.com/webstore/detail/php-console/nfhmhhlpfleoednkpnnnkolmclajemef)

> WARNING: you must enter the password which is "root".

Then simply call the function :

```php
wd($value);
```

You can add 2 optional parameters:

```php
wd($val, $tag = '');
```

Exemple :

```php
$array = ['color' => 'red'];
wd($array, 'color');
```

### In the current page

There is also the "rcd" function, which allows you to make your own "print_r".

You can add 2 optional parameters:

```php
rcd($val, $exit = false, $pre = true);
```

Exemple :

```php
$array = ['color' => 'red'];
rcd($array, true);
```

## :pill: use WP-CLI

Activate a plugin

```bash
WP_SITE_KEY=mywebsite wp plugin activate hello
```

Import all the SIT (Tourist information system) records of the destination from API (10000 max for the moment)

```bash
WP_SITE_KEY=mywebsite wp woody:hawwwai warm_cache
WP_SITE_KEY=mywebsite wp woody:process async_start
```

Delete all SIT records from the destination

```bash
WP_SITE_KEY=mywebsite wp woody:hawwwai delete_cache
```

Regenerate the canonicals all SIT records

```bash
WP_SITE_KEY=mywebsite wp woody:hawwwai update_canonicals
WP_SITE_KEY=mywebsite wp woody:hawwwai rsdu
```

## :recycle: Recommended VSCode extensions

-   Git Graph
-   BABA-Git Flow
-   EditorConfig for VS Code
-   Beautify
-   Intelephense
-   php cs fixer
-   Sass
-   TODO Highlight
-   Todo Tree
-   Trailing SPaces
-   Twig
-   TWIG pack
-   Bracket Pair Colorizer
-   Composer
-   ACF Snippet
-   Change String Case
-   Dash
-   Project Manager
-   Wordpress Snippets

Install php-cs-fixer and configure the VSCode extension to launch in "OnSave" mode

```bash
wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer
sudo chmod a+x php-cs-fixer
sudo mv php-cs-fixer /usr/local/bin/php-cs-fixer
```

## :metal: Contributors

Thank you to all the people who have already contributed to Woody Core !

For future contributors, please read our [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md)

Header photo by [John Lee on Unsplash](https://unsplash.com/@john_artifexfilms?utm_medium=referral&utm_campaign=photographer-credit&utm_content=creditBadge)<br/>
[![Header photo by John Lee on Unsplash](https://img.shields.io/badge/John%20Lee-black.svg?style=flat-square&logo=unsplash&logoWidth=10)](https://unsplash.com/@john_artifexfilms?utm_medium=referral&utm_campaign=photographer-credit&utm_content=creditBadge)

## :bookmark: License

Woody Core is open-sourced software licensed under the [GPL2](LICENSE).

## :crown: Sponsoring

Woody is a digital ecosystem co-financed by the Regional Tourism Committee of Brittany for [eBreizh Connexion](http://www.ebreizhconnexion.bzh)

![eBreizh Connexion](logo_ebreizh_connexion.png)
