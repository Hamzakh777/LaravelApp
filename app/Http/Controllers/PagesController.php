<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $title = 'Welcome to laravel';
        // return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about() {
        $title = 'About us';
        return view('pages.about', compact('title'));
    }

    public function services() {
        #if you want to pass multiple values you have to use an array
        $data = array(
            'title' => 'Services',
            'services' => [
                'Web design',
                'programming',
                'Maintenance'
            ]
        );
        #->with can be used to pass an array of values, like the following, passing only the variable 'array'
        return view('pages.services')->with($data);
    }
}

/*
    #we use compact to pass values from the controller
    #or we can use ->with('something here')
*/