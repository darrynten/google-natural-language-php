<?php

namespace DarrynTen\GoogleNaturalLanguagePhp\Tests\GoogleNaturalLanguagePhp;

use PHPUnit_Framework_TestCase;
use DarrynTen\AnyCache\AnyCache;

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;

class GoogleNaturalLanguagePhpTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $config = [
            'projectId' => 'project-id'
        ];

        $instance = new GoogleNaturalLanguage($config);
        $this->assertInstanceOf(GoogleNaturalLanguage::class, $instance);
    }

    public function testSet() {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => true,
            'cache' => true,
            // 'authCache' => null,
            // 'authCacheOptions' => ['options'],
            // 'authHttpHandler' => null,
            // 'httpHandler' => null,
            'keyFile' => '{key:1}',
            'keyFilePath' => '.',
            'retries' => 3,
            'scopes' => ['scope'],
        ];

        $instance = new GoogleNaturalLanguage($config);

        $instance->setText('test text');
        $this->assertEquals('test text', $instance->originalText);

        $instance->setEncoding('UTF16');
        $this->assertEquals('UTF16', $instance->config->encoding);

        $instance->setType('HTML');
        $this->assertEquals('HTML', $instance->config->type);

        $instance->setLanguage('en-ZA');
        $this->assertEquals('en-ZA', $instance->config->language);

        $this->assertEquals(true, $instance->config->cheapskate);
        $instance->setCheapskate(false);
        $this->assertEquals(false, $instance->config->cheapskate);
        $instance->setCheapskate(true);

        $this->assertEquals(true, $instance->config->cache);
        $instance->setCache(false);
        $this->assertEquals(false, $instance->config->cache);
        $instance->setCache(true);
    }

    public function testGetEntities() {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
            $config = [
                'projectId' => 'project-id',
                'cheapskate' => true,
                'cache' => true,
            ];

            $instance = new GoogleNaturalLanguage($config);

            $instance->setText('A duck and a cat in a field at night');

            $entities = $instance->getEntities();

            $retrievedEntities = $entities->entities();
            $this->assertInternalType('array', $retrievedEntities);

            $this->assertEquals('duck', $retrievedEntities[0]['name']);
            $this->assertEquals('OTHER', $retrievedEntities[0]['type']);

            $this->assertEquals('cat', $retrievedEntities[1]['name']);
            $this->assertEquals('OTHER', $retrievedEntities[1]['type']);

            $this->assertEquals('field', $retrievedEntities[2]['name']);
            $this->assertEquals('LOCATION', $retrievedEntities[2]['type']);
        }
    }

    public function testGetSyntax() {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
             $config = [
                'projectId' => 'project-id',
                'cheapskate' => true,
                'cache' => true,
            ];

            $instance = new GoogleNaturalLanguage($config);

            $instance->setText('A duck and a cat in a field at night');

            $syntax = $instance->getSyntax();

            $sentences = $syntax->sentences();
            $tokens = $syntax->tokens();

            $this->assertInternalType('array', $sentences);
            $this->assertInternalType('array', $tokens);

            $this->assertEquals('A duck and a cat in a field at night', $sentences[0]['text']['content']);

            $this->assertEquals(0, $sentences[0]['beginOffset']);

            $this->assertEquals('duck', $tokens[1]['text']['content']);
            $this->assertEquals('NOUN', $tokens[1]['partOfSpeech']['tag']);
            $this->assertEquals('SINGULAR', $tokens[1]['partOfSpeech']['number']);
        }
    }

    public function testGetSentiment() {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
             $config = [
                'projectId' => 'project-id',
                'cheapskate' => true,
                'cache' => true,
            ];

            $instance = new GoogleNaturalLanguage($config);

            $instance->setText('A duck and a cat in a field at night');

            $sentiment = $instance->getSentiment();

            $this->assertInternalType('array', $sentiment->documentSentiment());

            $documentSentiment = $sentiment->documentSentiment();

            $this->assertInternalType('double', $documentSentiment['magnitude']);
            $this->assertInternalType('double', $documentSentiment['score']);
        }
    }

    public function testGetAll() {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
             $config = [
                'projectId' => 'project-id',
                'cheapskate' => true,
                'cache' => true,
            ];

            $instance = new GoogleNaturalLanguage($config);

            $instance->setText('A duck and a cat in a field at night');

            $all = $instance->getAll();

            $entities = $all->entities();
            $sentences = $all->sentences();
            $tokens = $all->tokens();
            $sentiment = $all->documentSentiment();
            $language = $all->language();

            $this->assertInternalType('array', $entities);
            $this->assertInternalType('array', $entities[0]);
            $this->assertInternalType('array', $sentences);
            $this->assertInternalType('array', $sentences[0]);
            $this->assertInternalType('array', $tokens);
            $this->assertInternalType('array', $tokens[0]);
            $this->assertInternalType('array', $sentiment);
            $this->assertInternalType('double', $sentiment['magnitude']);
            $this->assertInternalType('string', $language);

            $this->assertEquals('en', $language);

        }
    }
}


