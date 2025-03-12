@php
$attendance = [
     ['Ув', 23],
     ['Н/ув', 55]
 ];
@endphp
<script>
    document.addEventListener("DOMContentLoaded", function () {
        c3.generate({
            bindto: '#absence-ratio',
            data: {
                columns: @json($attendance),
                type: 'bar',
                groups: [
                    ['Ув', 'Н/ув']
                ],
            },
            bar: {
                width: 50
            },
            color: {
                pattern: ['#F8D66F', '#ff6961']
            },
            axis: {
                x: {
                    show: true,
                    type: 'category',
                    categories: [' '],
                    tick: {
                        outer: false
                    }
                },
                y: {
                    show: false
                }
            },
        });
    });
</script>
