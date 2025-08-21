<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffPubsController extends Controller
{
    //
    public function view()
    {
        return view('staff.pubs.view');
    }
}
