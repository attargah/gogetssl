<?php

namespace Tests;


use PHPUnit\Framework\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
    public function getConfig()
    {
        return include(__DIR__.'/../config/gogetssl.php');
    }

}

