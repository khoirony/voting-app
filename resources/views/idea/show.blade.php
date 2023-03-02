<x-app-layout>
    <x-slot name="title">
        {{ $idea->title }} | Laracasts Voting
    </x-slot>
    <div>
        <a href="{{ $backUrl }}" class="flex items-center font-semibold hover:underline">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
              </svg>
            <span class="ml-2">All Ideas (or back to chosen category with filters)</span>
        </a>
    </div>

    <livewire:idea-show 
        :idea="$idea" 
        :votesCount="$votesCount" 
    />

    <livewire:idea-comments :idea="$idea" />

    <x-notification-success />

    <x-modals-container :idea="$idea" />

    {{-- Comment --}}
</x-app-layout>