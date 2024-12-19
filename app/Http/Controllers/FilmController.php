<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Http\Resources\FilmResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index(){
        $films = Film::all();
        return response()->json($films, 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'director' => 'required|string',
            'release_year' => 'required|integer',
            'genre' => 'required',
            'poster' => 'nullable|string',
        ]);

        $films = Film::create($validated);

        if (!$films) {
            return response()->json(['message' => 'Gagal Menambahkan Film'], 500);
        }

        return response()->json($films, 201);
    }

    public function show(Film $film)
    {
        return response()->json($film);

    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'director' => 'sometimes|string',
            'release_year' => 'sometimes|integer',
            'genre' => 'sometimes',
            'poster' => 'nullable|string',// Ubah validasi ini
        ]);

        $film->update($validated);
        return response()->json($film);
    }


    public function destroy(Film $film)
    {

        $film->delete();
        // do right return and return statsu code
        return response()->json(['message' => 'Produk berhasil dihapus'], 204);
    }
    //
}
