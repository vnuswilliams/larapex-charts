<script>
(function () {
    var registry = window.larapexChartsRegistry = window.larapexChartsRegistry || {};
    var apexScriptPromise = null;

    function parseOptions(el) {
        try {
            return JSON.parse(el.getAttribute('data-larapex-chart'));
        } catch (e) {
            console.error('LarapexCharts: failed to parse chart options for #' + el.id, e);
            return null;
        }
    }

    function destroyChart(id) {
        if (!registry[id]) {
            return;
        }

        try {
            registry[id].destroy();
        } catch (e) {
            console.error('LarapexCharts: failed to destroy chart #' + id, e);
        }

        delete registry[id];
    }

    function renderChart(el) {
        var id = el.id;

        if (!id) {
            console.warn('LarapexCharts: chart container without id was ignored.');
            return;
        }

        var options = parseOptions(el);

        if (!options) {
            return;
        }

        destroyChart(id);

        try {
            registry[id] = new ApexCharts(el, options);
            registry[id].render();
        } catch (e) {
            console.error('LarapexCharts: failed to initialize chart #' + id, e);
        }
    }

    function cleanupDetachedCharts() {
        Object.keys(registry).forEach(function (id) {
            if (!document.getElementById(id)) {
                destroyChart(id);
            }
        });
    }

    function renderCharts(scope) {
        var root = scope && scope.querySelectorAll ? scope : document;
        var charts = root.querySelectorAll('[data-larapex-chart]');

        charts.forEach(function (el) {
            renderChart(el);
        });

        cleanupDetachedCharts();
    }

    function ensureApexLoaded(callback) {
        if (window.ApexCharts) {
            callback();
            return;
        }

        if (apexScriptPromise) {
            apexScriptPromise.then(callback);
            return;
        }

        apexScriptPromise = new Promise(function (resolve, reject) {
            var script = document.createElement('script');
            script.src = '<?php echo \vnusWilliams\LarapexCharts\LarapexChart::cdn(); ?>';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });

        apexScriptPromise.then(callback).catch(function (error) {
            console.error('LarapexCharts: failed to load ApexCharts from CDN.', error);
        });
    }

    function boot() {
        ensureApexLoaded(function () {
            renderCharts(document);
        });
    }

    document.addEventListener('DOMContentLoaded', boot);

    if (window.Livewire) {
        if (typeof window.Livewire.hook === 'function') {
            window.Livewire.hook('message.processed', function (_, component) {
                ensureApexLoaded(function () {
                    var scope = component && component.el ? component.el : document;
                    renderCharts(scope);
                });
            });
        }

        if (typeof window.Livewire.on === 'function') {
            window.Livewire.on('larapex:refresh', function () {
                ensureApexLoaded(function () {
                    renderCharts(document);
                });
            });
        }
    }
})();
</script>
