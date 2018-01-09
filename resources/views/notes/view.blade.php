@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
        <div class="panel-heading">View Note <a class="pull-right" href="{{ url('/') }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a></div>
                <view-note :note="{{ $note }}"></view-note>
            </div>
        </div>
    </div>
@endsection