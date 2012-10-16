# Automated application test suite

Colibri contains an automated testing suite for your application. It will detect all controllers you have defined and generate "requests" for those controllers.

To use it, make sure the `COLIBRI_SYS_PATH`, `COLIBRI_WEB_PATH` and `COLIBRI_CONF_PATH` constants are correctly defined.

Install PHPUnit (you can use [composer](http://getcomposer.org/); `cd` into the Colibri `sys` folder and call `php composer.phar install` from the command line) and call `phpunit -c ApplicationTestSuite.xml` to run the automated test suite.


## A note about code coverage

This test suite is automatically generated, on the fly, and cannot be considered enough if you really need to test your application logic thouroughly. It does give a starting point however, especially for applications that contain a lot of "public" or "static" content (like a blog application).
