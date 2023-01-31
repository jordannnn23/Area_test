<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
    <p>dlksldk</p>

    <div class="row">
        @foreach ($response ?? '' as $video)
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading"> {{$video['snippet']['title']}} </div>
                </div>
            </div>
        @endforeach
    </div> --}}



</x-app-layout>