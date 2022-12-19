<div class="min-h-screen flex flex-col  items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="card_padding">
        <div>
            {{ $logo }}
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
