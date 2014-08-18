Symfony EmberJS Edition
========================

Welcome to the Symfony EmberJS Edition - a fully-functional Symfony2
application that you can use as the skeleton for your new applications.

It owes a lot to:
[FOSRestBundle][14]

http://williamdurand.fr/2012/08/02/rest-apis-with-symfony2-the-right-way/

http://welcometothebundle.com/symfony2-rest-api-the-best-2013-way/

This document contains information on how to download, install, and start
using Symfony. For a more detailed explanation, see the [Installation][1]
chapter of the Symfony Documentation.



1) Installing Dependencies
----------------------------------

npm install -g bower
npm install -g ember-precompile


2) Installing the EmberJS Edition
----------------------------------

When it comes to installing the Symfony EmberJS Edition, you have the
following options.

### Use Composer (*recommended*)

As Symfony uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new Symfony application:

    php composer.phar create-project ucsf-ckm/symfony-emberjs-edition path/to/install

Composer will install Symfony and all its dependencies under the
`path/to/install` directory.

### Download an Archive File

To quickly test Symfony, you can also download an [archive][3] of the EmberJS
Edition and unpack it somewhere under your web server root directory.

If you downloaded an archive "without vendors", you also need to install all
the necessary dependencies. Download composer (see above) and run the
following command:

    php composer.phar install

3) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path-to-project/web/config.php

If you get any warnings or recommendations, fix them before moving on.

4) Browsing the Demo Application
--------------------------------

Congratulations! You're now ready to use Symfony.

From the `config.php` page click on the "Configure your
Symfony Application online" link of the `config.php` page.

Setup your database connection - use sqlite for a fast demo.

Create the database schema and add some sample data:

    php app/console doctrine:schema:create --env=dev
    php app/console doctrine:fixtures:load --env=dev

To see a real-live EmberJS in Symfony page in action, access the following page:

    web/app_dev.php/

To browse your new API documentation visit:

    web/app_dev.php/api/doc/

And to see the API in action

    web/app_dev.php/api/v1/products
    web/app_dev.php/api/v1/products/1.json
    web/app_dev.php/api/v1/products/1.xml


What's inside?
---------------

The Symfony EmberJS Edition is configured with the following defaults:

  * Twig is the only configured template engine;

  * Doctrine ORM/DBAL is configured;

  * Swiftmailer is configured;

  * Annotations for everything are enabled.

  * FOSRest is configured

  * Bower is configured

  * Assetic with ember-precompile is configured

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * [**AsseticBundle**][12] - Adds support for Assetic, an asset processing
    library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev/test env) - Adds code generation
    capabilities

  * [**FOSRestBundle**][14] - Adds suport for rest API

  * [**NelmioApiDocBundle**][15] - Generates API Docs

  * [**FOSJsRoutingBundle**][16] - Exposes routes in JavaScript

  * [**SpBowerBundle**][17] - Downloads bower dependencies

  * **AcmeApiBundle** (in dev/test env) - A demo bundle with example code for building
  an EmberJS friendly API

  * **AcmeEmberBundle** (in dev/test env) - A demo bundle with example code for organizing and
  EmberJS application

All libraries and bundles included in the Symfony EmberJS Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  http://symfony.com/doc/2.4/book/installation.html
[2]:  http://getcomposer.org/
[3]:  http://symfony.com/download
[4]:  http://symfony.com/doc/2.4/quick_tour/the_big_picture.html
[5]:  http://symfony.com/doc/2.4/index.html
[6]:  http://symfony.com/doc/2.4/bundles/SensioFrameworkExtraBundle/index.html
[7]:  http://symfony.com/doc/2.4/book/doctrine.html
[8]:  http://symfony.com/doc/2.4/book/templating.html
[9]:  http://symfony.com/doc/2.4/book/security.html
[10]: http://symfony.com/doc/2.4/cookbook/email.html
[11]: http://symfony.com/doc/2.4/cookbook/logging/monolog.html
[12]: http://symfony.com/doc/2.4/cookbook/assetic/asset_management.html
[13]: http://symfony.com/doc/2.4/bundles/SensioGeneratorBundle/index.html
[14]: https://github.com/FriendsOfSymfony/FOSRestBundle
[15]: https://github.com/nelmio/NelmioApiDocBundle
[16]: https://github.com/FriendsOfSymfony/FOSJsRoutingBundle
[17]: https://github.com/Spea/SpBowerBundle
