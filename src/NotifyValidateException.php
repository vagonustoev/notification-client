<?php

namespace NotificationClient;

use Throwable;

class NotifyValidateException extends \Exception

{
    public function __construct(string $message, int $code = 422, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
