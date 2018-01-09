@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">My notes</div>
                    <div class="panel-body">
                        @if($notes->isEmpty())
                            <p>
                                You have not created any notes! <a href="{{ url('create') }}">Create one</a> now.
                            </p>
                        @else
                        <ul class="list-group">
                            @foreach($notes as $note)
                                <li class="list-group-item panel-body">
                                    <span class="col-md-12 btn-block h4">
                                     {{ $note->title }}   
                                    </span>    
                                    <span class="col-md-1 pull-right"> 
                                        <a class="btn btn-sm btn-info" href="{{ url('edit', [$note->slug]) }}">
                                        <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                                     
                                        </a></span>
                                    <span class="col-md-1 pull-right">
                                       <a class="btn btn-sm btn-danger" href="{{ url('delete', [$note->slug]) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    <span class="col-md-1 pull-right">
                                         <a class="btn btn-sm btn-success" href="{{ url('view', [$note->slug]) }}">
                                         <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    <span class="col-md-1 pull-right">
                                         <a class="btn btn-sm btn-success" href="{{ url('edit', [$note->slug]) }}">
                                         <i class="glyphicon glyphicon-share" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    <span class="col-md-12 text-info">{{ $note->updated_at->diffForHumans() }}</span>

                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection