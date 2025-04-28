<!-- Top Info Bar -->
<div class="top-info-bar" style="z-index: 1050;position: relative;">
    <div class="container">
      <div class="info-content">
        <div class="weather-info">
            <i ></i> <span id="weather">Detecting location...</span>
        </div>
        <div class="time-info">
            <i class="far fa-clock"></i> Local Time: <span id="localTime">Loading...</span>
        </div>
        <div class="contact-info">
          <a href="tel:+62123456789"
            ><i class="fas fa-phone"></i> Emergency: +62 123 456 789</a
          >
        </div>
      </div>
    </div>
  </div>
  <!-- Main Navigation -->
  <nav class="navbar navbar-expand-lg premium-navbar" >
    <div class="container">
      <a class="navbar-brand" href="#">
        <div class="brand-content">
            <div class="logo-container" style="display: flex; align-items: center; justify-content: center; position: relative;">
                <i class="fa-solid fa-plane" style="font-size: 24px; position: absolute; z-index: 2;"></i>
                <span class="logo-circle" style="width: 60px; height: 60px; background-color: #003285; border-radius: 50%; position: absolute; z-index: 1;"></span>
            </div>
          <div class="brand-text">
            <span class="brand-title">SkyGate</span>
            <span class="brand-subtitle">Fast & Easy Flight Booking</span>
          </div>
        </div>
      </a>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContent"
      >
        <span class="toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="#">
              <span class="nav-icon"><i class="fas fa-home"></i></span>
              <span class="nav-text">Home</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('flights.index') }}" class="nav-link {{ Request::routeIs('flights.index') ? 'active' : '' }}" href="#">
              <span class="nav-icon"
                ><i class="fas fa-plane-departure"></i
              ></span>
              <span class="nav-text">Flights</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('transactions.index') }}" class="nav-link {{ Request::routeIs('transactions.index') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-receipt"></i></span>
                <span class="nav-text">Transactions</span>
            </a>
          </li>
        </ul>

        <div class="nav-actions">
          <div class="search-container">
            <input
              type="text"
              class="search-input"
              placeholder="Search flights..."
            />
            <button class="search-btn">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div class="action-buttons">
            <button class="btn btn-language">
              <i class="fas fa-globe"></i>
              <span>EN</span>
            </button>
            @if(Auth::guard('customers')->check())
                <!-- Jika sudah login, tampilkan tombol logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            @else
                <!-- Jika belum login, tampilkan tombol login -->
                <div class="action-buttons">
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="fas fa-user"></i>
                        <span>Login</span>
                    </a>
                </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </nav>
