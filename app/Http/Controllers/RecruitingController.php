<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Career;
use Illuminate\Support\Facades\Redirect;

class RecruitingController extends Controller
{
    public function manage()
    {
        $news = Career::where([['status', '=', 1],['owner_id','=',auth()->user()->id]])->paginate(7);
        return view('fontend.career.manage')->with('news', $news);
    }
}
