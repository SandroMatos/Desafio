<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('dashboard') }}">
                @csrf
                <div class="flex items-center justify-start" style="width: 400px">
                    <div class="inline-flex items-center px-2 mb-7">   
                        <label class="block text-left" style="max-width: 400px">
                            <span class="text-gray-700">Rooms</span>
                            <select class="form-select block w-full mt-1", name="room_id">
                                @foreach($rooms as $room)
                                    <option value="{{$room->id}}">{{$room->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <x-button class="ml-3">
                        {{ __('Selecionar') }}
                    </x-button>
                </div>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($calendar != null)
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                    @else
                    <span class="text-gray-700">Selecione uma sala!</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
