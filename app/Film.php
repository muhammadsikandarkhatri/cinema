<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'name',
        'slug',
        'description',
        'release_date',
        'rating',
        'price',
        'photo',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['genres', 'country'];

    /**
     * Film belongs to many Genres
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres(){
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    /**
     * Film belongs to a country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
