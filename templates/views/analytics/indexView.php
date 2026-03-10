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
                        <select class="form-select" id="filtro_tipo" name="click_tipo">
                            <option value="">Todos</option>
                            <option value="menu">Menú</option>
                            <option value="item">Item</option>
                            <option value="boton">Botón</option>
                            <option value="card">Card</option>
                            <option value="link">Enlace</option>
                            <option value="banner">Banner</option>
                            <option value="documento">Documento</option>
                            <option value="elemento">Elemento</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filtro_modulo" class="form-label">Módulo</label>
                        <input type="text" class="form-control" id="filtro_modulo" name="click_modulo" placeholder="Ej: comunicaciones">
                    </div>
                    <div class="col-md-2 align-self-end">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" id="btnFiltrar">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="btnLimpiar">
                                <i class="fas fa-eraser me-1"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-success" id="btnExportarExcel">
                            <i class="fas fa-file-excel me-1"></i> Exportar a Excel
                        </button>
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

                <!-- Gráficas actuales -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white">
                                <strong>Top 10 elementos más clicados</strong>
                            </div>
                            <div class="card-body position-relative" style="height: 360px;">
                                <canvas id="chartTopElementos"></canvas>
                                <div id="emptyTopElementos" class="d-none h-100 d-flex align-items-center justify-content-center text-muted">
                                    Sin datos
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white">
                                <strong>Clics por tipo</strong>
                            </div>
                            <div class="card-body position-relative" style="height: 360px;">
                                <canvas id="chartPorTipo"></canvas>
                                <div id="emptyPorTipo" class="d-none h-100 d-flex align-items-center justify-content-center text-muted">
                                    Sin datos
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <strong>Tendencia diaria</strong>
                            </div>
                            <div class="card-body position-relative" style="height: 340px;">
                                <canvas id="chartSerieDiaria"></canvas>
                                <div id="emptySerieDiaria" class="d-none h-100 d-flex align-items-center justify-content-center text-muted">
                                    Sin datos
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="bg-white rounded-3 p-4 shadow-sm">
                    <div class="table-responsive">
                        <table id="tablaClics" class="table table-striped table-bordered align-middle w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha y Hora</th>
                                    <th>Tipo</th>
                                    <th>Etiqueta</th>
                                    <th>Módulo</th>
                                    <th>Clave</th>
                                    <th>Página</th>
                                    <th>Sección</th>
                                    <th>Contexto</th>
                                    <th>Posición</th>
                                    <th>Coordenadas</th>
                                    <th>Texto visible</th>
                                    <th>URL Destino</th>
                                    <th>Usuario</th>
                                    <th>IP</th>
                                    <th>Session</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

function mostrarEstadoVacio(canvasId, emptyId, mostrarVacio) {
    const canvas = document.getElementById(canvasId);
    const empty = document.getElementById(emptyId);

    if (!canvas || !empty) return;

    if (mostrarVacio) {
        canvas.classList.add('d-none');
        empty.classList.remove('d-none');
    } else {
        canvas.classList.remove('d-none');
        empty.classList.add('d-none');
    }
}

function obtenerFiltros() {
    return {
        fecha_inicio: ($('#fecha_inicio').val() || '').trim(),
        fecha_fin: ($('#fecha_fin').val() || '').trim(),
        click_tipo: ($('#filtro_tipo').val() || '').trim(),
        click_modulo: ($('#filtro_modulo').val() || '').trim()
    };
}

function construirUrl(baseUrl, paramsObj) {
    const params = new URLSearchParams();

    Object.keys(paramsObj).forEach(function(key) {
        const value = paramsObj[key];
        if (value !== null && value !== undefined && value !== '') {
            params.append(key, value);
        }
    });

    const query = params.toString();
    return query ? (baseUrl + '&' + query) : baseUrl;
}

function formatearNumero(valor) {
    const numero = parseInt(valor || 0, 10);
    return isNaN(numero) ? '0' : numero.toLocaleString('es-CO');
}

function renderKPIs(resumen) {
    $('#kpi_total_clics').text(formatearNumero(resumen.total_clics));
    $('#kpi_elementos_unicos').text(formatearNumero(resumen.elementos_unicos));
    $('#kpi_usuarios_unicos').text(formatearNumero(resumen.usuarios_unicos));
    $('#kpi_sesiones_unicas').text(formatearNumero(resumen.sesiones_unicas));
}

