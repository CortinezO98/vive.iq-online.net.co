<?php require_once INCLUDES.'inc_head.php'; ?>

<?php
// Datos del mes
$year = (int)($d->year ?? date('Y'));
$month = (int)($d->month ?? date('n'));
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
$mesAnterior = $month - 1;
$yearAnterior = $year;
if ($mesAnterior < 1) {
    $mesAnterior = 12;
    $yearAnterior--;
}

$mesSiguiente = $month + 1;
$yearSiguiente = $year;
if ($mesSiguiente > 12) {
    $mesSiguiente = 1;
    $yearSiguiente++;
}

// Nombres de meses en español
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

$diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// FIX: permitir ADMINISTRADOR y normalizar mayúsculas (igual que en el controller)
$perfil = strtoupper(trim((string)($_SESSION[APP_SESSION.'usu_perfil'] ?? '')));
$puedeEditar = in_array($perfil, ['ADMIN','ADMINISTRADOR','SUPERADMIN'], true);

// CSRF token seguro (no rompe si no existe)
$csrfToken = (string)($_SESSION['iqvive_token'] ?? '');
?>

<style>
/* Estilos para el calendario */
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
    min-height: 150px;
    background: #f8f9fa;
    border-radius: 16px;
    padding: 0.75rem;
    transition: all 0.2s;
    border: 2px solid transparent;
    position: relative;
}

.calendar-day:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
    opacity: 0;
    transition: opacity 0.2s;
}

