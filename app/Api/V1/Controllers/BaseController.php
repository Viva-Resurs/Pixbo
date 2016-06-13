<?php
namespace App\Api\V1\Controllers;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions;

class BaseController extends Controller
{
    use Helpers;

    protected $user;
    protected $exception;

    public function __construct()
    {
       $this->user = $this->getUser();
    }

    public function getUser()
    {
        $user = false;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }
        finally {
            return $user;
        }

    }
}
