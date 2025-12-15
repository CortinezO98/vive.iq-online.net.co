<?php

if (!function_exists('e')) {
  function e($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
  }
}

if (!function_exists('asset_upload')) {
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
    $layout = strtoupper($layout);
    return match($layout) {
      'FULL' => 'container-fluid px-0',
      'NARROW' => 'container',
      default => 'container'
    };
  }
}


if (!function_exists('sec_cfg')) {
  function sec_cfg($sec): array {
    $raw = $sec->sec_config_json ?? null;

    if ($raw === null || $raw === '') return [];

    if (is_string($raw)) {
      $decoded = json_decode($raw, true);
      return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
    }

    if (is_object($raw)) return (array)$raw;
    if (is_array($raw)) return $raw;

    return [];
  }
}

if (!function_exists('cfg_get')) {
  function cfg_get($sec, string $key, $default = null) {
    $cfg = sec_cfg($sec);
    return array_key_exists($key, $cfg) ? $cfg[$key] : $default;
  }
}
