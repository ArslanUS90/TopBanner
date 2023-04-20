# TopBanner

### Features
*   It displays an advertising section on the top of your web pages.
*   This advertising section provides a clickable link to open and explore more about the new features or sales/discounts/offers.
*	Once the user closes the top banner by clicking on the cross (X) button, then the top banner will not appear again on the same browser for users.
*	Admin can create new top banners to display on webpages and he can set their duration for advertisement.
*	Admin can change/create theme templates for top banners.

## Installation

1. Please run the following command
```shell
composer require arslanfarrukh/top-banner
```

2. Update the composer if required
```shell
composer update
```

3. Enable module
```shell
php bin/magento module:enable ArslanFarrukh_Core
php bin/magento module:enable ArslanFarrukh_TopBanner
php bin/magento setup:upgrade
php bin/magento cache:clean
php bin/magento cache:flush
```
4.If your website is running in product mode the you need to deploy static content and
then clear the cache
```shell
php bin/magento setup:static-content:deploy
php bin/magento setup:di:compile
```



#####This extension is compatible with all the versions of Magento 2.3.* and 2.4.*.
###Tested on following instances:
#####multiple instances i.e. 2.3.7-p3 and 2.4.5-p1
