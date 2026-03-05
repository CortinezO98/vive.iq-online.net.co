<?php
// Este archivo renderiza SOLO el grid del calendario para AJAX
$diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// Calcular primer día del mes
$primerDia = new DateTime(sprintf('%04d-%02d-01', $year, $month));
$ultimoDia = new DateTime($primerDia->format('Y-m-t'));
$diasEnMes = (int)$ultimoDia->format('d');

// Día de la semana del primer día (1=Lunes, 7=Domingo)
$primerDiaSemana = (int)$primerDia->format('N');

// Días del mes anterior a mostrar
$diasAntes = $primerDiaSemana - 1;

$fecha = new DateTime(sprintf('%04d-%02d-01', $year, $month));
$fecha->modify("-{$diasAntes} days");
?>

<div class="calendar-grid">
    <?php for ($i = 0; $i < 42; $i++):
        $diaActual = (int)$fecha->format('d');
        $mesActual = (int)$fecha->format('n');
        $anioActual = (int)$fecha->format('Y');

        $esMesActual = ($mesActual == $month) && ($anioActual == $year);
        $esHoy = ($fecha->format('Y-m-d') == date('Y-m-d'));

        $keyFecha = $fecha->format('Y-m-d');
        $eventos = $eventosPorDia[$keyFecha] ?? [];

        $clase = 'calendar-day';
        if (!$esMesActual) $clase .= ' other-month';
        if ($esHoy) $clase .= ' today';
    ?>
        <div class="<?= $clase ?>" data-fecha="<?= htmlspecialchars($keyFecha) ?>">
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
    endfor; ?>
</div>