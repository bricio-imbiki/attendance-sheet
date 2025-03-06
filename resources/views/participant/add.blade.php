@extends('template.base')

@section('content')

<section>
    <div class="col-xl-8 ms-auto me-auto shadow shadow-md p-5">
       <hr class="mb-5">
        <h4 class="text-muted mb-3">Ajouter un participant a l'évenement "{{ $event->title }}"</h4>
        <hr class="mb-3">

        <form action="" method="post">
            @csrf
            <div class="row">
                <div class="col-xl-12 mb-5">
                    <label for="participants" class="form-label">Participants</label>
                    <select name="participants[]" id="participants" class="form-select" multiple="multiple">
                        @foreach ($participants as $participant)
                            <option value="{{ $participant->id }}">{{ $participant->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary"><i class="fa fa-save me-2"></i>Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        $("#participants").select2({
            placeholder: "Selectionner les participants"
        })
    </script>
@endpush
