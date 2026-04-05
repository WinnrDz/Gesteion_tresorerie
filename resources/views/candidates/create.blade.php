  @extends('layouts.app')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">


              <div class="card p-3">
                  <p class="h1 text-center">Ajouter un candidate</p>
                  <form action="{{ route('candidates.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                          <div class="col-md-6">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Prénom</label>
                                  <input type="text" name="first_name" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Nom</label>
                                  <input type="text" name="last_name" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Email</label>
                                  <input type="email" name="email" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Téléphone</label>
                                  <input type="text" name="phone" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Adresse</label>
                                  <input type="text" name="location" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="input-group input-group-outline my-3">
                                  <textarea name="availability" rows="4" placeholder="Disponibilité" class="form-control"></textarea>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Années d’expérience</label>
                                  <input type="number" name="exp_years" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <input type="file" name="cv" class="form-control">
                                  <span style="transform: translate(-120px, 8px); position: relative;">CV</span>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">LinkedIn Url</label>
                                  <input type="text" name="linkedIn" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Github Url</label>
                                  <input type="text" name="github" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Portfolio Url</label>
                                  <input type="text" name="portfolio_url" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <select name="recruitment_pipeline" class="form-control">
                                      <option value="" disabled selected hidden>Pipeline</option>
                                      <option value="new">Nouveau</option>
                                      <option value="interview">Entretien</option>
                                      <option value="shortlisted">Shortlist</option>
                                      <option value="offer">Offre</option>
                                      <option value="rejected">Rejeté</option>
                                      <option value="hired">Embauché</option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-4">

                              <!-- Select -->
                              <div class="input-group input-group-outline my-3">
                                  <select id="skill-select" class="form-control">
                                      <option value="" disabled selected>Choisir Les compétence</option>
                                      @foreach ($skills as $skill)
                                        <option value="{{$skill->name}}">{{$skill->name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <!-- Tags container -->
                              <div id="tags-container" class="d-flex flex-wrap mt-2"></div>

                              <!-- Hidden input -->
                              <input type="hidden" name="skills" id="skills-hidden">
                              <button type="button" id="add-skill" class="btn btn-secondary btn-sm mt-2">
                                  + Ajouter une compétence
                              </button>

                          </div>

                          <script>
                              let skills = [];

                              const select = document.getElementById('skill-select');
                              const container = document.getElementById('tags-container');
                              const hiddenInput = document.getElementById('skills-hidden');

                              select.addEventListener('change', function() {
                                  let value = this.value;

                                  if (value && !skills.includes(value)) {
                                      skills.push(value);

                                      let tag = document.createElement('span');
                                      tag.classList.add('badge', 'bg-dark', 'me-2', 'mb-1');
                                      tag.innerHTML = `
                ${value} <span style="cursor:pointer; margin-left:5px;">×</span>
            `;

                                      // remove tag
                                      tag.querySelector('span').addEventListener('click', function() {
                                          skills = skills.filter(s => s !== value);
                                          tag.remove();
                                          updateHidden();
                                      });

                                      container.appendChild(tag);
                                      updateHidden();
                                  }

                                  // reset select
                                  this.value = "";
                              });

                              function updateHidden() {
                                  hiddenInput.value = JSON.stringify(skills);
                              }
                          </script>

                          
                          <div class="col-md-4">

                              <!-- Select -->
                              <div class="input-group input-group-outline my-3">
                                  <select id="profile-select" class="form-control">
                                      <option value="" disabled selected>choisir un profil</option>
                                      @foreach ($profiles as $profile)
                                        <option value="{{$profile->name}}">{{$profile->name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <!-- Tags container -->
                              <div id="tags-container-2" class="d-flex flex-wrap mt-2"></div>

                              <!-- Hidden input -->
                              <input type="hidden" name="profiles" id="profiles-hidden">
                              <button type="button" id="add-profile-2" class="btn btn-secondary btn-sm mt-2">
                                  + Ajouter un profil
                              </button>

                          </div>

                          <script>
                              let profiles = [];

                              const select2 = document.getElementById('profile-select');
                              const container2 = document.getElementById('tags-container-2');
                              const hiddenInput2 = document.getElementById('profiles-hidden');

                              select2.addEventListener('change', function() {
                                  let value = this.value;

                                  if (value && !profiles.includes(value)) {
                                      profiles.push(value);

                                      let tag = document.createElement('span');
                                      tag.classList.add('badge', 'bg-dark', 'me-2', 'mb-1');
                                      tag.innerHTML = `
                ${value} <span style="cursor:pointer; margin-left:5px;">×</span>
            `;

                                      // remove tag
                                      tag.querySelector('span').addEventListener('click', function() {
                                          profiles = profiles.filter(s => s !== value);
                                          tag.remove();
                                          updateHidden2();
                                      });

                                      container2.appendChild(tag);
                                      updateHidden2();
                                  }

                                  // reset select
                                  this.value = "";
                              });

                              function updateHidden2() {
                                  hiddenInput2.value = JSON.stringify(profiles);
                              }
                          </script>




                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <select name="level" class="form-control">
                                      <option value="" disabled selected hidden>Niveau</option>
                                      <option value="beginner">Débutante</option>
                                      <option value="intermediate">Intermédiaire</option>
                                      <option value="advanced">Avancée</option>
                                      <option value="expert">Expert</option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Notation</label>
                                  <input type="number" name="notation" min="0" max="10"
                                      class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Salaire</label>
                                  <input type="number" name="salary" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Date de candidature</label>
                                  <input name="application_date" type="text" id="dateCandidature"
                                      class="form-control">
                              </div>
                          </div>

                          <script>
                              flatpickr("#dateCandidature", {
                                  dateFormat: "Y-m-d", // matches the placeholder
                                  allowInput: true, // lets user type manually
                                  wrap: false // not using data-wrap
                              });
                          </script>

                          <div class="col-md-4">
                              <div class="input-group input-group-outline my-3">
                                  <label class="form-label">Date d’entretien</label>
                                  <input name="interview_date" type="text" id="dateEntretien" class="form-control">
                              </div>
                          </div>
                          <script>
                              flatpickr("#dateEntretien", {
                                  dateFormat: "Y-m-d", // matches the placeholder
                                  allowInput: true, // lets user type manually
                                  wrap: false // not using data-wrap
                              });
                          </script>


                          

                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif


                      </div>
                      <div class="d-flex justify-content-center">
                          <button class="btn bg-gradient-dark mb-0" type="submit">Ajouter</button>
                      </div>
                  </form>
              </div>
          </div>

      </main>
  @endsection
