<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/icons/icon-192x192.png">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    

</head>


<body class="min-h-screen font-sans antialiased bg-slate-50 dark:bg-base-200">


    <x-nav sticky full-width class="h-17 py-0 items-center border-none bg-slate-50 dark:bg-base-100  rounded-b-2xl">
        
            <x-slot:brand>
                {{-- Drawer toggle for "main-drawer" --}}
                <label for="main-drawer" class="lg:hidden mr-3">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>
                
                {{-- Brand --}}
                {{-- <x-app-brand /> --}}
                {{-- <div class="font-bold text-2xl text-emerald-600">GSD</div> --}}
                <img src="icons/icon-192.png" class="w-10" alt="">
            </x-slot:brand>
            
            {{-- Right side actions --}}
            <x-slot:actions class="sm:gap-4 gap-0.5">
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
            </x-slot:actions>
        </x-nav>
 
    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>
 
        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">
           
                
            @livewire('components.menuside')              


        </x-slot:sidebar>
 
        {{-- The `$slot` goes here --}}
        <x-slot:content style="padding: 0px">
            {{ $slot }}
        </x-slot:content>
        
    </x-main>
    
    <x-toast />
    {{--  TOAST area --}}

</body>
</html>
