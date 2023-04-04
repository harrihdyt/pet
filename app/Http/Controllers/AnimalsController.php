<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AnimalsController extends Controller
{
    
    public function all_pets()
    {
        $pets = Pet::all();

        return response()->json([
            'status' => '200',
            'data' => $pets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'pets_type', 'weight', 'age');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'pets_type' => 'required|string',
            'weight' => 'required|string',
            'age' => 'required|string'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $pets = Pet::create([
        	'name' => $request->name,
        	'pets_type' => $request->pets_type,
            'weight' => $request->weight,
            'age' => $request->age
        ]);

        //User created, return success response
        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'Create pets successfully',
            'data' => $pets
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function show(Animals $animals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function edit(Animals $animals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animals $animals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animals $animals)
    {
        //
    }
}
