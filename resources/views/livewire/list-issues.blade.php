<div class="max-w-7xl mx-auto pt-10 px-20 space-y-5">
    <section class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white md:text-4xl">
            <span class="block">RapidKL Issue Tracker</span>
            <span class="text-base font-normal text-gray-500">Your one-stop center for all Klang Valley public transportation issues.</span>
        </h2>
    </section>

    <section>
        @livewire(\App\Livewire\StatsOverview::class)
    </section>

    <section>
        {{ $this->table }}
    </section>

    <section>
        @livewire(\App\Livewire\ServiceStatus::class)
    </section>

    <footer class="flex justify-center items-center text-xs text-gray-500">
        made with ❤️ by&nbsp;
        <a href="https://khrnchn.xyz" class="text-blue-500 hover:underline"> @khrnchn</a>
    </footer>
</div>