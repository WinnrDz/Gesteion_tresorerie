@extends('layouts.app')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-2">

            <div class="card p-4">
                <h2 class="text-center mb-4">
                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                </h2>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Prénom:</strong>
                        <p>{{ $candidate->first_name }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Nom:</strong>
                        <p>{{ $candidate->last_name }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Email:</strong>
                        <p>{{ $candidate->email }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Téléphone:</strong>
                        <p>{{ $candidate->phone }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Adresse:</strong>
                        <p>{{ $candidate->location }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Disponibilité:</strong>
                        <p>{{ $candidate->availability }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Années d’expérience:</strong>
                        <p>{{ $candidate->exp_years }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>CV:</strong><br>
                        @if ($candidate->cv)
                            <a href="{{ asset('storage/' . $candidate->cv) }}" target="_blank">
                                Voir CV
                            </a>
                        @else
                            <p>Non disponible</p>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>LinkedIn:</strong><br>
                        <a href="{{ $candidate->linkedIn }}" target="_blank">
                            {{ $candidate->linkedIn }}
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Github:</strong><br>
                        <a href="{{ $candidate->github }}" target="_blank">
                            {{ $candidate->github }}
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Portfolio:</strong><br>
                        <a href="{{ $candidate->portfolio_url }}" target="_blank">
                            {{ $candidate->portfolio_url }}
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Pipeline:</strong>
                        <p>{{ $candidate->recruitment_pipeline }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Notation:</strong>
                        <p>{{ $candidate->notation }}/10</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Compétences:</strong>
                        @foreach ($candidate->skills as $skill)
                            <li>{{ $skill->name }}</li>
                        @endforeach
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Salaire:</strong>
                        <p>{{ $candidate->salary }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Date de candidature:</strong>
                        <p>{{ $candidate->application_date }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Date d’entretien:</strong>
                        <p>{{ $candidate->interview_date }}</p>
                    </div>

                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('candidates.index') }}" class="btn btn-secondary">
                        Retour
                    </a>
                </div>

            </div>

        </div>
    </main>
@endsection
