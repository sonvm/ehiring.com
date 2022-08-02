@extends('layouts.default')

@section('title', 'Apply')

@section('page-header', 'Apply Form')

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

{!! Form::open(array('url' => '/careers/'.$id.'/apply', 'class' => 'form-horizontal')) !!}

<!-- <div class="form-group row">
      <label for="user" class="col-sm-2 col-form-label">User</label>
      <div class="col-sm-10">
        <input type="text" readonly="" class="form-control-plaintext" name="user" value="email@example.com">
      </div>
    </div> -->

<div class="form-group">
    {!! Form::label('name', 'Full Name', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-12">
        {!! Form::text('name', $name, array('class' => 'form-control',)) !!}
    </div>
</div>
<br>

<div class="row">
    <div class="form-group col-4">
        {!! Form::label('bod', 'Birthday', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-12">
            {!! Form::date('bod', '', array('class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group col-5">
        {!! Form::label('phone', 'Phone Number', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-12">
            {!! Form::text('phone', '', array('class' => 'form-control')) !!}
        </div>
    </div>
</div>

<br>


<div class="form-group">
    {!! Form::label('address', 'Address', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-12">
        {!! Form::text('address', '', array('class' => 'form-control')) !!}
    </div>
</div>
<br>

<div class="form-group">
    {!! Form::label('gpa', 'GPA (Grade Point Average)', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-12">
        {!! Form::text('gpa', '', array('class' => 'form-control')) !!}
    </div>
</div>
<br>


<div class="form-group">
    {!! Form::label('experience', '!Experience', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-12">
        {!! Form::textarea('experience', '', array('class' => 'form-control')) !!}
    </div>
</div>
<br>
<br>

{{ Form::hidden('recruiting_id', $id) }}

<div class="form-group d-grid gap-2 col-3 mx-auto">
    <button type="submit" class="btn btn-primary">Finish</button>
</div>
{!! Form::close() !!}
</table>

</fieldset>
</form>
@endsection