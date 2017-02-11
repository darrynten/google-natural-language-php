<?php
/**
 * Google Natural Language API Exception
 *
 * @category Exception
 * @package  GoogleNaturalLanguagePhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/google-natural-language-php/LICENSE>
 * @link     https://github.com/darrynten/google-natural-language-php
 */

namespace DarrynTen\GoogleNaturalLanguagePhp;

use \Exception;

/**
 * Custom exception for Clarifai
 *
 * @package Clarifai
 */
class GoogleNaturalLanguagePhpException extends Exception
{

    /**
     * @inheritdoc
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        // Construct message from JSON if required.
        if (substr($message, 0, 1) === '{') {
            $messageObject = json_decode($message);
            $message = $messageObject->status . ': ' . $messageObject->title . ' - ' . $messageObject->detail;
            if (!empty($messageObject->errors)) {
                $message .= ' ' . serialize($messageObject->errors);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
