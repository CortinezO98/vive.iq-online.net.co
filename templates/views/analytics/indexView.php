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
                    <div class="col-md-2">
                        <label for="filtro_tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="filtro_tipo">
                            <option value="">Todos</option>
                            <option value="menu">Menú</option>
                            <option value="item">Item</option>
                            <option value="boton">Botón</option>
                            <option value="card">Card</option>
                            <option value="link">Enlace</option>
                            <option value="banner">Banner</option>
                            <option value="documento">Documento</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filtro_modulo" class="form-label">Módulo</label>
                        <input type="text" class="form-control" id="filtro_modulo" placeholder="Ej: comunicaciones">
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button class="btn btn-primary w-100" id="btnFiltrar">
                            <i class="fas fa-filter me-1"></i> Filtrar
                        </button>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?php echo URL; ?>?uri=analytics/exportar_excel<?php echo isset($_GET['fecha_inicio']) ? '?fecha_inicio='.$_GET['fecha_inicio'].'&fecha_fin='.$_GET['fecha_fin'] : ''; ?>" 
                           class="btn btn-success" target="_blank">
                            <i class="fas fa-file-excel me-1"></i> Exportar a Excel
                        </a>
                    </div>
                </div>

                <!-- KPIs -->
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
                                <h6 class="text-muted mb-2">Elementos únicos</h6>
                                <h3 class="mb-0" id="kpi_elementos_unicos">0</h3>
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
                                <strong>Top 10 elementos más clicados</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="chartTopElementos" height="150"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <strong>Clics por tipo</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="chartPorTipo" height="150"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <strong>Tendencia diaria</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="chartSerieDiaria" height="100"></canvas>
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
                                <th>Tipo</th>
                                <th>Etiqueta</th>
                                <th>Módulo</th>
                                <th>Clave</th>
                                <th>URL Destino</th>
                                <th>Usuario</th>
                                <th>IP</th>
                                <th>Session</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
let tablaClics = null;
let chartTopElementos = null;
let chartPorTipo = null;
let chartSerieDiaria = null;

function destruirChart(chartRef) {
    if (chartRef) {
        chartRef.destroy();
    }
}

function renderKPIs(resumen) {
    $('#kpi_total_clics').text(resumen.total_clics || 0);
    $('#kpi_elementos_unicos').text(resumen.elementos_unicos || 0);
    $('#kpi_usuarios_unicos').text(resumen.usuarios_unicos || 0);
    $('#kpi_sesiones_unicas').text(resumen.sesiones_unicas || 0);
}

function renderTopElementos(data) {
    destruirChart(chartTopElementos);

    if (!data || data.length === 0) {
        $('#chartTopElementos').parent().html('<p class="text-muted text-center">Sin datos</p>');
        return;
    }

    const labels = data.map(x => x.click_label);
    const values = data.map(x => parseInt(x.total_clics, 10));

    const ctx = document.getElementById('chartTopElementos').getContext('2d');
    chartTopElementos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Clics',
                data: values,
                backgroundColor: '#1C2262',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function renderPorTipo(data) {
    destruirChart(chartPorTipo);

    if (!data || data.length === 0) {
        $('#chartPorTipo').parent().html('<p class="text-muted text-center">Sin datos</p>');
        return;
    }

    const labels = data.map(x => x.click_tipo);
    const values = data.map(x => parseInt(x.total_clics, 10));

    const ctx = document.getElementById('chartPorTipo').getContext('2d');
    chartPorTipo = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderWidth: 1,
                backgroundColor: ['#1C2262', '#09A28E', '#F1C40F', '#E74C3C', '#3498DB', '#9B59B6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function renderSerieDiaria(data) {
    destruirChart(chartSerieDiaria);

    if (!data || data.length === 0) {
        $('#chartSerieDiaria').parent().html('<p class="text-muted text-center">Sin datos</p>');
        return;
    }

    const labels = data.map(x => x.fecha);
    const values = data.map(x => parseInt(x.total_clics, 10));

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
                borderColor: '#1C2262',
                backgroundColor: 'rgba(28, 34, 98, 0.1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function cargarDatos() {
    const params = new URLSearchParams({
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val(),
        click_tipo: $('#filtro_tipo').val(),
        click_modulo: $('#filtro_modulo').val()
    });

    $.ajax({
        url: '<?= URL ?>?uri=analytics/datos_json?' + params.toString(),
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            renderKPIs(response.resumen || {});
            renderTopElementos(response.top_elementos || []);
            renderPorTipo(response.por_tipo || []);
            renderSerieDiaria(response.serie_diaria || []);

            if (tablaClics) {
                tablaClics.clear();
                tablaClics.rows.add(response.data || []);
                tablaClics.draw();
            }
        },
        error: function() {
            renderKPIs({});
            renderTopElementos([]);
            renderPorTipo([]);
            renderSerieDiaria([]);
        }
    });
}

$(document).ready(function() {
    tablaClics = $('#tablaClics').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '<?= URL ?>?uri=analytics/datos_json',
            data: function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
                d.click_tipo = $('#filtro_tipo').val();
                d.click_modulo = $('#filtro_modulo').val();
            },
            dataSrc: function(json) {
                renderKPIs(json.resumen || {});
                renderTopElementos(json.top_elementos || []);
                renderPorTipo(json.por_tipo || []);
                renderSerieDiaria(json.serie_diaria || []);
                return json.data || [];
            }
        },
        columns: [
            { data: 'click_id' },
            { data: 'click_fecha' },
            { data: 'click_tipo' },
            { data: 'click_label' },
            { data: 'click_modulo' },
            { data: 'click_clave' },
            { 
                data: 'click_url_destino',
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
            { data: 'click_session_id' }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exportar',
                className: 'btn btn-success btn-sm',
                title: 'Reporte_Clics'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-info btn-sm',
                title: 'Reporte_Clics'
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

    // Cargar datos iniciales
    cargarDatos();
});
</script>

<?php require_once INCLUDES . 'inc_footer.php'; ?>