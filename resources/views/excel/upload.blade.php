@extends('layouts.app')

@section('content')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="row">
            <div class="ms-3">
                <h3 class="mb-0 h4 font-weight-bolder">Gestion Excel</h3>
                <p class="mb-4">
                    Remarque : le fichier doit respecter exactement ce
                    <a href="{{ asset('assets/excel/Exemple Gestion de tresorerie.xlsx') }}" style="font-weight: bold"
                        download>format.</a>
                </p>
            </div>

            <div class="ms-3 d-flex gap-3 mb-4">
                <!-- Import Button -->
                <button type="button" class="btn bg-gradient-primary btn-lg flex-fill p-3" data-bs-toggle="modal"
                    data-bs-target="#importModal">
                    Import Excel
                </button>

                <!-- Export Button -->
                <button type="button" class="btn bg-gradient-success btn-lg flex-fill p-3" data-bs-toggle="modal"
                    data-bs-target="#exportModal">
                    Export Excel
                </button>
            </div>

            <!-- Display errors -->
            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <!-- Import Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-normal" id="importModalLabel">Import Excel</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 p-3">
                                    <label class="form-label text-sm">Import file</label>
                                    <input type="file" name="file" accept=".xlsx,.xls" required class="form-control">
                                </div>

                                <div class="input-group input-group-outline mb-3 m-3 w-80">
                                    <label class="form-label">Year</label>
                                    <input type="text" name="year" class="form-control">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-primary">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Modal -->
            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-normal" id="exportModalLabel">Export Excel</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('excel.export') }}" method="POST">
                                @csrf

                                <div class="input-group input-group-outline mb-3 m-3 w-80">
                                    <label class="form-label">Year</label>
                                    <input type="text" name="year" class="form-control"
                                        required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-success">Export</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection
