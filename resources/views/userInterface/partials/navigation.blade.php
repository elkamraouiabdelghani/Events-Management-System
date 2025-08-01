<nav class="navbar navbar-expand-lg bg-white p-3 shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('Accueil') }}">Events</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('Événements') }}">Événements</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('contact') }}">Contact</a> 
          </li>
        </ul>
      </div>
    </div>
  </nav>