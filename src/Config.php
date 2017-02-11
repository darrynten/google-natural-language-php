<?php

namespace DarrynTen\GoogleNaturalLanguagePhp;

use DarrynTen\AnyCache\AnyCache;

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguagePhpException;

class Config
{
    public $projectId;

    public $type = 'PLAIN_TEXT';
    public $encoding = 'UTF8';
    public $language;

    public $cache = true;
    public $cheapskate = true;

    public $authCache;
    public $authCacheOptions;
    public $authHttpHandler;
    public $httpHandler;
    public $keyFile;
    public $keyFilePath;
    public $retries;
    public $scopes;

    public function __construct($config)
    {
        // Throw exceptions on essentials
        if (!isset($config['projectId']) || empty($config['projectId'])) {
            throw new GoogleNaturalLanguagePhpException('Missing Google Natural Language Project ID');
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
         *
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

    public function getNaturalLanguageConfig() {
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
