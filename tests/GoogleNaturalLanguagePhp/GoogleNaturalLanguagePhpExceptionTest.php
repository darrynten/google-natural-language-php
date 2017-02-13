<?php

namespace DarrynTen\GoogleNaturalLanguagePhp\Tests\GoogleNaturalLanguagePhp;

use DarrynTen\GoogleNaturalLanguagePhp\CustomException;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;
use PHPUnit_Framework_TestCase;

class GoogleNaturalLanguagePhpExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testApiException()
    {
        $this->expectException(CustomException::class);

        new GoogleNaturalLanguage([], 'xxx');
    }

    public function testApiJsonException()
    {
        $this->expectException(CustomException::class);

        throw new CustomException(
            json_encode(
                [
                    'errors' => [
                        'code' => 1,
                    ],
                    'status' => 404,
                    'title' => 'Not Found',
                    'detail' => 'Details',
                ]
            )
        );
    }

    public function testCheapskateTriggerException()
    {
        $this->expectException(CustomException::class);

        $config = [
            'projectId' => 'project-id',
        ];

        $instance = new GoogleNaturalLanguage($config);

        $instance->setCheapskate(true);
        $instance->setText(str_repeat('test ', 1000));
    }
}
