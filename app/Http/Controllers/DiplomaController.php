<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Diploma;
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
            'graphics' => 'required|string',
            'hypotheses' => 'required|string',
            'technologies.*.name' => 'required|string'
        ]);

        if ($validator->fails()){
            Response::json($validator->errors()->toArray(), 400)
            ->send();
        }

        $diploma = new Diploma();
        $diploma->name = $request->json()->get('name');
        $diploma->graphics = $request->json()->get('graphics');
        $diploma->hypotheses = $request->json()->get('hypotheses');
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
        Response::json($diploma, 200)
            ->send();
    }

}
