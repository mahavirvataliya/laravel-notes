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

    public function view(Request $request)
    {
       $noteidstag = NoteTag::select('note_id')->where('tag_id',$request->id)->get();
       
       if(!empty($noteidstag)){
        foreach ($noteidstag as $notetag) {
            # code...
            $nntag[]=$notetag->note_id;
        }
       if(!empty($nntag)){
        $notes = Note::where('user_id', auth()->user()->id)
                        ->orderBy('updated_at', 'DESC')
                        ->find($nntag);
        $snpms = SharedNote::where('suser_email', auth()->user()->email)
                        ->whereIn('note_id',$nntag)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
                    }
                    else{
                        $notes = Note::where('user_id', auth()->user()->email)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
            $snpms = SharedNote::where('suser_email', auth()->user()->id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
                    }
        }
        else{
             $notes = Note::where('user_id', auth()->user()->email)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
            $snpms = SharedNote::where('suser_email', auth()->user()->id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        }
       $snotes = array();
        foreach ($snpms as $snpm) {
            # code...
            $ssnotes = Note::where('id', $snpm->note_id)
                        ->get();
            if(!$ssnotes->isEmpty())
                $snotes[] = $ssnotes[0];
        }
        $tags = Tag::all();
        return view('tags.tagview', compact('notes','snpms','snotes','tags'));
    }

}
