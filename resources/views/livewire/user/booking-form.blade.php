<div>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $step * 33 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-sm font-medium {{ $step >= 1 ? 'text-primary-600' : 'text-gray-500' }}">Detail Acara</span>
                        <span class="text-sm font-medium {{ $step >= 2 ? 'text-primary-600' : 'text-gray-500' }}">Review</span>
                        <span class="text-sm font-medium {{ $step >= 3 ? 'text-primary-600' : 'text-gray-500' }}">Selesai</span>
                    </div>
                </div>

                <!-- Step 1: Event Details -->
                @if($step === 1)
                <div>
                    <h2 class="text-2xl font-bold mb-6">Detail Acara</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Gedung</label>
                            <p class="mt-1 text-lg font-semibold">{{ $venue->name }}</p>
                        </div>

                        <div>
                            <label for="eventName" class="block text-sm font-medium text-gray-700">Nama Acara *</label>
                            <input type="text" wire:model="eventName" id="eventName" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            @error('eventName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="eventDescription" class="block text-sm font-medium text-gray-700">Deskripsi Acara *</label>
                            <textarea wire:model="eventDescription" id="eventDescription" rows="3" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                            @error('eventDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="startDate" class="block text-sm font-medium text-gray-700">Tanggal Mulai *</label>
                                <input type="date" wire:model="startDate" id="startDate" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="endDate" class="block text-sm font-medium text-gray-700">Tanggal Selesai *</label>
                                <input type="date" wire:model="endDate" id="endDate" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button wire:click="nextStep" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">
                            Lanjut
                        </button>
                    </div>
                </div>
                @endif

                <!-- Step 2: Review -->
                @if($step === 2)
                <div>
                    <h2 class="text-2xl font-bold mb-6">Review Booking</h2>
                    
                    <div class="bg-gray-50 p-4 rounded-md mb-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Booking</h3>
                        
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm text-gray-600">Nama Gedung</p>
                                <p class="font-medium">{{ $venue->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nama Acara</p>
                                <p class="font-medium">{{ $eventName }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Durasi</p>
                                <p class="font-medium">{{ $totalDays }} hari</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Harga per Hari</p>
                                <p class="font-medium">Rp {{ number_format($venue->price_per_day, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Harga</p>
                                <p class="font-medium text-primary-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Upload Dokumen Pendukung</label>
                            <input type="file" wire:model="documents" multiple
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            <p class="mt-1 text-sm text-gray-500">Upload surat permohonan atau dokumen pendukung lainnya (PDF, JPG, PNG)</p>
                            @error('documents.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea wire:model="notes" id="notes" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button wire:click="previousStep" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Kembali
                        </button>
                        <button wire:click="submitBooking" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">
                            Ajukan Booking
                        </button>
                    </div>
                </div>
                @endif

                <!-- Step 3: Success -->
                @if($step === 3)
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <x-heroicon-s-check class="h-6 w-6 text-green-600" />
                    </div>
                    <h2 class="mt-4 text-2xl font-bold text-gray-900">Booking Berhasil Diajukan!</h2>
                    <p class="mt-2 text-sm text-gray-600">Booking Anda telah berhasil diajukan dan sedang menunggu persetujuan admin.</p>
                    <div class="mt-6">
                        <a href="{{ route('user.bookings.index') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">
                            Lihat Booking Saya
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>