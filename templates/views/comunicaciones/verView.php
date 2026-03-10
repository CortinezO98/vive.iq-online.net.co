<?php require_once INCLUDES.'inc_header.php'; ?>

<?php
// Cargar estilos adicionales
render_com_styles_once();
?>

<style>
/* Estilos mejorados para la vista pública */
.com-page-section {
  position: relative;
  overflow: hidden;
}

/* Hero mejorado */
.com-hero-custom {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
}

.com-hero-custom::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(28,34,98,0.85) 0%, rgba(9,162,142,0.85) 100%);
  z-index: 1;
}

.com-hero-custom .container {
  position: relative;
  z-index: 2;
}

.com-hero-custom h1 {
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  font-weight: 800;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.com-hero-custom .lead {
  font-size: clamp(1.1rem, 2vw, 1.5rem);
  opacity: 0.95;
  max-width: 800px;
}

/* Secciones */
.com-section-custom {
  padding: 5rem 0;
}

.com-section-custom:nth-child(even) {
  background-color: #f8f9fa;
}

.com-section-custom .section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #1C2262;
  margin-bottom: 1rem;
}

.com-section-custom .section-subtitle {
  font-size: 1.1rem;
  color: #6c757d;
  max-width: 700px;
  margin: 0 auto 2.5rem;
}

/* Carrusel mejorado */
.com-carousel {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.com-carousel-item {
  background: #fff;
}

.com-carousel-image {
  min-height: 400px;
  background-size: cover;
  background-position: center;
  transition: transform 0.5s ease;
}

.com-carousel-item:hover .com-carousel-image {
  transform: scale(1.05);
}

.com-carousel-content {
  padding: 3rem;
}

.com-carousel-content h4 {
  font-size: 2rem;
  font-weight: 700;
  color: #1C2262;
  margin-bottom: 1rem;
}

.com-carousel-content p {
  font-size: 1.1rem;
  line-height: 1.6;
  color: #495057;
  margin-bottom: 1.5rem;
}

.com-carousel-content .btn {
  padding: 0.75rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  transition: all 0.3s;
}

.com-carousel-content .btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(28,34,98,0.2);
}

/* Tarjetas mejoradas */
.com-card-grid {
  margin: -1rem;
}

.com-card-item {
  padding: 1rem;
}

.com-card-custom {
  border: none;
  border-radius: 20px;
  overflow: hidden;
  transition: all 0.3s;
  height: 100%;
  background: white;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.com-card-custom:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(28,34,98,0.15);
}

.com-card-custom .card-img-wrapper {
  height: 240px;
  overflow: hidden;
}

.com-card-custom .card-img-top {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s;
}

.com-card-custom:hover .card-img-top {
  transform: scale(1.1);
}

.com-card-custom .card-body {
  padding: 1.5rem;
}

.com-card-custom .card-title {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1C2262;
  margin-bottom: 0.75rem;
}

.com-card-custom .card-text {
  color: #6c757d;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.com-card-custom .btn {
  border-radius: 50px;
  padding: 0.5rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s;
}

/* Enlaces mejorados */
.com-links-list {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.com-links-list .list-group-item {
  border: none;
  border-bottom: 1px solid #e9ecef;
  padding: 1.25rem 1.5rem;
  transition: all 0.3s;
}

.com-links-list .list-group-item:last-child {
  border-bottom: none;
}

.com-links-list .list-group-item:hover {
  background: #f8f9fa;
  padding-left: 2rem;
}

.com-links-list .list-group-item .link-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1C2262;
  margin-bottom: 0.25rem;
}

.com-links-list .list-group-item .link-desc {
  color: #6c757d;
  font-size: 0.95rem;
}

.com-links-list .list-group-item .arrow {
  color: #1C2262;
  font-size: 1.2rem;
  opacity: 0.5;
  transition: all 0.3s;
}

.com-links-list .list-group-item:hover .arrow {
  opacity: 1;
  transform: translateX(5px);
}

/* Video y calendario */
.com-embed-wrapper {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* CTA mejorado */
.com-cta-section {
  background: linear-gradient(135deg, #1C2262 0%, #09A28E 100%);
  border-radius: 20px;
  padding: 3rem;
  color: white;
  margin: 2rem 0;
}

.com-cta-section h4 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.com-cta-section p {
  font-size: 1.1rem;
  opacity: 0.95;
  margin-bottom: 1.5rem;
}

.com-cta-section .btn {
  background: white;
  color: #1C2262;
  border: none;
  padding: 1rem 3rem;
  border-radius: 50px;
  font-weight: 700;
  font-size: 1.1rem;
  transition: all 0.3s;
}

.com-cta-section .btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.2);
  background: white;
}

