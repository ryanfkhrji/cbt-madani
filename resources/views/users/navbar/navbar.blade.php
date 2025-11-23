<div class="sticky top-0 z-10 shadow-sm navbar bg-white-custom dark:bg-dark-black-custom">
    <div class="navbar-start">
        <a class="btn btn-ghost">
            <img src="{{ asset('assets/logo-sekolah.png') }}" alt="logo-sekolah" class="w-10">
        </a>
    </div>
    <div class="navbar-end">
        <!-- change popover-1 and --anchor-1 names. Use unique names for each dropdown -->
        <button class="font-semibold btn btn-ghost text-black-custom dark:text-white-custom" popovertarget="popover-1"
            style="anchor-name:--anchor-1">
            {{ Auth::check() ? Auth::user()->name : 'Guest' }}
        </button>
        <div class="dropdown dropdown-end">
            <ul class="w-auto shadow-sm dropdown menu rounded-box bg-base-100 dark:bg-dark-black-custom" popover id="popover-1"
                style="position-anchor:--anchor-1">
                <li>
                    <table class="table text-black-custom dark:text-white-custom">
                        <tbody>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td>{{ Auth::check() ? Auth::user()->username : 'Guest' }}</td>
                            </tr>
                            <tr>
                                <td>Nama Peserta</td>
                                <td>:</td>
                                <td>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="font-semibold text-black-custom dark:text-white-custom">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
