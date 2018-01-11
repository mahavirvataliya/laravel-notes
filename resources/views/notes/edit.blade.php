@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            	<a class="pull-right btn btn-danger" href="{{ url('/') }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                <edit-note :note="{{ $note }}"></edit-note>
            </div>
        </div>
    </div>
@endsection