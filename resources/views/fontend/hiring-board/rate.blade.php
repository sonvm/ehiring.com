@extends('layouts.default')

@section('title', 'Rating Canidate')

@section('page-header', 'Rating Canidate')

@section('content')



<div class="row">
   <div class="col-4">
      <?php
      $id = $cv->id;
      $rid = $cv->recruiting_id;
      $name = $cv->name;
      $bod = $cv->bod;
      $bod = date("Y-m-d", strtotime($bod));
      $gpa = $cv->gpa;
      ?>

      <div class="p-2 my-1 rounded text-dark">
         <a href="/applicant/{{$id}}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
               <div>

                  <ul>
                     <li>Name: {{$name}}</li>
                     <li>Birthday: {{$bod}}</li>
                     <li>GPA: {{$gpa}}</li>
                  </ul>
               </div>

            </div>
         </a>
      </div>
   </div>



   <div class="col-8">
      @include('layouts.message')
      @if($criterias->count()==0)
      <div class="alert alert-success" role="alert">There are no criterias to rate.</div>
      @else
      {!! Form::open(array('url' => '/careers/'.$rid.'/applicants/'.$id.'/save', 'class' => 'form-horizontal','method' => 'get')) !!}







      <fieldset class="form-group">
         <ul class="list-group">
            @foreach($criterias as $criteria)
            <?php
            $c_id = $criteria->criteria_id;
            $name = $criteria->name;
            $is_cost_criteria = ($criteria->is_cost_criteria);
            $rate=0;

            foreach($ratings as $rating)
            {
               if ($rating->criteria_id==$c_id) {$rate=$rating->rating;break;}
            }

            ?>

            <li class="list-group-item m-0">
               <div class="form-check">
                  <?php
                  $cname = 'criteria_' . $c_id;
                  ?>

                  <label for="{{$cname}}" class="form-label">
                     {{$name}}
                     @if($is_cost_criteria)
                     (cost)
                     @endif
                  </label>
                  <input type="range" class="form-range" min="1" max="5" step="1" name="{{$cname}}" value="<?php echo $rate?$rate:3; ?>">
                  <div class="row">

                     @if($is_cost_criteria)
                     <div class="col text-start">Low</div>
                     <div class="col text-center">Normal</div>
                     <div class="col text-end">High</div>
                     @else
                     <div class="col text-start">Bad</div>
                     <div class="col text-center">Normal</div>
                     <div class="col text-end">Good</div>
                     @endif

                  </div>


            </li>
            @endforeach
         </ul>
      </fieldset>
      <br>

      <div class="d-flex justify-content-center">
         <button class="btn btn-primary" type="submit" id="button-addon2">Finish</button>
      </div>

   </div>






   {!! Form::close() !!}
   @endif
</div>



</div>



@endsection