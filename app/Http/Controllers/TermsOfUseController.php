<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsOfUseController extends Controller
{
    public function index() {
        return view('pages.terms_of_use.index');
    }
}
