<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::paginate(7);
        return view('fontend.criteria.list')->with('criterias', $criterias);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255|unique:App\Models\Criteria,name',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $criteria = new Criteria();
        $criteria->name = $request->name;
        $criteria->is_cost_criteria = ($request->is_cost_criteria) ? 1 : 0;
        $criteria->save();
        return Redirect::to('/criterias')->with('message','Success!');
    }

    public function switch($id)
    {
        $criteria = Criteria::find($id);
        $criteria->is_cost_criteria = ($criteria->is_cost_criteria) ? 0 : 1;
        $criteria->save();
        return Redirect::to('/criterias');
    }
}
