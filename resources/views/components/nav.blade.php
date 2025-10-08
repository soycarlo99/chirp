<div class="navbar-end gap-2">
    @auth
        <span class="text-sm">{{ auth()->user()->name }}</span>
        <form method="POST" action="/logout" class="inline">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
        </form>
    @else
        <a href="/login" class="btn btn-ghost btn-sm">Sign In</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
    @endauth
</div>
