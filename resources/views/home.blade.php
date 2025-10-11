<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Latest Chirps</h1>

        <!-- Chirp Form -->
        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <form method="POST" action="/chirps">
                    @csrf
                    <div class="form-control w-full">
                        <textarea name="message" placeholder="What's on your mind?" class="textarea textarea-bordered w-full resize-none"
                            rows="4" maxlength="255" required></textarea>
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Chirp
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Feed -->
        <div id="chirps-container" class="space-y-4 mt-8">
            @forelse ($chirps as $chirp)
                <x-chirp :chirp="$chirp" />
            @empty
                <div class="hero py-12">
                    <div class="hero-content text-center">
                        <div>
                            <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <p class="mt-4 text-base-content/60">No chirps yet. Be the first to chirp!</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
<script type="module">
    // Listen for new chirps
    Echo.channel('public-chirps')
        .listen('.chirp.sent', (e) => {
            console.log('New chirp received:', e.chirp);

            const chirpHtml = `
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <div class="flex space-x-3">
                            <div class="avatar">
                                <div class="size-10 rounded-full">
                                    <img src="https://avatars.laravel.cloud/${encodeURIComponent(e.chirp.user.email)}"
                                         alt="${e.chirp.user.name}'s avatar"
                                         class="rounded-full" />
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex justify-between w-full">
                                    <div class="flex items-center gap-1">
                                        <span class="text-sm font-semibold">${e.chirp.user.name}</span>
                                        <span class="text-base-content/60">·</span>
                                        <span class="text-sm text-base-content/60">just now</span>
                                    </div>
                                </div>
                                <p class="mt-1">${e.chirp.message}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.querySelector('#chirps-container').insertAdjacentHTML('afterbegin', chirpHtml);
        });
</script>
