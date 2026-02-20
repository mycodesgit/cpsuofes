@php
    $current_route=request()->route()->getName();
@endphp

@php
    $manageOpen = request()->routeIs('ratingscale.*', 'instruction.*', 'category.*', 'question.*', 'subquestion.*', 'semester.*', 'setting.*');
@endphp

<ul class="nav flex-column">
    <li class="px-4 py-2">
        <small class="nav-text text-muted">Main</small>
    </li>
    <li>
        <a class="nav-link {{$current_route=='index.dashboard'?'active':''}}" href="{{ route('index.dashboard') }}">
            <i class="ti ti-layout-grid"></i><span class="nav-text">Dashboard</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{$current_route=='index.calendar'?'active':''}}" href="{{ route('index.calendar') }}">
            <i class="ti ti-calendar"></i><span class="nav-text">Calendar</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ request()->is('faculty/list*') ? 'active' : '' }}" href="{{ route('index.faculty') }}">
            <i class="ti ti-users"></i><span class="nav-text">Faculty</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center justify-content-between {{ $manageOpen ? '' : '' }}" data-bs-toggle="collapse" href="#manageMenu" role="button" aria-expanded="false" aria-controls="manageMenu">
            <div class="d-flex align-items-center">
                <i class="ti ti-server me-2"></i>&nbsp;
                <span class="nav-text">Manage</span>
            </div>
            <!-- <i class="ti ti-chevron-down"></i> -->
        </a>

        <div class="collapse {{ $manageOpen ? 'show' : '' }}" id="manageMenu">
            <ul class="nav flex-column ms-3 mt-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/ratingscale*') ? 'active' : '' }}" href="{{ route('ratingscale.index') }}">
                        <i class="ti ti-scale"></i> <span class="nav-text">Rating Scale</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/category*') ? 'active' : '' }}" href="{{ route('category.index') }}">
                        <i class="ti ti-box"></i> <span class="nav-text">Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/instruction*') ? 'active' : '' }}" href="{{ route('instruction.index') }}">
                        <i class="ti ti-alert-circle"></i> <span class="nav-text">Instruction</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/question*') ? 'active' : '' }}" href="{{ route('question.index') }}">
                        <i class="ti ti-help"></i> <span class="nav-text">Questions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/subquestion*') ? 'active' : '' }}" href="{{ route('subquestion.index') }}">
                        <i class="ti ti-help-circle-filled"></i> <span class="nav-text">Sub Questions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/semester*') ? 'active' : '' }}" href="{{ route('semester.index') }}">
                        <i class="ti ti-calendar"></i> <span class="nav-text">Semester</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('conf/setting*') ? 'active' : '' }}" href="{{ route('setting.index') }}">
                        <i class="ti ti-settings"></i> <span class="nav-text">Setting</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <a class="nav-link {{ request()->is('studaccount*') ? 'active' : '' }}" href="{{ route('studaccount.index') }}">
            <i class="ti ti-user-circle"></i> <span class="nav-text">Students</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('user.index') }}">
            <i class="ti ti-user-plus"></i> <span class="nav-text">Users</span>
        </a>
    </li>


    <li class="px-4 pt-4 pb-2"><small class="nav-text text-muted">Reports</small></li>
    <li>
        <a class="nav-link {{ request()->is('reports/view*') ? 'active' : '' }}" href="{{ route('printeval.index') }}">
            <i class="ti ti-receipt"></i> <span class="nav-text">Print Evaluation</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ request()->is('reports/eval*') ? 'active' : '' }}" href="{{ route('summaryevalresult.index') }}">
            <i class="ti ti-files"></i> <span class="nav-text">Evaluation Result</span>
        </a>
    </li>
    <li>
        <a class="nav-link" href="#">
            <i class="ti ti-report-analytics"></i> <span class="nav-text">Conducted Eval.</span>
        </a>
    </li>
</ul>