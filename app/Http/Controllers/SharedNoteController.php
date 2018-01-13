<?php

namespace App\Http\Controllers;
use App\Note;
use Illuminate\Http\Request;
use App\SharedNote;
use App\User;
use App\Tag;
use App\NoteTag;
use Auth;
use DB; 
class SharedNoteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
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
}
