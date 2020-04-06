<div x-data="components.search()" x-init="components.search().init" class="flex flex-1 justify-end items-center text-right">
    <div
        class="absolute md:relative w-full justify-end left-0 z-10 px-6 md:px-0 hidden md:flex"
        :class="{'hidden md:flex': ! searching}"
    >
        <label for="search" class="hidden">Search</label>

        <input
            id="search"
            x-model="query"
            x-ref="search"
            class="transition-all duration-200 block border-b border-gray-200 outline-none cursor-pointer text-gray-700 w-full leading-6 md:w-2/5 md:focus:w-3/4"
            autocomplete="off"
            name="search"
            placeholder="Press “/” to search"
            type="text"
            @keyup.escape="reset()"
            @blur="reset()"
            @keydown.slash.document.stop.prevent="$refs.search.focus()"
        />

        <button
            x-show="query || searching"
            class="absolute top-0 right-0 h-6 text-gray-500 hover:text-gray-900 focus:text-gray-900 focus:outline-none mr-6 md:mr-0"
            @click="reset()"
        >
            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
        </button>

        <div
            x-show="query"
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="absolute top-0 left-0 right-0 md:inset-auto w-full md:w-3/4 text-left mb-4 mt-6"
        >
            <div
                class="flex flex-col bg-white border-t border-gray-400 shadow-lg mx-4 md:mx-0"
            >
                <div
                    x-show="query && !results().length"
                    class="bg-white w-full hover:bg-gray-100 border-b border-gray-200 rounded-b-lg shadow cursor-pointer p-4"
                >
                    <p class="my-0">
                        No results for <strong class="font-medium" x-text="query"></strong>
                    </p>
                </div>
                <template x-for="result in results()" :key="result.link">
                    <a
                        class="bg-white hover:bg-gray-100 border-b border-gray-200 text-base cursor-pointer p-4 last:rounded-b-lg"
                        :href="result.link"
                        :title="result.title"
                        @mousedown.prevent
                    >
                        <span class="block font-medium" x-text="result.title"></span>
                        <span
                            class="block font-normal text-gray-600 text-sm leading-5 my-1"
                            x-html="result.snippet"
                        ></span>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <button
        title="Start searching"
        type="button"
        class="flex justify-center items-center text-gray-500 focus:outline-none focus:text-gray-900 hover:text-gray-900 md:hidden"
        @click.prevent="showInput()"
    >
        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/></svg>
    </button>
</div>
