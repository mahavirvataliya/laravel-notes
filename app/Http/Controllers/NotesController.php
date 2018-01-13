<?php

namespace App\Http\Controllers;

use App\Note;
use App\SharedNote;
use App\User;
use App\Tag;
use App\NoteTag;
use Auth;
use Illuminate\Http\Request;
use DB; 
class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $notes = Note::where('user_id', auth()->user()->id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        $snpms = SharedNote::where('suser_email', auth()->user()->email)
                        ->orderBy('updated_at', 'DESC')
                        ->get();

       $snotes = array();
        foreach ($snpms as $snpm) {
            # code...
            $ssnotes = Note::where('id', $snpm->note_id)
                        ->get();
            if(!$ssnotes->isEmpty())
                $snotes[] = $ssnotes[0];
        }
        
        return view('notes.index', compact('notes','snpms','snotes'));
    }

    public function create()
    {
        $tags  = Tag::all();
        return view('notes.create',compact('tags'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required'
        ]);

        $note = Note::create([
            'user_id' => $request->user()->id,
            'title'   => $request->title,
            'slug'    => str_slug($request->title) . str_random(10),
            'body'    => $request->body
        ]);


        $tags="";
        if(!empty($request->check_list)){
        // Loop to store and display values of individual checked checkbox.
            foreach($request->check_list as $tagname){
               $iid = DB::table('tags')->select('id')->where('tagname',$tagname)->first()->id;
               $notetag = NoteTag::create([
                    'tag_id' => $iid,
                    'note_id'   => $note->id,
                    'slug'    => str_slug($tagname) . str_random(10)
                ]);

                $tags=$tags.$tagname."</br>";
            }
        }
       /*  session_start();
        $_SESSION["status_delete"] = "Note Deleted with Title : ".$tags;*/
        return redirect('/');
    }

    public function delete(Note $note)
    {
        Note::find($note)->delete();
        SharedNote::where('note_id', $note->id)->delete();
        NoteTag::where('note_id',$note->id)->delete();
        session_start();
        $_SESSION["status_delete"] = "Note Deleted with Title : ".$note->title;
        return redirect('/');
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function View(Note $note)
    {
        $snpms = SharedNote::where('note_id', $note->id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        $user = User::where('id',$note->user_id)->get();
        $username[] = $user[0]->name;
        $username[] = $user[0]->email;

        $notetags  = NoteTag::where('note_id',$note->id)->get();
        foreach ($notetags as $notetag) {
            # code...
            $tagnames[] = Tag::select('tagname')->where('id',$notetag->tag_id)->first()->tagname;
        }
        return view('notes.view', compact('note','snpms','username','tagnames'));
    }

    public function update(Request $request, Note $note)
    {
        $note->title = $request->title;
        $note->body = $request->body;

        $note->save();

        return 'Saved!';
    }
}
