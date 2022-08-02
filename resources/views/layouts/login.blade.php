<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      {!! Form::open(array('url' =>'/login', 'class' => 'form-horizontal')) !!}
      <div class="form-group">
         {!! Form::label('username', 'Username *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-12">
            {!! Form::text('username', '', array('class' => 'form-control')) !!}
         </div>
      </div>
      <br>

      <div class="form-group">
         {!! Form::label('password', 'Password *', array('class' => 'col-sm-3 control-label')) !!}
         <div class="col-sm-12">
            {!! Form::password('password', array('class' => 'form-control')) !!}
         </div>
      </div>

      

      <div class="modal-footer">
      {!! Form::submit('Login', array('class' => 'btn btn-primary')) !!}
      </div>

      {!! Form::close() !!}

      </div>

    </div>
  </div>
</div>