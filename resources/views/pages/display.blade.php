@extends('layouts.app')

@section('content')
<div class="p-4 pb-0 bg-white block sm:flex items-center justify-between border-gray-200 dark:bg-gray-900 dark:border-gray-700">
    <div class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($user->menus[$s_menu]['subs'] as $sub)
                <!-- Button 1 -->
                <a href="{{ route($sub['reference']) }}" class="flex flex-col items-center space-y-2 p-4 bg-gray-100 text-black rounded-lg shadow-md hover:bg-gray-200 transition-all duration-300 ease-in-out">
                    <!-- Icon -->
                    <i class="fa {{ $sub['icon'] }}"></i>
                    <!-- Button Text -->
                    <span class="text-sm md:text-base">{{ $sub['detail'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
