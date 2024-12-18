<aside id="sidebar" class="hidden fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
        <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            <ul class="pb-2 space-y-2">
            @foreach ($user->menus as $mn => $menu)
                @if ($menu['branched'])
                    <li>
                        <button type="button" class="{{ $mn == $s_menu ? 'active' : '' }} flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" aria-controls="{{ $mn }}" data-collapse-toggle="{{ $mn }}">
                            <i class="fa {{ $menu['icon'] }} text-xl flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $menu['detail'] }}</span>
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul id="{{ $mn }}" class="{{ $mn == $s_menu ? '' : 'hidden' }} py-2 space-y-2">
                            @foreach ($menu['subs'] as $sb => $sub)
                                <li>
                                    <a href="{{ route($sub['reference']) }}" class="{{ $sb == $s_submenu ? 'active' : '' }}  flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">{{ $sub['detail'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['reference']) }}" class="{{ $mn == $s_menu ? 'active' : '' }} flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa {{ $menu['icon'] }} text-xl text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                            <span class="ml-3" sidebar-toggle-item>{{ $menu['detail'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
            </ul>
        </div>
    </div>
</aside>

<div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
