<p align="center">
    <img src="https://media.licdn.com/dms/image/C4D0BAQHP4YO6cY3KMg/company-logo_200_200/0/1519889116930?e=2147483647&v=beta&t=2FLNTD3odaRUxyviQGbFilfHEucyUWbXe8wE2V8IT-w"/>
</p>

# Invoice CFac Groupe

[![Build Status](https://travis-ci.org/invoiceninja/invoiceninja.svg?branch=master)](https://travis-ci.org/invoiceninja/invoiceninja)
[![Docs](https://readthedocs.org/projects/invoice-ninja/badge/?version=latest)](https://invoice-ninja.readthedocs.io/en/latest/?badge=latest)

## [Hosted](https://www.invoiceninja.com) | [Self-Hosted](https://www.invoiceninja.org)

### We're on Slack, join us at [slack.invoiceninja.com](http://slack.invoiceninja.com) or if you like [StackOverflow](https://stackoverflow.com/tags/invoice-ninja/)

Just make sure to add the `invoice-ninja` tag to your question.

#### Note: v5 is now tagged Stable! To upgrade from v4 you need to [install v5](https://invoiceninja.github.io/docs/self-host-installation/) as a separate app and then use the migration tool in the latest version of v4 on Settings > Account Management.

All Pro and Enterprise features from the hosted app are included in the open-code. We offer a $30 per year white-label license to remove the Invoice Ninja branding from client facing parts of the app.

The self-host zip includes all third party libraries whereas downloading the code from GitHub requires using Composer to install the dependencies.

* [Features](https://www.invoiceninja.com/invoicing-features/)
* [User Guide](https://docs.invoiceninja.com/)
* [Support Forum](https://www.invoiceninja.com/forums/forum/support/)
* [StackOverflow](https://stackoverflow.com/tags/invoice-ninja/)

## Referral Program

## Mobile App
* [iPhone](https://itunes.apple.com/us/app/invoice-ninja/id1435514417?ls=1&mt=8)
* [Android](https://play.google.com/store/apps/details?id=com.invoiceninja.flutter)
* [Source Code](https://github.com/invoiceninja/flutter-mobile)

## Installation Options
* [Ansible](https://github.com/invoiceninja/ansible-installer)
* [Self-Host Zip](https://invoice-ninja.readthedocs.io/en/latest/install.html)
* [Docker File](https://hub.docker.com/r/invoiceninja/invoiceninja/)
* [Cloudron](https://cloudron.io/store/com.invoiceninja.cloudronapp.html)
* [Softaculous](https://www.softaculous.com/apps/ecommerce/Invoice_Ninja)
* [Lando](https://github.com/invoiceninja/invoiceninja/issues/2880)
* [Yunohost](https://github.com/YunoHost-Apps/invoiceninja_ynh)

## Recommended Providers
* [Stripe](https://stripe.com/)
* [Postmark](https://postmarkapp.com/)

## Development
* [API Documentation](https://invoice-ninja.readthedocs.io/en/latest/api.html)
* [PHP SDK](https://github.com/invoiceninja/sdk-php)
* [Laminas Framework](https://github.com/alexz707/InvoiceNinjaModule)
* [Custom Module](https://invoice-ninja.readthedocs.io/en/latest/custom_modules.html)

## Third Party Modules
* [Event Scheduler](https://github.com/cytech/Scheduler-InvoiceNinja)
* [Manufacturer Module](https://github.com/dicarlosystems/manufacturer-invoiceninja)
* [Point of Sale](https://github.com/dicarlosystems/pointofsale-invoiceninja)
* [Invoice Design Import/Export](https://github.com/feyst/invoicedesignexport)

> Feel free to email us for help if you're working on a module, we're happy to provide developer support.

## Third Party Tools
* [InvoicePlane Import](https://github.com/turbo124/Plane2Ninja)
* [Toggl Sync](https://github.com/Matth--/toggl-invoiceninja-sync)
* [Shopping Cart](https://github.com/Scifabric/invoiceninjashoppingcart)

## Third Party Developers
* [Bold Compass](https://boldcompass.com/customize-invoice-ninja/)

## Contributing
All contributors are welcome!  
For information on how contribute to Invoice Ninja, please see our [contributing guide](CONTRIBUTING.md).

## Credits
* [Hillel Coren](https://hillelcoren.com/)
* [David Bomba](https://github.com/turbo124)
* [All contributors](https://github.com/invoiceninja/invoiceninja/graphs/contributors)

**Special thanks to:**
* [Troels Liebe Bentsen](https://github.com/tlbdk)
* [Jeramy Simpson](https://github.com/JeramyMywork) - [MyWork](https://www.mywork.com.au)
* [Sigitas Limontas](https://lt.linkedin.com/in/sigitaslimontas)
* [Joshua Dwire](https://github.com/joshuadwire) - [Bold Compass](https://boldcompass.com/)
* [Holger Lösken](https://github.com/codedge) - [codedge](http://codedge.de)
* [Samuel Laulhau](https://github.com/lalop) - [Lalop](http://lalop.co/)
* [Alexander Zamponi](https://github.com/alexz707)
* [Matthieu Calie](https://github.com/Matth--)
* [Christopher Di Carlo](https://github.com/dicarlosystems) - [Di Carlo Systems Inc.](https://www.dicarlosystems.ca)
* [Kristian Feldsam](https://github.com/feldsam) - [FeldHost™](https://www.feldhost.net)
* [Suhas Sunil Gaikwad](https://github.com/Suhas-Gaikwad)
* [Mike Skaggs](https://github.com/titan-fail)

## License
Invoice Ninja is released under the Elastic License 2.0
See [LICENSE](LICENSE) for details.

## to SetUp The Application For A Quick Hosting

Need to install php 7.3 and mysql
## 1 donwload the php version from this URL:

https://windows.php.net/downloads/releases/

## 2 donwload the mysql version from this URL:

https://www.apachefriends.org/fr/download.html


```sh
git clone https://github.com/invoiceninja/invoiceninja/releases/download/v4.5.50/invoiceninja.zip
cp .env.example .env
composer update
php artisan key:generate
```

Please Note: 
Your APP_KEY in the .env file is used to encrypt data, if you lose this you will not be able to run the application.

Run if you want to load sample data, remember to configure .env
```sh
php artisan migrate:fresh --seed && php artisan db:seed && php artisan ninja:create-test-data
```

To run the web server
```sh
php artisan serve 
C:\wamp64\bin\php\php7.0.33\php.exe artisan serve --host=127.0.0.1 --port=8000
```

Please Note: 
if you running both application on visual studio code you must compile them with different port and addresses
and change the path for php version in xampp:solution here (https://stackoverflow.com/questions/64702504/running-php-artisan-serve-command-with-different-php-versions)

```sh
C:\xampp\php73\php.exe artisan serve --host=127.0.0.1 --port=8000 
```

Navigate to (replace localhost with the appropriate domain)
```
http://localhost:8000/setup - To setup your configuration if you did not load sample data.
http://localhost:8000/ - For Administrator Logon
user: small@example.com
pass: password
http://localhost:8000/client/login - For Client Portal
user: user@example.com
pass: password
```


## set up no captcha from this URL on the git hub or the yotub channel:

we added the no captcha to the application to make it anti spam vs bots to access.

setup URL:
https://www.youtube.com/watch?v=v8R0FRkFOmg

documentation URL:
https://github.com/anhskohbo/no-captcha

troubleshooting the error : ERROR: cURL error 60: SSL certificate problem: unable to get local issuer certificate for local pc:(work fine)
https://www.youtube.com/watch?v=f5jQqWvw44U


## Using mailgun to monitore the emails (to add this option):
1- know when your mail are viewed.
2- estimate the tracking email.
3- trouble shoot your email logs.
4- estimate next send to best engage with audience

## to clear all cache use this commend:
```sh
php artisan optimize:clear
```

## to rebuild css and javascrip files use this commend:
```sh
php artisan clear-compiled 
composer dump-autoload
php artisan optimize
```

# to re build the pdf maker : script in the pdf   bowerDir + '/pdfmake/build/pdfmake.js' decomment in the changes and then comment in production
# this is the URL to see: https://arjunphp.com/run-gulp-tasks-laravel-elixir/
npm install --global gulp


# how to fix the SSH key in git hub and the server to download the project 
https://www.youtube.com/watch?v=Irj-2tmV0JM


# For better hosting the application of Jakarta PaaS
# application invoice cfac:
https://www.virtuozzo.com/application-platform-docs/php-application-server-config/

## This Function is to the cron job to send reccuring email
## and if you don't want the output
0 7 * * * curl --silent "http://invoicepro.cfacgroup.com/run_command?command=send-invoices&secret=10101010" > /dev/null


## this is a blogger where images cfac and all entreprise are putted:
https://www.blogger.com/blog/posts/5725059306816087074

email: iheb@cfac.com.tn
