<script>
    document.addEventListener("DOMContentLoaded", function () {
        c3.generate({
            bindto: '#grade-distribution',
            data: {
                columns: @json($gradeDistributionData['grades']),
                type: 'bar',
                groups: [
                    ['5', '4', '3', '2']
                ],
                order: null
            },
            legend: {
                position: 'right'
            },
            axis: {
                rotated: true,
                x: {
                    show: true,
                    type: 'category',
                    categories: @json($gradeDistributionData['categories']),
                    tick: {
                        multiline: false,
                        multilineMax: 1,
                    }
                },
                y: {
                    show: false
                }
            },
            color: {
                pattern: ['#7abd7e', '#b9ca77', '#F8D66F', '#ff6961']
            },
            padding: {
                bottom: 10
            },
        });
    });
</script>
