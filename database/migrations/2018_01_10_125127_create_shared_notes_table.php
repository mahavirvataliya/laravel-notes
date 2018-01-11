<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('note_id');
            $table->string('suser_email');
            $table->boolean('owner');
            $table->boolean('edit_only');
            $table->boolean('share_only');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_notes');
    }
}
