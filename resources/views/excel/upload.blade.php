  @extends('layouts.app')

  @section('content')

      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

          <!-- Button trigger modal -->
          <button type="button" class="btn bg-gradient-primary btn-lg w-70 p-3 m-5" data-bs-toggle="modal"
              data-bs-target="#exampleModal">
              Upload Excel
          </button>

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
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Upload Excel</h5>
                          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                      </div class="input-group input-group-outline mb-3">
                      <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="mb-3 p-3">
                              <label class="form-label text-sm">Upload file</label>
                              <input type="file" name="file" accept=".xlsx,.xls" required class="form-control">
                          </div>

                          <div class="input-group input-group-outline mb-3 m-3 w-80">
                              <label class="form-label">Year</label>
                              <input type="text" name="year" class="form-control">
                          </div>


                          <div class="modal-footer">
                              <button type="button" class="btn bg-gradient-secondary"
                                  data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn bg-gradient-primary">Upload</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>



      </main>
  @endsection
