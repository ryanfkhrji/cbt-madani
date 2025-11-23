<div class="sticky top-0 left-0 z-10 navbar bg-white-custom dark:bg-dark-black-custom">
    <div class="flex-1 lg:hidden">
        <label for="my-drawer-2">
            <i class="text-xl cursor-pointer fa-solid fa-bars text-black-custom dark:text-white-custom"></i>
        </label>
    </div>
    <div class="flex justify-end flex-1">
        <div class="dropdown dropdown-end"></div>
        <div class="dropdown dropdown-end">
            <div class="flex items-center gap-2">
                <h4 class="text-sm font-semibold text-black-custom md:text-md dark:text-white-custom">{{ Auth::user()->name }}</h4>
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="logo-admin" src="{{ asset('storage/profile/admin/' . Auth::user()->image) }}" />
                    </div>
                </div>
            </div>
            <ul tabindex="0" class="p-2 mt-3 shadow menu menu-sm dropdown-content bg-base-100 rounded-box z-1 w-52 dark:bg-dark-black-custom">
                <li>
                    <a class="flex flex-col gap-1 font-semibold text-black-custom hover:bg-light-blue-custom dark:text-white-custom dark:hover:bg-gray-600">
                        {{ Auth::user()->name }}
                        <span class="text-xs font-light text-gray-custom">{{ Auth::user()->username }}</span>
                    </a>
                </li>
                <li><a href="/profile" class="font-semibold text-black-custom hover:bg-light-blue-custom dark:text-white-custom dark:hover:bg-gray-600"><i
                            class="fa-regular fa-user"></i>Profile</a></li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="font-semibold text-black-custom hover:bg-light-blue-custom dark:text-white-custom dark:hover:bg-gray-600">
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
