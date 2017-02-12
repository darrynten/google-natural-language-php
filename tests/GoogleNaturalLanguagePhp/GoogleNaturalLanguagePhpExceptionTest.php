<?php

namespace DarrynTen\GoogleNaturalLanguagePhp\Tests\GoogleNaturalLanguagePhp;

use PHPUnit_Framework_TestCase;

use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;
use DarrynTen\GoogleNaturalLanguagePhp\CustomException;

class GoogleNaturalLanguagePhpExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testApiException()
    {
        $this->expectException(CustomException::class);

        $language = new GoogleNaturalLanguage([
        ], 'xxx');
    }

    public function testApiJsonException() {
        $this->expectException(CustomException::class);

        throw new CustomException(json_encode([
          'errors' => [
            'code' => 1
          ]
        ]));
    }

    public function testCheapskateTriggerException() {
        $this->expectException(CustomException::class);

        $config = [
            'projectId' => 'project-id'
        ];

        $instance = new GoogleNaturalLanguage($config);

        $instance->setCheapskate(true);
        $instance->setText(str_repeat('test ', 1000));
    }
}

