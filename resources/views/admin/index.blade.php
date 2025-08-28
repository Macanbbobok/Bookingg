<x-admin-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kalender Terintegrasi</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola acara dinas dan booking gedung dalam satu kalender</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900">Legenda</h3>
                <div class="mt-2 flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-100 border border-green-300 rounded mr-2"></div>
                        <span class="text-sm">Acara Dinas</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-100 border border-blue-300 rounded mr-2"></div>
                        <span class="text-sm">Booking Disetujui</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-100 border border-yellow-300 rounded mr-2"></div>
                        <span class="text-sm">Booking Pending</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-100 border border-red-300 rounded mr-2"></div>
                        <span class="text-sm">Booking Ditolak</span>
                    </div>
                </div>
            </div>

            @livewire('admin.calendar-manager')
        </div>
    </div>
</x-admin-layout>