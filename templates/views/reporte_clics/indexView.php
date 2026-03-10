<?php require_once INCLUDES . 'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES . 'inc_header.php'; ?>

    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0 font-size-11">
                                | <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?>
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button class="btn btn-primary" id="btnFiltrar">Filtrar</button>
                        <button class="btn btn-secondary" id="btnLimpiar">Limpiar</button>
                    </div>
                </div>

                <!-- Métricas -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Total clics</h6>
                                <h3 class="mb-0" id="kpi_total_clics">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Items clicados</h6>
                                <h3 class="mb-0" id="kpi_items_clicados">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Usuarios únicos</h6>
                                <h3 class="mb-0" id="kpi_usuarios_unicos">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Sesiones únicas</h6>
                                <h3 class="mb-0" id="kpi_sesiones_unicas">0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficas -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <strong>Top 10 items más clicados</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="chartTopItems" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <strong>Clics por sección</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="chartTopSecciones" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <strong>Tendencia de clics por día</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="chartSerieDiaria" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla detalle -->
                <div class="bg-white rounded-3 p-4 shadow-sm">
                    <table id="tablaClics" class="table table-striped table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha y Hora</th>
                                <th>Página</th>
                                <th>Sección</th>
                                <th>Item</th>
                                <th>URL</th>
                                <th>Usuario</th>
                                <th>IP</th>
                                <th>Referer</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
let tablaClics = null;
let chartTopItems = null;
let chartTopSecciones = null;
let chartSerieDiaria = null;

function destruirChart(chartRef) {
    if (chartRef) {
        chartRef.destroy();
    }
}

function renderKPIs(resumen) {
    $('#kpi_total_clics').text(resumen.total_clics || 0);
    $('#kpi_items_clicados').text(resumen.items_clicados || 0);
    $('#kpi_usuarios_unicos').text(resumen.usuarios_unicos || 0);
    $('#kpi_sesiones_unicas').text(resumen.sesiones_unicas || 0);
}

function renderTopItems(topItems) {
    destruirChart(chartTopItems);

    const labels = topItems.map(x => x.itm_titulo);
    const values = topItems.map(x => parseInt(x.total_clics, 10));

    const ctx = document.getElementById('chartTopItems').getContext('2d');
    chartTopItems = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Clics',
                data: values,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function renderTopSecciones(topSecciones) {
    destruirChart(chartTopSecciones);

    const labels = topSecciones.map(x => x.sec_titulo || 'Sin sección');
    const values = topSecciones.map(x => parseInt(x.total_clics, 10));

    const ctx = document.getElementById('chartTopSecciones').getContext('2d');
    chartTopSecciones = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function renderSerieDiaria(serieDiaria) {
    destruirChart(chartSerieDiaria);

    const labels = serieDiaria.map(x => x.fecha);
    const values = serieDiaria.map(x => parseInt(x.total_clics, 10));

    const ctx = document.getElementById('chartSerieDiaria').getContext('2d');
    chartSerieDiaria = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Clics por día',
                data: values,
                tension: 0.25,
                fill: false,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function cargarMetricas() {
    $.ajax({
        url: '<?= URL ?>?uri=reporte_clics/generar_json',
        type: 'GET',
        dataType: 'json',
        data: {
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val()
        },
        success: function(response) {
            renderKPIs(response.resumen || {});
            renderTopItems(response.top_items || []);
            renderTopSecciones(response.top_secciones || []);
            renderSerieDiaria(response.serie_diaria || []);
        },
        error: function() {
            renderKPIs({});
            renderTopItems([]);
            renderTopSecciones([]);
            renderSerieDiaria([]);
        }
    });
}

$(document).ready(function() {
    tablaClics = $('#tablaClics').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '<?= URL ?>?uri=reporte_clics/generar_json',
            data: function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
            },
            dataSrc: function(json) {
                renderKPIs(json.resumen || {});
                renderTopItems(json.top_items || []);
                renderTopSecciones(json.top_secciones || []);
                renderSerieDiaria(json.serie_diaria || []);
                return json.data || [];
            }
        },
        columns: [
            { data: 'click_id' },
            { data: 'click_fecha' },
            { data: 'pagina_titulo' },
            { data: 'seccion_titulo' },
            { data: 'itm_titulo' },
            {
                data: 'itm_url',
                render: function(data) {
                    if (data && data !== '#' && data !== '#!') {
                        return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data + '</a>';
                    }
                    return data || '';
                }
            },
            {
                data: 'usuario_nombre',
                render: function(data) {
                    return data ? data : 'Anónimo';
                }
            },
            { data: 'click_ip' },
            { data: 'click_referer' }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
                className: 'btn btn-success btn-sm',
                title: 'Reporte_Clics_Items'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> Exportar a CSV',
                className: 'btn btn-info btn-sm',
                title: 'Reporte_Clics_Items'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
                className: 'btn btn-danger btn-sm',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Reporte_Clics_Items'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'btn btn-secondary btn-sm',
                title: 'Reporte_Clics_Items'
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    tablaClics.buttons().container().appendTo('#tablaClics_wrapper .col-md-6:eq(1)');

    $('#btnFiltrar').on('click', function() {
        tablaClics.ajax.reload();
    });

    $('#btnLimpiar').on('click', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        tablaClics.ajax.reload();
    });
});
</script>

<?php require_once INCLUDES . 'inc_footer.php'; ?>