@extends('layouts.guest')

@section('content')
<h2 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white">
    Forgot your password?
</h2>
<p class="text-base font-normal text-gray-500 dark:text-gray-400">
    Don't fret! Just type in your email and we will send you a code to reset your password!
</p>

<form class="mt-8 space-y-6" action="#">
    <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required />
    </div>
    <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Reset Password</button>
    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
        Change of mind? <a href="{{ route('signin') }}" class="text-blue-700 hover:underline dark:text-blue-500">Login here</a>
    </div>
</form>
@endsection
