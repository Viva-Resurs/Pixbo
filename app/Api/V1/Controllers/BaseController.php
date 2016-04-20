<?php
namespace App\Api\V1\Controllers;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use JWTAuth;

class BaseController extends Controller
{
    use Helpers;

    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
}