<?php

namespace App\Http\Controllers;

use App\Note;
use App\SharedNote;
use App\User;
use Auth;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of all notes.
     *
     * @return \Illuminate\Http\Response
     */
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
            $snotes[] = $ssnotes[0];
        }
        

        return view('notes.index', compact('notes','snpms','snotes'));
    }

    /**
     * Show the form for creating a new note.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created note in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect('/');
    }

    public function storeshareNote(Request $request)
    {
       /* $this->validate($request, [
            'suser_email' => 'required'
        ]);*/
        
         $perm = $request->noteaccess;
        if($perm ==='owner'){
            $owner = true;
            $edit_only=false;
            $share_only=false;
        }
        elseif ($perm==='edit_only') {
            # code...
            $owner = false;
            $share_only=false;
            $edit_only=true;
        }
        elseif ($perm==='share_only') {
            # code...
            $share_only=true;
            $owner = false;
            $edit_only=false;
        }
        else{
            $owner = false;
            $share_only=false;
            $edit_only=false;
        }

        $sharednote = SharedNote::create([
            'note_id' => $request->note_id,
            'suser_email' => $request->suser_email,
            'owner'   => $owner,
            'edit_only'    => $edit_only,
            'share_only'    => $share_only
        ]);

        return redirect('/');
    }

     public function delete(Note $note)
    {
        Note::find($note)->delete();
        session_start();
        $_SESSION["status_delete"] = "Deleted";
        return redirect('/');
    }

    /**
     * Show the form for editing the specified note.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function View(Note $note)
    {

        return view('notes.view', compact('note'));
    }

    public function share(Note $note)
    {
        $users = User::all()->except(Auth::id());
        return view('notes.share', compact('note','users'));
    }
    /**
     * Update the specified note.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $note->title = $request->title;
        $note->body = $request->body;

        $note->save();

        return 'Saved!';
    }
}
