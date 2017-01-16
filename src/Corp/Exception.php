<?php
namespace WeChart\Corp;

class Exception
{
    const ERR_MSG_TYPE = 1;

    //const ERR_MSG_TYPE = 2;

    private static $messages = [self::ERR_MSG_TYPE => 'wrong message type'];

    public function __construct($errId)
    {
        throw new \Exception(self::$messages[$errId]);
    }
}