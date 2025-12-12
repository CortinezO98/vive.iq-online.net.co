<?php if($registro->hva_estado=='Pendiente' OR $registro->hva_estado=='Pendiente Fase 2'): ?>
    <div class="alert bg-warning text-dark px-1 py-0 font-size-10 m-0"><?php echo $registro->hva_estado; ?></div>
<?php elseif($registro->hva_estado=='Documentos Cargados'): ?>
    <div class="alert bg-success text-white px-1 py-0 font-size-10 m-0">Documentos Cargados</div>
<?php elseif($registro->hva_estado=='Vinculado'): ?>
    <div class="alert bg-success text-white px-1 py-0 font-size-10 m-0">Vinculado</div>
<?php elseif($registro->hva_estado=='No vinculado'): ?>
    <div class="alert bg-danger text-white px-1 py-0 font-size-10 m-0">No vinculado</div>
<?php elseif($registro->hva_estado=='Desiste'): ?>
    <div class="alert bg-dark text-white px-1 py-0 font-size-10 m-0">Desiste</div>
<?php elseif($registro->hva_estado=='Retirado'): ?>
    <div class="alert bg-dark text-white px-1 py-0 font-size-10 m-0">Retirado</div>
<?php elseif($registro->hva_estado=='Diligenciado'): ?>
    <div class="alert bg-success text-white px-1 py-0 font-size-10 m-0">Diligenciado</div>
<?php elseif($registro->hva_estado=='Rechazado'): ?>
    <div class="alert bg-danger text-white px-1 py-0 font-size-10 m-0"><?php echo $registro->hva_estado; ?></div>
<?php endif; ?>