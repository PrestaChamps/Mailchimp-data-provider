Mailchimp data provider for Yii2
================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist prestachamps/mailchimp-data-provider "~1.0"
```

or add

```
"prestachamps/mailchimp-data-provider": "~1.0"
```

to the require section of your `composer.json` file.

Usage
------------

```php
        $dataProvider = new MailchimpDataProvider([
            'apiKey' => 'API_KEY', // you can concat the token and the dc with a "-" to pass the dc in one line
            'path' => 'batches',
            'entity' => 'batches',
        ]);
```
