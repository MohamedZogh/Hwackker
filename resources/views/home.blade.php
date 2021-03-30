@extends('layout')

@section('content')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <img src="/logo.svg" alt="Logo">
            </div>

            <div class="flex justify-center mt-12">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            </div>
        </div>
    </div>
@endsection
