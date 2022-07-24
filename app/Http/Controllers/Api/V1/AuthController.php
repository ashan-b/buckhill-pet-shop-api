<?php

use App\Http\Controllers\AppBaseController;

class AuthController extends AppBaseController
{
    public function __construct()
    {
    }

    public function testRoute(){
        return "Test route.";
    }
}
