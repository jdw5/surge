<template>
    <li>
        <div class="relative pb-8">
            <span class="last:hidden absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
            <div class="relative flex space-x-3">
                <div>
                    <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white">
                        <slot name="icon" />
                    </span>
                </div>
                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                    <slot />
                </div>
            </div>
        </div>
    </li>
</template>
