@extends('template.base')

@section('content')

<!-- result section-->
<section id="result">
    <div class="container px-4">
        <h1 class="text-muted mb-3">Les dernieres évènements</h1>

        <hr class="mb-5">

        <div class="row gx-4 justify-content-center">
            @foreach ($events as $event)
                <div class="col-xl-4 mb-5">
                    <div class="card shadow">
                        <div class="card-header bg-secondary text-white">
                            <a href="#" class="link-light text-decoration-none">{{ $event->title }}</a>
                        </div>
                        <div class="card-body">
                            <div class="card-title mb-3">
                                <p class="m-0"><span class="fw-bold">Debut:</span> <span class="fst-italic text-primary">{{ $event->debut->format('d-m-Y h:i') }}</span></p>
                                <p class="m-0"><span class="fw-bold">Fin:</span> <span class="fst-italic text-primary">{{ $event->fin->format('d-m-Y h:i') }}</span></i></p>
                                <hr>
                                <span class="badge {{ $event->getStatusColor() }} rounded">{{ $event->getStatus() }}</span>
                            </div>
                            <div class="card-text mb-3">
                                <p style="text-align: justify">{{ substr($event->description, 0, 150) }}...</p>
                            </div>
                            <span><b>Nombre de participant:</b> {{ $event->participantNumber() }}</span>
                        </div>
                        <div class="card-footer text-center">
                            @if ($event->inProgress())
                                <a href="{{ route('event.presence', ['event' => $event, 'tranche' => $tranche, 'date' => date('Y-m-d')]) }}" class="text-secondary fw-bold text-decoration-none text-uppercase">Faire une présence</a>
                            @else
                                <span class="text-secondary fw-bold text-decoration-none text-uppercase">Disponible dans {{ $event->getDisponibility() }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
</section>

@endsection
