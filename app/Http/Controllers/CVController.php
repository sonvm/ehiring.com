<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CV;
use App\Models\Career;
use App\Models\HiringBoard;
use App\Models\Rating;
use App\Models\RecruitingCriteria;
use Illuminate\Support\Facades\Redirect;

class CVController extends Controller
{
    public function apply($id)
    {
        return view('fontend.cv.apply')->with(['id' => $id, 'name' => auth()->user()->name]);
    }

    public function store(Request $request)
    {
        $status=Career::select('status')->where('id','=',$request->input('recruiting_id'))->first();

        var_dump($status->status);
        if ($status["status"]==0)
        {
            return Redirect::back()
            ->with('existed','This recruitment is now closed.')
            ->withInput();
        }

        if (CV::where('user_id', '=', auth()->user()->id)->where('recruiting_id','=',$request->input('recruiting_id'))->exists()) {
           
            return Redirect::back()
                ->with('existed','You have applied for this job!')
                ->withInput();
         }

        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'bod'      => 'required',
            'address' => 'required',
            'phone'    => 'required|numeric',
            'gpa' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $cv          = new CV();

            $cv->user_id = auth()->user()->id;
            $cv->recruiting_id = $request->input('recruiting_id');
            $cv->name    = $request->input('name');
            $cv->bod   = $request->input('bod');
            $cv->address = $request->input('address');
            $cv->phone = $request->input('phone');
            $cv->gpa = $request->input('gpa');
            $cv->save();

            return Redirect::back()
                ->with('message', 'Success!!');
        }
    }

    public function calculateAverage($cv,$criterias)
    {
        $ratings = Rating::where('recruiting_id', '=', $cv->recruiting_id)
            ->where('cv_id', '=', $cv->id)->join('criterias', 'ratings.criteria_id', '=', 'criterias.id')
            ->select('name', 'rating', 'is_cost_criteria')
            ->get()->toArray();


            $rs=[];
        //if(!count($ratings)) return null;
            foreach($criterias  as $criteria)
            {
                $keys = array_keys(array_column($ratings, 'name'), $criteria['name']);
                $n=count($keys);
                if ($n==0) continue;
                $temp=0;
                foreach($keys as $key)
                {
                    $temp+=$ratings[$key]['rating'];
                }
                $tavg=$temp/$n;

                $rs[]=array('name'=>$criteria['name'],'average'=>$tavg);
            }


        return $rs;
    }

    public function manageApplicants($id)
    {

        

        $cvs = CV::where([['recruiting_id', '=', $id]])->paginate(7);
        $position = Career::select('title')->where('id', '=', $id)->first();

        $criterias = RecruitingCriteria::join('criterias', 'criteria_id', '=', 'criterias.id')->select('name')->distinct()->get()->toArray();

        foreach ($cvs as $cv) {
            $avg = $this->calculateAverage($cv,$criterias);

            // echo $cv->name . '<br>';
            // echo '<pre>';
            // var_dump($avg);
            // echo '</pre>';

            $cv->avg=$avg;

                    

        }


        return view('fontend.cv.applicants')->with('cvs', $cvs)->with('position', $position);
    }

    public function showApplicants($id)
    {
        $applicant = CV::where('id', '=', $id)->first();
        $position = Career::select('title')->where('id', '=', $applicant->recruiting_id)->first();
        return view('fontend.cv.detail')->with('applicant', $applicant)->with('position', $position);
    }

    public function manageCVs()
    {
        $cvs = CV::select('id', 'recruiting_id','status')->where([['user_id', '=', auth()->user()->id]])->paginate(7);
        foreach ($cvs as $cv) {
            $cv->position = Career::where('id', '=', $cv->recruiting_id)->first();
        }

        return view('fontend.cv.my-cvs')->with('cvs', $cvs);
    }

    public function myAppliedCV($id){
        $applicant = CV::where('user_id', '=', auth()->user()->id)->first();
        $position = Career::select('title')->where('id', '=', $applicant->recruiting_id)->first();
        return view('fontend.cv.detail')->with('applicant', $applicant)->with('position', $position);
    }
}
