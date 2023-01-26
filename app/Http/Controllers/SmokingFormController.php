<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenience_store;

class SmokingFormController extends Controller
{
    public function index($lat, $lng, $check){
        $DB_store = new Convenience_store();
        $DB_store->name = "コンビニ";
        $DB_store->lat = $lat;
        $DB_store->lng = $lng;
        $DB_store->check = $check;
        $DB_store->save();
    }
}
