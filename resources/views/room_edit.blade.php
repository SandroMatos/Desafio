<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Sala') }}
        </h2>
    </x-slot>

    <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="{{ route('room.update', $room->id) }}">
                    @csrf
                    @method('PUT')
        
                    <!-- Nome da sala -->
                    <div class="flex items-center justify-start">
                        <div class="mb-5">
                            <x-label for="name" :value="__('Nome da sala')" />
            
                            <x-input id="name" class="block mt-1 w-full" value="{{ $room->name }}" type="text" name="name" required autofocus />
                        </div>
    
                        <x-button class="ml-3">
                            {{ __('Salvar') }}
                        </x-button>
                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
