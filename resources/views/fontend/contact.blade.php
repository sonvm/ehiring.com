@extends('layouts.default')

@section('title', 'All Laravel - Liên hệ với chúng tôi')

@section('content')

{!! Button::success('Gửi tin nhắn') !!}
{!! Alert::info('Oh nyo') !!}

   {!! Form::open(array('url' => '/contact', 'class' => 'form-horizontal')) !!}
      <div class="form-group">
         {!! Form::label('name', 'Họ và tên', array('class' => 'col-sm-2 control-label')) !!}
         <div class="col-sm-10">
            {!! Form::text('name', isset($name)?$name:'', array('class' => 'form-control', 'placeholder' => 'Nhập họ tên đầy đủ')) !!}
         </div>
      </div>

      <div class="form-group">
         {!! Form::label('email', 'Địa chỉ email', array('class' => 'col-sm-2 control-label')) !!}
         <div class="col-sm-10">
            {!! Form::email('email', isset($email)?$email:'', array('class' => 'form-control', 'placeholder' => 'Địa chỉ email thật để nhận phản hồi')) !!}
         </div>
      </div>

      <div class="form-group">
         {!! Form::label('title', 'Tiêu đề', array('class' => 'col-sm-2 control-label')) !!}
         <div class="col-sm-10">
            {!! Form::text('title', '', array('class' => 'form-control', 'placeholder' => 'Tiêu đề tin nhắn')) !!}
         </div>
      </div>

      <div class="form-group">
         {!! Form::label('content', 'Nội dung liên hệ', array('class' => 'col-sm-2 control-label')) !!}
         <div class="col-sm-10">
            {!! Form::textarea('content', '', array('class' => 'form-control', 'placeholder' => 'Nội dung không quá 200 từ', 'rows' => '3')) !!}
         </div>
      </div>

      <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Gửi tin nhắn', array('class' => 'btn btn-success')) !!}
         </div>
      </div>
   {!! Form::close() !!}
@endsection

