# {{ languageNameEn }} ({{ languageNameLocal }}) Magento2 Language Pack ({{ language }})
This is a Language Pack generated from the [official Magento2 translations project](https://crowdin.com/project/magento-2) at [Crowdin](https://crowdin.com).
The {{ languageNameEn }} ({{ languageNameLocal }}) translations used can be found [here](https://crowdin.com/project/magento-2/{{ link }}).
This translation is usefull for people living in the {{ countryNameEn }} ({{ countryNameLocal }}).

For our other language packs look at the [Magento2Translations](http://magento2translations.github.io/) page.

# Version & progress
This translation is generated from the branch [{{ branch }}](https://crowdin.com/project/magento-2/{{ link }}#/{{ branch }}) at Crowdin and based on the Magento {{ mageVersion }} sourcefiles.
There have been  {{ translationCount }} strings translated of the {{ sourceCount }} strings in the Magento source.

Translation progress:![Progress](http://progressed.io/bar/{{ progress }})

# Installation
## Via composer
To install this translation package with composer you need access to the command line of your server and you need to have [Composer](https://getcomposer.org).
```
cd <your magento path>
composer require magento2translations/language_{{ language|lower }}:dev-master
php bin/magento cache:clean
```
## Manually
To install this language package manually you need access to your server file system.
* Download the zip file [here](https://github.com/Magento2Translations/language_{{ language|lower }}/archive/master.zip).
* Upload the contents to `<your magento path>/app/i18n/magento2translations/language_{{ language|lower }}`.
* The composer files should then be located like this `<your magento path>/app/i18n/magento2translations/{{ language }}/{{ language }}.csv`.
* Go to your Magento admin panel and clear the caches.

#Usage
To use this language pack login to your admin panel and goto `Stores -> Configuration -> General > General -> Locale options` and set the '*locale*' option as '*{{ languageNameEn }} ({{ countryNameEn }})*'

# Contribute
To help push the '*{{ languageNameEn }} ({{ languageNameLocal }}) Magento2 Language Pack ({{ language }})*' forward please goto [this](https://crowdin.com/project/magento-2/{{ link }}) crowdin page and translate the lines.

# Authors
The translations are done by the [official Magento2 translations project](https://crowdin.com/project/magento-2).

Code generation is sponsored by [Wijzijn.Guru](http://www.wijzijn.guru/).