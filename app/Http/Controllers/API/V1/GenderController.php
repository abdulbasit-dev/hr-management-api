<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use HTML5;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GenderController extends Controller
{

    public function __invoke(Request $request)
    {
        $genders = Gender::toArray();
        return $this->jsonResponse(true, __("All Gender"), Response::HTTP_OK, $genders);
    }
}
