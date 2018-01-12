@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">My Notes


                    </div>
                    <div class="panel-body">
                        <?php 
                        session_start(); 
                        if(isset($_SESSION["status_delete"]) && $_SESSION["status_delete"]!=""){ 
                            ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong> <?php
                            echo $_SESSION["status_delete"]; ?></strong> 
                          </div>
                         <?php
                            $_SESSION["status_delete"]="";
                        }
                        ?>

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
                                        <a class="btn btn-sm btn-success" href="{{ url('share', [$note->slug]) }}">
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
                <div class="panel panel-default">
                    <div class="panel-heading">Shared Notes With Me</div>
                    <div class="panel-body">
                   {{-- @if (!$snotes->isEmpty()) --}}
                        {{-- expr --}}
                        <ul class="list-group">
                            @foreach ($snpms as $snpm)
                             @foreach ($snotes as $ssnote)
                                    {{-- expr --}}
                                @if ($ssnote->id===$snpm->note_id)
                                <li class="list-group-item panel-body">
                                    <span class="col-md-12 btn-block h4">
                                     {{ $ssnote->title }}   
                                    </span>

                                    
                                    <span class="col-md-1 pull-right"> 
                                        <a class="btn btn-sm btn-info" href="
                                        @if ($snpm->owner || $snpm->edit_only)
                                            {{ url('edit', [$ssnote->slug]) }}
                                        @else
                                            {{ '#' }}
                                        @endif">
                                        <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                                     
                                        </a></span>
                                        
                                    <span class="col-md-1 pull-right">
                                       <a class="btn btn-sm btn-danger"  href="
                                       @if ($snpm->owner || $snpm->edit_only)
                                       {{ url('delete', [$ssnote->slug]) }}
                                       @else
                                            {{ '#' }}
                                        @endif">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    <span class="col-md-1 pull-right">
                                         <a class="btn btn-sm btn-success" href="{{ url('view', [$ssnote->slug]) }}">
                                         <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    <span class="col-md-1 pull-right">
                                        <a class="btn btn-sm btn-success" href="
                                        @if ($snpm->owner || $snpm->share_only)
                                        {{url('share', [$ssnote->slug]) }}
                                        @else
                                            {{ '#' }}
                                        @endif">
                                             <i class="glyphicon glyphicon-share" aria-hidden="true"></i>
                                            </a> 

                                    </span>
                                    <span class="col-md-12 text-info">{{ $ssnote->updated_at->diffForHumans() }}
                                    </span>
                                    
                                </li>
                                @endif
                             @endforeach   
                            @endforeach
                        </ul>
                    {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection