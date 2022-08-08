<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Career;
use App\Models\HiringBoard;
use App\Models\User;
use App\Models\Criteria;
use App\Models\CV;
use App\Models\Rating;
use App\Models\RecruitingCriteria;
use Illuminate\Support\Facades\Redirect;


class CareerController extends Controller
{
    public function test()
    {
        return view('layouts.test');
    }
    //
    public function create()
    {
        return view('fontend.career.create');
    }

    public function store(Request $request)
    {
        // return redirect('careers/create')
        //             ->with('message',$request->input('endDate') );

        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'description'      => 'required|max:10000',
            'criteria' => 'required|gt:0',
            'startDate'    => 'required',
            'endDate' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('careers/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $active = $request->has('active') ? 1 : 0;
            // $recruit_id = DB::table('recruitings')->insertGetId([
            //     'title'       => $request->input('title'),
            //     'description'      => $request->input('description'),
            //     'criteria' =>  $request->input('criteria'),
            //     'starting_date'    => $request->input('startDate'),
            //     'closing_date' => $request->input('endDate'),
            //     'status'     => $request->input('status')?1:0,
            //     ]);

            $career          = new Career();
            $career->owner_id = auth()->user()->id;
            $career->title    = $request->input('title');
            $career->description   = $request->input('description');
            $career->criteria = $request->input('criteria');
            $career->starting_date = $request->input('startDate');
            $career->closing_date = $request->input('endDate');
            $career->status  = $request->input('status') ? 1 : 0;
            $career->save();

            return redirect('careers/create')
                ->with('message', 'Success!!');
        }
    }

    public function index()
    {

        //$news = DB::table('recruitings')->get();

        //$news = Career::all();
        $news = Career::paginate(7);
        return view('fontend.career.list')->with('news', $news);
    }