function renderTopElementos(data) {
    destruirChart(chartTopElementos);

    if (!data || data.length === 0) {
        mostrarEstadoVacio('chartTopElementos', 'emptyTopElementos', true);
        return;
    }

    mostrarEstadoVacio('chartTopElementos', 'emptyTopElementos', false);

    const labels = data.map(item => item.click_label || item.click_clave || 'Sin etiqueta');
    const values = data.map(item => parseInt(item.total_clics || 0, 10));

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
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

function renderPorTipo(data) {
    destruirChart(chartPorTipo);

    if (!data || data.length === 0) {
        mostrarEstadoVacio('chartPorTipo', 'emptyPorTipo', true);
        return;
    }

    mostrarEstadoVacio('chartPorTipo', 'emptyPorTipo', false);

    const labels = data.map(item => item.click_tipo || 'Sin tipo');
    const values = data.map(item => parseInt(item.total_clics || 0, 10));

    const ctx = document.getElementById('chartPorTipo').getContext('2d');
    chartPorTipo = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderWidth: 1,
                backgroundColor: [
                    '#1C2262',
                    '#09A28E',
                    '#F1C40F',
                    '#E74C3C',
                    '#3498DB',
                    '#9B59B6',
                    '#16A085',
                    '#D35400',
                    '#2ECC71',
                    '#34495E'
                ]
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
        mostrarEstadoVacio('chartSerieDiaria', 'emptySerieDiaria', true);
        return;
    }

    mostrarEstadoVacio('chartSerieDiaria', 'emptySerieDiaria', false);

    const labels = data.map(item => item.fecha);
    const values = data.map(item => parseInt(item.total_clics || 0, 10));

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
                backgroundColor: 'rgba(28, 34, 98, 0.10)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

function renderDashboard(json) {
    renderKPIs(json.resumen || {});
    renderTopElementos(json.top_elementos || []);
    renderPorTipo(json.por_tipo || []);
    renderSerieDiaria(json.serie_diaria || []);
}

function limpiarDashboard() {
    renderKPIs({
        total_clics: 0,
        elementos_unicos: 0,
        usuarios_unicos: 0,
        sesiones_unicas: 0
    });
    renderTopElementos([]);
    renderPorTipo([]);
    renderSerieDiaria([]);
}

function exportarExcelConFiltros() {
    const filtros = obtenerFiltros();
    const url = construirUrl('<?= URL ?>?uri=analytics/exportar_excel', filtros);
    window.open(url, '_blank');
}

$(document).ready(function () {
    tablaClics = $('#tablaClics').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '<?= URL ?>?uri=analytics/datos_json',
            type: 'GET',
            data: function (d) {
                const filtros = obtenerFiltros();
                d.fecha_inicio = filtros.fecha_inicio;
                d.fecha_fin = filtros.fecha_fin;
                d.click_tipo = filtros.click_tipo;
                d.click_modulo = filtros.click_modulo;
            },
            dataSrc: function (json) {
                renderDashboard(json || {});
                return (json && Array.isArray(json.data)) ? json.data : [];
            },
            error: function () {
                limpiarDashboard();
            }
        },
        columns: [
            { data: 'click_id', defaultContent: '' },
            { data: 'click_fecha', defaultContent: '' },
            { data: 'click_tipo', defaultContent: '' },
            { data: 'click_label', defaultContent: '' },
            {
                data: 'click_modulo',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : 'Sin módulo';
                }
            },
            { data: 'click_clave', defaultContent: '' },
            {
                data: 'page_slug',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : 'Sin página';
                }
            },
            {
                data: 'seccion_nombre',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : 'Sin sección';
                }
            },
            {
                data: 'click_contexto',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : 'Sin contexto';
                }
            },
            {
                data: 'click_posicion',
                render: function (data) {
                    return data !== null && data !== undefined && String(data).trim() !== '' ? data : '';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    const x = row.click_x ?? '';
                    const y = row.click_y ?? '';
                    return (x !== '' && y !== '') ? (x + ', ' + y) : '';
                }
            },
            {
                data: 'click_texto_visible',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : '';
                }
            },
            {
                data: 'click_url_destino',
                render: function (data, type) {
                    if (!data) {
                        return '';
                    }

                    const text = $('<div>').text(data).html();

                    if (type === 'display' && data !== '#' && data !== '#!') {
                        return '<a href="' + text + '" target="_blank" rel="noopener noreferrer">' + text + '</a>';
                    }

                    return text;
                }
            },
            {
                data: 'usuario_nombre',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : 'Anónimo';
                }
            },
            {
                data: 'click_ip',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : '';
                }
            },
            {
                data: 'click_session_id',
                render: function (data) {
                    return data && String(data).trim() !== '' ? data : '';
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        scrollX: true,
        dom: "<'row align-items-center mb-3'<'col-md-6'B><'col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row align-items-center mt-3'<'col-md-5'i><'col-md-7'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Exportar tabla',
                className: 'btn btn-success btn-sm',
                title: 'Reporte_Clics',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv me-1"></i> CSV',
                className: 'btn btn-info btn-sm',
                title: 'Reporte_Clics',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    $('#btnFiltrar').on('click', function () {
        tablaClics.ajax.reload();
    });

    $('#btnLimpiar').on('click', function () {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#filtro_tipo').val('');
        $('#filtro_modulo').val('');
        tablaClics.ajax.reload();
    });

    $('#btnExportarExcel').on('click', function () {
        exportarExcelConFiltros();
    });

    $('#fecha_inicio, #fecha_fin, #filtro_tipo').on('change', function () {
        tablaClics.ajax.reload();
    });

    $('#filtro_modulo').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            tablaClics.ajax.reload();
        }
    });
});
</script>

<?php require_once INCLUDES . 'inc_footer.php'; ?>