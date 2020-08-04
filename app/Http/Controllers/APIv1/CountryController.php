<?php

namespace App\Http\Controllers\APIv1;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryCollection;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function countryList(){
        return new CountryCollection(Country::all());
    }
}
