@php
$groups = ['9СЫС-33.3', '4DD-4.12', 'AB0-B223', 'АБВ-1.23'];
$averageGrades = ['', 4.5, 3.76, 3.6, 3];
@endphp
<script>
document.addEventListener("DOMContentLoaded", function () {
    c3.generate({
        bindto: '#average-grades',
        data: {
            columns: [
                @json($averageGrades)
            ],
            type: 'bar',
            color: function (color, d) {
                if (d && d.value) {
                    if (d.value > 4) {
                        return '#7abd7e';
                    } else if (d.value > 3.75) {
                        return '#B9CA77';
                    } else if (d.value > 3.5) {
                        return '#F8D66F';
                    } else {
                        return '#ff6961';
                    }
                }
                return color;
            },
            labels: {
                format: function (v) {
                    return v;
                }
            }
        },
        legend: {
            show: false
        },
        padding: {
            bottom: 10
        },
        axis: {
            rotated: true,
            x: {
                type: 'category',
                categories: @json($groups),
                tick: {
                    multiline: false,
                    multilineMax: 1,
                }
            },
            y: {
                show: false
            }
        },
        bar: {
            space: 0.5,
            width: {
                ratio: 0.9
            }
        },
    });
});
</script>
