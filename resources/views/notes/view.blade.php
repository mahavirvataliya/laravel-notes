@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
            		<a class="pull-right btn btn-danger" href="{{ url('/') }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                <div class="panel-heading">View Note</div>
                <view-note :note="{{ $note }}"></view-note>
                <div class="panel-body">
                  @if (!empty($tagnames))
                    {{-- expr --}}
                    @foreach ($tagnames as $tagname)
                      <label> 
                       <code class="text-primary bg-info" >{{ $tagname }}</code>
                     </label>
                    @endforeach
                  @endif
                </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">Information of Note Id and Note Creater</div>
                 <div class="panel-body">
                    <div class="alert alert-primary alert-dismissable show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong style="white-space: pre-wrap">Note Id is : {{ $note->id }}</strong>
                  </div>
                  <div class="alert alert-primary alert-dismissable show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong style="white-space: pre-wrap">Created By <b class="text-uppercase text-primary">{{ $username[0] }}</b> with Email ID <u class="text-primary">{{ $username[1] }}</u></strong> 
                </div>
              </div>
          </div>
            <div class="panel panel-default">
            <div class="panel-heading">Note is Shared With</div>
                  <div class="panel-body">
                    <ul class="list-group">
                     @foreach ($snpms as $snpm)
                     <li class="list-group-item ">
                         {{ $snpm->suser_email }}
                     </li>
                     @endforeach 
                    </ul>
                    </div>
            </div>
            </div>
            
        </div>
    </div>
@endsection