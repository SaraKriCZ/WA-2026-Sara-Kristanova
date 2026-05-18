<?php /** PARTIAL: _scripts.php – toast + confirm modal */ ?>

<div id="cr-modal-overlay"
     class="fixed inset-0 z-[100] hidden flex items-center justify-center"
     style="background:rgba(15,23,42,0.6);backdrop-filter:blur(4px)">
    <div id="cr-modal-box"
         class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6 transform scale-95 transition-all duration-200">
        <div class="text-3xl text-center mb-3" id="cr-modal-icon">⚠️</div>
        <p id="cr-modal-msg" class="text-center text-gray-800 font-semibold text-base mb-6 leading-relaxed"></p>
        <div class="flex gap-3">
            <button id="cr-modal-cancel"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition">
                Zrušit
            </button>
            <button id="cr-modal-confirm"
                    class="flex-1 py-2.5 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition">
                Potvrdit
            </button>
        </div>
    </div>
</div>

<div id="cr-toast-wrap" class="fixed bottom-5 right-5 z-[200] flex flex-col gap-2 items-end pointer-events-none"></div>

<script>
// ══ TOAST ════════════════════════════════════════════════
function showToast(message, type = 'info', duration = 3500) {
    const palettes = {
        success: { bg: 'bg-green-600',  icon: '✅' },
        error:   { bg: 'bg-red-600',    icon: '❌' },
        warning: { bg: 'bg-orange-500', icon: '⚠️' },
        info:    { bg: 'bg-blue-600',   icon: 'ℹ️' },
    };
    const { bg, icon } = palettes[type] ?? palettes.info;

    const t = document.createElement('div');
    t.className = `pointer-events-auto flex items-center gap-3 text-white font-semibold
                   pl-4 pr-2 py-3 rounded-2xl shadow-xl text-sm max-w-xs
                   transition-all duration-300 opacity-0 translate-y-2 ${bg}`;
    t.innerHTML = `
        <span class="text-base shrink-0">${icon}</span>
        <span class="flex-1">${message}</span>
        <button class="ml-1 opacity-70 hover:opacity-100 transition text-white font-black text-xl leading-none px-1"
                aria-label="Zavřít">&times;</button>`;

    document.getElementById('cr-toast-wrap').appendChild(t);
    requestAnimationFrame(() => t.classList.remove('opacity-0', 'translate-y-2'));

    const timer = setTimeout(() => closeToast(t), duration);
    t.querySelector('button').addEventListener('click', () => { clearTimeout(timer); closeToast(t); });
}

function closeToast(t) {
    t.classList.add('opacity-0', 'translate-y-2');
    setTimeout(() => t.remove(), 300);
}

// ══ CONFIRM MODAL ════════════════════════════════════════
function showConfirm(message, onConfirm, opts = {}) {
    const overlay   = document.getElementById('cr-modal-overlay');
    const msgEl     = document.getElementById('cr-modal-msg');
    const iconEl    = document.getElementById('cr-modal-icon');
    const btnOk     = document.getElementById('cr-modal-confirm');
    const btnCancel = document.getElementById('cr-modal-cancel');
    const box       = document.getElementById('cr-modal-box');

    msgEl.textContent  = message;
    iconEl.textContent = opts.icon ?? '⚠️';
    btnOk.textContent  = opts.confirmLabel ?? 'Potvrdit';
    btnOk.className    = `flex-1 py-2.5 rounded-xl text-white font-bold transition ${opts.confirmClass ?? 'bg-red-600 hover:bg-red-700'}`;
    btnCancel.classList.remove('hidden');

    overlay.classList.remove('hidden');
    requestAnimationFrame(() => box.classList.replace('scale-95', 'scale-100'));

    const close = () => {
        box.classList.replace('scale-100', 'scale-95');
        setTimeout(() => overlay.classList.add('hidden'), 180);
        btnOk.onclick = btnCancel.onclick = overlay.onclick = null;
    };
    btnOk.onclick     = () => { close(); onConfirm(); };
    btnCancel.onclick = close;
    overlay.onclick   = e => { if (e.target === overlay) close(); };
}

// ══ INFO MODAL (bez Zrušit) ══════════════════════════════
function showInfo(message, opts = {}) {
    const overlay   = document.getElementById('cr-modal-overlay');
    const msgEl     = document.getElementById('cr-modal-msg');
    const iconEl    = document.getElementById('cr-modal-icon');
    const btnOk     = document.getElementById('cr-modal-confirm');
    const btnCancel = document.getElementById('cr-modal-cancel');
    const box       = document.getElementById('cr-modal-box');

    msgEl.innerHTML    = message;
    iconEl.textContent = opts.icon ?? 'ℹ️';
    btnOk.textContent  = 'Rozumím';
    btnOk.className    = 'flex-1 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition';
    btnCancel.classList.add('hidden');

    overlay.classList.remove('hidden');
    requestAnimationFrame(() => box.classList.replace('scale-95', 'scale-100'));

    const close = () => {
        box.classList.replace('scale-100', 'scale-95');
        setTimeout(() => overlay.classList.add('hidden'), 180);
        btnCancel.classList.remove('hidden');
        btnOk.onclick = overlay.onclick = null;
    };
    btnOk.onclick     = close;
    overlay.onclick   = e => { if (e.target === overlay) close(); };
}

// ══ HELPER: zobrazit/skrýt heslo ════════════════════════
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type   = isHidden ? 'text' : 'password';
    btn.textContent = isHidden ? '🙈' : '👁️';
}
</script>
