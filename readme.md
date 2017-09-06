# MUTTS-Site #

This repository contains the public-facing MUTTS Website.

### How do I get set up? ###

You need a PHP-capable (5.6+) webserver (e.g. [XAMPP](https://www.apachefriends.org/index.html) for Windows) and [Composer](http://www.getcomposer.org). No database required.

1. Clone this repository into your the document root of your webserver

2. Install dependencies and create config file:
```
composer install
cp config.sample.php config.php
```

3. Edit configuration file for Mailman list server settings (if applicable) - the website will function fine without changing this, you just won't be able to subscribe to any lists