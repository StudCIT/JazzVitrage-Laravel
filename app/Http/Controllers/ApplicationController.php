<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Evaluation;
use App\Models\GroupPeople;
use App\Models\ApplicationType;
use App\Models\Preparation;
use App\Models\Presentation;

class ApplicationController extends Controller
{
    public function index()
    {	
        return view('application');
    }

    public function store(Request $request)
    {
        // TO DO
    }

     public function getMembers()
     {
         $data = Application::with('appType', 'soloDuet', 'group')->get();
         return response()->json($data);
     }
     
     public function getAllMembers()
     {
         $data = Application::with('appType', 'soloDuet', 'group')->where('status', '!=', 'archive')->get();
         return response()->json($data);
     }

     public function getMember($id)
     {
         $data = Application::with('appType', 'soloDuet', 'group', 'preparation', 'presentation')->where('application_id', '=', $id)->get();
         return response()->json($data);
     }

    public function archiveMembers($id)
    {
        $model = Application::find($id);

        $model->status = 'archive';

        if($model->save()){
            return 'ok';
        }

    }
    public function unarchiveMembers($id)
    {
        $model = Application::find($id);

        $model->status = 'created';

        if($model->save()){
            return ;
        }

    }
    public function deleteMembers($id)
    {
        $model = Application::find($id);

        if($model->delete()){
            return ;
        }

    }
    /** 
     * To rate
     * 
     * App\Models\Application $id
     * Illuminate\Http\Request $request 
     **/
    public function toRate(Request $request, $id) {

        ///$model = Application::find($id)->evaluations;
        //$ev = Evaluation::find(1);
    
        return ($ev);
       // $data = $model->evaluations;
        //return $model;

        // minor evaluation
        // $min = 0;
        // $max = 25;
        // $validatedData = $request->validate([
        //     'artistic_value' => "required|numeric|min:$min|max:$max",
        //     'artistry' => "required|numeric|min:$min|max:$max",
        //     'evaluation' => "required|numeric|min:$min|max:100", // total rate 100
        //     'originality' => "required|numeric|min:$min|max:$max",
        //     'stylistic_matching' => "required|numeric|min:$min|max:$max"
        // ]);

        // $data = $request->all();
        // $model->update($data);

        // return response('ok', 200);
    }
}
