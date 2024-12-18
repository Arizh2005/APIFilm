<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Http\Resources\FilmResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index(){
        $films = Film::latest()->paginate(5);
        return new FilmResource(true, 'Data Film', $films);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'director' => 'required',
            'release_year' => 'required|integer',
            'genre' => 'required',
        ]);


        $film = Film::create([
            'title' => $request->title,
            'description' => $request->description,
            'director' => $request->director,
            'release_year' => $request->release_year,
            'genre' => $request->genre,
        ]);

        return new FilmResource(true, 'Film created successfully', $film);
    }

    public function show($id)
    {
        $film = Film::findOrFail($id);

        $film->poster = $film->poster ? Storage::url($film->poster) : null;

        return new FilmResource(true, 'Film retrieved successfully', $film);
    }

    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'director' => 'sometimes|required',
            'release_year' => 'sometimes|required|integer',
            'genre' => 'sometimes|required',
        ]);

        $film->update([
            'title' => $request->title ?? $film->title,
            'description' => $request->description ?? $film->description,
            'director' => $request->director ?? $film->director,
            'release_year' => $request->release_year ?? $film->release_year,
            'genre' => $request->genre ?? $film->genre,
        ]);

        return new FilmResource(true, 'Film updated successfully', $film);
    }


    public function destroy($id)
    {
        $film = Film::findOrFail($id);

        Storage::disk('public')->delete($film->poster);

        $film->delete();

        return new FilmResource(true, 'Film deleted successfully', null);
    }
    //
}
