<?php
// calendarioView.php

// Datos del mes
$year  = (int)($d->year ?? date('Y'));
$month = (int)($d->month ?? date('n'));
$secId = (int)($d->secId ?? 0);

// Eventos por día (organizados por fecha Y-m-d)
$eventosPorDia = $d->eventosPorDia ?? [];

// Calcular primer día del mes
$primerDia = new DateTime(sprintf('%04d-%02d-01', $year, $month));
$ultimoDia = new DateTime($primerDia->format('Y-m-t'));
$diasEnMes = (int)$ultimoDia->format('d');

// Día de la semana del primer día (1=Lunes, 7=Domingo)
$primerDiaSemana = (int)$primerDia->format('N');

// Días del mes anterior a mostrar
$diasAntes = $primerDiaSemana - 1;

// Mes anterior y siguiente
$mesAnterior  = $month - 1;
$yearAnterior = $year;
if ($mesAnterior < 1) { $mesAnterior = 12; $yearAnterior--; }

$mesSiguiente  = $month + 1;
$yearSiguiente = $year;
if ($mesSiguiente > 12) { $mesSiguiente = 1; $yearSiguiente++; }

// Nombres de meses en español
$meses = [
  1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
  5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
  9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

$diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// Verificar permisos de administrador
$perfil = strtoupper(trim((string)($_SESSION[APP_SESSION.'usu_perfil'] ?? '')));
$puedeEditar = in_array($perfil, ['ADMIN','ADMINISTRADOR','SUPERADMIN'], true);

// Token CSRF
if (empty($_SESSION['iqvive_token'])) {
    $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
}
$csrfToken = (string)($_SESSION['iqvive_token'] ?? '');

// DEBUG SIMPLE - Mostrar valores importantes
echo "<!-- DEBUG: year=$year, month=$month, secId=$secId, puedeEditar=".($puedeEditar?'1':'0')." -->";
?>

<?php require_once INCLUDES.'inc_head.php'; ?>

<style>
/* Estilos simplificados para asegurar que se vea todo */
.calendar-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    padding: 2rem;
    margin: 2rem 0;
}
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}
.calendar-header h2 {
    color: #1C2262;
    font-weight: 700;
    font-size: 2rem;
    margin: 0;
}
.calendar-nav {
    display: flex;
    gap: 0.5rem;
}
.calendar-nav .btn {
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 500;
}
.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}
.calendar-weekday {
    text-align: center;
    font-weight: 700;
    color: #1C2262;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    text-transform: uppercase;
    font-size: 0.9rem;
}
.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.5rem;
}
.calendar-day {
    min-height: 120px;
    background: #f8f9fa;
    border-radius: 16px;
    padding: 0.75rem;
    border: 2px solid transparent;
}
.calendar-day.today {
    border-color: #1C2262;
    background: #e7e9f0;
}
.calendar-day.other-month {
    background: #f1f3f5;
    opacity: 0.7;
}
.calendar-day-number {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1C2262;
    margin-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.add-event-btn {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #1C2262;
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    cursor: pointer;
    opacity: 1; /* Siempre visible */
}
.add-event-btn:hover {
    background: #09A28E;
    transform: scale(1.1);
}
.calendar-events {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.calendar-event {
    background: white;
    border-left: 4px solid #1C2262;
    border-radius: 8px;
    padding: 0.5rem;
    font-size: 0.85rem;
    cursor: pointer;
}
.event-time {
    font-size: 0.7rem;
    color: #6c757d;
}
.event-title {
    font-weight: 600;
    color: #1C2262;
}
.event-link {
    font-size: 0.7rem;
    color: #09A28E;
    text-decoration: none;
}
.event-link:hover {
    text-decoration: underline;
}
.calendar-event.all-day {
    background: #e7e9f0;
    border-left-color: #09A28E;
}

/* Estilos de modales */
.event-modal .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}
.event-modal .modal-header {
    background: #1C2262;
    color: white;
    border-radius: 20px 20px 0 0;
    padding: 1.5rem;
}
.event-modal .btn-close {
    filter: brightness(0) invert(1);
}
.event-detail-label {
    font-weight: 600;
    color: #1C2262;
    margin-bottom: 0.25rem;
}
.event-detail-value {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 12px;
}

/* DEBUG - Bordes rojos para ver celdas */
.calendar-day {
    border: 1px solid #ccc; /* Temporal para ver los límites */
}
</style>

<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>

    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">

                <!-- Breadcrumb -->
                <div class="row mb-4">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?= URL ?>?uri=comunicaciones/ver/<?= htmlspecialchars($d->pagina->pag_slug ?? 'inicio') ?>">
                                        <?= htmlspecialchars($d->pagina->pag_titulo ?? 'Comunicaciones') ?>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Calendario</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Botón volver -->
                <?php if ($secId > 0): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="<?= URL ?>?uri=comunicaciones/ver/<?= htmlspecialchars($d->pagina->pag_slug ?? 'inicio') ?>#sec-<?= $secId ?>"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a la sección
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Calendario -->
                <div class="calendar-container">
                    <div class="calendar-header">
                        <h2>
                            <i class="fas fa-calendar-alt me-3" style="color: #1C2262;"></i>
                            <?= htmlspecialchars($meses[$month] ?? 'Mes') ?> <?= (int)$year ?>
                        </h2>
                        <div class="calendar-nav">
                            <a href="?uri=comunicaciones/calendario/<?= $secId ?>&year=<?= (int)$yearAnterior ?>&month=<?= (int)$mesAnterior ?>"
                               class="btn btn-outline-primary">
                                <i class="fas fa-chevron-left me-2"></i>Mes anterior
                            </a>
                            <a href="?uri=comunicaciones/calendario/<?= $secId ?>&year=<?= (int)date('Y') ?>&month=<?= (int)date('n') ?>"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-calendar-day me-2"></i>Hoy
                            </a>
                            <a href="?uri=comunicaciones/calendario/<?= $secId ?>&year=<?= (int)$yearSiguiente ?>&month=<?= (int)$mesSiguiente ?>"
                               class="btn btn-outline-primary">
                                Mes siguiente<i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Días de la semana -->
                    <div class="calendar-weekdays">
                        <?php foreach ($diasSemana as $dia): ?>
                            <div class="calendar-weekday"><?= htmlspecialchars($dia) ?></div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Cuadrícula del calendario -->
                    <div class="calendar-grid">
                        <?php
                        $fecha = new DateTime(sprintf('%04d-%02d-01', $year, $month));
                        $fecha->modify("-{$diasAntes} days");

                        for ($i = 0; $i < 42; $i++):
                            $diaActual  = (int)$fecha->format('d');
                            $mesActual  = (int)$fecha->format('n');
                            $anioActual = (int)$fecha->format('Y');

                            $esMesActual = ($mesActual == $month) && ($anioActual == $year);
                            $esHoy = ($fecha->format('Y-m-d') == date('Y-m-d'));

                            $keyFecha = $fecha->format('Y-m-d');
                            $eventos  = $eventosPorDia[$keyFecha] ?? [];

                            $clase = 'calendar-day';
                            if (!$esMesActual) $clase .= ' other-month';
                            if ($esHoy) $clase .= ' today';
                        ?>
                            <div class="<?= $clase ?>" data-fecha="<?= htmlspecialchars($keyFecha) ?>">

                                <!-- DEBUG SIMPLE -->
                                <div style="font-size:9px; background:#f0f0f0; padding:2px; margin-bottom:2px;">
                                    <?= $diaActual ?>/<?= $mesActual ?>
                                    (<?= $esMesActual ? 'actual' : 'otro' ?>)
                                </div>

                                <div class="calendar-day-number">
                                    <?= (int)$diaActual ?>
                                    <?php if ($puedeEditar && $esMesActual): ?>
                                        <button class="add-event-btn" type="button"
                                                onclick="abrirFormularioEvento('<?= htmlspecialchars($keyFecha) ?>')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="calendar-events">
                                    <?php foreach (array_slice($eventos, 0, 3) as $ev):
                                        $isAllDay = !empty($ev['is_all_day']) ? 1 : 0;
                                    ?>
                                        <div class="calendar-event <?= $isAllDay ? 'all-day' : '' ?>"
                                             data-evento='<?= htmlspecialchars(json_encode($ev), ENT_QUOTES, 'UTF-8') ?>'
                                             onclick='verEvento(this.dataset.evento ? JSON.parse(this.dataset.evento) : null)'
                                             style="border-left-color: <?= htmlspecialchars($ev['color'] ?? '#1C2262') ?>;">
                                            <?php if (!$isAllDay && !empty($ev['start_time'])): ?>
                                                <div class="event-time">
                                                    <?= htmlspecialchars(substr($ev['start_time'], 0, 5)) ?>
                                                    <?php if (!empty($ev['end_time'])): ?>
                                                        - <?= htmlspecialchars(substr($ev['end_time'], 0, 5)) ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="event-time">Todo el día</div>
                                            <?php endif; ?>
                                            <div class="event-title"><?= htmlspecialchars($ev['title'] ?? '') ?></div>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php if (count($eventos) > 3): ?>
                                        <div class="text-muted small text-center">
                                            +<?= (int)(count($eventos) - 3) ?> más
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php
                            $fecha->modify('+1 day');
                        endfor;
                        ?>
                    </div>
                </div>

                <!-- Botón de prueba para crear evento fijo -->
                <div class="text-center mt-4">
                    <button class="btn btn-success" onclick="abrirFormularioEvento('2026-03-15')">
                        <i class="fas fa-plus"></i> Probar crear evento (15 Marzo 2026)
                    </button>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Modales -->
<div class="modal fade event-modal" id="eventoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Detalle del evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="eventoModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <?php if ($puedeEditar): ?>
                    <button type="button" class="btn btn-outline-danger" onclick="eliminarEvento()">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="editarEvento()">
                        <i class="fas fa-pen me-1"></i>Editar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade event-modal" id="eventoFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoFormTitle">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="eventoForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="eventoId" value="0">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="eventoTitulo" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Color</label>
                            <select class="form-select" name="color" id="eventoColor">
                                <option value="#1C2262">Azul</option>
                                <option value="#09A28E">Verde</option>
                                <option value="#dc3545">Rojo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="event_date" id="eventoFecha" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Hora inicio</label>
                            <input type="time" class="form-control" name="start_time" id="eventoHoraInicio">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Hora fin</label>
                            <input type="time" class="form-control" name="end_time" id="eventoHoraFin">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_all_day" id="eventoAllDay" value="1">
                                <label class="form-check-label" for="eventoAllDay">Todo el día</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ubicación</label>
                            <input type="text" class="form-control" name="location" id="eventoLocation">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Enlace</label>
                            <input type="url" class="form-control" name="meet_url" id="eventoMeetUrl">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea class="form-control" name="description" id="eventoDescripcion" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Variable global para mantener el mes actual
let currentMonth = <?= json_encode($month) ?>;
let currentYear = <?= json_encode($year) ?>;
let currentSecId = <?= json_encode($secId) ?>;
let eventoActual = null;

function abrirFormularioEvento(fecha) {
    console.log('Abriendo formulario para fecha:', fecha);
    
    document.getElementById('eventoFormTitle').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Nuevo evento';
    document.getElementById('eventoId').value = '0';
    document.getElementById('eventoTitulo').value = '';
    document.getElementById('eventoFecha').value = fecha;
    document.getElementById('eventoHoraInicio').value = '';
    document.getElementById('eventoHoraFin').value = '';
    document.getElementById('eventoAllDay').checked = false;
    document.getElementById('eventoLocation').value = '';
    document.getElementById('eventoMeetUrl').value = '';
    document.getElementById('eventoDescripcion').value = '';
    document.getElementById('eventoColor').value = '#1C2262';
    
    // Habilitar campos de hora
    document.getElementById('eventoHoraInicio').disabled = false;
    document.getElementById('eventoHoraFin').disabled = false;
    
    // Abrir modal
    try {
        const modal = new bootstrap.Modal(document.getElementById('eventoFormModal'));
        modal.show();
    } catch (e) {
        console.error('Error al abrir modal:', e);
        alert('Error al abrir el formulario. ¿Bootstrap está cargado?');
    }
}

function verEvento(evento) {
    if (!evento) return;
    
    eventoActual = evento;
    console.log('Viendo evento:', evento);
    
    let html = '<div class="event-detail">' +
               '<div class="event-detail-label">Título</div>' +
               '<div class="event-detail-value">' + (evento.title || '') + '</div>' +
               '</div>';
    
    if (evento.description) {
        html += '<div class="event-detail">' +
                '<div class="event-detail-label">Descripción</div>' +
                '<div class="event-detail-value">' + evento.description.replace(/\n/g,'<br>') + '</div>' +
                '</div>';
    }
    
    html += '<div class="event-detail">' +
            '<div class="event-detail-label">Fecha</div>' +
            '<div class="event-detail-value">' + (evento.event_date || '') + '</div>' +
            '</div>';
    
    document.getElementById('eventoModalBody').innerHTML = html;
    
    try {
        const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
        modal.show();
    } catch (e) {
        console.error('Error al abrir modal:', e);
    }
}

function editarEvento() {
    if (!eventoActual) return;
    
    try {
        bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
    } catch (e) {}
    
    document.getElementById('eventoFormTitle').innerHTML = '<i class="fas fa-pen me-2"></i>Editar evento';
    document.getElementById('eventoId').value = eventoActual.id || 0;
    document.getElementById('eventoTitulo').value = eventoActual.title || '';
    document.getElementById('eventoFecha').value = eventoActual.event_date || '';
    document.getElementById('eventoHoraInicio').value = eventoActual.start_time || '';
    document.getElementById('eventoHoraFin').value = eventoActual.end_time || '';
    document.getElementById('eventoAllDay').checked = (eventoActual.is_all_day == 1);
    document.getElementById('eventoLocation').value = eventoActual.location || '';
    document.getElementById('eventoMeetUrl').value = eventoActual.meet_url || '';
    document.getElementById('eventoDescripcion').value = eventoActual.description || '';
    document.getElementById('eventoColor').value = eventoActual.color || '#1C2262';
    
    // Ajustar campos de hora según allDay
    const allDay = document.getElementById('eventoAllDay').checked;
    document.getElementById('eventoHoraInicio').disabled = allDay;
    document.getElementById('eventoHoraFin').disabled = allDay;
    
    setTimeout(() => {
        try {
            const modal = new bootstrap.Modal(document.getElementById('eventoFormModal'));
            modal.show();
        } catch (e) {}
    }, 250);
}

// ✅ VERSIÓN CORREGIDA - Guardar SIN recargar la página
document.getElementById('eventoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Mostrar indicador de carga
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('<?= URL ?>?uri=comunicaciones/evento_guardar_ajax', {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        console.log('Respuesta del servidor:', text);
        
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('No es JSON válido:', text);
            throw new Error('El servidor no devolvió JSON válido');
        }
    })
    .then(data => {
        if (data.success) {
            // ✅ Cerrar modal
            try {
                bootstrap.Modal.getInstance(document.getElementById('eventoFormModal')).hide();
            } catch (e) {}
            
            // ✅ RECARGAR SOLO EL CONTENIDO DEL CALENDARIO, NO TODA LA PÁGINA
            recargarCalendario();
            
            // Mensaje de éxito (opcional)
            // alert('Evento guardado correctamente');
        } else {
            alert('Error: ' + (data.message || 'No se pudo guardar'));
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Error al guardar: ' + err.message);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// ✅ NUEVA FUNCIÓN - Recargar calendario vía AJAX
function recargarCalendario() {
    // Mostrar indicador de carga en el calendario
    const calendarGrid = document.querySelector('.calendar-grid');
    const originalHTML = calendarGrid.innerHTML;
    calendarGrid.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
    
    // Hacer petición AJAX para obtener solo el HTML del calendario
    fetch('<?= URL ?>?uri=comunicaciones/calendario_ajax/' + currentSecId + '?year=' + currentYear + '&month=' + currentMonth)
    .then(response => response.text())
    .then(html => {
        // Reemplazar solo el grid del calendario
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newGrid = doc.querySelector('.calendar-grid');
        
        if (newGrid) {
            calendarGrid.innerHTML = newGrid.innerHTML;
            
            // Reasignar eventos a los nuevos botones
            document.querySelectorAll('.add-event-btn').forEach(btn => {
                const fecha = btn.closest('[data-fecha]')?.dataset.fecha;
                if (fecha) {
                    btn.onclick = (e) => {
                        e.preventDefault();
                        abrirFormularioEvento(fecha);
                    };
                }
            });
            
            // Reasignar eventos a los eventos del calendario
            document.querySelectorAll('.calendar-event').forEach(eventEl => {
                const eventoData = eventEl.getAttribute('data-evento');
                if (eventoData) {
                    eventEl.onclick = () => verEvento(JSON.parse(eventoData));
                }
            });
        }
    })
    .catch(err => {
        console.error('Error al recargar calendario:', err);
        calendarGrid.innerHTML = originalHTML;
        alert('Error al actualizar el calendario');
    });
}

// Modificar la función eliminarEvento para usar recargarCalendario
function eliminarEvento() {
    if (!eventoActual) return;
    if (!confirm('¿Estás seguro de eliminar este evento?')) return;
    
    const params = new URLSearchParams();
    params.append('id', eventoActual.id);
    params.append('token', '<?= htmlspecialchars($csrfToken) ?>');
    
    fetch('<?= URL ?>?uri=comunicaciones/evento_eliminar_ajax', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // ✅ Cerrar modal
            try {
                bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
            } catch (e) {}
            
            // ✅ Recargar SOLO el calendario
            recargarCalendario();
        } else {
            alert('Error: ' + (data.message || 'No se pudo eliminar'));
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Error de conexión');
    });
}

// Manejar checkbox "Todo el día"
document.getElementById('eventoAllDay').addEventListener('change', function() {
    const hi = document.getElementById('eventoHoraInicio');
    const hf = document.getElementById('eventoHoraFin');
    
    hi.disabled = this.checked;
    hf.disabled = this.checked;
    
    if (this.checked) {
        hi.value = '';
        hf.value = '';
    }
});

// Verificar que Bootstrap está cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página cargada');
    console.log('Bootstrap disponible:', typeof bootstrap !== 'undefined');
    console.log('Modal elements:', {
        formModal: document.getElementById('eventoFormModal'),
        viewModal: document.getElementById('eventoModal')
    });
});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>