<script>
    document.addEventListener("DOMContentLoaded", function () {
        c3.generate({
            bindto: '#grades-ratio',
            data: {
                columns: @json($gradesRatioData),
                type: 'donut',
                order: null
            },
            color: {
                pattern: ['#7abd7e', '#b9ca77', '#F8D66F', '#ff6961']
            },
        });
    });
</script>
