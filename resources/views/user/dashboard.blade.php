<x-user-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Dashboard User</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Stats Cards -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                                    <x-heroicon-s-calendar class="h-6 w-6 text-blue-600" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Booking</p>
                                    <p class="text-2xl font-bold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow">
                            <div class="flex items-center">
                                <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                                    <x-heroicon-s-clock class="h-6 w-6 text-yellow-600" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Pending Approval</p>
                                    <p class="text-2xl font-bold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-lg mr-4">
                                    <x-heroicon-s-check-badge class="h-6 w-6 text-green-600" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Approved</p>
                                    <p class="text-2xl font-bold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Booking Terbaru</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-500 text-center">Belum ada booking</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>