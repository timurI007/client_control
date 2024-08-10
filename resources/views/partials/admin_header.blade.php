<header>
    Current User: <span class="bold">{{ $userFullName }}</span>
    <nav>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('clients.all') }}">
                    Clients
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</header>