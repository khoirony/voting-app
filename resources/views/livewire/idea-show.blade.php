<div>
    {{-- Idea --}}
    <div class="idea-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-6 py-6">
            <div class="flex-none mx-2">
                <a href="#">
                    <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold">
                    {{ $idea->title }}
                </h4>
                <div class="text-gray-600 mt-3">
                    {{ $idea->description }}
                </div>

                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-bold text-gray-900">{{ $idea->user->name }}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHUmans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->name }}</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">3 Comment</div>
                    </div>
                    <div 
                        class="flex items-center space-x-2 mt-4 md:mt-0"
                        x-data="{ option: false }" 
                    >
                        <div class="{{ $idea->status->classes }} text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">{{ $idea->status->name }}</div>
                        <button  @click="option = !option" class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                            
                            <ul
                                x-cloak
                                x-show.transition.origin.top.left="option"
                                @click.away="option = false"
                                x-on:keydown.escape.window="option = false"
                                class="absolute z-10 w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
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
                            <div class="text-sm font-bold leading-none @if($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                            <div class="text-xs font-semibold leading-none text-gray-400">Votes</div>
                        </div>
                        @if ($hasVoted)
                            <button 
                                wire:click.prevent="vote"
                                class="w-20 bg-blue text-white border border-blue font-bold text-xs uppercase rounded-xl 
                                hover:blue-hover transition duration-150 ease-in px-4 py-3 -mx-5"
                            >
                                Vote
                            </button> 
                        @else
                            <button 
                                wire:click.prevent="vote"
                                class="w-20 bg-gray-200 border border-gray-200 font-bold hover:border-gray-400 
                                text-xs uppercase rounded-xl transition duration-150 ease-in px-4 py-3 -mx-5"
                            >
                                Vote
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action --}}
    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
            <div 
                class="relative"
                x-data="{ reply: false }" 
            >
                <button 
                    @click="reply = !reply" 
                    class="flex items-center justify-center w-32 h-11 text-xs bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-2">
                    <span class="text-white">Reply</span>
                </button>
                <div
                    x-cloak
                    x-show.transition.origin.top.left="reply"
                    @click.away="reply = false"
                    x-on:keydown.escape.window="reply = false"  
                    class="absolute z-10 w-80 md:w-104 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2">
                    <form action="#" method="post" class="space-y-4 px-4 py-6">
                        <div>
                            <textarea name="post_comment" id="post_comment" cols="30" rows="4" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2" placeholder="Go ahead, dont shy. share your thoughts..."></textarea>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="button" class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-2">
                                <span class="text-white">Post Comment</span>
                            </button>
                            <button type="button" class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-2">
                                <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span class="ml-2">Attach</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    
            @auth
                @if (auth()->user()->isAdmin())
                    <livewire:set-status :idea="$idea"/>
                @endif
            @endauth
        </div>

        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-1">
                <div class="text-xl leading-snug @if($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                <div class="text-gray-400 text-xs leading-none">
                    Votes
                </div>
            </div>
            @if ($hasVoted)
                <button 
                    wire:click.prevent="vote" 
                    class="w-32 h-11 text-xs bg-blue text-white font-semibold uppercase rounded-xl border border-blue hover:border-blue transition duration-150 ease-in px-6 py-2">
                    <span>Vote</span>
                </button>
            @else
                <button 
                    wire:click.prevent="vote" 
                    class="w-32 h-11 text-xs bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-2">
                    <span>Vote</span>
                </button>
            @endif
        </div>
    </div>
</div>
