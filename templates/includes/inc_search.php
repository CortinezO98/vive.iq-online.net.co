<form name="form_filtro_busqueda" action="" method="POST">
  <div class="form-group m-0">
    <div class="input-group">
      <input type="text" class="form-control form-control-sm" name="filtro_busqueda" id="filtro_busqueda" value='<?php if (isset($_POST["filtro_busqueda"])) { echo checkInput($_POST['filtro_busqueda']); } else {if($data['filtro']!="null"){echo $data['filtro'];}} ?>' placeholder="Búsqueda" required autofocus>
      <div class="input-group-append">
        <button class="btn pt-1 px-2 btn-primary btn-sm btn-corp" type="submit" name="form_filtro_busqueda"><span class="fas fa-search font-size-12"></span></button>
        <a href="<?php echo URL; ?><?php echo $data['path']; ?>0/null<?php echo $data['path_add']; ?>" class="btn pt-1 px-2 btn-primary btn-sm btn-corp"><span class="fas fa-sync-alt font-size-12"></span></a>
      </div>
    </div>
  </div>
</form>