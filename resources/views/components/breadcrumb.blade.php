<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
        <li class="inline-flex items-center">
            <a href="/" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                <i class="fa fa-home mr-2"></i>
                Home
            </a>
        </li>
        @if (empty($s_submenu))
            <li>
                <div class="flex items-center">
                    <i class="fa fa-angle-right text-gray-400 mx-1"></i>
                    <span class="text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ $user->menus[$s_menu]['detail'] }}</span>
                </div>
            </li>
        @else
            <li class="flex items-center">
                <a href="{{ route($user->menus[$s_menu]['reference']) }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                    <i class="fa fa-angle-right text-gray-400 mx-1"></i>
                    <span class="md:ml-2" aria-current="page">{{ $user->menus[$s_menu]['detail'] }}</span>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa fa-angle-right text-gray-400 mx-1"></i>
                    <span class="text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ $user->menus[$s_menu]['subs'][$s_submenu]['detail'] }}</span>
                </div>
            </li>
        @endif
    </ol>
</nav>
<h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
    @if (empty($s_submenu))
        {{ $user->menus[$s_menu]['detail'] }}
    @else
        {{ $user->menus[$s_menu]['subs'][$s_submenu]['detail'] }}
    @endif
</h1>
