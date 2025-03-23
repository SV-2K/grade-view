@php
    $groups = \App\Models\Group::all()->pluck('name');
    $subjects = \App\Models\Subject::all()->pluck('name');
@endphp

<div class="col-6 ms-auto side-menu">

    <a href="{{ route('college') }}" class="section side-button @if(request()->is('college')) side-button-active @endif">
        Общее
    </a>
    @if(request()->is('group'))
        <div class="section side-button side-button-active p-0">
            <div class="side-label">
                Группа
            </div>
            <div class="side-list">
                @foreach($groups as $group)
                    <a href="{{ route('group', ['name' => $group]) }}" class="section @if(request()->get('name') !== $group) side-button-active @endif">
                        {{ $group }}
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ route('group') }}" class="section side-button">
            Группа
        </a>
    @endif
    @if(request()->is('subject'))
        <div class="section side-button side-button-active p-0">
            <div class="side-label">
                Предмет
            </div>
            <div class="side-list">
                @foreach($subjects as $subject)
                    <a href="{{ route('subject', ['name' => $subject]) }}" class="section @if(request()->get('name') !== $subject) side-button-active @endif">
                        {{ $subject }}
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ route('subject') }}" class="section side-button @if(request()->is('subject')) side-button-active @endif">
            Предмет
        </a>
    @endif
</div>
