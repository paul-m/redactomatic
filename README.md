Redact-o-Matic
===

What is it?
----

A Twitter anonymizer. (Not really.)

That is, it will 'redact' identifying information from any Twitter status update with the hashtag `#redacted`.

Redacted tweets are presented with a link back to the original, and thus hopefully won't violate the Twitter API terms of service.

Redact-o-Matic uses the following PHP libraries and frameworks:

- Slim
- Guzzle
- Doctrine
- PHPUnit
- Composer

Why?
----

Assignment 3 for a PHP class I'm taking. :-)

Installation
----

You need Composer. Do the standard Composer things:

- `cd` to project directory.
- `curl -s https://getcomposer.org/installer | php` will install Composer for you.
- `php ./composer.phar -o update` will make sure all the dependencies are set up.

Redact-o-Matic needs the .htaccess file provided by Slim, so copy it over from `vendor/slim/slim/.htaccess` to the root directory.

Set your web server's docroot to the project directory.

Change the database credentials in `bootstrap_doctrine.php`

And then try it out.

To Do
----

- More (any) tests.
- Fix Unicode errors.
