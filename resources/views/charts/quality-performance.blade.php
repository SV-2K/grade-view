<script>
    document.addEventListener("DOMContentLoaded", function () {
        c3.generate({
            bindto: '#quality-performance',
            data: {
                columns: [
                    @json($qualityPerformanceData['performance'])
                ],
                type: 'bar',
                order: null,
                color: function (color, d) {
                    if (d && d.value) {
                        if (d.value > 70) {
                            return '#7abd7e';
                        } else if (d.value > 60) {
                            return '#B9CA77';
                        } else if (d.value > 50) {
                            return '#F8D66F';
                        } else {
                            return '#ff6961';
                        }
                    }
                    return color;
                },
                labels: {
                    format: function (v) {
                        return v.toFixed(1);
                    }
                }
            },
            axis: {
                rotated: true,
                x: {
                    type: 'category',
                    categories: @json($qualityPerformanceData['categories']),
                    tick: {
                        multiline: false,
                        multilineMax: 1,
                    }
                },
                y: {
                    show: false
                }
            },
            legend: {
                show: false
            },
            padding: {
                bottom: 20
            },
        });
    });
</script>