.calendar-day:hover .add-event-btn {
    opacity: 1;
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
    transition: all 0.2s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.calendar-event:hover {
    transform: translateX(3px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.calendar-event .event-time {
    font-size: 0.7rem;
    color: #6c757d;
    margin-bottom: 0.2rem;
}

.calendar-event .event-title {
    font-weight: 600;
    color: #1C2262;
    margin-bottom: 0.2rem;
}

.calendar-event .event-link {
    font-size: 0.7rem;
    color: #09A28E;
    text-decoration: none;
}

.calendar-event .event-link:hover {
    text-decoration: underline;
}

.calendar-event.all-day {
    background: #e7e9f0;
    border-left-color: #09A28E;
}

/* Modal de eventos */
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

.event-modal .modal-title {
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.event-modal .btn-close {
    filter: brightness(0) invert(1);
}

.event-modal .modal-body {
    padding: 1.5rem;
}

.event-detail {
    margin-bottom: 1.5rem;
}

.event-detail-label {
    font-weight: 600;
    color: #1C2262;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.event-detail-value {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 12px;
    color: #495057;
}

.event-detail-value a {
    color: #1C2262;
    text-decoration: none;
    font-weight: 500;
}

.event-detail-value a:hover {
    text-decoration: underline;
}

/* Colores de eventos */
.event-color-1 { border-left-color: #1C2262; }
.event-color-2 { border-left-color: #09A28E; }
.event-color-3 { border-left-color: #dc3545; }
.event-color-4 { border-left-color: #ffc107; }
.event-color-5 { border-left-color: #17a2b8; }
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
                                    <a href="<?= URL ?>?uri=comunicaciones/ver/<?= htmlspecialchars($d->pagina->pag_slug ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($d->pagina->pag_titulo ?? 'Comunicaciones', ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Calendario</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Calendario -->
                <div class="calendar-container">
                    <div class="calendar-header">
                        <h2>
                            <i class="fas fa-calendar-alt me-3" style="color: #1C2262;"></i>
                            <?= htmlspecialchars($meses[$month] ?? 'Mes', ENT_QUOTES, 'UTF-8') ?> <?= (int)$year ?>
                        </h2>
                        <div class="calendar-nav">
                            <a href="?year=<?= (int)$yearAnterior ?>&month=<?= (int)$mesAnterior ?>" class="btn btn-outline-primary">
                                <i class="fas fa-chevron-left me-2"></i>Mes anterior
                            </a>
                            <a href="?year=<?= (int)date('Y') ?>&month=<?= (int)date('n') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-calendar-day me-2"></i>Hoy
                            </a>
                            <a href="?year=<?= (int)$yearSiguiente ?>&month=<?= (int)$mesSiguiente ?>" class="btn btn-outline-primary">
                                Mes siguiente<i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Días de la semana -->
                    <div class="calendar-weekdays">
                        <?php foreach ($diasSemana as $dia): ?>
                            <div class="calendar-weekday"><?= htmlspecialchars($dia, ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Cuadrícula del calendario -->
                    <div class="calendar-grid">
                        <?php
                        // Días del mes anterior
                        $fecha = new DateTime(sprintf('%04d-%02d-01', $year, $month));
                        $fecha->modify("-{$diasAntes} days");

                        for ($i = 0; $i < 42; $i++):
                            $diaActual = (int)$fecha->format('d');
                            $mesActual = (int)$fecha->format('n');
                            $anioActual = (int)$fecha->format('Y');
                            $esMesActual = ($mesActual == $month) && ($anioActual == $year);
                            $esHoy = ($fecha->format('Y-m-d') == date('Y-m-d'));

                            // IMPORTANTE: evitar mezclar eventos de otros meses con mismo "día"
                            $key = $fecha->format('Y-m-d');
                            $eventos = $eventosPorDia[$key] ?? [];

                            // Compatibilidad: si aún te llega por número de día, úsalo SOLO si es mes actual
                            if ($esMesActual && empty($eventos)) {
                                $eventos = $eventosPorDia[$diaActual] ?? [];
                            }

                            if (!$esMesActual) {
                                $eventos = [];
                            }

                            $clase = 'calendar-day';
                            if (!$esMesActual) $clase .= ' other-month';
                            if ($esHoy) $clase .= ' today';
                        ?>
                            <div class="<?= $clase ?>" data-fecha="<?= htmlspecialchars($fecha->format('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>">
                                <div class="calendar-day-number">
                                    <?= (int)$diaActual ?>
                                    <?php if ($puedeEditar && $esMesActual): ?>
                                        <button class="add-event-btn" type="button" onclick="abrirFormularioEvento('<?= htmlspecialchars($fecha->format('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="calendar-events">
                                    <?php foreach (array_slice($eventos, 0, 3) as $ev): ?>
                                        <?php
                                            // Asegurar flags/valores esperados
                                            $isAllDay = !empty($ev['is_all_day']) ? 1 : 0;
                                            $evSafe = $ev;
                                            $evSafe['is_all_day'] = $isAllDay;
                                        ?>
                                        <div class="calendar-event <?= $isAllDay ? 'all-day' : '' ?>"
                                             onclick='verEvento(<?= json_encode($evSafe, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>)'
                                             style="border-left-color: <?= htmlspecialchars($ev['color'] ?? '#1C2262', ENT_QUOTES, 'UTF-8') ?>;">
                                            <?php if (!$isAllDay && !empty($ev['start_time'])): ?>
                                                <div class="event-time">
                                                    <?= htmlspecialchars(substr((string)$ev['start_time'], 0, 5), ENT_QUOTES, 'UTF-8') ?>
                                                    <?php if (!empty($ev['end_time'])): ?>
                                                        - <?= htmlspecialchars(substr((string)$ev['end_time'], 0, 5), ENT_QUOTES, 'UTF-8') ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="event-time">Todo el día</div>
                                            <?php endif; ?>
                                            <div class="event-title"><?= htmlspecialchars((string)($ev['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
                                            <?php if (!empty($ev['meet_url'])): ?>
                                                <a href="<?= htmlspecialchars((string)$ev['meet_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="event-link" onclick="event.stopPropagation()">
                                                    <i class="fas fa-video me-1"></i>Unirse
                                                </a>
                                            <?php endif; ?>
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

                <!-- Leyenda -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4 flex-wrap">
                                    <span class="fw-semibold">Eventos:</span>
                                    <span class="d-flex align-items-center gap-2">
                                        <span style="width: 20px; height: 4px; background: #1C2262;"></span>
                                        <span>Puntual</span>
                                    </span>
                                    <span class="d-flex align-items-center gap-2">
                                        <span style="width: 20px; height: 4px; background: #09A28E;"></span>
                                        <span>Todo el día</span>
                                    </span>
                                    <?php if ($puedeEditar): ?>
                                        <span class="ms-auto">
                                            <i class="fas fa-plus-circle text-success me-1"></i>
                                            Haz clic en el <i class="fas fa-plus bg-dark text-white p-1 rounded-circle" style="font-size: 0.7rem;"></i> para agregar eventos
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Modal para ver evento -->
<div class="modal fade event-modal" id="eventoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-check me-2"></i>
                    Detalle del evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="eventoModalBody">
                <!-- Contenido dinámico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <?php if ($puedeEditar): ?>
                    <button type="button" class="btn btn-outline-danger" id="eliminarEventoBtn" onclick="eliminarEvento()">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                    <button type="button" class="btn btn-primary" id="editarEventoBtn" onclick="editarEvento()">
                        <i class="fas fa-pen me-1"></i>Editar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear/editar evento -->
<div class="modal fade event-modal" id="eventoFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoFormTitle">
                    <i class="fas fa-plus-circle me-2"></i>
                    Nuevo evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="eventoForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="eventoId" value="0">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['iqvive_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="eventoTitulo" required maxlength="200">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Color</label>
                            <select class="form-select" name="color" id="eventoColor">
                                <option value="#1C2262">Azul corporativo</option>
                                <option value="#09A28E">Verde</option>
                                <option value="#dc3545">Rojo</option>
                                <option value="#ffc107">Amarillo</option>
                                <option value="#17a2b8">Celeste</option>
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
                                <label class="form-check-label" for="eventoAllDay">
                                    Todo el día
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ubicación</label>
                            <input type="text" class="form-control" name="location" id="eventoLocation" placeholder="Oficina, sala, etc.">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Enlace de reunión</label>
                            <input type="url" class="form-control" name="meet_url" id="eventoMeetUrl" placeholder="https://meet.google.com/...">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea class="form-control" name="description" id="eventoDescripcion" rows="3" maxlength="500"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: #1C2262; border-color: #1C2262;">
                        <i class="fas fa-save me-1"></i>Guardar evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let eventoActual = null;
let fechaSeleccionada = null;

// Abrir formulario para nuevo evento
function abrirFormularioEvento(fecha) {
    fechaSeleccionada = fecha;
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

    new bootstrap.Modal(document.getElementById('eventoFormModal')).show();
}

// Escapar texto (por si vienen caracteres especiales en descripción)
function esc(s) {
    s = (s ?? '').toString();
    return s.replace(/[&<>"']/g, function(m) {
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]);
    });
}

// Ver detalle de evento
function verEvento(evento) {
    eventoActual = evento;

    let html = `
        <div class="event-detail">
            <div class="event-detail-label">Título</div>
            <div class="event-detail-value">${esc(evento.title)}</div>
        </div>
    `;

    if (evento.description) {
        html += `
            <div class="event-detail">
                <div class="event-detail-label">Descripción</div>
                <div class="event-detail-value">${esc(evento.description).replace(/\n/g, '<br>')}</div>
            </div>
        `;
    }

    html += `
        <div class="event-detail">
            <div class="event-detail-label">Fecha y hora</div>
            <div class="event-detail-value">
                ${new Date(evento.event_date).toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
    `;

    if (!evento.is_all_day && evento.start_time) {
        html += `<br>${(evento.start_time || '').toString().substring(0,5)}`;
        if (evento.end_time) {
            html += ` - ${(evento.end_time || '').toString().substring(0,5)}`;
        }
    } else {
        html += `<br>Todo el día`;
    }

    html += `</div></div>`;

    if (evento.location) {
        html += `
            <div class="event-detail">
                <div class="event-detail-label">Ubicación</div>
                <div class="event-detail-value">${esc(evento.location)}</div>
            </div>
        `;
    }

    if (evento.meet_url) {
        const url = esc(evento.meet_url);
        html += `
            <div class="event-detail">
                <div class="event-detail-label">Enlace de reunión</div>
                <div class="event-detail-value">
                    <a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>
                </div>
            </div>
        `;
    }

    document.getElementById('eventoModalBody').innerHTML = html;

    <?php if ($puedeEditar): ?>
        document.getElementById('eliminarEventoBtn').style.display = 'inline-block';
        document.getElementById('editarEventoBtn').style.display = 'inline-block';
    <?php endif; ?>

    new bootstrap.Modal(document.getElementById('eventoModal')).show();
}

// Editar evento
function editarEvento() {
    if (!eventoActual) return;

    bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();

    document.getElementById('eventoFormTitle').innerHTML = '<i class="fas fa-pen me-2"></i>Editar evento';
    document.getElementById('eventoId').value = eventoActual.id;
    document.getElementById('eventoTitulo').value = eventoActual.title || '';
    document.getElementById('eventoFecha').value = eventoActual.event_date || '';
    document.getElementById('eventoHoraInicio').value = eventoActual.start_time || '';
    document.getElementById('eventoHoraFin').value = eventoActual.end_time || '';
    document.getElementById('eventoAllDay').checked = (eventoActual.is_all_day == 1);
    document.getElementById('eventoLocation').value = eventoActual.location || '';
    document.getElementById('eventoMeetUrl').value = eventoActual.meet_url || '';
    document.getElementById('eventoDescripcion').value = eventoActual.description || '';
    document.getElementById('eventoColor').value = eventoActual.color || '#1C2262';

    setTimeout(() => {
        new bootstrap.Modal(document.getElementById('eventoFormModal')).show();
    }, 300);
}

// Eliminar evento (FIX: enviar token también)
function eliminarEvento() {
    if (!eventoActual) return;

    if (!confirm('¿Estás seguro de eliminar este evento?')) return;

    const params = new URLSearchParams();
    params.append('id', eventoActual.id);
    params.append('token', '<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>');

    fetch('<?= URL ?>?uri=comunicaciones/evento_eliminar_ajax', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params.toString()
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'No se pudo eliminar'));
        }
    })
    .catch(() => alert('Error de red al eliminar el evento'));
}

// Guardar evento
document.getElementById('eventoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?= URL ?>?uri=comunicaciones/evento_guardar_ajax', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('eventoFormModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'No se pudo guardar'));
        }
    })
    .catch(() => alert('Error de red al guardar el evento'));
});

// Validar horas cuando se marca/desmarca "Todo el día"
document.getElementById('eventoAllDay').addEventListener('change', function() {
    const horaInicio = document.getElementById('eventoHoraInicio');
    const horaFin = document.getElementById('eventoHoraFin');

    if (this.checked) {
        horaInicio.disabled = true;
        horaFin.disabled = true;
        horaInicio.value = '';
        horaFin.value = '';
    } else {
        horaInicio.disabled = false;
        horaFin.disabled = false;
    }
});

// Estado inicial (por si el modal abre con checkbox marcado)
document.addEventListener('DOMContentLoaded', function() {
    const chk = document.getElementById('eventoAllDay');
    if (chk && chk.checked) chk.dispatchEvent(new Event('change'));
});
</script>

<?php require_once INCLUDES.'inc_footer.php'; ?>