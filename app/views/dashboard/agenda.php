<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="dns-prefetch" href="//unpkg.com" />
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <link rel="stylesheet" href="/css/style.css">
</head>
<!-- component -->
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div
        class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">

        <!-- Header -->
        <div class="fixed w-full flex items-center justify-between h-14 text-white z-10">
            <div
                class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-blue-800 dark:bg-gray-800 border-none">
                <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden"
                    src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg" />
                <span
                    class="hidden md:block"><?php echo $userName?></span>
            </div>
            <div class="flex justify-between items-center h-14 bg-blue-800 dark:bg-gray-800 header-right">
                <div
                    class="bg-white rounded flex items-center w-full max-w-xl mr-4 p-2 shadow-sm border border-gray-200">
                    <button class="outline-none focus:outline-none">
                        <svg class="w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <input type="search" name="" id="" placeholder="Search"
                        class="w-full pl-3 text-sm text-black outline-none focus:outline-none bg-transparent" />
                </div>
                <ul class="flex items-center">
                    <li>
                        <button aria-hidden="true" @click="toggleTheme"
                            class="group p-2 transition-colors duration-200 rounded-full shadow-md bg-blue-200 hover:bg-blue-200 dark:bg-gray-50 dark:hover:bg-gray-200 text-gray-900 focus:outline-none">
                            <svg x-show="isDark" width="24" height="24"
                                class="fill-current text-gray-700 group-hover:text-gray-500 group-focus:text-gray-700 dark:text-gray-700 dark:group-hover:text-gray-500 dark:group-focus:text-gray-700"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <svg x-show="!isDark" width="24" height="24"
                                class="fill-current text-gray-700 group-hover:text-gray-500 group-focus:text-gray-700 dark:text-gray-700 dark:group-hover:text-gray-500 dark:group-focus:text-gray-700"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    </li>
                    <li>
                        <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
                    </li>
                    <li>
                        <a href="/user/logout" class="flex items-center mr-4 hover:text-blue-100">
                            <span class="inline-flex mr-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </span>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ./Header -->

        <!-- Sidebar -->
        <div
            class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-blue-900 dark:bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
            <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
                <ul class="flex flex-col py-4 space-y-1">
                    <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                        </div>
                    </li>
                    <li>
                        <a href="/dashboard"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/agenda"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Book a session</span>
                        </a>
                    </li>
                    <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center mt-5 h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Settings</div>
                        </div>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Settings</span>
                        </a>
                    </li>
                </ul>
                <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">Copyright @2021</p>
            </div>
        </div>
        <!-- ./Sidebar -->

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64">
            <div class="antialiased sans-serif bg-gray-100">
                <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                    <div class="container mx-auto px-4 py-2 md:py-5">
                        <div class="font-bold text-gray-800 text-xl mb-4">
                            Book a Session
                        </div>
                        <div class="bg-white rounded-lg shadow overflow-hidden">

                            <div class="flex items-center justify-between py-2 px-6">
                                <div>
                                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                    <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                </div>
                                <div class="border rounded-lg px-1" style="padding-top: 2px;">
                                    <button type="button"
                                        class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center"
                                        :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                        :disabled="month == 0 ? true : false" @click="month--; getNoOfDays()">
                                        <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <div class="border-r inline-flex h-6"></div>
                                    <button type="button"
                                        class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1"
                                        :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                        :disabled="month == 11 ? true : false" @click="month++; getNoOfDays()">
                                        <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="-mx-1 -mb-1">
                                <div class="flex flex-wrap" style="margin-bottom: -40px;">
                                    <template x-for="(day, index) in DAYS" :key="index">
                                        <div style="width: 14.26%" class="px-2 py-2">
                                            <div x-text="day"
                                                class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex flex-wrap border-t border-l">
                                    <template x-for="blankday in blankdays">
                                        <div style="width: 14.28%; height: 120px"
                                            class="text-center border-r border-b px-4 pt-2">
                                        </div>
                                    </template>
                                    <template x-for="(dayObj, dateIndex) in no_of_days" :key="dateIndex">
                                        <div style="width: 14.28%; height: 120px"
                                            class="px-4 pt-2 border-r border-b relative">
                                            <div x-text="dayObj.day"
                                                class="inline-flex w-6 h-6 items-center justify-center cursor-pointer text-center leading-none rounded-full transition ease-in-out duration-100"
                                                :class="{
                                                'bg-blue-500 text-white': isToday(dayObj.day) == true,
                                                'text-gray-700 hover:bg-blue-200': isToday(dayObj.day) == false,
                                                'cursor-not-allowed bg-gray-200': dayObj.disabled
                                                }" @click="dayObj.disabled || showEventModal(dayObj)">
                                            </div>

                                            <div style="height: 80px;" class="overflow-y-auto mt-1">
                                                <template
                                                    x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, dayObj.day).toDateString() )">
                                                    <div class="px-2 py-1 rounded-lg mt-1 overflow-hidden border"
                                                        :class="{
                    'border-blue-200 text-blue-800 bg-blue-100': event.event_theme === 'blue',
                    'border-red-200 text-red-800 bg-red-100': event.event_theme === 'red',
                    'border-yellow-200 text-yellow-800 bg-yellow-100': event.event_theme === 'yellow',
                    'border-green-200 text-green-800 bg-green-100': event.event_theme === 'green',
                    'border-purple-200 text-purple-800 bg-purple-100': event.event_theme === 'purple'
                }" @click="runIt(event)">
                                                        <p x-text="event.event_title"
                                                            class="text-sm truncate leading-tight">
                                                        </p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div style=" background-color: rgba(0, 0, 0, 0.8)"
                        class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full"
                        x-show.transition.opacity="openEventModal">
                        <div class="p-4 max-w-xl mx-auto relative absolute left-0 right-0 overflow-hidden mt-24">
                            <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                                x-on:click="openEventModal = !openEventModal">
                                <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                                </svg>
                            </div>

                            <div class="shadow w-full rounded-lg bg-white overflow-hidden w-full block p-8">

                                <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Add Event Details</h2>

                                <div class="mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event
                                        title</label>
                                    <input
                                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                        type="text" x-model="event_title">
                                </div>

                                <div class="mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event
                                        date</label>
                                    <input
                                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                        type="date" x-model="event_date">
                                </div>

                                <div class="mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event
                                        time</label>
                                    <input
                                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                        type="time" x-model="event_time">
                                </div>

                                <div class="inline-block w-64 mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Select a
                                        theme</label>
                                    <div class="relative">
                                        <select @change="event_theme = $event.target.value;" x-model="event_theme"
                                            class="block appearance-none w-full bg-gray-200 border-2 border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-gray-700">
                                            <template x-for="(theme, index) in themes">
                                                <option :value="theme.value" x-text="theme.label"></option>
                                            </template>

                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 text-right">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2"
                                        @click="openEventModal = !openEventModal">
                                        Cancel
                                    </button>
                                    <button type="button"
                                        class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm"
                                        @click="addEvent()">
                                        Save Event
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Modal -->

                    <!-- Event Details Modal -->
                    <div style=" background-color: rgba(0, 0, 0, 0.8)"
                        class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full"
                        x-show.transition.opacity="openEventDetailsModal">
                        <div class="p-4 max-w-xl mx-auto relative absolute left-0 right-0 overflow-hidden mt-24">
                            <div class="shadow w-full rounded-lg bg-white overflow-hidden w-full block p-8">

                                <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Event Details</h2>

                                <div class="mb-4">
                                    <p class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Title:</p>
                                    <p x-text="selectedEvent.event_title" class="text-gray-700 leading-tight"></p>
                                </div>

                                <div class="mb-4">
                                    <p class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Date:</p>
                                    <span x-text="date_formatted(selectedEvent.event_date)"></span>
                                </div>

                                <div class="mb-4">
                                    <p class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Time:</p>
                                    <p x-text="selectedEvent.event_time" class="text-gray-700 leading-tight"></p>
                                </div>

                                <div class="mb-4">
                                    <p class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Theme:</p>
                                    <p x-text="selectedEvent.event_theme" class="text-gray-700 leading-tight"></p>
                                </div>

                                <div class="mt-8 text-right">
                                    <button type="button"
                                        class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm"
                                        @click="openEventDetailsModal = false">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Event Details Modal -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/darkmode.js">
</script>
<script src="/js/agenda.js"></script>