    public function edit($id)
    {
        //$recruiting = DB::table('recruitings')->find($id);
        $recruiting = Career::find($id);
        return view('fontend.career.edit')->with(compact('recruiting'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'description'      => 'required|max:10000',
            'criteria' => 'required|gt:0',
            'startDate'    => 'required',
            'endDate' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $career = Career::find($id);
            $career->title    = $request->input('title');
            $career->description   = $request->input('description');
            $career->criteria = $request->input('criteria');
            $career->starting_date = $request->input('startDate');
            $career->closing_date = $request->input('endDate');
            $career->status  = $request->input('status') ? 1 : 0;
            $career->save();

            return Redirect::back()
                ->with('message', 'Update Success')
                ->withInput();
        }
    }

    public function show($id)
    {
        $recruiting = DB::table('recruitings')->find($id);
        return view('fontend.career.show')->with(compact('recruiting'));
    }

    public function manageNews()
    {
        $news = Career::where([['owner_id', '=', auth()->user()->id]])->paginate(7);
        return view('fontend.career.manage')->with('news', $news);
    }

    public function hbCurr($id)
    {
        // $users=HiringBoard::select('user_id')->where('recruiting_id','=',$id)->get();

        // foreach($users as $user){
        //     $user->data=User::where('id','=',$user->user_id)->get();
        // }

        $users = DB::table('hiring_board_members')->where('hiring_board_members.recruiting_id', '=', $id)->join('users', 'hiring_board_members.user_id', '=', 'users.id')->get();

        return $users;
    }

    public function hbConfig($id)
    {
        $users = $this->hbCurr($id);
        //var_dump($users);
        return view('fontend.career.hb-config')->with('id', $id)->with('users', $users);
    }



    public function searchAdd(Request $request, $id)
    {
        $users = $this->hbCurr($id);
        $seachText = $request->get('search_users');
        $results = User::where('name', 'LIKE', '%' . $seachText . '%')->get();
        return view('fontend.career.hb-config')->with('results', $results)->with('id', $id)->with('users', $users);
    }

    public function add($id, $uid)
    {
        if (HiringBoard::where('user_id', '=', $uid)->where('recruiting_id', '=', $id)->exists()) {

            return Redirect::back()
                ->with('existed', 'This member is already included!')
                ->withInput();
        }

        $hbMem = new HiringBoard();
        $hbMem->user_id = $uid;
        $hbMem->recruiting_id = $id;
        $hbMem->save();
        return redirect('careers/' . $id . '/hiring-board');
    }

    public function remove($id, $uid)
    {
        HiringBoard::where('user_id', '=', $uid)->where('recruiting_id', '=', $id)->delete();

        return redirect('careers/' . $id . '/hiring-board');
    }

    public function criteriaConfig($id)
    {
        $criterias = Criteria::get();
        $currently = RecruitingCriteria::select('criteria_id', 'weight')->where('recruiting_id', '=', $id)->get()->toArray();

        foreach ($criterias as $criteria) {
            if (in_array($criteria->id, array_column($currently, 'criteria_id'))) {
                $criteria->checked = true;

                $loc = array_search($criteria->id, array_column($currently, 'criteria_id'));

                $criteria->weight = $currently[$loc]['weight'];
            } else $criteria->checked = false;
        }

        return view('fontend.career.criteria-config')->with('id', $id)->with('criterias', $criterias)->with('currently', $currently);
    }

    public function updateCriteria($id, Request $request)
    {
        $max = Criteria::max('id');



        for ($i = 1; $i <= $max; $i++) {

            RecruitingCriteria::where('recruiting_id', '=', $id)->where('criteria_id', '=', $i)->delete();

            $str = 'criteria_' . $i;
            $str_w = 'criteria_w_' . $i;
            if ($request->$str) {
                $update = new RecruitingCriteria();
                $update->recruiting_id = $id;
                $update->criteria_id = $i;
                if ($request->$str_w) {
                    $update->weight = $request->$str_w;
                }
                $update->save();
            }
        }

        return redirect('careers/' . $id . '/criteria')->with('message', 'Success!');
    }

    public function checkRating($id, $hbid)
    {
        $ratings = Rating::where('recruiting_id', '=', $id)
            ->where('hiring_member_id', '=', $hbid)->join('criterias', 'ratings.criteria_id', '=', 'criterias.id')
            ->select('cv_id', 'name', 'rating', 'is_cost_criteria')
            ->get()->toArray();
        // echo '<pre>';
        // var_dump($ratings);
        // echo '</pre>';




        $hb = User::select('name', 'email')->where('id', '=', $hbid)->first();
        $cvs = CV::where('recruiting_id', '=', $id)->paginate(7);
        $position = Career::select('title')->where('id', '=', $id)->first();
        // echo '<pre>';
        // var_dump($position->title);
        // echo '</pre>';

        return view('fontend.career.hb-rating')
            ->with('cvs', $cvs)
            ->with('ratings', $ratings)
            ->with('position', $position)
            ->with('hb', $hb);
    }

    public function calculateAverage($cv, $criterias)
    {


        $ratings = Rating::where('recruiting_id', '=', $cv->recruiting_id)
            ->where('cv_id', '=', $cv->id)->join('criterias', 'ratings.criteria_id', '=', 'criterias.id')
            ->select('name', 'rating', 'is_cost_criteria')
            ->get()->toArray();


        $rs = [];
        //if(!count($ratings)) return null;
        foreach ($criterias  as $criteria) {
            $keys = array_keys(array_column($ratings, 'name'), $criteria['name']);
            $n = count($keys);
            if ($n == 0) {
                $rs[] = array('name' => $criteria['name'], 'average' => 0);
                continue;
            }
            $temp = 0;
            foreach ($keys as $key) {
                $temp += $ratings[$key]['rating'];
            }
            $tavg = $temp / $n;

            $rs[] = array('name' => $criteria['name'], 'average' => $tavg);
        }


        return $rs;
    }

    public function getColumn($arr, $column)
    {

        $rs = [];
        foreach ($arr as $a) {
            $rs[] = $a->$column;
        }


        return $rs;
    }

    public function vectorizeArray($arr)
    {

        $div = 0;
        foreach ($arr as $a) {
            $div += $a * $a;
        }
        $div = sqrt($div);

        foreach ($arr as &$a) {
            $a = number_format($a / $div, 4);
        }

        return $arr;
    }

    public function standardizeArr($arr)
    {

        $div = 0;
        foreach ($arr as $a) {
            $div += $a;
        }
        //$div=sqrt($div)
        foreach ($arr as &$a) {
            $a = number_format($a / $div, 4);
        }

        return $arr;
    }

    public function distanceTo($arr, $checker)
    {
        $distance = 0;
        $size = count($arr);
        for ($i = 0; $i < $size; $i++) {
            $minus = $arr[$i] - $checker[$i];
            $distance += $minus * $minus;
        }

        return sqrt($distance);
    }

    public function suggest($id)
    {


        $criterias = RecruitingCriteria::where('recruiting_id', '=', $id)->join('criterias', 'criteria_id', '=', 'criterias.id')->select('name', 'is_cost_criteria', 'weight')->distinct()->get()->toArray();

        $cvs = CV::where('recruiting_id', '=', $id)->get();
        $rated = Rating::select('cv_id')->where('recruiting_id', '=', $id)->distinct()->pluck('cv_id')->toArray();
        
        foreach ($cvs as $key=>$cv){
            if(!in_array($cv->id,$rated)) unset($cvs[$key]);
        }

        if ($cvs->count() == 0)
            return view('fontend.career.suggestion-error');

        foreach ($cvs as $cv) {
            $name = $cv->name;
            $bod = $cv->bod;
            $bod = date("Y-m-d", strtotime($bod));
            $gpa = $cv->gpa;
            $avgs = $this->calculateAverage($cv, $criterias);
            $cv->avgs = $avgs;
        }



        foreach ($cvs as $cv) {

            $avgs = $cv->avgs;
            foreach ($avgs as $avg) {
                $t_name = $avg['name'];
                $cv->$t_name = $avg['average'];
            }
        }

        foreach ($criterias as $criteria) {
            $t_name = $criteria['name'];

            if ($criteria['is_cost_criteria']) {
                foreach ($cvs as $cv) {

                    $cv->$t_name = 1/$cv->$t_name;
                }
            }


            $vec = $this->vectorizeArray($this->getColumn($cvs, $t_name));

            $i = 0;
            foreach ($cvs as $cv) {
                $cv->$t_name = $vec[$i];
                $i++;
            }
        }


        foreach ($cvs as $cv) {


            foreach ($criterias as $criteria) {
                $t_name = $criteria['name'];
            }
        }

        $all_weights = [];
        foreach ($criterias as $criteria) {
            $all_weights[] = $criteria['weight'];
        }

        $all_weights = $this->standardizeArr($all_weights);

        foreach ($criterias as $criteria) {
            $t_name = $criteria['name'];
        }

        foreach ($cvs as $cv) {
            $i = 0;

            foreach ($criterias as $criteria) {
                $t_name = $criteria['name'];
                $cv->$t_name = $cv->$t_name * $all_weights[$i];

                $i++;
            }
        }

        $best_a = [];
        $worst_a = [];
        foreach ($criterias as $criteria) {
            $t_name = $criteria['name'];
            $cvs_criteria_arr = [];

            $cvs_criteria_arr = $this->getColumn($cvs, $t_name);



            $best_a[] = max($cvs_criteria_arr);
            $worst_a[] = min($cvs_criteria_arr);
        }

        $distanceToBest = [];
        $distanceToWorst = [];
        foreach ($cvs as $cv) {
            $i = 0;
            $location = [];

            foreach ($criterias as $criteria) {
                $t_name = $criteria['name'];
                $location[] = $cv->$t_name;
            }

            $distanceToBest[] = $cv->dtb;
            $distanceToWorst[] = $cv->dtw;


            $cv->dtb = $this->distanceTo($location, $best_a);
            $cv->dtw = $this->distanceTo($location, $worst_a);
        }

        $size = count($cvs);

        foreach ($cvs as $cv) {
            $dtb = $cv->dtb;
            $dtw = $cv->dtw;
            if ($dtb + $dtw != 0) $cv->c = $dtw / ($dtb + $dtw);
            else $cv->c = 'N/A';
        }

        $splus = array_keys($distanceToBest, min($distanceToBest));
        $splus = array_search(min($distanceToBest), $distanceToBest);

        $sminus = array_keys($distanceToWorst, max($distanceToWorst));
        $sminus = array_search(max($distanceToWorst), $distanceToWorst);


        $cs=[];
        foreach($cvs as $cv){
            $cs[]=$cv->c;
        }
        $c=array_search(max($cs),$cs);
        //$c = 2;

        return view('fontend.career.suggestion')
            ->with('criterias', $criterias)
            ->with('cvs', $cvs)
            ->with('best', $best_a)
            ->with('worst', $worst_a)
            ->with('dtb', $distanceToBest)
            ->with('dtw', $distanceToWorst)
            ->with('splus', $splus)
            ->with('sminus', $sminus)
            ->with('c', $c);
    }

    public function oldSuggest($id)
    {


        $criterias = RecruitingCriteria::where('recruiting_id', '=', $id)->join('criterias', 'criteria_id', '=', 'criterias.id')->select('name', 'is_cost_criteria', 'weight')->distinct()->get()->toArray();

        //return view('fontend.career.suggestion');

        echo '<legend>TOPSIS</legend><br>';
        echo '<pre>';

        echo 'ALL CVs';
        $cvs = CV::where('recruiting_id', '=', $id)->get();
        $rated = Rating::select('cv_id')->where('recruiting_id', '=', $id)->distinct()->pluck('cv_id')->toArray();
        
        foreach ($cvs as $key=>$cv){
            if(!in_array($cv->id,$rated)) unset($cvs[$key]);
        }



        echo '<br>Each Canidates and their inputs<br><br>';

        foreach ($cvs as $cv) {
            $name = $cv->name;
            $bod = $cv->bod;
            $bod = date("Y-m-d", strtotime($bod));
            $gpa = $cv->gpa;
            $avgs = $this->calculateAverage($cv, $criterias);
            $cv->avgs = $avgs;

            echo '===================OVERVIEW======================<br><br>';
            echo 'Basic infos<br>';
            echo 'Name: ' . $name . '<br>';
            echo 'Birthday: ' . $bod . '<br>';
            echo '-----------------------------------------<br>';
            echo 'Input from CV<br>';
            echo 'GPA: ' . $gpa . '<br>';
            echo '-----------------------------------------<br>';
            echo 'Input from HB Rating<br>';
            foreach ($avgs as $avg) {
                echo $avg['name'] . ' :' . $avg['average'] . '<br>';
            }
        }

        echo '===================TOPSIS STEP 0======================<br><br>';

        echo "\t\t";
        foreach ($criterias as $criteria) {
            echo $criteria['name'] . "\t\t";
        }
        echo '<br>';

        foreach ($cvs as $cv) {
            echo $cv->name . "\t";
            $avgs = $cv->avgs;
            foreach ($avgs as $avg) {
                $t_name = $avg['name'];
                $cv->$t_name = $avg['average'];
                echo $cv->$t_name . "\t\t";
            }

            echo '<br>';
        }

        echo '<br>';



        echo '===================TOPSIS STEP 1======================<br><br>';

        echo "\t\t";
        foreach ($criterias as $criteria) {
            $t_name = $criteria['name'];
            echo $t_name . "\t\t";

            if ($criteria['is_cost_criteria']) {
                // $t_arr = [];
                // foreach ($cvs as $cv) {
                //     $t_arr[] = $cv->$t_name;
                // }
                // $t_max = max($t_arr);

                foreach ($cvs as $cv) {
                    //$cv->$t_name = $t_max - $cv->$t_name;
                    $cv->$t_name = 1/$cv->$t_name;
                }
            }

            $vec = $this->vectorizeArray($this->getColumn($cvs, $t_name));

            $i = 0;
            foreach ($cvs as $cv) {
                //$cv->$t_name = $t_max - $cv->$t_name;
                $cv->$t_name = $vec[$i];
                $i++;
            }
        }
        echo '<br>';



        foreach ($cvs as $cv) {
            echo $cv->name . "\t";

            foreach ($criterias as $criteria) {
                $t_name = $criteria['name'];
                echo $cv->$t_name . "\t\t";
            }

            echo '<br>';
        }

        echo '<br>';


        echo '===================TOPSIS STEP 2======================<br><br>';

        $all_weights = [];
        foreach ($criterias as $criteria) {
            $all_weights[] = $criteria['weight'];
        }

        $all_weights = $this->standardizeArr($all_weights);
        var_dump($all_weights);

        echo "\t\t";
        foreach ($criterias as $criteria) {
            $t_name = $criteria['name'];
            echo $t_name . "\t\t";
        }
        echo '<br>';

        foreach ($cvs as $cv) {
            echo $cv->name . "\t";
            $i = 0;

            foreach ($criterias as $criteria) {
                $t_name = $criteria['name'];
                $cv->$t_name = $cv->$t_name * $all_weights[$i];
                echo $cv->$t_name . "\t\t";
                $i++;
            }

            echo '<br>';
        }

        echo '<br>';
        echo '===================TOPSIS STEP 3======================<br><br>';

        $best_a = [];
        $worst_a = [];
        foreach ($criterias as $criteria) {
            $t_name = $criteria['name'];
            $cvs_criteria_arr = [];

            $cvs_criteria_arr = $this->getColumn($cvs, $t_name);

            echo "<pre>";
            var_dump($cvs_criteria_arr);
            echo "</pre>";


            $best_a[] = max($cvs_criteria_arr);
            $worst_a[] = min($cvs_criteria_arr);
        }

        $distanceToBest = [];
        $distanceToWorst = [];
        foreach ($cvs as $cv) {
            $i = 0;
            $location = [];

            foreach ($criterias as $criteria) {
                $t_name = $criteria['name'];
                $location[] = $cv->$t_name;
            }

            $distanceToBest[] = $this->distanceTo($location, $best_a);
            $distanceToWorst[] = $this->distanceTo($location, $worst_a);
        }

        echo "<pre> BEST";
        var_dump($best_a);
        echo "</pre>";



        echo "<pre> Distance to best";
        var_dump($distanceToBest);
        echo "</pre>";


        echo '<br>';
        echo "<pre> WORST";
        var_dump($worst_a);
        echo "</pre>";

        echo "<pre> Distance to worst";
        var_dump($distanceToWorst);
        echo "</pre>";



        echo '===================TOPSIS STEP 5======================<br><br>';

        $size = count($cvs);
        $similarity = [];

        for ($i = 0; $i < $size; $i++) {
            $similarity[] = $distanceToWorst[$i] / ($distanceToWorst[$i] + $distanceToBest[$i]);
        }

        echo "<pre> SIMILAR";
        var_dump($similarity);
        echo "</pre>";

        echo '</pre>';

        echo '===================TOPSIS OVERALL======================<br><br>';

        echo "<pre> S+ CANIDATE ";
        $splus = array_keys($distanceToBest, min($distanceToBest));
        $splus = array_search(min($distanceToBest), $distanceToBest);
        var_dump($splus);
        echo "</pre>";

        echo "<pre> S- CANIDATE ";
        $sminus = array_keys($distanceToWorst, max($distanceToWorst));
        $sminus = array_search(max($distanceToWorst), $distanceToWorst);
        var_dump($sminus);
        echo "</pre>";

        echo "<pre> C CANIDATE ";
        $c = array_search(max($similarity), $similarity);
        var_dump($c);
        echo "</pre>";


        //================================== visualize

        //var_dump($criterias);

        return view('fontend.career.suggestion')
            ->with('criterias', $criterias)
            ->with('cvs', $cvs)
            ->with('best', $best_a)
            ->with('worst', $worst_a)
            ->with('dtb', $distanceToBest)
            ->with('dtw', $distanceToWorst)
            ->with('s', $similarity)
            ->with('splus', $splus)
            ->with('sminus', $sminus)
            ->with('c', $c);
    }

    public function hiring($id)
    {
        $cvs = CV::where([['recruiting_id', '=', $id]])->paginate(7);
        $position = Career::select('id', 'title', 'criteria')->where('id', '=', $id)->first();

        $criteria = Career::select('criteria')->where('id', '=', $id)->first();
        $passed = CV::select('id')->where('status', '=', 'passed')->count();

        if ($passed == $criteria->criteria) {

            return view('fontend.career.hiring')->with('done', 'This hiring is finished.')->with('cvs', $cvs)->with('position', $position);
        }



        return view('fontend.career.hiring')->with('cvs', $cvs)->with('position', $position);
    }

    public function finishHiring($id, Request $request)
    {
        $cv_ids = CV::select('id', 'status')->where([['recruiting_id', '=', $id]])->get();

        $criteria = Career::select('criteria')->where('id', '=', $id)->first();

        $passed_id = CV::select('id')->where('status', '=', 'passed')->get()->toArray();

        $number_passed = 0;

        $passed = [];

        foreach ($cv_ids as $cv_id) {
            $str = 'canidate_' . $cv_id->id;

            if ($request->$str) {
                $number_passed++;
                $passed[] = $cv_id->id;
            }
        }

        if ($number_passed > $criteria->criteria)
            return Redirect::back()
                ->with('error', 'The number of candidate you selected is over the limit!');

        foreach ($passed_id as $pid) {
            $k = array_search($pid["id"], $passed);
            if ($k === false) {
                //echo $pid["id"].' will be removed! <br>';

                $cv = CV::find($pid["id"]);
                $cv->status = "applied";
                $cv->save();
            } else {
                //echo $pid["id"].' was hired! <br>';
                unset($passed[$k]);
            }
        }

        foreach ($passed as $p) {
            //echo $p.' will be added! <br>';
            $cv = CV::find($p);
            $cv->status = "passed";
            $cv->save();
        }



        if ($number_passed == $criteria->criteria) {
            $cv_ids = CV::select('id', 'status')->where([['recruiting_id', '=', $id]])->where([['status', '=', 'applied']])->get();
            foreach ($cv_ids as $cv_id) {

                $cv = CV::find($cv_id->id);
                $cv->status = "failed";
                $cv->save();
            }
            return Redirect::back();
        }

        if ($number_passed == $criteria->criteria)
        {
            $car=Career::find($id);
            $car->status=0;
            $car->save();
        }


        return Redirect::back()
            ->with('message', 'Hiring List updated.');



        // foreach ($cv_ids as $cv_id) {
        //     $str = 'canidate_' . $cv_id->id;


        //     if ($request->$str) {

        //         $update = CV::find($cv_id->id);
        //         $update->status = 'passed';
        //         $update->save();
        //         $number_passed++;
        //     }
        //     // else{
        //     //     $update = CV::find($cv_id);
        //     //     $update->status='failed';
        //     //     $update->save();
        //     // }
        // }
        // var_dump($number_passed);

        // if ($number_passed >= $criteria->criteria) {
        //     foreach ($cv_ids as $cv_id) {

        //         $update = CV::find($cv_id->id);
        //         if ($update->status != 'passed') {
        //             $update->status = 'failed';
        //             $update->save();
        //         }
        //     }
        //     $update = Career::find($id);
        //     $update->status = 0;
        //     $update->save();
        // }

        // return Redirect::back()
        //         ->with('message', 'Success!!');
    }
}
