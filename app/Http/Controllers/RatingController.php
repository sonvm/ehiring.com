<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\CV;
use App\Models\Rating;
use App\Models\RecruitingCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RatingController extends Controller
{
    public function rate($rid, $id)
    {
        $cv = CV::where('id', '=', $id)->first();
        $criterias = DB::table('criterias')->join('recruiting_criteria', 'criterias.id', '=', 'recruiting_criteria.criteria_id')->where('recruiting_id', '=', $rid)->get();

        $ratings=Rating::where('hiring_member_id', '=', auth()->user()->id)->where('cv_id', '=', $id)->select('rating','criteria_id')->get();
        //var_dump($criterias);
        return view('fontend.hiring-board.rate')->with('cv', $cv)->with('criterias', $criterias)->with('ratings',$ratings);
    }

    public function saveRating($rid, $id, Request $request)
    {

        //recruiting_id	cv_id	cv_id	criteria_id	rating

        Rating::where('hiring_member_id', '=', auth()->user()->id)->where('cv_id', '=', $id)->delete();
        $cids = DB::table('criterias')->join('recruiting_criteria', 'criterias.id', '=', 'recruiting_criteria.criteria_id')->select('criterias.id')->where('recruiting_id', '=', $rid)->get()->toArray();


        foreach ($cids as $cid) {

            $name = "criteria_" . $cid->id;
            //var_dump($cid->id);
            $rating = new Rating();
            $rating->recruiting_id = $rid;
            $rating->cv_id = $id;
            $rating->hiring_member_id = auth()->user()->id;
            $rating->criteria_id = $cid->id;
            $rating->rating = $request->$name;
            $rating->save();
        }



        return Redirect::back()
            ->with('message', 'Ratings are updated.');
    }
}
