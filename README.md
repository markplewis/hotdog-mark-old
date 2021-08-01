# The Real Hotdog Mark

Source code for [www.therealhotdogmark.com](http://www.therealhotdogmark.com/)

## Development notes

The code in `index.php` is based on this ["PHP quickstart" guide for Google Analytics Reporting API v4](https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php).

This website uses the Google Analytics API to track the number of unique visitors. This required me to create a [Google Clound Platform](https://console.cloud.google.com/) project with an associated service account. I then had to add the service account to my [Google Analytics](https://analytics.google.com/) account.

**Important**: For security reasons, the service account credentials have not been committed to source control. Before deploying these files to a web server, you'll need to paste the service account credentials into the `service-account-credentials.json` file, then upload this file into a folder above the web root.
## Getting started

1. [Follow these instructions](https://getcomposer.org/doc/00-intro.md#locally) to install [Composer](https://getcomposer.org/) locally, into the project's root directory.
2. Run `mv composer.phar composer` to rename the Composer file.
3. Run `php composer install` to install the project's dependencies.
4. Run `php -v` and make sure that you have PHP version 7.2.5 or higher installed. The web server that you deploy these files to will also need to be running this version of PHP or higher.
5. Run `php -S localhost:9000` to start a local PHP development server.

## Upgrading dependencies

1. Run `php composer outdated` to check for available updates.
2. Run `php composer update` to update the dependencies.