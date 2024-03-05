<div class="py-5 pl-5 mb-4 border border-gray-100 rounded-xl bg-gray-50">
    <time class="text-lg font-semibold text-gray-900">Live tweets today {{ \Carbon\Carbon::today()->toDateString() }}</time>

    @for ($i = 0; $i < 3; $i++) <ul role="list" class="space-y-6">
        <li class="relative flex gap-x-4 space-y-3 ">
            <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                <div class="w-px bg-gray-200"></div>
            </div>
            <div class="relative flex h-6 w-6 flex-none items-center justify-center">
                <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
            </div>
            <div class="flex-auto rounded-md p-3 mr-5 ring-1 ring-inset ring-gray-200">
                <div class="flex justify-between gap-x-4">
                    <div class="py-0.5 text-xs leading-5 text-gray-500"><span class="font-medium text-gray-900">Admin</span> tweeted</div>
                    <time datetime="2023-01-23T15:56" class="flex-none py-0.5 text-xs leading-5 text-gray-500">3d ago</time>
                </div>
                <p class="text-sm leading-6 text-gray-500">train sangkut dekat lrt bangsar sebab rosak.</p>
            </div>
        </li>
        </ul>
        @endfor
</div>