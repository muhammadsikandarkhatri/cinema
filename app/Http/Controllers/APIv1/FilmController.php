<?php

namespace App\Http\Controllers\APIv1;

use App\Events\FilmCreated;
use App\Film;
use App\Http\Controllers\Controller;
use App\Http\Resources\Film as FilmResource;
use App\Http\Resources\FilmCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'price' => ['required', 'numeric', 'min:1'],
            'country' => ['required', 'exists:countries,id'],
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
            'country_id' => $data['country'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-'),
            'description' => $data['description'],
            'release_date' => Carbon::parse($data['release_date'])->format('yy-m-d'),
            'rating' => $data['rating'],
            'price' => $data['price'],
            'photo' => isset($data['photo_path']) ? $data['photo_path'] : '',
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

        if ($request->file('photo')->isValid()) {
            $path = $request->file('photo')->store('photos');
            $request->request->add(['photo_path' => $path]);
        }

        event(new FilmCreated($film = $this->createFilm($request->all())));

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
