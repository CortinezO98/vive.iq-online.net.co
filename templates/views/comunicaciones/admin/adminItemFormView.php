<?php require_once __DIR__.'/../_helpers.php'; ?>
<?php require_once TEMPLATES.'inc_header.php'; ?>

<?php
  $it = $item ?? null;
  $isEdit = $it && !empty($it->itm_id);
?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0"><?php echo $isEdit ? 'Editar' : 'Nuevo'; ?> item</h1>
    <a class="btn btn-outline-secondary" href="<?php echo URL; ?>comunicaciones/admin_items/<?php echo e($seccion->sec_id); ?>">Volver</a>
  </div>

  <form class="bg-white border rounded p-3" method="post" enctype="multipart/form-data"
        action="<?php echo URL; ?>comunicaciones/admin_item_guardar">

    <input type="hidden" name="itm_id" value="<?php echo e($it->itm_id ?? ''); ?>">
    <input type="hidden" name="sec_id" value="<?php echo e($seccion->sec_id ?? 0); ?>">
    <input type="hidden" name="itm_imagen" value="<?php echo e($it->itm_imagen ?? ''); ?>">

    <div class="row g-3">
      <div class="col-12 col-md-6">
        <label class="form-label">Título</label>
        <input class="form-control" name="itm_titulo" value="<?php echo e($it->itm_titulo ?? ''); ?>">
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Orden</label>
        <input class="form-control" type="number" name="itm_orden" value="<?php echo e($it->itm_orden ?? 0); ?>">
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Estado</label>
        <?php $st = (string)($it->itm_estado ?? 'ACTIVO'); ?>
        <select class="form-select" name="itm_estado">
          <option value="ACTIVO" <?php echo $st==='ACTIVO'?'selected':''; ?>>ACTIVO</option>
          <option value="INACTIVO" <?php echo $st==='INACTIVO'?'selected':''; ?>>INACTIVO</option>
        </select>
      </div>

      <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea class="form-control" name="itm_descripcion" rows="3"><?php echo e($it->itm_descripcion ?? ''); ?></textarea>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">URL destino</label>
        <input class="form-control" name="itm_url" value="<?php echo e($it->itm_url ?? ''); ?>">
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Target</label>
        <?php $tg = (string)($it->itm_target ?? '_blank'); ?>
        <select class="form-select" name="itm_target">
          <option value="_blank" <?php echo $tg==='_blank'?'selected':''; ?>>_blank</option>
          <option value="_self"  <?php echo $tg==='_self'?'selected':''; ?>>_self</option>
        </select>
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Badge (opcional)</label>
        <input class="form-control" name="itm_badge" value="<?php echo e($it->itm_badge ?? ''); ?>" placeholder="Nuevo">
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Subir imagen</label>
        <input class="form-control" type="file" name="itm_imagen_file" accept="image/*">
        <div class="form-text">Si no subes, se mantiene la actual.</div>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Embed (opcional)</label>
        <textarea class="form-control" name="itm_embed" rows="2"><?php echo e($it->itm_embed ?? ''); ?></textarea>
      </div>

      <div class="col-12">
        <label class="form-label">Extra JSON (opcional)</label>
        <textarea class="form-control" name="itm_extra_json_raw" rows="3"><?php echo e($it->itm_extra_json ?? ''); ?></textarea>
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Guardar</button>
      </div>
    </div>
  </form>
</div>

<?php require_once TEMPLATES.'inc_footer.php'; ?>
