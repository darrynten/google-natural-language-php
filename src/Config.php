<?php

namespace DarrynTen\GoogleNaturalLanguagePhp;

use DarrynTen\GoogleNaturalLanguagePhp\CustomException;

/**
 * GoogleNaturalLanguage Config
 *
 * @category Configuration
 * @package  GoogleNaturalLanguagePhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/google-natural-language-php/LICENSE>
 * @link     https://github.com/darrynten/google-natural-language-php
 */
class Config
{
    /**
     * The project ID
     *
     * @var string $projectId
     */
    public $projectId;

    /**
     * The type of text.
     *
     * Options are `PLAIN_TEXT` and `HTML`
     *
     * @var enum $type
     */
    public $type = 'PLAIN_TEXT';

    /**
     * The encoding
     *
     * Options are `UTF8`, `UTF16`, `UTF32` and `NONE`
     *
     * @var enum $encoding
     */
    public $encoding = 'UTF8';

    /**
     * The language
     *
     * If this is not set then it is auto-detected.
     *
     * @var $language The language in either `en` or `en-ZA` format
     */
    public $language;

    /**
     * Whether or not to use caching.
     *
     * The default is true as this is a good idea.
     *
     * @var boolean $cache
     */
    public $cache = true;

    /**
     * Cheapskate mode - trim text at 1000 chars
     *
     * @var boolean $cheapskate
     */
    public $cheapskate = true;

    /**
     * Custom Auth Cache
     *
     * @var CacheItemPoolInterface $authCache
     */
    public $authCache;

    /**
     * Custom Auth Cache options
     *
     * @var array $authCacheOptions
     */
    public $authCacheOptions;

    /**
     * Custom Auth HTTP Handler
     *
     * @var callable $authHttpHandler
     */
    public $authHttpHandler;

    /**
     * Custom REST HTTP Handler
     *
     * @var callable $httpHandler
     */
    public $httpHandler;

    /**
     * A custom key file for auth
     *
     * @var json $keyFile
     */
    public $keyFile;

    /**
     * A path on disk to the key file
     *
     * @var string $keyFilePath
     */
    public $keyFilePath;

    /**
     * The number of times to retry failed calls
     *
     * @var integer $retries
     */
    public $retries = 3;

    /**
     * The scopes
     *
     * @var array $scopes
     */
    public $scopes;

    /**
     * Construct the config object
     *
     * @param array $config An array of configuration options
     */
    public function __construct($config)
    {
        // Throw exceptions on essentials
        if (!isset($config['projectId']) || empty($config['projectId'])) {
            throw new CustomException('Missing Google Natural Language Project ID');
        } else {
            $this->projectId = (string)$config['projectId'];
        }

        // optionals
        if (isset($config['cheapskate'])) {
            $this->cheapskate = (bool)$config['cheapskate'];
        }

        if (isset($config['cache']) && !empty($config['cache'])) {
            $this->cache = (bool)$config['cache'];
        }

        /**
         * TODO
         
        if (isset($config['authCache']) && !empty($config['authCache'])) {
            $this->authCache = (bool)$config['cache'];
        }

        if (isset($config['authCacheOptions']) && !empty($config['authCacheOptions'])) {
            $this->authCacheOptions = $config['authCacheOptions'];
        }

        if (isset($config['authHttpHandler']) && !empty($config['authHttpHandler'])) {
            $this->authHttpHandler = $config['authHttpHandler'];
        }

        if (isset($config['httpHandler']) && !empty($config['httpHandler'])) {
            $this->httpHandler = $config['httpHandler'];
        }
        *
        */

        if (isset($config['keyFile']) && !empty($config['keyFile'])) {
            $this->keyFile = $config['keyFile'];
        }

        if (isset($config['keyFilePath']) && !empty($config['keyFilePath'])) {
            $this->keyFilePath = $config['keyFilePath'];
        }

        if (isset($config['retries']) && !empty($config['retries'])) {
            $this->retries = $config['retries'];
        }

        if (isset($config['scopes']) && !empty($config['scopes'])) {
            $this->scopes = $config['scopes'];
        }
    }

    /**
     * Retrieves the expected config for the Natural Language API
     *
     * @return array
     */
    public function getNaturalLanguageConfig()
    {
        $config = [
            'projectId' => $this->projectId
        ];

        /**
         * TODO
         *
        if ($this->authCache) {
            $config['authCache'] = $this->authCache;
        }

        if ($this->authCache && $this->authCacheOptions) {
            $config['authCacheOptions'] = $this->authCacheOptions;
        }

        if ($this->authHttpHandler) {
            $config['authHttpHandler'] = $this->authHttpHandler;
        }

        if ($this->httpHandler) {
            $config['httpHandler'] = $this->httpHandler;
        }
        *
        */

        if ($this->keyFile) {
            $config['keyFile'] = $this->keyFile;
        }

        if ($this->keyFilePath) {
            $config['keyFilePath'] = $this->keyFilePath;
        }

        if ($this->retries) {
            $config['retries'] = $this->retries;
        }

        if ($this->scopes) {
            $config['scopes'] = $this->scopes;
        }

        return $config;
    }
}
