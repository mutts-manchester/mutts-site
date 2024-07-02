# MUTTS-Site #

This repository contains the public-facing MUTTS Website.

### How do I get set up? ###

You need PHP (5.6+) and [Composer](http://www.getcomposer.org). No database required.
This project uses twig version ^1.34, which is not compatible with modern versions of PHP and contains deprecated functionality. You will need to set up a compatible version of php in your local environment.

1. Clone this repository into your the document root of your webserver

2. Install dependencies and create config file:

    ```
    composer install && cp config.sample.php config.php
    ```

3. *optional* Set `$twigCaching` in `config.php` to **false** to disable caching of templates to see your changes quicker when developing

4. Run development server:

    ```
    php -S localhost:8000
    ```