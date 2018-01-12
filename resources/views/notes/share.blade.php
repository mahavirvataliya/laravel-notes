@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
       			 <div class="panel-heading">Share Note</div>
       			     <div class="panel-body">
			           		<form action="{{ url('shares') }}" method="POST" class="form" role="form">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('suser_email') ? ' has-error' : '' }}">
                            <label for="suser_email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-8">
                                <input id="suser_email" type="email" list="users" class="form-control" name="suser_email" value="{{ old('suser_email') }}" required>
                                @if ($errors->has('suser_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('suser_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="note_id" value="{{ $note->id }}">
                          
                            <datalist id="users">
                            	@foreach($users as $user)
                            	<option value="{{ $user->email }}"></option>
                            	@endforeach
                            </datalist>
                        </div>
                        <br>
                        <div class="form-group">
                        	<label for="noteaccess" class="col-md-12 control-label"><br>Access to Note For User Leave For Read-Only</label>
                            <div class="radio">
							  <label><input type="radio" {{ $per[0] }} value="owner" name="noteaccess">Owner</label>
							</div>
							<div class="radio">
							  <label><input type="radio" {{ $per[1] }} value="edit_only" name="noteaccess">Edit And Delete Only</label>
							</div>
							<div class="radio">
							  <label><input type="radio" {{ $per[2] }} value="share_only" name="noteaccess">Share Only</label>
							</div>
						
						</div>
                            <button class="btn btn-primary pull-right" {{ $per[2] }}>Share</button>&nbsp;
                            <a class="btn btn-danger" href="{{ url('') }}">Cancel</a>
                        </form>

			        </div>
                    
			    </div>
            </div>
        </div>
    </div>
@endsection