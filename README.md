## google-natural-language-php

An unofficial, fully unit tested Google Natural Language PHP client with 
extra sugar.

## Why not just use the official one?

The official one is great, and we actually use it in this package, it
just doesn't quite have the sort of features we needed, so we wrapped
it up with some extra bits.

## What extra features?

### Cost Cutters

The Google Natural Language API costs money. If you're doing anything
with it at scale, you're going to have to keep an eye on your calls to
make sure things aren't running away with you. I learnt this the hard
way. It can get expensive.

That's why we introduced some cost cutting features.

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

### Conveniences

There are a few other conveniences like being able to set the type,
language, encoding etc.

One use case would be running a single instance of text through
multiple language attempts.

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
$language->setType('HTML');
$language->setLanguage('en');
$language->setEncodingType('UTF16');

// Extra features
$language->setCaching(false);
$language->setCheapskate(false);

// Full config options
$config = [
  'projectId' => 'my-awesome-project',     // required
  'authCache' => \CacheItemPoolInterface,  // stores access tokens
  'authCacheOptions' => $array,            // cache config
  'authHttpHandler' => callable(),         // psr-7 auth handler
  'httpHandler' => callable(),             // psr-7 rest handler
  'keyFile' => $json,                      // content
  'keyFilePath' => $string,                // path
  'retries' => 3,                          // default is 3
  'scopes' => $array,                      // app scopes
  'cache' => $boolean,                     // cache
  'cheapskate' => $boolean                 // limit text to 1000 chars
];

// authCache, authCacheOptions, authHttpHandler and httpHandler are not
// currently implemented.
```

See [The Google Cloud Docs](https://googlecloudplatform.github.io/google-cloud-php/#/docs/v0.20.2/naturallanguage/naturallanguageclient)
for more on these options and their usage.

## Options

* `setType($type)` - Either `PLAIN_TEXT` (default) or `HTML`
* `setEncodingType($type)` - Either `UTF8` (default) `UTF16`, `UTF32` or `NONE`
* `setLanguage($language)` - Either ISO (`en`, `es`) or BCP-47 (`en-ZA`, `en-GB`).

If no language is provided then it is autodetected from the text and
is returned with the response.

## Missing Features

Feel free to open a PR!

Usage of Google\Cloud\Storage\StorageObject is presently not possible.

* Custom `authCache` and `authCacheOptions`
* Custom `httpHandler` and `authHttpHandler`

## Test Coverage

Test coverage is 100% but may not be immediately apparent. This is due
to the fact that the prediction service is paid for, and running many
unit tests can become quite expensive.

As a result you need to enable the tests with

```bash
export DO_LIVE_API_TESTS=true
```

before you run `phpunit`.

It is also important to note that tests will run with a transient
cache and as a result no caching persists across tests.

## Roadmap

- [ ] - Get Entities of Type - Will allow the ability to retrieve, for
example, only the People, or only the Locations
- [ ] - Sentiment shortcuts (is positive etc)
- [ ] - Check for types, has location etc
- [ ] - And more!

## Acknowledgements

* Open a PR and put yourself here :)


