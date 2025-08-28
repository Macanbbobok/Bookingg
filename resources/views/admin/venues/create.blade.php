<x-admin-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Gedung Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Isi form berikut untuk menambahkan gedung baru</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.venues.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Gedung</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700">Kapasitas</label>
                        <input type="number" name="capacity" id="capacity" min="1" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="price_per_day" class="block text-sm font-medium text-gray-700">Harga per Hari (Rp)</label>
                        <input type="number" name="price_per_day" id="price_per_day" min="0" step="1000" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" checked
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Gedung Aktif</label>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Fasilitas</label>
                        <div class="mt-2 grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach(['AC', 'Panggung', 'Sound System', 'Lighting', 'Kursi', 'Meja', 'Proyektor', 'WiFi', 'Parkir'] as $facility)
                            <div class="flex items-center">
                                <input id="facility-{{ $facility }}" name="facilities[]" type="checkbox" value="{{ $facility }}"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="facility-{{ $facility }}" class="ml-2 block text-sm text-gray-900">{{ $facility }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="maintenance_start" class="block text-sm font-medium text-gray-700">Maintenance Start</label>
                        <input type="date" name="maintenance_start" id="maintenance_start"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="maintenance_end" class="block text-sm font-medium text-gray-700">Maintenance End</label>
                        <input type="date" name="maintenance_end" id="maintenance_end"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="images" class="block text-sm font-medium text-gray-700">Gambar Gedung</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <p class="mt-1 text-sm text-gray-500">Unggah beberapa gambar gedung (maks. 5 gambar)</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.venues.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Batal
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan Gedung
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>