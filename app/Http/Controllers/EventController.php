<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class EventController extends Controller
{
    public function presence(Request $request, Event $event) : View
    {
        if ($request->tranche === null) $tranche = $this->getTranche();
        else $tranche = intval($request->tranche);

        if ($request->date === null) $date = date('Y-m-d');
        else $date = Carbon::parse($request->date)->format('Y-m-d');

        $participants = $event->participants()
            ->wherePivot('tranche', $tranche)
            ->wherePivot('date_participation', $date);

        if ($request->search !== null)
        {
            $participants = $participants
                ->where('nom', 'LIKE', "%{$request->search}%")
                ->orWhere('prenoms', 'LIKE', "%{$request->search}%");
        }

        $participants = $participants->paginate(10);

        return view('event.presence', [
            'event' => $event,
            'participants' => $participants,
            'tranche' => $tranche,
            'active' => 'presence',
            'date' => $date
        ]);
    }


    public function savePresence(Request $request, Event $event)
    {
        $data = $request->validate([
            "date" => ['required', 'date', 'date_format:Y-m-d'],
            "tranche" => ['required', 'numeric', 'in:0,1']
        ]);

        return to_route('event.presence', [$event, ...$data]);
    }


    /**
     * Retourner un formulaire d'ajour d'un participant a un évenement
     *
     * @param Request $request
     * @param Event $event
     * @return void
     */
    public function addParticipant(Request $request, Event $event)
    {
        $date = $request->date('date') === null ? date('Y-m-d') : $request->date('date')->format('Y-m-d');
        $tranche = $request->integer('tranche');

        if ($tranche > 1 || $tranche < 0) $tranche = $this->getTranche();

        $participants = Participant::all()->filter(function (Participant $participant) use ($event, $tranche, $date) {
            return $participant->events()
                ->wherePivot('event', $event->id)
                ->wherePivot('tranche', $tranche)
                ->wherePivot('date_participation', $date)
                ->get()
                ->count() === 0;
        });

        return view('participant.add', [
            'event' => $event,
            'participants' => $participants,
            'active' => 'home'
        ]);
    }


    /**
     * Enregistrer un ou plusieurs participants a un évenement
     *
     * @param Request $request
     * @param Event $event
     * @return void
     */
    public function saveParticipant(Request $request, Event $event)
    {
        $data = $request->validate([
            'participants' => ['array'],
            'participants.*' => ['required', 'numeric', 'exists:participants,id'],
            'tranche' => ['required', 'numeric', 'in:0,1'],
            'date' => ['required', 'date', 'date_format:Y-m-d']
        ]);

        $data['participant'] = $data['participants'];

        $this->attachParticipant($event, $data);

        return redirect()->route('event.presence', ['event' => $event, 'date' => $data['date'], 'tranche' => $data['tranche']])
            ->with('success', 'Participant ajoutée avec success');
    }


    public function getTranche() : int
    {
        if (intval(now()->format('H')) >= Carbon::getMidDayAt()) return 1;
        return 0;
    }


    public function attachParticipant(Event $event, array $data)
    {
        $event->participants()->attach($data['participant'], [
            'date_participation' => $data['date'],
            'tranche' => $data['tranche']
        ]);
    }
}
