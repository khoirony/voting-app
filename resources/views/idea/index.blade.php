<x-app-layout>
    <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
        <div class="w-full md:w-1/3">
            <select class="w-full rounded-xl px-4 py-2 border-none" name="category" id="category">
                <option value="Category One">Category One</option>
                <option value="Category Two">Category Two</option>
                <option value="Category Three">Category Three</option>
                <option value="Category Four">Category Four</option>
            </select>
        </div>

        <div class="w-full md:w-1/3">
            <select class="w-full rounded-xl px-4 py-2 border-none" name="other_filters" id="other_filters">
                <option value="Filter One">Filter One</option>
                <option value="Filter Two">Filter Two</option>
                <option value="Filter Three">Filter Three</option>
                <option value="Filter Four">Filter Four</option>
            </select>
        </div>

        <div class="w-full md:w-2/3 relative">
            <input type="search" name="search" id="search" placeholder="Find an idea" class="w-full rounded-xl bg-white border-none px-4 py-2 pl-8 placeholder:text-gray-900">
            <div class="absolute top-0 flex items-center h-full ml-2">
                <svg class="w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- List Idea --}}
    <div class="ideas-container space-y-6 my-6">
        @foreach ($ideas as $idea)
        <div 
            x-data
            @click="
                clicked = $event.target
                target = clicked.tagName.toLowerCase()
                ignores = ['button', 'svg', 'path', 'a']
                
                if(!ignores.includes(target)){
                    clicked.closest('.idea-container').querySelector('.idea-link').click()
                }
            "
            class="idea-container hover:shadow-card transition duration-150 ease-in bg-white rounded-xl flex cursor-pointer">
            {{-- vote desktop version --}}
            <div class="border-r hidden md:block border-gray-100 px-5 py-8">
                <div class="text-center">
                    <div class="font-semi-bold text-2xl">12</div>
                    <div class="text-gray-500">Votes</div>
                </div>
                <div class="mt-8">
                    <button class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400 font-bold text-xxs uppercase rounded-xl transition duration-150 ease-in px-4 py-3">Vote</button>
                </div>
            </div>
            <div class="flex flex-col md:flex-row flex-1 px-2 py-6">
                <div class="flex-none mx-2 md:mx-0">
                    <a href="#">
                        <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                    </a>
                </div>
                <div class="w-full flex flex-col justify-between mx-2 md:mx-4">
                    <h4 class="text-xl font-semibold mt-2 md:mt-0">
                        <a href="{{ route('idea.show', $idea) }}" class="idea-link hover:underline">{{ $idea->title }}</a>
                    </h4>
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        {{ $idea->description }}
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-6">
                        <div class="flex items-center text-xs text-gray-400 font-semibold md:space-x-2">
                            <div>&bull;</div>
                            <div>{{ $idea->created_at->diffForHUmans() }}</div>
                            <div>&bull;</div>
                            <div>{{ $idea->category->name }}</div>
                            <div>&bull;</div>
                            <div class="text-gray-900">3 Comment</div>
                        </div>

                        {{-- action button --}}
                        <div x-data="{ isOpen: false }"
                            class="flex items-center space-x-2 mt-4 md:mt-0">
                            <div class="{{ $idea->status->classes }} text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">{{ $idea->status->name }}</div>
                            <button 
                                @click="isOpen =!isOpen"
                                class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                                <ul 
                                    x-cloak
                                    x-show.transition.origin.top.left.duration.1000ms="isOpen"
                                    @click.away="isOpen = false"
                                    x-on:keydown.escape.window="isOpen = false"
                                    class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                                    <li>
                                        <a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Mark as spam</a>
                                    </li>
                                    <li>
                                        <a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete post</a>
                                    </li>
                                </ul>
                            </button>
                        </div>

                        {{-- vote mobile version --}}
                        <div class="flex items-center md:hidden mt-4 md:mt-0">
                            <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                                <div class="text-sm font-bold leading-none">12</div>
                                <div class="text-xs font-semibold leading-none text-gray-400">Votes</div>
                            </div>
                            <button 
                                class="w-20 bg-gray-200 border border-gray-200 font-bold hover:border-gray-400 
                                text-xs uppercase rounded-xl transition duration-150 ease-in px-4 py-3 -mx-5"
                            >
                                Vote
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="my-8">
            {{ $ideas->links() }}
        </div>
    </div>
</x-app-layout>


  