<div class="sm:w-96 mx-auto">
    <div class="w-full text-end">
        <x-theme-toggle darkTheme="dark" lightTheme="light" class="mt-1" />
    </div>
    <div class="w-full flex flex-col items-center justify-center mt-14">
        <img src="{{ url('icons/logo.png')}}" alt="" class="w-20">
        <div class="text-3xl font-bold mt-8  dark:text-slate-100">G S D</div>
        <div class="mt-1 text-sm">Aplikasi Gorontalo Satu Data</div>
        {{-- <div class="text-xl font-bold mt-2">Selamat datang!</div> --}}
    </div>

    <div class="mb-4 mt-10 text-sm text-slate-500 dark:text-slate-400">Silahkan login</div>

    <x-form wire:submit="login">
        <x-input label="Username" wire:model="username" class="text-sm" icon="o-user" inline />
        <x-input label="Password" wire:model="password" class="text-sm" type="password" icon="o-key" inline />
 
        <x-slot:actions>
            <x-button label="Create an account" class="btn-ghost"/>
            <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary btn-outline" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>