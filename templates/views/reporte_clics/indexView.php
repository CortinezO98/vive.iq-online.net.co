<?php require_once INCLUDES . 'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES . 'inc_header.php'; ?>

    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h3 class="mb-0 font-size-11">| <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Filtros de fecha -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button class="btn btn-primary" id="btnFiltrar">Filtrar</button>
                        <button class="btn btn-secondary" id="btnLimpiar">Limpiar</button>
                    </div>
                </div>

                <!-- Tabla de reportes -->
                <div class="bg-white rounded-3 p-4">
                    <table id="tablaClics" class="table table-striped table-bordered" style="width:100%">
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

<!-- DataTables CSS/JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#tablaClics').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '<?= URL ?>?uri=reporte_clics/generar_json',
            data: function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
            },
            dataSrc: 'data'
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
                        return '<a href="' + data + '" target="_blank">' + data + '</a>';
                    }
                    return data;
                }
            },
            { data: 'usuario_nombre' },
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
                className: 'btn btn-info btn-sm'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
                className: 'btn btn-danger btn-sm',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    table.buttons().container().appendTo('#tablaClics_wrapper .col-md-6:eq(1)');

    $('#btnFiltrar').on('click', function() {
        table.ajax.reload();
    });

    $('#btnLimpiar').on('click', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        table.ajax.reload();
    });
});
</script>
<?php require_once INCLUDES . 'inc_footer.php'; ?>