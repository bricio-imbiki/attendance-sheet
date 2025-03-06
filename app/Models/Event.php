<?php

namespace App\Models;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "title", "description", "edition", "localisation", "debut", "fin"
    ];


    /**
     * Les differentes status a associer a un évenement
     *
     * @var array
     */
    private array $status = [
        "A venir",
        "En cours",
        "Terminé"
    ];


    /**
     * Les couleurs de badges pour chaque statut
     *
     * @var array
     */
    private array $colors = [
        "bg-warning",
        "bg-success",
        "bg-danger"
    ];


    /**
     * Cast des attributs provenant de la base de données
     *
     * @var array
     */
    protected $casts = [
        'debut' => 'datetime',
        'fin' => 'datetime'
    ];


    /**
     * Recuperer la clé de statut en fonction de la date de l'évenement
     *
     * @return integer
     */
    private function getStatusKey() : int
    {
        $started = $this->debut->lessThanOrEqualTo(now());
        $ended = $this->fin->lessThan(now());

        $key = null;

        if ($started === false) $key = 0;
        if ($started === true AND $ended === false) $key = 1;
        if ($ended === true) $key = 2;

        return $key;
    }


    /**
     * Recuperer le statut de l'évemenement
     *
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status[$this->getStatusKey()];
    }


    /**
     * Recuperer la couleur de la status
     *
     * @return string
     */
    public function getStatusColor() : string
    {
        return $this->colors[$this->getStatusKey()];
    }


    /**
     * Permet de determiner si un evenement est en cours
     *
     * @return bool
     */
    public function inProgress() : bool
    {
        return $this->getStatusKey() === 1;
    }


    /**
     * Recuperer la disponibilité en format humain pour un évenement a vénir
     *
     * @return string
     */
    public function getDisponibility() : string
    {
        $difference = $this->debut->diffForHumans(now());
        return str_replace('après', ' ', $difference);
    }


    /**
     * Recuperer l'évenements où participer le participant
     *
     * @return BelongsToMany
     */
    public function participants() : BelongsToMany
    {
        return $this->belongsToMany(Participant::class, 'participations', 'event', 'participant')->withPivot([
            'date_participation', 'tranche'
        ]);
    }


    public function participantNumber() : int
    {
        return $this->participants->countBy('pivot.participant')->count();
    }
}
