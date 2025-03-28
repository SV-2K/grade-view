@php
    use Illuminate\Support\Facades\Route;
    $groups = \App\Models\Group::all()->pluck('name');
    $subjects = \App\Models\Subject::all()->pluck('name');
@endphp

<div class="ms-auto side-menu me-2">
    @if(auth()->check())
        <a href="{{ route('profile') }}" class="section side-button">
            &#8592; Вернуться в профиль
        </a>
    @endif
    <a href="{{ route('college', ['monitoring' => $monitoring->id]) }}" class="section side-button @if(Route::is('college'))) side-button-active @endif">
        Общее
    </a>
    @if(Route::is('group'))
        <div class="section side-button side-button-active p-0">
            <div class="side-label">
                Группа
            </div>
            <div class="side-list">
                @foreach($groups as $group)
                    <a href="{{ route('group', ['name' => $group, 'monitoring' => $monitoring->id]) }}" class="section @if(request()->get('name') !== $group) side-button-active @endif">
                        {{ $group }}
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ route('group', ['monitoring' => $monitoring->id]) }}" class="section side-button">
            Группа
        </a>
    @endif
    @if(Route::is('subject'))
        <div class="section side-button side-button-active p-0">
            <div class="side-label">
                Предмет
            </div>
            <div class="side-list">
                @foreach($subjects as $subject)
                    <a href="{{ route('subject', ['name' => $subject, 'monitoring' => $monitoring->id]) }}" class="section @if(request()->get('name') !== $subject) side-button-active @endif">
                        {{ $subject }}
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ route('subject', ['monitoring' => $monitoring->id]) }}" class="section side-button @if(request()->is('subject')) side-button-active @endif">
            Предмет
        </a>
    @endif
</div>
