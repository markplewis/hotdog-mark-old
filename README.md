# The Real Hotdog Mark

Source code for [www.therealhotdogmark.com](http://www.therealhotdogmark.com/)

## Development notes

The PHP code in `index.php` is based on this ["PHP quickstart" guide for Google Analytics Reporting API v4](https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php).

1. I installed [Composer](https://getcomposer.org/) (a package manager for PHP) globally by following [these instructions](https://getcomposer.org/doc/00-intro.md#globally).
2. I created a new [Google Clound Platform](https://console.cloud.google.com/) project.
3. Under that project, I created a service account and gave it "Read & Analyze" permissions. It generated a public/private key pair for me in JSON format, which I then downloaded.

**Important**: For security reasons, the service account credentials have not been committed to source control. Before deploying these files to a web server, you'll need to paste the service account credentials into the `service-account-credentials.json` file, then upload this file into a folder above the web root.