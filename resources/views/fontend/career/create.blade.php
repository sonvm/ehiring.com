@extends('layouts.default')

@section('title', 'Start A New Recruiting')

@section('page-header', 'Start A New Recruiting')

@section('content')

@include('layouts.message')

    
    @if (count($errors) > 0)
      <div class="alert alert-danger">
          Invalid Inputs:
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

  <legend>Creating</legend>

  {!! Form::open(array('url' => '/careers', 'class' => 'form-horizontal')) !!}

    <!-- <div class="form-group row">
      <label for="user" class="col-sm-2 col-form-label">User</label>
      <div class="col-sm-10">
        <input type="text" readonly="" class="form-control-plaintext" name="user" value="email@example.com">
      </div>
    </div> -->

    <div class="form-group">
         {!! Form::label('title', 'Title', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-12">
            {!! Form::text('title', '', array('class' => 'form-control')) !!}
         </div>
    </div>
    <br>

    <div class="form-group">
         {!! Form::label('description', 'Job\'s description', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-12">
            {!! Form::textarea('description', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('criteria', 'Criteria Number', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-4">
            {!! Form::number('criteria', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('startDate', 'Starting Date', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-12">
            {!! Form::date('startDate', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('endDate', 'Ending Date', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-12">
            {!! Form::date('endDate', '', array('class' => 'form-control')) !!}
         </div>
      </div>
<br>

    <fieldset>
      <legend class="mt-4">Status</legend>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="status" checked="">
        <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
      </div>
    </fieldset>
    <br>

    <br>

    <div class="form-group d-grid gap-2 col-3 mx-auto">
        <button type="submit" class="btn btn-primary">Finish</button>
    </div>
    {!! Form::close() !!}
</table>

  </fieldset>
</form>
@endsection