<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Participant extends Model
{
    use HasFactory;

    protected $with = [
        'events'
    ];

    protected $fillable = [
        "nom", "prenoms", "email", "contact", "organisation"
    ];


    /**
     * Recuperer le nom complet du participant
     *
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return trim(strtoupper($this->nom) . " " . $this->prenoms);
    }


    /**
     * Recuperer l'évenements où participer le participant
     *
     * @return BelongsToMany
     */
    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'participations', 'participant', 'event')->withPivot([
            'date_participation', 'tranche'
        ]);
    }


    public function participe(string $date, int $tranche) : bool
    {
        $participation = $this->events()->wherePivot('date_participation', $date)->wherePivot('tranche', $tranche);
        return $participation->count() > 0;
    }
}
