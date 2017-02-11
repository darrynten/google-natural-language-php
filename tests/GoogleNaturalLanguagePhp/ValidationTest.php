<?php

namespace DarrynTen\GoogleNaturalLanguagePhp\Tests;

use PHPUnit_Framework_TestCase;

use DarrynTen\GoogleNaturalLanguagePhp\Validation;
use DarrynTen\GoogleNaturalLanguagePhp\GoogleNaturalLanguage;

class ValidationTest extends PHPUnit_Framework_TestCase
{
    public function testValidEncoding()
    {
        $this->assertTrue(Validation::isValidEncoding('UTF16'));
    }

    public function testValidType()
    {
        $this->assertTrue(Validation::isValidType('HTML'));
    }

    public function testValidLanguage()
    {
        $this->assertTrue(Validation::isValidLanguageRegex('en'));
        $this->assertTrue(Validation::isValidLanguageRegex('en-ZA'));
    }

    public function testInvalidEncoding()
    {
        $this->assertFalse(Validation::isValidEncoding('FOO'));
    }

    public function testInvalidType()
    {
        $this->assertFalse(Validation::isValidType('BAR'));
    }

    public function testInvalidLanguage()
    {
        $this->assertFalse(Validation::isValidLanguageRegex('BAR'));
    }
}
