  <header class="default-header">
      <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
              <a class="navbar-brand" href="index.html">
                  <img src="img/logo.png" alt="" />
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="lnr lnr-menu"></span>
              </button>

              <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
                  <ul class="navbar-nav">
                      <li><a href="/home">Home</a></li>
                      <li><a href="/about">About</a></li>
                      <li><a href="/course">Courses</a></li>
                      <li><a href="/contact">Contacts</a></li>

                      <li>
                          <button class="search">
                              <span class="lnr lnr-magnifier" id="search"></span>
                          </button>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
      <div x-data="{ isOpen: false, isProfileOpen: false }" class="relative w-1/2 flex justify-end">

          <button @click="isOpen = !isOpen"
              class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
              <img
                  src="{{ Auth::user()->profile ? asset('storage/' . Auth::user()->profile) : asset('images/default-profile.png') }}">
          </button>
          <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">

              <button @click="isProfileOpen = !isProfileOpen" href="#"
                  class="text-center w-full py-2 hover:text-white account-link">
                  Profile
              </button>
              <form action="{{ route('auth.logout') }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-center w-full py-2 account-link hover:text-white">Logout</button>
              </form>
          </div>
          @include('partials.profile-modal')
      </div>
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
