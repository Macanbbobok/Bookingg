<x-admin-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Gedung</h1>
                <p class="mt-1 text-sm text-gray-600">Daftar semua gedung yang tersedia untuk booking</p>
            </div>
            <a href="{{ route('admin.venues.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">
                Tambah Gedung
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($venues as $venue)
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($venue->images)
                                <div class="flex-shrink-0 h-16 w-24 mr-4">
                                    <img class="h-16 w-24 object-cover rounded" src="{{ Storage::url($venue->images[0]) }}" alt="{{ $venue->name }}">
                                </div>
                                @endif
                                <div>
                                    <div class="flex items-center">
                                        <h4 class="text-lg font-medium text-primary-600">{{ $venue->name }}</h4>
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $venue->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $venue->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500">
                                        Kapasitas: {{ $venue->capacity }} orang • 
                                        Harga: Rp {{ number_format($venue->price_per_day, 0, ',', '.') }}/hari
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500">
                                        Fasilitas: {{ implode(', ', $venue->facilities) }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.venues.show', $venue) }}" class="text-blue-600 hover:text-blue-900">
                                    <x-heroicon-s-eye class="h-5 w-5" />
                                </a>
                                <a href="{{ route('admin.venues.edit', $venue) }}" class="text-green-600 hover:text-green-900">
                                    <x-heroicon-s-pencil-square class="h-5 w-5" />
                                </a>
                                <form action="{{ route('admin.venues.destroy', $venue) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gedung ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <x-heroicon-s-trash class="h-5 w-5" />
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @empty
                <li class="px-4 py-4 text-center text-gray-500">
                    Belum ada gedung yang terdaftar.
                </li>
                @endforelse
            </ul>
        </div>

        <div class="mt-4">
            {{ $venues->links() }}
        </div>
    </div>
</x-admin-layout>