<div class="row pe-0">
  <div class="col-md-7 pt-1">
    <p class="card-description my-0 py-2">Mostrando <?php echo $data['pag_inicio']; ?> a <?php echo $data['pag_fin']; ?> de <?php echo $data['resultado_registros_count']; ?></p>
  </div>
  <div class="col-md-5 pt-1 text-end px-0">
      <nav aria-label="Paginación" class="paginacion">
          <ul class="pagination justify-content-end m-0 pagination-sm">
              <li class="page-item <?php echo ($data['pagina']<=0) ? 'disabled':'' ?>"><a class="page-link font-size-11 pt-1 <?php echo ($data['pagina']<=0) ? '':'color-corp' ?>" href="<?php echo URL; ?><?php echo $data['path']; ?>0/<?php echo $data['filtro']; ?><?php echo $data['path_add']; ?>"><span class="fas fa-angle-double-left"></span></a></li>
              <li class="page-item <?php echo ($data['pagina']<=0) ? 'disabled':'' ?>"><a class="page-link font-size-11 pt-1 <?php echo ($data['pagina']<=0) ? '':'color-corp' ?>" href="<?php echo URL; ?><?php echo $data['path']; ?><?php echo $data['pagina']-1; ?>/<?php echo $data['filtro']; ?><?php echo $data['path_add']; ?>"><span class="fas fa-angle-left"></span></a></li>
              <?php
                  if ($data['pag_total']<=5 OR $data['pagina']<=3) {
                      $pagina_inicio=0; $pagina_fin=$data['pag_total'];
                      if ($data['pagina']<=3 AND $data['pag_total']>=5) {
                          $pagina_fin=5;
                      }
                  } else {
                      $pagina_inicio=$data['pagina']-2; $pagina_fin=$data['pagina']+2;
                      if (($data['pag_total']-$pagina_inicio)<=5) {
                          $pagina_inicio=$data['pag_total']-4; $pagina_fin=$data['pag_total'];
                      }
                  }
              ?>
              <?php for ($i=$pagina_inicio; $i < $pagina_fin; $i++): ?>
                  <li class="page-item <?php echo ($data['pagina']==$i) ? 'active':'' ?>"><a class="page-link <?php echo ($data['pagina']==$i) ? 'btn-corp':'color-corp' ?>" href="<?php echo URL; ?><?php echo $data['path']; ?><?php echo $i; ?>/<?php echo $data['filtro']; ?><?php echo $data['path_add']; ?>"><?php echo $i+1; ?></a></li>
              <?php endfor; ?>
              <li class="page-item <?php echo $data['pagina']+1>=$data['pag_total'] ? 'disabled':'' ?>"><a class="page-link font-size-11 pt-1 <?php echo $data['pagina']+1>=$data['pag_total'] ? '':'color-corp' ?>" href="<?php echo URL; ?><?php echo $data['path']; ?><?php echo $data['pagina']+1; ?>/<?php echo $data['filtro']; ?><?php echo $data['path_add']; ?>"><span class="fas fa-angle-right"></a></li>
              <li class="page-item <?php echo $data['pagina']+1>=$data['pag_total'] ? 'disabled':'' ?>"><a class="page-link font-size-11 pt-1 <?php echo $data['pagina']+1>=$data['pag_total'] ? '':'color-corp' ?>" href="<?php echo URL; ?><?php echo $data['path']; ?><?php echo $data['pag_total']-1; ?>/<?php echo $data['filtro']; ?><?php echo $data['path_add']; ?>"><span class="fas fa-angle-double-right"></a></li>
          </ul>
      </nav>
  </div>
</div>