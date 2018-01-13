<?php

namespace App\Http\Controllers;

use App\Note;
use App\SharedNote;
use App\User;
use App\Tag;
use App\NoteTag;
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
            if(!$ssnotes->isEmpty())
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
        $tags  = Tag::all();
        return view('notes.create',compact('tags'));
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
        $tags="";
        if(!empty($request->check_list)){
        // Loop to store and display values of individual checked checkbox.
            foreach($request->check_list as $tagnames){
                $tags=$tags.$tagnames."</br>";
            }
        }

        $note = Note::create([
            'user_id' => $request->user()->id,
            'title'   => $request->title,
            'slug'    => str_slug($request->title) . str_random(10),
            'body'    => $request->body
        ]);

       /*  session_start();
        $_SESSION["status_delete"] = "Note Deleted with Title : ".$tags;*/
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
        SharedNote::where('note_id', $note->id)->delete();
        session_start();
        $_SESSION["status_delete"] = "Note Deleted with Title : ".$note->title;
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
        $snpms = SharedNote::where('note_id', $note->id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        $user = User::where('id',$note->user_id)->get();
        $username[] = $user[0]->name;
        $username[] = $user[0]->email;
        return view('notes.view', compact('note','snpms','username'));
    }

    public function share(Note $note)
    {
        $users = User::all()->except(Auth::id());
        $snpms = SharedNote::where('note_id', $note->id)
                        ->where('suser_email',auth()->user()->email)
                        ->get();
        $per = array('','','');
        if(!$snpms->isEmpty()){
        if($snpms[0]->owner)
        {
            $per[0]='';
            $per[1]='';
            $per[2]='';
        }
        elseif ($snpms[0]->edit_only) {
            # code...
            $per[0]='disabled';
            $per[1]='';
            $per[2]='disabled';           
        }
        elseif ($snpms[0]->share_only) {
            # code...
            $per[0]='disabled';
            $per[1]='disabled';
            $per[2]=''; 
        }
        else
        {
            $per[0]='disabled';
            $per[1]='disabled';
            $per[2]='disabled'; 
        }}
        return view('notes.share', compact('note','users','per'));
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
