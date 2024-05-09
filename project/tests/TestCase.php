<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
