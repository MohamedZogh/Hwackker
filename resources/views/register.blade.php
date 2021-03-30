@extends('layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-16 w-auto" src="/logo.svg" alt="Logo">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Register
                </h2>
            </div>

            @if(!empty($errors))
                <ul class="text-red-500">
                    @foreach ($errors->all() as $message)
                        <li>- {{ $message }}</li>
                    @endforeach
                </ul>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                <div class="rounded-md shadow-sm">
                    <div class="mb-4">
                        <label for="profile_picture" class="">Profile picture</label>
                        <input id="profile_picture" name="profile_picture" required type="file" class="mt-5">
                    </div>
                    <div class="mb-4">
                        <label for="username" class="sr-only">Username</label>
                        <input id="username" name="username" placeholder="Username" required value="{{ old('username') }}" class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="birth_date" class="sr-only">Birth date</label>
                        <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date') }}"  class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Birth date">
                    </div>
                     <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <label for="country" class="sr-only">Country</label>
                        <select id="country" name="country" required class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500 bg-white">
                            <option value="FR" {{ old('country') === 'FR' ? 'selected' : '' }}>France</option>
                            <option value="DE {{ old('country') === 'DE' ? 'selected' : '' }}">Germany</option>
                            <option value="IT {{ old('country') === 'IT' ? 'selected' : '' }}">Italy</option>
                            <option value="ES {{ old('country') === 'ES' ? 'selected' : '' }}">Spain</option>
                            <option value="PT {{ old('country') === 'PT' ? 'selected' : '' }}">Portugal</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="facebook_url" class="sr-only">Facebook url</label>
                        <input id="facebook_url" name="facebook_url" required value="{{ old('facebook_url') }}" class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Facebook url">
                    </div>
                    <div class="mb-4">
                        <label for="twitter_url" class="sr-only">Twitter url</label>
                        <input id="twitter_url" name="twitter_url" required value="{{ old('twitter_url') }}" class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Twitter url">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Password">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="sr-only">Password confirmation</label>
                        <input id="password" name="password_confirmation" type="password" required class="rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Password confirmation">
                    </div>
                    @csrf
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
