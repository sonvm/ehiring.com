<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\HiringBoard;
use App\Models\Career;
use App\Models\CV;
use App\Models\Rating;
use Illuminate\Support\Facades\Redirect;

class HiringBoardController extends Controller
{
    public function manageHB($id)
    {
        return view('fontend.hiring-board.manage')->with(['id'=>$id,'name'=>auth()->user()->name]);
    }

    public function manageMyHB()
    {
        $myHBs = HiringBoard::select('id','recruiting_id')->where([['user_id','=',auth()->user()->id]])->paginate(7);
        foreach($myHBs as $hb){
            $hb->position=Career::where('id','=',$hb->recruiting_id)->first();
        }
        
        return view('fontend.hiring-board.manage')->with('cvs',$myHBs);
    }

    public function ratingApplicants($id)
    {
        $cvs = CV::where([['recruiting_id','=',$id]])->paginate(7);
        $position=Career::select('title')->where('id','=',$id)->first();
        
        
        return view('fontend.hiring-board.applicants')->with('rid',$id)->with('cvs',$cvs)->with('position',$position);
    }
}
