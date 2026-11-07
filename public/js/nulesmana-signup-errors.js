/*
 * Peringatan kolom per langkah; tetap mengandalkan validator server Laravel.
 * Mendengarkan 'invalid' dari checkStep bawaan wizard Nulesmana,
 * sehingga alur Next / Back / Submit tidak diubah.
 */
(() => {
  function init() {
    const form = document.getElementById('nl-signup-form');
    if (!form || form.dataset.nlErrorsReady === '1') return;
    form.dataset.nlErrorsReady = '1';

    const labelMap = {
      name: 'Nama lengkap', gender: 'Jenis kelamin', email: 'Email',
      phone: 'Nomor WhatsApp', photo: 'Foto anggota', address: 'Alamat lengkap',
      banom: 'Pilihan banom', password: 'Password',
      password_confirmation: 'Konfirmasi password'
    };
    const visibleTarget = field => field.type === 'file'
      ? (field.parentElement || field)
      : field;
    const errorElement = field => {
      if (field.name === 'photo') return document.getElementById('nl-photo-error');
      let node = form.querySelector(`[data-nl-error-for="${field.id}"]`);
      if (!node) {
        node = document.createElement('p');
        node.dataset.nlErrorFor = field.id;
        node.id = `nl-validation-${field.id}`;
        node.className = 'nl-validation-message';
        node.setAttribute('role', 'alert');
        field.parentElement.appendChild(node);
      }
      return node;
    };
    const messageFor = field => {
      const label = labelMap[field.name] || 'Kolom ini';
      if (field.validity.valueMissing || (field.type === 'file' && !field.files?.length)) {
        return `${label} wajib diisi.`;
      }
      if (field.name === 'email' && (field.validity.typeMismatch || field.validity.patternMismatch)) {
        return 'Format email belum benar. Contoh: nama@email.com';
      }
      if (field.validity.tooShort) {
        return `${label} minimal ${field.minLength} karakter.`;
      }
      if (field.validity.tooLong) {
        return `${label} terlalu panjang.`;
      }
      if (field.name === 'password_confirmation' && field.validity.customError) {
        return 'Konfirmasi password belum sama.';
      }
      return `${label} belum valid. Silakan periksa lagi.`;
    };

    function render(field, message, animate = false) {
      if (!field || !field.id) return;
      const visual = visibleTarget(field);
      const node = errorElement(field);
      if (!node) return;
      const invalid = Boolean(message);
      visual.classList.toggle(field.type === 'file' ? 'nl-photo-invalid' : 'nl-field-invalid', invalid);
      field.setAttribute('aria-invalid', String(invalid));
      node.textContent = message || '';
      // Foto memakai elemen pesan dari form asli, yang default-nya tersembunyi.
      if (field.name === 'photo') node.classList.toggle('hidden', !invalid);
      else node.hidden = !invalid;
      if (invalid) {
        const existing = (field.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean);
        if (!existing.includes(node.id)) field.setAttribute('aria-describedby', [...existing, node.id].join(' '));
        if (animate) {
          visual.classList.remove('nl-field-shake');
          // Putar ulang animasi hanya ketika pengguna menekan Lanjut/Kirim.
          void visual.offsetWidth;
          visual.classList.add('nl-field-shake');
        }
      } else {
        visual.classList.remove('nl-field-shake');
        const described = (field.getAttribute('aria-describedby') || '').split(/\s+/).filter(id => id !== node.id);
        if (described.length) field.setAttribute('aria-describedby', described.join(' '));
        else field.removeAttribute('aria-describedby');
      }
    }

    // checkStep() yang sudah ada memanggil reportValidity(); ubah tooltip bawaan
    // browser menjadi pesan inline tanpa mengganti validasi multi-step asli.
    form.addEventListener('invalid', event => {
      const field = event.target;
      if (!(field instanceof HTMLElement) || !field.name) return;
      event.preventDefault();
      render(field, messageFor(field), true);
      const target = visibleTarget(field);
      target.scrollIntoView({ behavior: 'smooth', block: 'center' });
      if (field.type !== 'file') field.focus({ preventScroll: true });
      else document.getElementById('nl-open-camera')?.focus({ preventScroll: true });
    }, true);

    for (const field of form.querySelectorAll('input, select, textarea')) {
      if (!field.name || !field.id) continue;
      const refresh = () => {
        if (field.getAttribute('aria-invalid') !== 'true') return;
        if (field.checkValidity()) render(field, '');
        else render(field, messageFor(field));
      };
      field.addEventListener('input', refresh);
      field.addEventListener('change', refresh);
    }

    // Berikan highlight pada kolom yang ditolak validator server juga.
    const serverErrors = window.nulesmanaSignupServerErrors || {};
    Object.entries(serverErrors).forEach(([name, errors]) => {
      const field = [...form.elements].find(el => el.name === name);
      if (field && errors?.[0]) render(field, String(errors[0]));
    });
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else init();
})();
