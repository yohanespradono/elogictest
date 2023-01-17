# Mage2 Module Yohanes Vendor

    ``yohanes/module-vendor``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Module for elogic.co offline exam

Evidences:
- Frontend: https://ibb.co/HDM7FGZ
- Vendor Grid: https://ibb.co/CH373P0
- Vendor Edit: https://ibb.co/G0YB9dQ

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the content of the zip file to `app/code/Yohanes/Vendor`
 - Enable the module by running `php bin/magento module:enable Yohanes_Vendor`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require yohanes/module-vendor`
 - enable the module by running `php bin/magento module:enable Yohanes_Vendor`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications




## Attributes



