<?php

namespace App\Http\Controllers;

class FallbackController extends Controller {
    public function __invoke() {
        return view('errors.404');
    }
}
