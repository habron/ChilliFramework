<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

/**
 * Url exception
 * @author ondra
 */
class UrlException extends Exception
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null) {        
        parent::__construct($message, $code, $previous);
    }
}
