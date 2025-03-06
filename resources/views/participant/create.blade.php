@extends('template.base')

@section('content')

<section>
    <div class="col-xl-8 ms-auto me-auto shadow shadow-md p-5">
     <hr class="mb-5">
        <h4 class="text-muted mb-3">Nouveau participant pour l'évenement "{{ $event->title }}"</h4>
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

        <form action="" method="post">

            @csrf

            <div class="row mb-3">
                <div class="col-xl-6">
                    <label class="form-label" for="nom">Nom du participant (<span class="text-danger">*</span>)</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" value="{{ old('nom') }}">
                    @error('nom')
                        <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-xl-6">
                    <label class="form-label" for="prenoms">Prénoms du participant</label>
                    <input type="text" class="form-control @error('prenoms') is-invalid @enderror" name="prenoms" id="prenoms" value="{{ old('prenoms') }}">
                    @error('prenoms')
                        <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xl-6">
                    <label class="form-label" for="email">Adresse e-mail</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-xl-6">
                    <label class="form-label" for="contact">Contact (<span class="text-danger">*</span>)</label>
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" id="contact" value="{{ old('contact') }}">
                    @error('contact')
                        <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xl-12">
                    <label class="form-label" for="organisation">Organisation ou entité</label>
                    <input type="text" class="form-control @error('organisation') is-invalid @enderror" name="organisation" id="organisation" value="{{ old('organisation') }}">
                    @error('organisation')
                        <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!--div class="mb-5 d-flex flex-row justify-content-start">
                <input type="checkbox" name="presence" id="presence" class="form-check-input me-3">
                <label for="presence" class="form-label">Me presenter</label>
            </div-->

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary align-self-end"><i class="fa fa-save me-2"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</section>

@endsection
