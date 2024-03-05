<div class="wrapper w-full h-full mx-auto pt-10 px-20 space-y-5">
    <h1 class="text-xl font-semibold text-white mb-6 font-mono">RapidKL Issue Tracker</h1>

    <section>
        @livewire(\App\Livewire\StatsOverview::class)
    </section>

    <section>
        {{ $this->table }}
    </section>


    <section>
        @livewire(\App\Livewire\LiveTweets::class)
    </section>

    <!-- <footer class="bg-white rounded-lg shadow">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023. pet project by <a href="https://github.com/khrnchn/rapidkl-issue-tracker" class="hover:underline">khairin</a>.
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">idea from nrmnqdds' <a href="https://ideaspace.nrmqdds.com" class="hover:underline">ideaspace</a>.
                </span>
                <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
        </div>
    </footer> -->
</div>