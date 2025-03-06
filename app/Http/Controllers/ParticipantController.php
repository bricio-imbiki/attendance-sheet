<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use App\Http\Requests\Participant\NewParticipantRequest;

class ParticipantController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $participants = Participant::paginate(10);

        return view('participant.create', [
            'participants' => $participants
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return View
    */
    public function create(Event $event) : View
    {
        return view('participant.create', [
            'event' => $event,
            'active' => 'home'
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  NewParticipantRequest  $request
    * @return Response
    */
    public function store(NewParticipantRequest $request, Event $event)
    {
        $data = $request->validated();

        try
        {
            $participant = Participant::create($data);

            $this->attachParticipant($event, [
                'participant' => $participant->id,
                'date' => date('Y-m-d'),
                'tranche' => $this->getTranche()
            ]);

            return back()->with('success', 'Enregistré avec success');
        }
        catch (QueryException $e)
        {
            return back()->with('error', "Impossible d'enregistrer: {$e->getMessage()}")->withInput();
        }
    }

    public function attachParticipant(Event $event, array $data)
    {
        $event->participants()->attach($data['participant'], [
            'date_participation' => $data['date'],
            'tranche' => $data['tranche']
        ]);
    }

    public function getTranche() : int
    {
        if (intval(now()->format('H')) >= Carbon::getMidDayAt()) return 1;
        return 0;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  Participant  $participant
    * @return Response
    */
    public function destroy(Participant $participant)
    {
        $participant->delete();
    }
}
