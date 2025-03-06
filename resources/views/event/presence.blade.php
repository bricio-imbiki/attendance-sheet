@extends('template.base')

@section('content')

<section>
    <div class="container px-4  ">
        <hr class="mb-5">
        <h4 class="text-muted mb-3">Présence pour l'évenement "{{ $event->title }}"</h4>
      <hr class="mb-3">

        @if(request()->session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ request()->session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(request()->session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ request()->session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="">
            <form action="" method="post">
                @csrf

                <div class="d-flex my-5 justify-content-between">
                    <div class="d-flex">
                        <input name="date" type="date" value="{{ $date }}" class="form-control me-2" placeholder="Rechercher...">
                    </div>
                    <div class="d-flex justify-content-end">
                        <select class="form-select w-75 me-3" name="tranche">
                            <option @if ($tranche === 0) selected @endif value="0">Matin</option>
                            <option @if ($tranche === 1) selected @endif value="1">Après-midi</option>
                        </select>
                        <button type="submit" class="btn btn-info text-white d-inline-flex align-items-center">
                            <i class="fa fa-refresh me-2 d-inline-block"></i>Valider
                        </button>
                    </div>
                </div>
            </form>

            <div class="d-flex my-5 justify-content-between">
                <form action="" method="get">
                    <div class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Rechercher...">
                        <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="d-flex">
                    <a href="{{ route('event.add-participant', ['event' => $event, 'tranche' => $tranche, 'date' => $date]) }}" class="btn btn-primary me-3">

                        <i class="fa fa-plus me-2"></i>Ajouter un participant
                    </a>
                    <a href="{{ route('participant.create', [$event]) }}" class="btn btn-secondary">

                        <i class="fa fa-plus me-2"></i>Nouveau participant
                    </a>
                </div>
            </div>


            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom et prénoms</th>
                        <th>Adresse e-mail</th>
                        <th>Contact</th>
                        <th>Organisation</th>
                        <th>Présence</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr class="align-middle">
                            <td>{{ $participant->id }}</td>
                            <td>{{ $participant->full_name }}</td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ $participant->contact }}</td>
                            <td>{{ ucfirst($participant->organisation) }}</td>
                            <td>
                                @if ($participant->participe($date, $tranche))
                                    <span class="badge bg-success">Présent</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6">Aucun participant</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $participants->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
