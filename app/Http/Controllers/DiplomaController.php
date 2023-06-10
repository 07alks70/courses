<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Diploma;
use App\Models\Graphic;
use App\Models\Hypothese;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DiplomaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string',
            'course.id' => 'required|exists:App\Models\Course,id',
            'user.id' => 'required|exists:App\Models\User,id',
            'graphics.*.name' => 'required|string',
            'hypotheses.*.name' => 'required|string',
            'technologies.*.name' => 'required|string'
        ]);

        if ($validator->fails()){
            Response::json($validator->errors()->toArray(), 400)
            ->send();
        }

        $diploma = new Diploma();
        $diploma->name = $request->json()->get('name');
        $diploma->user_id = User::find($request->json()->get('user')['id'])->id;
        $diploma->course_id = Course::find($request->json()->get('course')['id'])->id;
        $diploma->save();

        foreach ($request->json()->get('technologies') as $tech){
            $technology = new Technology();
            $technology->name = $tech['name'];
            $technology->description = $tech['description'];
            $technology->diploma_id = $diploma->id;
            $technology->save();
        }

        foreach ($request->json()->get('hypotheses') as $hyp){
            $hypothese = new Hypothese();
            $hypothese->name = $hyp['name'];
            $hypothese->diploma_id = $diploma->id;
            $hypothese->save();
        }

        foreach ($request->json()->get('graphics') as $rg){
            $graphic = new Graphic();
            $graphic->name = $rg['name'];
            $graphic->diploma_id = $diploma->id;
            $graphic->save();
        }

        return Response::json($diploma->id, 200)
            ->send();

    }

    /**
     * Display the specified resource.
     */
    public function show(Diploma $diploma, User $user)
    {
        $diploma = $user
            ->diplomas()
            ->where(['id' => $diploma->id])
            ->first();

        if ($diploma === null){
            Response::json([], 404)
                ->send();
        }

        $diploma->technologies;
        $diploma->hypotheses;
        $diploma->graphics;
        Response::json($diploma, 200)
            ->send();
    }

}
