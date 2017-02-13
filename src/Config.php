<?php

namespace DarrynTen\GoogleNaturalLanguagePhp;

use Psr\Cache\CacheItemPoolInterface;

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
    private $projectId;

    /**
     * The type of text.
     *
     * Options are `PLAIN_TEXT` and `HTML`
     *
     * @var string $type
     */
    private $type = 'PLAIN_TEXT';

    /**
     * The encoding
     *
     * Options are `UTF8`, `UTF16`, `UTF32` and `NONE`
     *
     * @var string $encoding
     */
    private $encoding = 'UTF8';

    /**
     * The language
     *
     * If this is not set then it is auto-detected.
     *
     * @var string $language The language in either `en` or `en-ZA` format
     */
    private $language;

    /**
     * Whether or not to use caching.
     *
     * The default is true as this is a good idea.
     *
     * @var boolean $cache
     */
    private $cache = true;

    /**
     * Cheapskate mode - trim text at 1000 chars
     *
     * @var boolean $cheapskate
     */
    private $cheapskate = true;

    /**
     * Custom Auth Cache
     *
     * @var CacheItemPoolInterface $authCache
     */
    private $authCache;

    /**
     * Custom Auth Cache options
     *
     * @var array $authCacheOptions
     */
    private $authCacheOptions;

    /**
     * Custom Auth HTTP Handler
     *
     * @var callable $authHttpHandler
     */
    private $authHttpHandler;

    /**
     * Custom REST HTTP Handler
     *
     * @var callable $httpHandler
     */
    private $httpHandler;

    /**
     * A custom key file for auth
     *
     * @var string $keyFile
     */
    private $keyFile;

    /**
     * A path on disk to the key file
     *
     * @var string $keyFilePath
     */
    private $keyFilePath;

    /**
     * The number of times to retry failed calls
     *
     * @var integer $retries
     */
    private $retries = 3;

    /**
     * The scopes
     *
     * @var array $scopes
     */
    private $scopes;

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
