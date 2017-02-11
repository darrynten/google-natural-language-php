<?php

namespace DarrynTen\GoogleNaturalLanguagePhp;

use Google\Cloud\NaturalLanguage\NaturalLanguageClient;
use GuzzleHttp\Client;
use DarrynTen\AnyCache\AnyCache;

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguagePhpException;
use DarrynTen\GoogleNaturalLanguagePhp\Validator;
use DarrynTen\GoogleNaturalLanguagePhp\Config;

class GoogleNaturalLanguage {

  public $config;
  private $_languageClient;
  private $_cache;

  public $entities;
  public $sentiment;
  public $syntax;

  public $all;

  public $originalText;

  public function __construct($config) {
    $this->config = new Config($config);
    $this->_cache = new AnyCache();

    $this->_languageClient = new NaturalLanguageClient($this->config->getNaturalLanguageConfig());
  }

  public function setText($text) {
    $this->originalText = $text;
    $this->_checkCheapskate();
  }

  public function getEntities() {
    $cacheKey = '__google_natural_language__entities_' . md5($this->originalText) . '_';

    if (!$result = unserialize($this->_cache->get($cacheKey))) {
      $result = $this->_languageClient->analyzeEntities($this->originalText);
      $this->_cache->put($cacheKey, serialize($result), 9999999);
    }

    return $result;
  }

  public function getSentiment() {
    $cacheKey = '__google_natural_language__sentiment_' . md5($this->originalText) . '_';

    if (!$result = unserialize($this->_cache->get($cacheKey))) {
      $result = $this->_languageClient->analyzeSentiment($this->originalText);
      $this->_cache->put($cacheKey, serialize($result), 9999999);
    }

    return $result;
  }

  public function getSyntax() {
    $cacheKey = '__google_natural_language__syntax_' . md5($this->originalText) . '_';

    if (!$result = unserialize($this->_cache->get($cacheKey))) {
      $result = $this->_languageClient->analyzeSyntax($this->originalText);
      $this->_cache->put($cacheKey, serialize($result), 9999999);
    }

    return $result;
  }

  public function getAll() {
    $cacheKey = '__google_natural_language__all_' . md5($this->originalText) . '_';

    if (!$result = unserialize($this->_cache->get($cacheKey))) {
      $result = $this->_languageClient->annotateText($this->originalText);
      $this->_cache->put($cacheKey, serialize($result), 9999999);
    }

    return $result;
  }

  /**
   * After 1000 characters google charges for a new evaluation
   *
   * Set `cheapskate` in your config to false to turn this off
   *
   * Default is on to save cash
   */
  private function _checkCheapskate() {
    if (strlen($this->originalText) > 999) {
      if ($this->config->cheapskate === true) {
        throw new GoogleNaturalLanguagePhpException('Text too long. 1000+ Characters incurrs additional charges. You can set `cheapskate` to false in config to disable this guard. Additional charges are per 1000 Characters.');
      }
    }
  }

  public function setType($type) 
  {
      if (Validation::isValidType($type)) {
          $this->config->type = $type;
      }
  }

  public function setEncoding($encoding) 
  {
      if (Validation::isValidEncoding($encoding)) {
          $this->config->encoding = $encoding;
      }
  }

  public function setLanguage($language)
  {
      if (Validation::isValidLanguageRegex($language)) {
          $this->config->language = $language;
      }
  }

  public function setCheapskate($value) {
      $this->config->cheapskate = (bool)$value;
  }

  public function setCache($value) {
      $this->config->cache = (bool)$value;
  }

}



