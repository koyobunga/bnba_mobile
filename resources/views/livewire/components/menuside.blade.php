<div>
    
    <div class="md:hidden block">
        <x-app-brand class="p-5 pt-3" />
    </div>
    {{-- User --}}
    @if($user = auth()->user())

        <x-list-item :item="$user" value="nama" sub-value="email" no-separator no-hover class="pt-2 ps-5">
            <x-slot:actions>
                <x-button icon="o-power" class="btn-circle btn-ghost text-red-500 btn-xs" tooltip-left="logoff"
                    no-wire-navigate link="/logout" />
            </x-slot:actions>
        </x-list-item>

        <x-menu-separator />
    @endif

    {{-- Activates the menu item when a route matches the `link` property --}}
    <x-menu activate-by-route>
        <x-menu-item title="Home" icon="o-home" link="{{url('/')}}" />
        <x-menu-sub title="Settings" icon="o-cog-6-tooth">
        <x-menu-item title="Reload data" icon="o-arrow-path" wire:click="$dispatch('show-modal-loaddata')"  />
        </x-menu-sub>

        <x-menu-separator />


    </x-menu>
    
    

</div>
