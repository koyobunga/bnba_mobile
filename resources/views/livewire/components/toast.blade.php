<div>
    <div x-show="toast" x-transition:enter="transform ease-out duration-500"
            x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transform ease-in duration-500" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-4 opacity-0"
            class="fixed flex px-5 justify-between items-center z-50 text-green-600 left-0 bottom-0 bg-base-200 text-sm w-full shadow-lg p-3 rounded-t-lg">
            <span class="font-semibold text-sm" x-text="message"></span>
            <x-icon name="s-check-circle" />
        </div>
        <div x-show="toasterror" x-transition:enter="transform ease-out duration-500"
            x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transform ease-in duration-500" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-4 opacity-0"
            class="fixed flex px-5 justify-between items-center z-50 text-orange-600 left-0 bottom-0 bg-base-200 text-sm w-full shadow-lg p-3 rounded-t-lg">
            <span class="text-sm" x-text="message"></span>
            <x-icon name="s-exclamation-triangle" />
        </div>

</div>
