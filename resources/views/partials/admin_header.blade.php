<header>
    Current User: <span class="bold">{{ $currentUserFullName }}</span>
    <nav>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('clients') }}">
                    Clients
                </a>
            </li>
        </ul>
    </nav>
</header>