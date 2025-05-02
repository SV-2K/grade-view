<script>
document.addEventListener("DOMContentLoaded", function () {
    c3.generate({
        bindto: '#average-grades',
        data: {
            columns: [
                @json($averageGradesData['averageGrades'])
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
                    return v.toFixed(2);
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
                categories: @json($averageGradesData['groupNames']),
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
