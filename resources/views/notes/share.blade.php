@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
       			 <div class="panel-heading">Share Note</div>
       			     <div class="panel-body">
           			<div class="card">
             		 <div class="card-body">
                    <h4 class="card-title">{{ $note->title }}</h4>
                    <p class="card-text "><xmp style="white-space: pre-wrap">{{ $note->body }}</xmp></p>
                </div>
            </div>
        </div>
    </div>


                
            </div>
        </div>
    </div>
@endsection