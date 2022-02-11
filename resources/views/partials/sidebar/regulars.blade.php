<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('regulars.index') }}">
            <font-awesome-icon icon="fa-solid fa-tags"/>
            Regulars
            @if (session()->has('regulars-badge-count') && session()->get('regulars-badge-count') != 0)
                <badge-component>{{ session()->get('regulars-badge-count') }}</badge-component>
            @endif
        </a>
        <ul>
            <!-- TODO: Change icon -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('possibleRegulars.scan') }}" @@click="scanForNewRegulars">
                    <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                    Scan for new Regulars
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('possibleRegulars.scanResults') }}">
                    <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                    View latest scan results
                </a>
            </li>
        </ul>
        <ul>
        <!--
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('regulars.create') }}">
                            <font-awesome-icon icon="fa-solid fa-tags" />&nbsp;Create Regular
                        </a>
                    </li>
-->
        </ul>
    </li>
</ul>
