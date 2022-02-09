<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('regulars.index') }}">
            <i class="fa fa-tag"></i> Regulars
            @if (session()->has('regulars-badge-count') && session()->get('regulars-badge-count') != 0)
                <badge-component>{{ session()->get('regulars-badge-count') }}</badge-component>
            @endif
        </a>
        <ul>
            <!-- TODO: Change icon -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('possibleRegulars.scan') }}" @@click="scanForNewRegulars">
                    <i class="fa fa-tag"></i> Scan for new Regulars
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('possibleRegulars.scanResults') }}">
                    <i class="fa fa-tag"></i> View latest scan results
                </a>
            </li>
        </ul>
        <ul>
        <!--
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('regulars.create') }}">
                            <i class="fa fa-tag"></i> Create Regular
                        </a>
                    </li>
-->
        </ul>
    </li>
</ul>
