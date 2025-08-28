<div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
    <div class="flex-1 flex flex-col min-h-0 bg-white border-r border-gray-200">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <h1 class="text-xl font-bold text-primary-600">Admin Panel</h1>
            </div>
            <nav class="mt-5 flex-1 px-2 bg-white space-y-1">
                <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <x-heroicon-s-home class="mr-3 flex-shrink-0 h-6 w-6" />
                    Dashboard
                </x-admin-nav-link>
                
                <x-admin-nav-link :href="route('admin.venues.index')" :active="request()->routeIs('admin.venues.*')">
                    <x-heroicon-s-building-office-2 class="mr-3 flex-shrink-0 h-6 w-6" />
                    Kelola Gedung
                </x-admin-nav-link>
                
                <x-admin-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                    <x-heroicon-s-calendar class="mr-3 flex-shrink-0 h-6 w-6" />
                    Kelola Booking
                </x-admin-nav-link>
                
                <x-admin-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                    <x-heroicon-s-calendar-days class="mr-3 flex-shrink-0 h-6 w-6" />
                    Acara Dinas
                </x-admin-nav-link>
                
                <x-admin-nav-link :href="route('admin.calendar.index')" :active="request()->routeIs('admin.calendar.index')">
                    <x-heroicon-s-calendar class="mr-3 flex-shrink-0 h-6 w-6" />
                    Kalender
                </x-admin-nav-link>
            </nav>
        </div>
    </div>
</div>