@php
$grades = [
    ['5', 23],
    ['4', 20],
    ['3', 10],
    ['2', 14]
];
@endphp

<script>
document.addEventListener("DOMContentLoaded", function () {
    c3.generate({
        bindto: '#grade-ratio',
        data: {
            columns: <?= json_encode($grades)?>,
            type: 'donut',
            order: null
        },
        color: {
            pattern: ['#7abd7e', '#b9ca77', '#F8D66F', '#ff6961']
        },
    });
});
</script>
