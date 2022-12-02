<?php

namespace MallardDuck\Whodis\Exceptions;

use Exception;

class UnknownWhoisException extends Exception
{
    /** @var int    An integer code for the exception. */
    public const CODE = 0;

    /**
     * Basic Exception Constructor
     *
     * @param string         $message  The Exceptions message: this type requires it be related to a missing item.
     * @param int            $code     The user defined exception code.
     * @param null|Exception $previous If present, the previous exception if nested exception.
     */
    public function __construct($message, $code = self::CODE, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
