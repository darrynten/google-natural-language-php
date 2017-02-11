<?php

namespace DarrynTen\GoogleNaturalLanguagePhp\Tests\GoogleNaturalLanguagePhp;

use PHPUnit_Framework_TestCase;

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguagePhpException;

class GoogleNaturalLanguagePhpExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testApiException()
    {
        $this->expectException(GoogleNaturalLanguagePhpException::class);

        $language = new GoogleNaturalLanguage([
        ], 'xxx');
    }

    public function testApiJsonException() {
        $this->expectException(GoogleNaturalLanguagePhpException::class);

        throw new GoogleNaturalLanguagePhpException(json_encode([
          'errors' => [
            'code' => 1
          ]
        ]));
    }

    public function testCheapskateTriggerException() {
        $this->expectException(GoogleNaturalLanguagePhpException::class);

        $config = [
            'projectId' => 'project-id'
        ];

        $instance = new GoogleNaturalLanguage($config);

        $instance->setCheapskate(true);
        $instance->setText(str_repeat('test ', 1000));
    }
}