/* Social cards */
.com-social-grid {
  margin: -0.5rem;
}

.com-social-card {
  padding: 0.5rem;
}

.com-social-card .card {
  border: none;
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.3s;
  background: white;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.com-social-card .card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(28,34,98,0.15);
}

.com-social-card .card-img-top {
  height: 140px;
  object-fit: cover;
}

.com-social-card .card-body {
  padding: 1rem;
}

.com-social-card .card-title {
  font-size: 1rem;
  font-weight: 700;
  color: #1C2262;
  margin-bottom: 0.25rem;
}

.com-social-card .card-text {
  font-size: 0.85rem;
  color: #6c757d;
}

/* Animaciones */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.com-section-custom {
  animation: fadeInUp 0.6s ease-out;
}

/* Responsive */
@media (max-width: 768px) {
  .com-section-custom {
    padding: 3rem 0;
  }
  
  .com-section-custom .section-title {
    font-size: 2rem;
  }
  
  .com-carousel-image {
    min-height: 250px;
  }
  
  .com-carousel-content {
    padding: 2rem;
  }
  
  .com-carousel-content h4 {
    font-size: 1.5rem;
  }
  
  .com-cta-section {
    padding: 2rem;
  }
  
  .com-cta-section h4 {
    font-size: 1.5rem;
  }
}
</style>

