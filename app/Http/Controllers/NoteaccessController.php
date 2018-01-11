<?php

namespace App\Http\Controllers;
use App\Note;
use Illuminate\Http\Request;

class NoteaccessController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

}
