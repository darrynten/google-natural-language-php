<?php
/**
 * GoogleNaturalLanguage Validation
 *
 * @category Validation
 * @package  GoogleNaturalLanguagePhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/google-natural-language-php/LICENSE>
 * @link     https://github.com/darrynten/google-natural-language-php
 */

namespace DarrynTen\GoogleNaturalLanguagePhp;

class Validation
{
    /**
     * The valid encoding types
     *
     * @var array $validEncodings
     */
    protected static $validEncodings = [
        'UTF8',
        'UTF16',
        'UTF32',
        'NONE',
    ];

    /**
     * The valid text types
     *
     * @var array $validTypes
     */
    protected static $validTypes = [
        'PLAIN_TEXT',
        'HTML',
    ];

    /**
     * A valid ISO language regex (en)
     *
     * @var regex $validISOLanguageRegex 2 characters
     */
    protected static $validISOLanguageRegex = '/^[a-z]{2}$/';

    /**
     * A valid BCP-47 language regex (en-ZA)
     *
     * @var regex $validBCP47LanguageRegex Two lowecase, dash, 2 uppercase
     */
    protected static $validBCP47LanguageRegex = '/^[a-z]{2}\-[A-Z]{2}$/';

    /**
     * Check if a type is valid
     *
     * @param string $type The type to check
     *
     * @return boolean
     */
    public static function isValidType($type)
    {
        return in_array($type, self::$validTypes);
    }

    /**
     * Check if an encoding is valid
     *
     * @param string $type The type to check
     *
     * @return boolean
     */
    public static function isValidEncoding($type)
    {
        return in_array($type, self::$validEncodings);
    }

    /**
     * Check if a string is a possible language string.
     *
     * Not the best but better than nothing. Can be expanded
     * upon.
     *
     * Accepts ISO (en, es, de) and BCP-47 (en-ZA, en-GB)
     *
     * @param string $language The language to check
     *
     * @return boolean
     */
    public static function isValidLanguageRegex($language)
    {
      $match = false;

      if (preg_match(self::$validISOLanguageRegex, $language)) {
          $match = true;
      }

      if (preg_match(self::$validBCP47LanguageRegex, $language)) {
          $match = true;
      }

      return $match;
    }
}
