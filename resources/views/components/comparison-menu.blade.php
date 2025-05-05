<div class="section comparison-menu">
    <h5>Сравнение с предыдущим мониторингом:</h5>
    @if(is_null($sideMenuStats))
        Предыдущий мониторинг не найден
    @else
        Средний балл
        <div class="d-flex">
            @if($sideMenuStats['avgGrade']['before'] < $sideMenuStats['avgGrade']['after'])
                <div class="red-text">
                    {{ $sideMenuStats['avgGrade']['before'] }}
                </div>
            @else
                <div class="green-text">
                    {{ $sideMenuStats['avgGrade']['before'] }}
                </div>
            @endif
            &nbsp;&#8594;&nbsp;
            @if($sideMenuStats['avgGrade']['after'] < $sideMenuStats['avgGrade']['before'])
                <div class="red-text">
                    {{ $sideMenuStats['avgGrade']['after'] }}
                </div>
            @else
                <div class="green-text">
                    {{ $sideMenuStats['avgGrade']['after'] }}
                </div>
            @endif
            &nbsp;
            @if($sideMenuStats['avgGrade']['percentage'] < 0)
                <div class="red-text">
                    ({{ $sideMenuStats['avgGrade']['percentage'] }}%)
                </div>
            @else
                <div class="green-text">
                    (+{{ $sideMenuStats['avgGrade']['percentage'] }}%)
                </div>
            @endif
        </div>
        Абсолютная успеваемость
        <div class="d-flex">
            @if($sideMenuStats['absolutePerf']['before'] < $sideMenuStats['absolutePerf']['after'])
                <div class="red-text">
                    {{ $sideMenuStats['absolutePerf']['before'] }}%
                </div>
            @else
                <div class="green-text">
                    {{ $sideMenuStats['absolutePerf']['before'] }}%
                </div>
            @endif
            &nbsp;&#8594;&nbsp;
            @if($sideMenuStats['absolutePerf']['after'] < $sideMenuStats['absolutePerf']['before'])
                <div class="red-text">
                    {{ $sideMenuStats['absolutePerf']['after'] }}%
                </div>
            @else
                <div class="green-text">
                    {{ $sideMenuStats['absolutePerf']['after'] }}%
                </div>
            @endif
            &nbsp;
            @if($sideMenuStats['absolutePerf']['percentage'] < 0)
                <div class="red-text">
                    ({{ $sideMenuStats['absolutePerf']['percentage'] }}%)
                </div>
            @else
                <div class="green-text">
                    (+{{ $sideMenuStats['absolutePerf']['percentage'] }}%)
                </div>
            @endif
        </div>
        Качественная успеваемость
        <div class="d-flex">
            @if($sideMenuStats['qualityPerf']['before'] < $sideMenuStats['qualityPerf']['after'])
                <div class="red-text">
                    {{ $sideMenuStats['qualityPerf']['before'] }}%
                </div>
            @else
                <div class="green-text">
                    {{ $sideMenuStats['qualityPerf']['before'] }}%
                </div>
            @endif
            &nbsp;&#8594;&nbsp;
            @if($sideMenuStats['qualityPerf']['after'] < $sideMenuStats['qualityPerf']['before'])
                <div class="red-text">
                    {{ $sideMenuStats['qualityPerf']['after'] }}%
                </div>
            @else
                <div class="green-text">
                    {{ $sideMenuStats['qualityPerf']['after'] }}%
                </div>
            @endif
            &nbsp;
            @if($sideMenuStats['qualityPerf']['percentage'] < 0)
                <div class="red-text">
                    ({{ $sideMenuStats['qualityPerf']['percentage'] }}%)
                </div>
            @else
                <div class="green-text">
                    (+{{ $sideMenuStats['qualityPerf']['percentage'] }}%)
                </div>
            @endif
        </div>
    @endif
</div>
