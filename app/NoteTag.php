<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteTag extends Model
{
    //
    protected $guarded = ['id'];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
