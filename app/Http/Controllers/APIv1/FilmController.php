<?php

namespace App\Http\Controllers\APIv1;

use App\Film;
use App\Http\Controllers\Controller;
use App\Http\Resources\Film as FilmResource;
use App\Http\Resources\FilmCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new FilmCollection(Film::paginate(1));
    }

    /**
     * Get a validator for an incoming film creation request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'rating' => ['required', 'digits_between:1,5'],
            'price' => ['required', 'numeric'],
            'photo' => ['required', 'image'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createFilm(array $data)
    {
        return Film::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-'),
            'description' => $data['description'],
            'release_date' => $data['release_date'],
            'rating' => $data['rating'],
            'price' => $data['price'],
            'photo' => $data['photo'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($film = $this->createFilm($request->all())));

        return new FilmResource($film);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $item = Film::where('slug', $slug)->first();
        return new FilmResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Film::destroy($id);
        } catch (\Exception $e){
            return new Response('', 204);
        }
        return new Response('', 204);
    }
}
