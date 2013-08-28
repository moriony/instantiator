<?php

class PublicStaticMethod
{
    public static function getInstance($arg1, $arg2)
    {
        return new self;
    }
}