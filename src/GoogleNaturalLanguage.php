<?php

namespace DarrynTen\GoogleNaturalLanguagePhp;

use Google\Cloud\NaturalLanguage\NaturalLanguageClient;
use DarrynTen\AnyCache\AnyCache;

/**
 * Google Natural Language Client
 *
 * @category Library
 * @package  GoogleNaturalLanguagePhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/google-natural-language-php/LICENSE>
 * @link     https://github.com/darrynten/google-natural-language-php
 */
class GoogleNaturalLanguage
{
    /**
     * Hold the config option
     *
     * @var Config $config
     */
    public $config;

    /**
     * Keeps a copy of the language client
     *
     * @var object $languageClient
     */
    private $languageClient;

    /**
     * The local cache
     *
     * @var AnyCache $cache
     */
    private $cache;

    /**
     * The text to perform actions on
     *
     * @var string $originalText
     */
    public $originalText;

    /**
     * Construct
     *
     * Bootstraps the config and the cache, then loads the client
     *
     * @param array $config Configuration options
     */
    public function __construct($config)
    {
        $this->config = new Config($config);
        $this->cache = new AnyCache();
        $this->languageClient = new NaturalLanguageClient(
            $this->config->getNaturalLanguageConfig()
        );
    }

    /**
     * Set the desired text
     *
     * @param string $text The text to be analysed
     *
     * @return void
     */
    public function setText($text)
    {
        $this->originalText = $text;
        $this->checkCheapskate();
    }

    /**
     * Get the entity analysis
     *
     * @return mixed
     */
    public function getEntities()
    {
        $cacheKey = '__google_natural_language__entities_' .
            md5($this->originalText) . '_';

        if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->languageClient->analyzeEntities($this->originalText);
            $this->cache->put($cacheKey, serialize($result), 9999999);
        }

        return $result;
    }

    /**
     * Get the sentiment analysis
     *
     * @return mixed
     */
    public function getSentiment()
    {
        $cacheKey = '__google_natural_language__sentiment_' .
            md5($this->originalText) . '_';

        if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->languageClient->analyzeSentiment($this->originalText);
            $this->cache->put($cacheKey, serialize($result), 9999999);
        }

        return $result;
    }

    /**
     * Get the syntax analysis
     *
     * @return mixed
     */
    public function getSyntax()
    {
        $cacheKey = '__google_natural_language__syntax_' .
            md5($this->originalText) . '_';

        if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->languageClient->analyzeSyntax($this->originalText);
            $this->cache->put($cacheKey, serialize($result), 9999999);
        }

        return $result;
    }

    /**
     * Get all analysis
     *
     * @return mixed
     */
    public function getAll()
    {
        $cacheKey = '__google_natural_language__all_' .
            md5($this->originalText) . '_';

        if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->languageClient->annotateText($this->originalText);
            $this->cache->put($cacheKey, serialize($result), 9999999);
        }

        return $result;
    }

    /**
     * After 1000 characters google charges for a new evaluation
     *
     * Set `cheapskate` in your config to false to turn this off
     *
     * Default is on to save cash
     *
     * @throws CustomException
     * @return void
     */
    private function checkCheapskate()
    {
        if ($this->config->cheapskate === false) {
            return;
        }
        
        if (strlen($this->originalText) > 999) {
            throw new CustomException(
                'Text too long. 1000+
                Characters incurrs additional charges. You can set
                `cheapskate` to false in config to disable this
                guard. Additional charges per 1000 Characters.'
            );
        }
    }

    /**
     * Sets the document type
     *
     * @param string $type Either `HTML` or `PLAIN_TEXT`
     *
     * @return void
     */
    public function setType($type)
    {
        if (Validation::isValidType($type)) {
            $this->config->type = $type;
        }
    }

    /**
     * Sets the encoding
     *
     * @param string $encoding Must be UTF8, UTF16, UTF32 or NONE
     *
     * @return void
     */
    public function setEncoding($encoding)
    {
        if (Validation::isValidEncoding($encoding)) {
            $this->config->encoding = $encoding;
        }
    }

    /**
     * Set the language. Either `en` `es` (ISO) or `en-ZA` `en-GB`
     *
     * @param string $language The desired language
     *
     * @return void
     */
    public function setLanguage($language)
    {
        if (Validation::isValidLanguageRegex($language)) {
            $this->config->language = $language;
        }
    }

    /**
     * Enable and disable cheapskate mode (trimming @ 1000 chars)
     *
     * @param boolean $value The state
     *
     * @return void
     */
    public function setCheapskate($value)
    {
        $this->config->cheapskate = (bool)$value;
    }

    /**
     * Enable and disable internal cache
     *
     * @param boolean $value The state
     *
     * @return void
     */
    public function setCache($value)
    {
        $this->config->cache = (bool)$value;
    }
}
