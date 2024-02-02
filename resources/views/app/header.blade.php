<p>
    Current User: <span style="font-weight:bold;">{{ auth()->user()->name . ' ' . auth()->user()->lastname }}</span>
    <br>
    @if(isset($dashboard) && $dashboard)
        <a href="/dashboard" style="margin-right:10px;">DASHBOARD</a>
    @endif
    <a href="{{ route('logout') }}">LOGOUT</a>
</p>