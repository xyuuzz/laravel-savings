    
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

            <li class="nav-item ">
                {{-- Cara agar navbar menjadi active ketika dia ada di menu tersebut --}}
                <a href="/home" class="nav-link {{request()->is('home') ? 'active' : ''}}">
                {{-- Cara baca : jika request (link) nya adalah '/', jika true class = active  --}}
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Home
                </p>
                </a>
            </li>

        <li class="nav-item">
            <a href="#" class="nav-link {{request()->is('kosong') ? 'active' : ''}}">
            <i class="nav-icon fas fa-copy"></i>
            <p>
                Profile
            </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('saving.index') }}" class="nav-link {{request()->is("saving") ? 'active' : ''}}">
            <i class="fas fa-copy nav-icon"></i>
            <p>Tabel Keuangan</p>
            </a>
        </li>

        <li class="nav-item ">
            <a href="#" class="nav-link {{request()->is('info') ? 'active' : ''}}">
            <i class="far fa-circle nav-icon"></i>
            <p>Diary Harian</p>
            </a>    
        </li>


    </ul>
  </nav>
  