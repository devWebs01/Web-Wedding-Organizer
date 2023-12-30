<nav aria-label="Main" class="flex-1 px-2 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto">
    <!-- logo links -->
    <div x-data="{ isActive: false, open: false }">
        <span aria-hidden="true">
            <a href="#"
                class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-blue-100 dark:hover:bg-blue-600"
                :class="{ 'bg-blue-100 dark:bg-blue-600': isActive || open }" role="button" aria-haspopup="true"
                :aria-expanded="(open || isActive) ? 'true' : 'false'">
                <span aria-hidden="true">
                    <i class="fa-regular fa-copyright text-2xl"></i> </span>
                <span class="ml-2 text-2xl font-bold"> SI Penjualan </span>
            </a>
    </div>

    <div x-data="{ isActive: false, open: false }">
        <!-- active & hover classes 'bg-blue-100 dark:bg-blue-600' -->
        <a href="/dashboard"
            class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-blue-100 dark:hover:bg-blue-600"
            :class="{ 'bg-blue-100 dark:bg-blue-600': isActive || open }" role="button" aria-haspopup="true"
            :aria-expanded="(open || isActive) ? 'true' : 'false'">
            <span aria-hidden="true">
                <i class="fa-solid fa-house"></i>
            </span>
            <span class="ml-2 text-sm"> Dashboards </span>
        </a>

    </div>

    <div x-data="{ isActive: false, open: false }">
        <!-- active & hover classes 'bg-blue-100 dark:bg-blue-600' -->
        <a href="/admin/categories"
            class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-blue-100 dark:hover:bg-blue-600"
            :class="{ 'bg-blue-100 dark:bg-blue-600': isActive || open }" role="button" aria-haspopup="true"
            :aria-expanded="(open || isActive) ? 'true' : 'false'">
            <span aria-hidden="true">
                <i class="fa-solid fa-layer-group"></i>
            </span>
            <span class="ml-2 text-sm"> Kategori Produk </span>
        </a>
    </div>

    <div x-data="{ isActive: false, open: false }">
        <!-- active & hover classes 'bg-blue-100 dark:bg-blue-600' -->
        <a href="/admin/productss"
            class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-blue-100 dark:hover:bg-blue-600"
            :class="{ 'bg-blue-100 dark:bg-blue-600': isActive || open }" role="button" aria-haspopup="true"
            :aria-expanded="(open || isActive) ? 'true' : 'false'">
            <span aria-hidden="true">
                <i class="fa-solid fa-window-restore"></i>
            </span>
            <span class="ml-2 text-sm"> Produk Toko </span>
        </a>
    </div>

    <!-- Authentication links -->
    <div x-data="{ isActive: false, open: false }">
        <!-- active & hover classes 'bg-blue-100 dark:bg-blue-600' -->
        <a href="#" @click="$event.preventDefault(); open = !open"
            class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-blue-100 dark:hover:bg-blue-600"
            :class="{ 'bg-blue-100 dark:bg-blue-600': isActive || open }" role="button" aria-haspopup="true"
            :aria-expanded="(open || isActive) ? 'true' : 'false'">
            <span aria-hidden="true">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </span>
            <span class="ml-2 text-sm"> Authentication </span>
            <span aria-hidden="true" class="ml-auto">
                <!-- active class 'rotate-180' -->
                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </a>
        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
            <!-- active & hover classes 'text-gray-700 dark:text-light' -->
            <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
            <a href="#" role="menuitem"
                class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                Register
            </a>
            <a href="#" role="menuitem"
                class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                Login
            </a>
            <a href="#" role="menuitem"
                class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                Password Reset
            </a>
        </div>
    </div>
</nav>