<div class="container-fluid px-0">
  <?php
    // Helpers
    $cfg = function($sec){
      if (empty($sec->sec_config_json)) return [];
      $arr = json_decode($sec->sec_config_json, true);
      return (json_last_error() === JSON_ERROR_NONE && is_array($arr)) ? $arr : [];
    };

    $items = $itemsPorSeccion ?? [];
  ?>

  <?php foreach(($secciones ?? []) as $index => $sec): ?>
    <?php $conf = $cfg($sec); $secItems = $items[$sec->sec_id] ?? []; ?>
    
    <section class="com-section-custom <?= $index % 2 === 0 ? 'bg-white' : 'bg-light' ?>">
      <div class="container">

    <?php if($sec->sec_tipo === 'HERO'): ?>
      <?php
        $bg = $conf['bg'] ?? null;
        $bgUrl = $bg ? (UPLOADS.$bg) : '';
        $height = $conf['height'] ?? '60vh';
        $overlay = $conf['overlay'] ?? '0.6';
        $align = $conf['align'] ?? 'center';
      ?>
      <div class="com-hero-custom" style="min-height: <?= htmlspecialchars($height) ?>; background-image: url('<?= htmlspecialchars($bgUrl) ?>');">
        <div class="container py-5">
          <div class="row">
            <div class="col-12 col-lg-8 mx-auto text-<?= htmlspecialchars($align) ?> text-white">
              <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($sec->sec_titulo ?? $pagina->pag_titulo) ?></h1>
              <?php if(!empty($sec->sec_descripcion)): ?>
                <p class="lead mb-4"><?= nl2br(htmlspecialchars($sec->sec_descripcion)) ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

    <?php elseif($sec->sec_tipo === 'CAROUSEL'): ?>
      <?php
        $id = 'car_'.$sec->sec_id;
        $auto = !empty($conf['autoplay']);
        $interval = (int)($conf['interval'] ?? 6000);
      ?>

      <?php if(!empty($sec->sec_titulo)): ?>
        <div class="text-center mb-5">
          <h2 class="section-title"><?= htmlspecialchars($sec->sec_titulo) ?></h2>
          <?php if(!empty($sec->sec_descripcion)): ?>
            <p class="section-subtitle"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if(count($secItems) > 0): ?>
        <div id="<?= $id ?>" class="carousel slide com-carousel" data-bs-ride="<?= $auto ? 'carousel' : 'false' ?>" data-bs-interval="<?= $interval ?>">
          <div class="carousel-inner">

            <?php foreach($secItems as $k => $it): ?>
              <?php
                $img = !empty($it->itm_imagen) ? (UPLOADS.$it->itm_imagen) : '';
                $url = !empty($it->itm_url) ? $it->itm_url : '#!';
              ?>
              <div class="carousel-item <?= $k === 0 ? 'active' : '' ?>">
                <div class="row g-0 align-items-stretch">
                  <div class="col-12 col-lg-6">
                    <div class="com-carousel-image" style="background-image: url('<?= htmlspecialchars($img) ?>');"></div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="com-carousel-content">
                      <?php if(!empty($it->itm_badge)): ?>
                        <span class="badge bg-primary mb-3"><?= htmlspecialchars($it->itm_badge) ?></span>
                      <?php endif; ?>
                      <h4><?= htmlspecialchars($it->itm_titulo ?? '') ?></h4>
                      <p><?= nl2br(htmlspecialchars($it->itm_descripcion ?? '')) ?></p>
                      <?php if($url !== '#!'): ?>
                        <a class="btn btn-primary" href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener">
                          <i class="fas fa-arrow-right me-2"></i>Ver más
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>

          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">Próximamente más contenido</div>
      <?php endif; ?>

    <?php elseif($sec->sec_tipo === 'CARDS'): ?>
      <?php $cols = (int)($conf['cols'] ?? 3); if(!in_array($cols,[2,3,4])) $cols=3; ?>

      <?php if(!empty($sec->sec_titulo)): ?>
        <div class="text-center mb-5">
          <h2 class="section-title"><?= htmlspecialchars($sec->sec_titulo) ?></h2>
          <?php if(!empty($sec->sec_descripcion)): ?>
            <p class="section-subtitle"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if(count($secItems) > 0): ?>
        <div class="row com-card-grid">
          <?php foreach($secItems as $it): ?>
            <?php
              $img = !empty($it->itm_imagen) ? (UPLOADS.$it->itm_imagen) : '';
              $url = !empty($it->itm_url) ? $it->itm_url : '#!';
              $colClass = $cols === 2 ? 'col-md-6' : ($cols === 4 ? 'col-md-6 col-lg-3' : 'col-md-6 col-lg-4');
            ?>
            <div class="<?= $colClass ?> com-card-item">
              <div class="card com-card-custom">
                <div class="card-img-wrapper">
                  <img src="<?= htmlspecialchars($img ?: 'https://via.placeholder.com/400x300?text=Sin+imagen') ?>" class="card-img-top" alt="<?= htmlspecialchars($it->itm_titulo ?? '') ?>">
                </div>
                <div class="card-body">
                  <?php if(!empty($it->itm_badge)): ?>
                    <span class="badge bg-primary mb-2"><?= htmlspecialchars($it->itm_badge) ?></span>
                  <?php endif; ?>
                  <h5 class="card-title"><?= htmlspecialchars($it->itm_titulo ?? '') ?></h5>
                  <p class="card-text"><?= htmlspecialchars($it->itm_descripcion ?? '') ?></p>
                  <?php if($url !== '#!'): ?>
                    <a href="<?= htmlspecialchars($url) ?>" class="btn btn-outline-primary" target="_blank" rel="noopener">
                      <i class="fas fa-arrow-right me-2"></i>Conocer más
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">Próximamente más contenido</div>
      <?php endif; ?>

    <?php elseif($sec->sec_tipo === 'LINKS'): ?>
      <?php if(!empty($sec->sec_titulo)): ?>
        <div class="text-center mb-5">
          <h2 class="section-title"><?= htmlspecialchars($sec->sec_titulo) ?></h2>
          <?php if(!empty($sec->sec_descripcion)): ?>
            <p class="section-subtitle"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if(count($secItems) > 0): ?>
        <div class="com-links-list">
          <?php foreach($secItems as $it): ?>
            <?php $url = !empty($it->itm_url) ? $it->itm_url : '#'; ?>
            <a href="<?= htmlspecialchars($url) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" target="_blank" rel="noopener">
              <div>
                <div class="link-title"><?= htmlspecialchars($it->itm_titulo ?? '') ?></div>
                <?php if(!empty($it->itm_descripcion)): ?>
                  <div class="link-desc"><?= htmlspecialchars($it->itm_descripcion) ?></div>
                <?php endif; ?>
              </div>
              <span class="arrow"><i class="fas fa-chevron-right"></i></span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">Próximamente más enlaces</div>
      <?php endif; ?>

    <?php elseif($sec->sec_tipo === 'CALENDAR'): ?>
      <div class="text-center mb-5">
        <h2 class="section-title"><?= htmlspecialchars($sec->sec_titulo ?? 'Agenda') ?></h2>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="section-subtitle"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>
      </div>

      <?php
        $embed = $secItems[0]->itm_embed ?? '';
      ?>
      <?php if($embed): ?>
        <div class="com-embed-wrapper">
          <div class="ratio ratio-16x9">
            <?= $embed ?>
          </div>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">
          <i class="fas fa-calendar-alt me-2"></i>
          Próximamente eventos y actividades
        </div>
      <?php endif; ?>

    <?php elseif($sec->sec_tipo === 'VIDEO'): ?>
      <div class="text-center mb-5">
        <h2 class="section-title"><?= htmlspecialchars($sec->sec_titulo ?? 'Video') ?></h2>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="section-subtitle"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>
      </div>

      <?php $embed = $secItems[0]->itm_embed ?? ''; ?>
      <?php if($embed): ?>
        <div class="com-embed-wrapper">
          <div class="ratio ratio-16x9">
            <?= $embed ?>
          </div>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">
          <i class="fas fa-video me-2"></i>
          Video próximamente
        </div>
      <?php endif; ?>

    <?php elseif($sec->sec_tipo === 'SOCIAL'): ?>
      <div class="text-center mb-5">
        <h2 class="section-title"><?= htmlspecialchars($sec->sec_titulo ?? 'Redes sociales') ?></h2>
        <?php if(!empty($sec->sec_descripcion)): ?>
          <p class="section-subtitle"><?= htmlspecialchars($sec->sec_descripcion) ?></p>
        <?php endif; ?>
      </div>

      <?php if(count($secItems) > 0): ?>
        <div class="row com-social-grid">
          <?php foreach($secItems as $it): ?>
            <?php
              $url = !empty($it->itm_url) ? $it->itm_url : '#';
              $img = !empty($it->itm_imagen) ? (UPLOADS.$it->itm_imagen) : '';
            ?>
            <div class="col-6 col-md-4 col-lg-3 com-social-card">
              <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener" class="text-decoration-none">
                <div class="card">
                  <?php if($img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="<?= htmlspecialchars($it->itm_titulo ?? '') ?>">
                  <?php endif; ?>
                  <div class="card-body text-center">
                    <div class="card-title"><?= htmlspecialchars($it->itm_titulo ?? '') ?></div>
                    <?php if(!empty($it->itm_descripcion)): ?>
                      <div class="card-text small"><?= htmlspecialchars($it->itm_descripcion) ?></div>
                    <?php endif; ?>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">Próximamente más redes sociales</div>
      <?php endif; ?>

    <?php elseif($sec->sec_tipo === 'CTA'): ?>
      <div class="com-cta-section">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <h4><?= htmlspecialchars($sec->sec_titulo ?? '') ?></h4>
            <p class="mb-lg-0"><?= htmlspecialchars($sec->sec_descripcion ?? '') ?></p>
          </div>
          <div class="col-lg-4 text-lg-end">
            <?php
              $btn = $secItems[0] ?? null;
            ?>
            <?php if($btn && !empty($btn->itm_url)): ?>
              <a class="btn btn-light btn-lg" href="<?= htmlspecialchars($btn->itm_url) ?>" target="_blank" rel="noopener">
                <?= htmlspecialchars($btn->itm_titulo ?? 'Contáctanos') ?>
                <i class="fas fa-arrow-right ms-2"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

    <?php elseif($sec->sec_tipo === 'SCHEDULE'): ?>
      <?php
        // Si tienes una función render_schedule en layout.php, la llamamos
        if (function_exists('render_schedule')) {
          render_schedule($sec, $secItems);
        }
      ?>

    <?php elseif($sec->sec_tipo === 'AGENDA'): ?>
      <?php
        // Si tienes un partial para agenda
        if (function_exists('render_agenda')) {
          render_agenda($sec, $secItems);
        }
      ?>

    <?php else: ?>
      <?php if(!empty($sec->sec_titulo)): ?>
        <h3 class="mb-3"><?= htmlspecialchars($sec->sec_titulo) ?></h3>
      <?php endif; ?>
      <?php if(!empty($sec->sec_descripcion)): ?>
        <p class="text-muted"><?= nl2br(htmlspecialchars($sec->sec_descripcion)) ?></p>
      <?php endif; ?>
    <?php endif; ?>

      </div>
    </section>
  <?php endforeach; ?>
</div>

<?php require_once INCLUDES.'inc_footer.php'; ?>

<?php

if (function_exists('render_event_modals')) {
    render_event_modals();
}
?>