<?php
// helpers de vista (escape seguro)
if (!function_exists('e')) {
  function e($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
  }
}
if (!function_exists('asset_upload')) {
  // UPLOADS debe existir en tu app (normalmente apunta a assets/uploads/)
  function asset_upload(?string $rel): string {
    if (!$rel) return '';
    return rtrim(UPLOADS, '/').'/'.ltrim($rel, '/');
  }
}
if (!function_exists('safe_target')) {
  function safe_target(?string $t): string {
    return in_array($t, ['_self','_blank'], true) ? $t : '_blank';
  }
}
if (!function_exists('section_layout_class')) {
  function section_layout_class(string $layout): string {
    return match($layout) {
      'FULL' => 'container-fluid px-0',
      'NARROW' => 'container',
      default => 'container'
    };
  }
}
