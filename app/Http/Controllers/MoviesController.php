<?php

namespace App\Http\Controllers;
use App\Models\Movies;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movies::get();
        if($movies!=null){
            return response()->json([
                'success' => true,
                'message' => 'Movies retrieved successfully',
                'data' => $movies
            ], 200);}
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Movies not found',
                ], 404);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $request->validate([
            'title' => 'required|min:2|max:255',
            'director' => 'required|min:2|max:255',
            'year' => 'required|integer|min:1900|max:2021',
            'synopsis' => 'required|min:2|max:1000',
        ]);

        $input = $request->all();
        $movie = Movies::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Movie created successfully',
            'data' => $movie
        ], 200);
    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed. ' . $e->getMessage(),
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Movie not created. ' . $e->getMessage(),
        ], 500);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movies::find($id);
        if($movie!=null){
            return response()->json([
                'success' => true,
                'message' => 'Movie retrieved successfully',
                'data' => $movie
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $movie = Movies::find($id);

    if (!$movie) {
        return response()->json([
            'success' => false,
            'message' => 'Movie not found',
        ], 404);
    }
    $movie->update($request->all());
    return response()->json([
        'success' => true,
        'message' => 'Movie updated successfully',
        'data' => $movie
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movies::find($id);
        if($movie!=null){
            $movie->delete();
            return response()->json([
                'success' => true,
                'message' => 'Movie deleted successfully',
                'data' => $movie
            ], 200);}
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Movie not deleted',
                ], 500);
            }
    }
}
