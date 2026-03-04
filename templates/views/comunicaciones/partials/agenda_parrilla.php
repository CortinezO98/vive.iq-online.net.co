<?php
// Datos de la agenda (deberías pasarlos desde el controlador)
$month = max(1, min(12, (int)($_GET['m'] ?? date('n'))));
$year  = max(2020, min(2100, (int)($_GET['y'] ?? date('Y'))));

$first = new DateTimeImmutable(sprintf('%04d-%02d-01', $year, $month));
$startDow = (int)$first->format('N'); // 1(Lun) .. 7(Dom)
$gridStart = $first->modify('-' . ($startDow - 1) . ' days');
$gridEnd = $gridStart->modify('+41 days'); // 6 semanas (42 días)

// Aquí deberías cargar los eventos desde tu modelo
$eventos = [];
$byDate = [];
foreach ($eventos as $ev) { 
    $byDate[$ev['event_date']][] = $ev; 
}

// Verificar si el usuario puede gestionar eventos
$canManageEvents = in_array($_SESSION[APP_SESSION.'usu_perfil'] ?? '', ['ADMIN','Administrador','SUPERADMIN']);
?>

<section class="com-section com-section--alt">
  <div class="container">
    <div class="com-surface">
      <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
        <div>
          <h3 class="com-section-title mb-0">Agenda</h3>
          <div class="text-muted small">Programación mensual con enlaces de reunión</div>
        </div>

        <div class="d-flex gap-2 align-items-center">
          <a class="btn btn-sm btn-outline-dark" 
             href="?m=<?= $month === 1 ? 12 : $month-1 ?>&y=<?= $month === 1 ? $year-1 : $year ?>&uri=comunicaciones/ver/<?= $slug ?>">◀</a>

          <div class="fw-semibold px-2"><?= htmlspecialchars(date('F Y', strtotime($first->format('Y-m-d')))) ?></div>

          <a class="btn btn-sm btn-outline-dark" 
             href="?m=<?= $month === 12 ? 1 : $month+1 ?>&y=<?= $month === 12 ? $year+1 : $year ?>&uri=comunicaciones/ver/<?= $slug ?>">▶</a>

          <?php if($canManageEvents): ?>
            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalEvent">
              + Nuevo evento
            </button>
          <?php endif; ?>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table com-agenda-table align-middle mb-0">
          <thead>
            <tr class="text-uppercase small text-muted">
              <th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $day = $gridStart;
            for($week=0; $week<6; $week++):
          ?>
            <tr>
              <?php for($d=0; $d<7; $d++): 
                $dateStr = $day->format('Y-m-d');
                $inMonth = (int)$day->format('n') === $month;
                $isToday = $dateStr === date('Y-m-d');
                $evs = $byDate[$dateStr] ?? [];
              ?>
                <td class="<?= $inMonth ? '' : 'is-out' ?> <?= $isToday ? 'is-today' : '' ?>">
                  <div class="com-agenda-day">
                    <div class="com-agenda-daynum"><?= (int)$day->format('j') ?></div>

                    <?php foreach($evs as $ev): ?>
                      <div class="com-agenda-ev">
                        <div class="com-agenda-ev__title"><?= htmlspecialchars($ev['title']) ?></div>
                        <div class="com-agenda-ev__meta">
                          <?php if(!$ev['is_all_day'] && $ev['start_time']): ?>
                            <span><?= htmlspecialchars(substr($ev['start_time'],0,5)) ?></span>
                          <?php else: ?>
                            <span>Todo el día</span>
                          <?php endif; ?>

                          <?php if(!empty($ev['meet_url'])): ?>
                            <a class="ms-2" target="_blank" rel="noopener"
                               href="<?= htmlspecialchars($ev['meet_url']) ?>">Abrir</a>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </td>
              <?php $day = $day->modify('+1 day'); endfor; ?>
            </tr>
          <?php endfor; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Modal para crear evento -->
<?php if($canManageEvents): ?>
<div class="modal fade" id="modalEvent" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
    <form class="modal-content" method="POST" action="<?= URL ?>comunicaciones/eventos/guardar">
      <input type="hidden" name="slug" value="<?= $slug ?>">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label">Título</label>
            <input class="form-control" name="title" required maxlength="180">
          </div>
          <div class="col-md-4">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" name="event_date" required>
          </div>

          <div class="col-md-3">
            <label class="form-label">Inicio</label>
            <input type="time" class="form-control" name="start_time">
          </div>
          <div class="col-md-3">
            <label class="form-label">Fin</label>
            <input type="time" class="form-control" name="end_time">
          </div>
          <div class="col-md-6">
            <label class="form-label">Link reunión (Meet/Teams/Zoom)</label>
            <input class="form-control" name="meet_url" maxlength="600" placeholder="https://...">
          </div>

          <div class="col-12">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="description" rows="3" maxlength="600"></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-dark" type="button" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-dark" type="submit">Guardar</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<style>
.com-agenda-table td{
  width: 14.285%;
  height: 140px;
  vertical-align: top;
  padding: 10px;
  border-color: rgba(0,0,0,.06);
}

.com-agenda-table td.is-out{
  background: #fafafa;
  color: #9ca3af;
}

.com-agenda-table td.is-today{
  outline: 2px solid rgba(17,24,39,.12);
  outline-offset: -2px;
  border-radius: 10px;
}

.com-agenda-day{
  display:flex;
  flex-direction:column;
  gap: 8px;
  min-height: 120px;
}

.com-agenda-daynum{
  font-weight: 800;
  font-size: 12px;
  opacity: .9;
}

.com-agenda-ev{
  background: #f3f4f6;
  border: 1px solid rgba(0,0,0,.06);
  border-radius: 10px;
  padding: 8px 10px;
}

.com-agenda-ev__title{
  font-weight: 700;
  font-size: 12px;
  line-height: 1.2;
  margin-bottom: 4px;
}

.com-agenda-ev__meta{
  font-size: 11px;
  color: #6b7280;
}

.com-agenda-ev__meta a{
  color: inherit;
  text-decoration: underline;
}
</style>