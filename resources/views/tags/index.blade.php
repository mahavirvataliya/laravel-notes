@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a class="pull-right btn btn-danger" href="{{ url('/') }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                <div class="panel panel-default">
                    <div class="panel-heading">Tags 
                    </div>
                    <div class="panel-body">
                        <?php 
                        session_start(); 
                        if(isset($_SESSION["tag_delete"]) && $_SESSION["tag_delete"]!=""){ 
                            ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong> <?php
                            echo $_SESSION["tag_delete"]; ?></strong> 
                          </div>
                         <?php
                            $_SESSION["tag_delete"]="";
                        }
                        ?>

                        @if($tags->isEmpty())
                            <p>
                                You have not created any Tags! 
                            </p>
                        @else
                        <ul class="list-group" type="1">
                            @foreach($tags as $tag)
                                <li class="list-group-item panel-body">
                                    <span class="col-md-10 h4">
                                    {{ $tag->id }}. <code class="text-primary bg-info" >{{ $tag->tagname }}</code> 
                                    </span>
                                    <span class="col-md-1 pull-right">
                                         <form action="{{ url('tagdelete') }}" method="POST" role="form">
                                      {{ csrf_field() }}

                                      <input type="hidden" name="tagid" value="{{ $tag->id }}">
                                       <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    </span>
                                </li>
                            @endforeach
                             @endif
                            <li class="list-group-item panel-body">
                                <span class="col-md-12 btn-block h4">
                                    <form action="{{ url('tags') }}" method="POST" class="form-inline" role="form">
                                      {{ csrf_field() }}

                                      <div class="form-group">
                                        <label for="tagname">Tag Name  : </label>
                                        <input type="text" required class="form-control" name="tagname" id="tagname">
                                        <button type="submit" class="btn btn-success">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                      </div>
                                </span>
                             </li>
                        </ul>
                       
                    </div>
                </div>
               
            </div>
        </div>
    </div>
@endsection