## google-natural-language-php

An unofficial Google Natural Language PHP client with extra sugar.

### Why not just use the official one?

The official one is great, and we actually use it in this package, it
just doesn't quite have the sort of features we needed, so we wrapped
it up with some extra bits

## What extra features?

### Cost Cutters

The Google Natural Language API costs money. If you're doing anything
with it at scale, you're going to have to keep an eye on your calls to
make sure things aren't running away with you. I learnt this the hard
way.

#### Caching Requests

By default this package caches your requests, something you would have
to usually do yourself.

It caches using a framework-agnostic approach, whereby it leverages any
host frameworks caching mechanism, and falls back to a temporary cache
if there is no cache available.

The supported frameworks are detailed in the [AnyCache](https://github.com/darrynten/any-cache) project.

Examples include Laravel, Symfony, Doctrine, Psr6 and more.

This feature is on by default and can easily be disabled.

#### Cheapskate Mode

While not immediately clear, the Google Natural Language API charges per 1000 characters.

We've added "cheapskate mode" that, if set, automatically truncates the 
desired text, saving you another credit.

This feature is on by default and can easily be disabled.

## Usage

```php
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;

// Config options
$config = [
  'projectId' => 'my-awesome-project'  // At the very least
];

// Make a processor
$language = new GoogleNaturalLanguage($config);

// Set text
$text = 'Google Natural Language processing is awesome!';
$language->setText($text);

// Get stuff
$language->getEntities();
$language->getSyntax();
$language->getSentiment();

// Get all stuff
$language->getAll();

// Set optional things
$this->setType('HTML');
$this->setLanguage('en');
$this->setEncodingType('UTF16');

// Extra features
$this->setCaching(false);
$this->setCheapskate(false);

// Full config options
$config = [
  'projectId' => 'my-awesome-project',     // required
  'authCache' => \CacheItemPoolInterface,  // stores access tokens
  'authCacheOptions' => $array,            // cache config
  'authHttpHandler' => callable(),         // psr-7 auth handler
  'httpHandler' => callable(),             // psr-7 rest handler
  'keyFile' => $json,                      // content
  'keyFilePath => $string,                 // path
  'retries' => 3,                          // default is 3
  'scopes' => $array,                      // app scopes
  'cache' => $boolean,                     // cache
  'cheapskate' => $boolean                 // limit text to 1000 chars
];
```

See [The Google Cloud Docs](https://googlecloudplatform.github.io/google-cloud-php/#/docs/v0.20.2/naturallanguage/naturallanguageclient)
for more on these options and their usage.

## Options

* `setType($type)` - Either `PLAIN_TEXT` (default) or `HTML`
* `setEncodingType($type)` - Either `UTF8` (default) `UTF16`, `UTF32` or `NONE`
* `setLanguage($language)` - Either ISO (`en`, `es`) or BCP-47 (`en-ZA`, `en-GB`).

If none is provided then it is autodetected

## Missing Features

Feel free to open a PR!

Usage of Google\Cloud\Storage\StorageObject is presently not possible.

Custom authCache and authCacheOptions

Custom httpHandler and authHttpHandler
