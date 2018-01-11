@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
            		<a class="pull-right btn btn-danger" href="{{ url('/') }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
        <div class="panel-heading">View Note </div>
                <view-note :note="{{ $note }}"></view-note>
            </div>
        </div>
    </div>
@endsection