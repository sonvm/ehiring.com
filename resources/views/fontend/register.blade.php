@extends('layouts.default')

@section('title', 'Register')

@section('page-header', 'Register')

@section('content')
    @if (count($errors) > 0)
      <div class="alert alert-danger">
          Nessessary infos required. Please check the following:
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    @if (isset($message))
      <div class="alert alert-success">
      {{ $message }}
      </div>
    @endif

    {!! Form::open(array('url' => '/register', 'class' => 'form-horizontal')) !!}
      <div class="form-group">
         {!! Form::label('name', 'Name *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-9">
            {!! Form::text('name', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('email', 'Email *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-9">
            {!! Form::email('email', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('username', 'Username *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-9">
            {!! Form::text('username', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('password', 'Password *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-9">
            {!! Form::password('password', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('password_confirmation', 'Confirm Password *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-9">
            {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         <div class="col-sm-offset-3 col-sm-9">
            {!! Form::submit('Register', array('class' => 'btn btn-primary')) !!}
         </div>
      </div>
   {!! Form::close() !!}
@endsection