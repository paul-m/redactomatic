Redact-o-Matic
===

What is it?
----

A Twitter anonymizer. (Not really. OK. Maybe. But not.)

That is, it will 'redact' identifying information from any Twitter status update with the hashtag `#redacted`.

Redacted tweets are presented with a link back to the original, and thus hopefully won't violate the Twitter API terms of service.

Redact-o-Matic uses the following PHP libraries and frameworks:

- Slim: http://www.slimframework.com/
- Guzzle: http://guzzlephp.org/
- Doctrine ORM: http://www.doctrine-project.org/projects/orm.html
- PHPUnit: https://github.com/sebastianbergmann/phpunit/
- Composer: http://getcomposer.org/
- SQLite: http://www.sqlite.org/

See it in action here: http://redactomatic.pagodabox.com/

Why?
----

Assignment 3 for a PHP class I'm taking. :-)

Installation
----

For Pagodabox.com hosting, just deploy. It has a Boxfile.

You need Composer. Do the standard Composer things:

- `cd` to project directory.
- `curl -s https://getcomposer.org/installer | php` will install Composer for you.
- `php ./composer.phar -o update` will read composer.json and make sure all the dependencies are set up.

Redact-o-Matic needs the .htaccess file provided by Slim, so copy it over from `vendor/slim/slim/.htaccess` to the root directory.

Set your web server's docroot to the project directory.

If you look at `bootstrap_doctrine.php`, you'll see that Redact-o-Matic uses SQLite as a database for local development. You can change the database settings here. Initially, the schema won't exist, but Doctrine can generate it for you, this way: `./vendor/bin/doctrine orm:schema-tool:update --force`

To Do
----

- More tests.
- Fix Unicode errors.
