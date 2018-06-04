<?php

namespace DarrynTen\GoogleNaturalLanguagePhp\Tests\GoogleNaturalLanguagePhp;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use ReflectionClass;

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;

class GoogleNaturalLanguageTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }
  
    public function testConstruct()
    {
        $config = [
            'projectId' => 'project-id'
        ];

        $instance = new GoogleNaturalLanguage($config);
        $this->assertInstanceOf(GoogleNaturalLanguage::class, $instance);
    }

    public function testSet()
    {
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

    public function testGetEntities()
    {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => true,
            'cache' => true,
        ];

        $client = m::mock(LanguageClient::class);

        $client->shouldReceive('analyzeEntities')
            ->once()
            ->andReturn();

        $instance = new GoogleNaturalLanguage($config);

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($instance);
        $reflectedClient = $reflection->getProperty('languageClient');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($instance, $client);

        $instance->setText('A duck and a cat in a field at night');
        $entities = $instance->getEntities();
    }

    public function testGetSyntax()
    {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => true,
            'cache' => true,
        ];

        $client = m::mock(LanguageClient::class);

        $client->shouldReceive('analyzeSyntax')
            ->once()
            ->andReturn();

        $instance = new GoogleNaturalLanguage($config);

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($instance);
        $reflectedClient = $reflection->getProperty('languageClient');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($instance, $client);

        $instance->setText('A duck and a cat in a field at night');
        $entities = $instance->getSyntax();
    }

    public function testGetSentiment()
    {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => true,
            'cache' => true,
        ];

        $client = m::mock(LanguageClient::class);

        $client->shouldReceive('analyzeSentiment')
            ->once()
            ->andReturn();

        $instance = new GoogleNaturalLanguage($config);

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($instance);
        $reflectedClient = $reflection->getProperty('languageClient');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($instance, $client);

        $instance->setText('A duck and a cat in a field at night');
        $entities = $instance->getSentiment();
    }

    public function testGetEntitySentiment()
    {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => true,
            'cache' => true,
        ];

        $client = m::mock(LanguageClient::class);

        $client->shouldReceive('analyzeEntitySentiment')
            ->once()
            ->andReturn();

        $instance = new GoogleNaturalLanguage($config);

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($instance);
        $reflectedClient = $reflection->getProperty('languageClient');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($instance, $client);

        $instance->setText('A duck and a cat in a field at night');
        $entities = $instance->getEntitySentiment();
    }

    public function testGetAll()
    {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => false,
            'cache' => true,
        ];

        $client = m::mock(LanguageClient::class);

        $client->shouldReceive('annotateText')
            ->once()
            ->andReturn();

        $instance = new GoogleNaturalLanguage($config);

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($instance);
        $reflectedClient = $reflection->getProperty('languageClient');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($instance, $client);

        $instance->setText('A duck and a cat in a field at night');
        $entities = $instance->getAll();
    }
}
