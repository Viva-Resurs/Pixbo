<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\Models\Client;

class ClientController extends BaseController
{
    public function index() {
        // TODO: Add authorization
        return Client::all()->toArray();
    }
}
