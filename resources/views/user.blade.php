@extends('layout')

@section('content')
<div class="bg-white shadow">
    <div class="container mx-auto px-4 py-2 md:py-3">
        <div class="flex justify-between items-center">
            <div class="text-lg md:text-xl font-bold text-gray-800">Hwackker</div>
            <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                Logout
            </a>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-10">
    <div class="flex items-center justify-center">
        <div class="w-12 h-12 rounded-full overflow-hidden">
            <img src="{{ $user->profile_picture }}" alt="avatar">
        </div>
        <h1 class="font-bold text-3xl ml-4">{{ $user->username }} profile</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-10">
    <div class="md:flex -mx-4">
        <div class="w-2/4 px-4">
            <form class="bg-white rounded-lg shadow px-4 py-4 mb-8" action="{{ route('user.hwack') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <textarea name="content" id="hwack_editor" class="mb-2 bg-gray-100 focus:outline-none focus:shadow-outline border border-transparent rounded-lg py-2 px-4 block w-full appearance-none leading-normal placeholder-gray-700" rows="3" placeholder="What's happening..."></textarea>

                <input multiple name="image" id="image" class="" type="file" accept="image/png, image/jpeg, image/webp, image/jpg, image/bmp,image/gif, image/svg">

                <br>

                <label for="private" class="mt-6">
                    Private
                    <input type="checkbox" name="private">
                </label>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 py-2 px-3 font-bold text-white rounded-md">
                        Send Hwack
                    </button>
                </div>
                @csrf
            </form>

            <div class="bg-white rounded-lg shadow mb-8">
                @foreach($hwacks as $hwack)
                @if($hwack->private)
                <div class="px-6 py-5 border-b bg-red-100 last:border-none">
                    @else
                    <div class="px-6 py-5 border-b border-gray-200 last:border-none">
                        @endif
                        <div class="flex w-full">
                            <div class="flex-shrink-0 mr-5">
                                <div class="cursor-pointer font-bold w-12 h-12 bg-gray-300 flex items-center justify-center rounded-full overflow-hidden">
                                    <img src="{{ $user->profile_picture }}" alt="avatar">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div>
                                    <a href="/user?username={{ $hwack->user->username }}" class="text-gray-600 font-bold">{{ '@' . $hwack->user->username }}</a>
                                    <span class="mx-1 text-gray-500">&bull;</span>
                                    <span class="text-gray-600">{{ $hwack->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="mb-4">
                                    <p class="text-gray-700">{!! $hwack->content !!}</p>
                                </div>

                                @if($hwack->image)
                                <div class="relative w-auto mb-2 border rounded-lg relative bg-gray-100 mb-4 shadow-inset overflow-hidden">
                                    <img class="bttrlazyloading" data-bttrlazyloading-lg-src="{{ $hwack->image }}" alt="Hwack image">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {!! $hwacks->links() !!}
            </div>

            <div class="w-2/3 px-4">
                <div class="bg-white rounded-lg shadow mb-8">
                    @if($displayButton)
                        <div class="px-6 py-3 border-b border-gray-200">
                            <div class="font-bold text-gray-800">
                                <button id="follow" data="{{ $user->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Follow
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-3 border-b border-gray-200">
                        <div class="font-bold text-gray-800">Qui me suis ?</div>
                    </div>

                    <div>
                        @foreach($usersFollowed as $userFollowed)
                            <p>{{ $userFollowed }}</p>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-3 border-b border-gray-200">
                        <div class="font-bold text-gray-800">Who to follow</div>
                    </div>

                    <div>
                        {{-- @TODO --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new SimpleMDE({
            element: document.getElementById("hwack_editor")
        });

        document.getElementById('follow').addEventListener('click', async function(){
            const response = await axios.post(
                '{{ route('follow') }}',
                {
                    followed_id: '{{ $user->id }}'
                }
            )
            console.log(response.data);
        });

    </script>
    @endsection
