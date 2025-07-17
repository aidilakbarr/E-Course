  <header class="default-header">
      <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
              <a class="navbar-brand" href="/">
                  <h1 class="text-white">
                      KitaBelajar

                  </h1>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="lnr lnr-menu"></span>
              </button>

              <div class="collapse navbar-collapse justify-content-center align-items-center"
                  id="navbarSupportedContent">
                  <ul class="navbar-nav">
                      <li><a href="/home">Beranda</a></li>
                      <li><a href="/about">Tentang Kami</a></li>
                      <li><a href="/course">Kursus</a></li>
                      <li><a href="/contact">Kontak</a></li>


                      <li>
                          <button class="search">
                              <span class="lnr lnr-magnifier" id="search"></span>
                          </button>
                      </li>
                  </ul>
              </div>
              @if (!Auth::user())
                  <div class="justify-content-end align-items-center">
                      <a href="/auth/login" class="genric-btn primary-border radius">Masuk</a>
                      <a href="/auth/register" class="genric-btn primary radius">Daftar</a>

                  </div>
              @else
                  <div class="d-flex justify-content-end align-items-center position-relative bg-light rounded-circle">
                      <div class="dropdown">
                          <button class="btn p-0 border-0 rounded-circle" type="button" id="avatarDropdown"
                              data-bs-toggle="dropdown" aria-expanded="false">
                              <img src="{{ Auth::user()->profile_url }}" class="rounded-circle" width="48"
                                  height="48" alt="Avatar">
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="avatarDropdown">
                              <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                      data-bs-target="#profileModal">Profile</a></li>
                              <li>
                                  <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="dropdown-item">Logout</button>
                                  </form>
                              </li>
                          </ul>
                      </div>
                  </div>
              @endif

          </div>
      </nav>
      <div class="search-input" id="search-input-box">
          <div class="container">
              <form class="d-flex justify-content-between">
                  <input type="text" class="form-control" id="search-input" placeholder="Search Here" />
                  <button type="submit" class="btn"></button>
                  <span class="lnr lnr-cross" id="close-search" title="Close Search"></span>
              </form>
          </div>
      </div>

  </header>
