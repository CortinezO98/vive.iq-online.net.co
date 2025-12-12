// --- aplica clases visuales a control y (si existe) al wrapper de bootstrap-select ---
function applyValidClasses(el, isValid) {
  el.classList.toggle('is-valid', isValid);
  el.classList.toggle('is-invalid', !isValid);

  // bootstrap-select
  const bs = el.closest('.bootstrap-select');
  if (bs) {
    const btn = bs.querySelector('.dropdown-toggle');
    [bs, btn].forEach(n => {
      if (!n) return;
      n.classList.toggle('is-valid', isValid);
      n.classList.toggle('is-invalid', !isValid);
    });
  }

  // Oculta cualquier .invalid-feedback adyacente (no queremos mensajes)
  let fb = el.nextElementSibling;
  while (fb && !fb.classList.contains('invalid-feedback')) fb = fb.nextElementSibling;
  if (fb) fb.style.display = 'none';
}

/**
 * Valida un control por ID (input/select/textarea).
 * - Si no pasas id o no existe, retorna false y no hace nada.
 * - Inputs: inválido si vacío/espacios o si contiene '.' (también bloquea escribir/pegar '.').
 * - Select: inválido si no hay selección real (value vacío o placeholder).
 * - Solo aplica is-valid / is-invalid (sin mensajes).
 * @param {string} id
 * @param {object} options { required?: boolean, placeholderValues?: string[] }
 * @returns {boolean} estado de validez actual
 */
function validateControlById(id, options = {}) {
  if (!id) return false;
  const el = document.getElementById(id);
  if (!el) return false;

  const tag = el.tagName.toLowerCase();
  const type = (el.type || '').toLowerCase();
  const required = options.required === true ? true : el.required === true;
  const placeholderValues = Array.isArray(options.placeholderValues)
    ? options.placeholderValues
    : ["", "0", "-1"];

  // --- bind de eventos una sola vez ---
  if (!el._vcBound) {
    if (tag === 'input' || tag === 'textarea') {
      // Bloquear puntos
      el.addEventListener('keydown', (e) => {
        if (e.key === '.' || e.code === 'NumpadDecimal') e.preventDefault();
      }, true);

      el.addEventListener('paste', (e) => {
        const data = (e.clipboardData || window.clipboardData).getData('text') || '';
        if (data.includes('.')) {
          e.preventDefault();
          const clean = data.replace(/\./g, '');
          const start = el.selectionStart ?? el.value.length;
          const end   = el.selectionEnd   ?? el.value.length;
          el.value = el.value.slice(0, start) + clean + el.value.slice(end);
          const pos = start + clean.length;
          try { el.setSelectionRange(pos, pos); } catch {}
        }
      }, true);

      el.addEventListener('input', () => {
        // Sanea puntos que se cuelen (IME/autofill)
        if (el.value.includes('.')) {
          const before = el.value;
          const start = el.selectionStart ?? before.length;
          el.value = before.replace(/\./g, '');
          const delta = before.length - el.value.length;
          const newPos = Math.max(0, start - delta);
          try { el.setSelectionRange(newPos, newPos); } catch {}
        }
        doValidate();
      }, true);

      el.addEventListener('blur', doValidate, true);
    } else if (tag === 'select') {
      el.addEventListener('change', doValidate, true);
      // Evento de bootstrap-select (si está presente)
      if (window.jQuery && typeof window.jQuery.fn.selectpicker === 'function') {
        window.jQuery(el).on('changed.bs.select', doValidate);
        // tras render/refresh, revalidar
        window.jQuery(el).on('loaded.bs.select rendered.bs.select', doValidate);
      }
    }
    el._vcBound = true;
  }

  function doValidate() {
    let ok = true;

    if (tag === 'select') {
      const v = (el.value ?? '').toString().trim();
      if (el.multiple) {
        const hasReal = Array.from(el.options)
          .some(o => o.selected && !placeholderValues.includes((o.value ?? '').toString().trim()));
        ok = required ? hasReal : true;
      } else {
        // inválido si value vacío, selectedIndex === -1, o value es placeholder
        const noSelection = (v.length === 0) || (el.selectedIndex === -1);
        ok = required ? (!noSelection && !placeholderValues.includes(v)) : true;
      }
    } else { // input / textarea
      const raw = (el.value ?? '');
      const trimmed = raw.trim();

      if (!required && trimmed.length === 0) {
        ok = true;
      } else {
        ok = trimmed.length > 0 && !raw.includes('.');
        // respetar restricciones nativas
        if (ok && el.validity) ok = el.validity.valid;
      }
    }

    applyValidClasses(el, ok);
    return ok;
  }

  // Pintar/retornar estado actual
  // (Útil si se llama justo después de inicializar selectpicker)
  return doValidate();
}