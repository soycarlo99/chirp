<div class="card bg-base-100 shadow">
    <div class="card-body">
        @if ($editing)
            {{-- Edit Mode --}}
            <form wire:submit="updateChirp">
                <div class="form-control w-full">
                    <textarea wire:model="message"
                        class="textarea textarea-bordered w-full resize-none @error('message') textarea-error @enderror" rows="4"
                        maxlength="255">
                    </textarea>

                    @error('message')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="card-actions justify-between mt-4">
                    <button type="button" wire:click="cancelEdit" class="btn btn-ghost btn-sm">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Update Chirp
                    </button>
                </div>
            </form>
        @else
            {{-- Display Mode --}}
            <div class="flex space-x-3">
                @if ($chirp->user)
                    <div class="avatar">
                        <div class="size-10 rounded-full">
                            <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                                alt="{{ $chirp->user->name }}'s avatar" class="rounded-full" />
                        </div>
                    </div>
                @else
                    <div class="avatar placeholder">
                        <div class="size-10 rounded-full">
                            <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                                alt="Anonymous User" class="rounded-full" />
                        </div>
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <div class="flex justify-between w-full">
                        <div class="flex items-center gap-1">
                            <span
                                class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                            @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                                <span class="text-base-content/60">·</span>
                                <span class="text-sm text-base-content/60 italic">edited</span>
                            @endif
                        </div>

                        @can('update', $chirp)
                            <div class="flex gap-1">
                                <button wire:click="startEditing" class="btn btn-ghost btn-xs">
                                    Edit
                                </button>
                                <button wire:click="deleteChirp" wire:confirm="Are you sure you want to delete this chirp?"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </div>
                        @endcan
                    </div>
                    <p class="mt-1">{{ $chirp->message }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
