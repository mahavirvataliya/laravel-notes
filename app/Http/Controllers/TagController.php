<?php

namespace App\Http\Controllers;
use App\Note;
use App\SharedNote;
use App\User;
use App\Tag;
use App\NoteTag;
use Auth;

use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	$tags = Tag::all();
        return view('tags.index', compact('tags'));
    }
    public function store(Request $request)
    {
        
        $tag = Tag::create([
            'tagname' => $request->tagname
        ]);
        return redirect('/tags');
    }
    public function delete(Request $request)
    {
    	$tag = Tag::where('id',$request->tagid)->get();
    	$tagname = $tag[0]->tagname;
        Tag::find($tag)->delete();   
        session_start();
        $_SESSION["tag_delete"] = "Tag Deleted with Name : ".$tagname;
        return redirect('/tags');
    }

}
