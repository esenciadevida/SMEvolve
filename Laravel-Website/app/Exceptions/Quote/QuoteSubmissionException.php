<?php

namespace App\Exceptions\Quote;

use Exception;

class QuoteSubmissionException extends Exception
{
    public static function alreadySubmitted(): self
    {
        return new self('This quote has already been submitted.');
    }

    public static function notReady(array $missing): self
    {
        return new self('This quote is missing required information to be submitted.');
    }
}
