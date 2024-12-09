<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" as="style" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>


<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
 
    
    <div class="flex fixed top-0 w-full z-10 p-3 md:p-4 justify-between items-center rounded-b-2xl bg-base-100 dark:bg-base-200">
        <div class="flex items-center justify-start">
            <label for="main-drawer" class="lg:hidden ms-2">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
            <div class="ms-5 hidden md:block">
                <x-app-brand />
            </div>
            <a wire:navigate href="{{url('/')}}" class="font-bold ms-4 text-emerald-600 pt-1 md:hidden text-xl">{{ $title ?? 'GSD' }}</a>
        </div>

        <div class="flex items-center justify-end sm:pe-3 gap-1 sm:gap-4">

            <x-theme-toggle darkTheme="dark" lightTheme="light" class="mt-1" />
            <x-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive />
            <div x-data="internetStatus">
                <template x-if="online">
                    <x-icon name="s-chart-bar" class="text-green-600 mb-1 h-5 w-5" />
                </template>
                <template x-if="!online">
                    <div class="inline-flex mt-2 items-center">
                        <x-icon name="s-signal-slash" class="text-red-600" />
                        <span class="text-xs text-red-500 font-semibold ms-1">Offline</span>
                    </div>
                </template>
            </div>

            <x-button label="There" icon="s-arrow-uturn-left" class="btn-sm md:hidden ms-3" responsive @click="window.history.back()" />

        </div>

    </div>

    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>

        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}


        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200 md:pt-16 lg:bg-inherit">
            @livewire('components.menuside')    
        </x-slot:sidebar>
        

        {{-- The `$slot` goes here --}}
        <x-slot:content style="padding: 0px">
            <div class="z-5">
                {{ $slot }}
            </div>
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />

</body>

</html>