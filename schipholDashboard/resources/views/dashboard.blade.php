<form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit">
        Uitloggen
    </button>
</form>

{{-- reizigers dashboard --}}
