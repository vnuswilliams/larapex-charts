<script>
(function () {
    var charts = document.querySelectorAll('[data-larapex-chart]');

    if (!charts.length) {
        return;
    }

    function initCharts() {
        charts.forEach(function (el) {
            try {
                var options = JSON.parse(el.getAttribute('data-larapex-chart'));
                new ApexCharts(el, options).render();
            } catch (e) {
                console.error('LarapexCharts: failed to initialize chart #' + el.id, e);
            }
        });
    }

    if (window.ApexCharts) {
        initCharts();
        return;
    }

    var script    = document.createElement('script');
    script.src    = '<?php echo \vnusWilliams\LarapexCharts\LarapexChart::cdn(); ?>';
    script.onload = initCharts;
    document.head.appendChild(script);
})();
</script>