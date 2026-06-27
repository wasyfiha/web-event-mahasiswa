<?php
// registration/register.php
// Dibuat oleh: arin
// Tugas: Form registrasi peserta ke event

require_once '../config/database.php';

// Ambil id_event dari URL, contoh: register.php?id_event=1
$id_event = isset($_GET['id_event']) ? (int)$_GET['id_event'] : 0;

// Ambil data event dari database
$event = null;
if ($id_event > 0) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id_event = ?");
    $stmt->execute([$id_event]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Jika event tidak ditemukan
if (!$event) {
    die("<div style='text-align:center;margin-top:50px;font-family:sans-serif;'>
            <h2>⚠️ Event tidak ditemukan.</h2>
            <a href='../events/list.php'>← Kembali ke Daftar Event</a>
         </div>");
}

// Ambil pesan sukses/error dari session (dikirim oleh process_register.php)
session_start();
$success_msg = $_SESSION['success_msg'] ?? null;
$error_msg   = $_SESSION['error_msg'] ?? null;
$old_input   = $_SESSION['old_input'] ?? [];
unset($_SESSION['success_msg'], $_SESSION['error_msg'], $_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event – <?= htmlspecialchars($event['nama_event']) ?></title>
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4ff;
            color: #1e2a45;
            min-height: 100vh;
        }

        /* ===== NAVBAR ===== */
        nav {
            background: #1a3a8f;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        nav .brand {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: .5px;
        }
        nav a.back-link {
            color: #a8c0ff;
            font-size: .9rem;
            text-decoration: none;
        }
        nav a.back-link:hover { color: #fff; }

        /* ===== MAIN LAYOUT ===== */
        .page-wrapper {
            max-width: 760px;
            margin: 48px auto;
            padding: 0 16px;
        }

        /* ===== EVENT CARD (info singkat) ===== */
        .event-card {
            background: #1a3a8f;
            color: #fff;
            border-radius: 14px;
            padding: 28px 32px;
            margin-bottom: 28px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        .event-card .icon {
            font-size: 2.2rem;
            flex-shrink: 0;
        }
        .event-card h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            font-size: .9rem;
            opacity: .85;
        }
        .event-meta span { display: flex; align-items: center; gap: 5px; }

        /* ===== ALERT ===== */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: .95rem;
            font-weight: 500;
        }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

        /* ===== FORM CARD ===== */
        .form-card {
            background: #fff;
            border-radius: 14px;
            padding: 36px 40px;
            box-shadow: 0 4px 24px rgba(26,58,143,.08);
        }
        .form-card h2 {
            font-size: 1.2rem;
            color: #1a3a8f;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e8eeff;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: .875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-group label .required {
            color: #ef4444;
            margin-left: 2px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: .95rem;
            color: #1e2a45;
            transition: border-color .2s, box-shadow .2s;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1a3a8f;
            box-shadow: 0 0 0 3px rgba(26,58,143,.1);
        }
        .form-group input.error-field {
            border-color: #ef4444;
        }
        .field-hint {
            font-size: .8rem;
            color: #6b7280;
            margin-top: 4px;
        }

        /* ===== SUBMIT BUTTON ===== */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #1a3a8f;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: .4px;
            transition: background .2s, transform .1s;
            margin-top: 8px;
        }
        .btn-submit:hover  { background: #0f2a70; }
        .btn-submit:active { transform: scale(.99); }
        .btn-submit:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        /* ===== LOADING STATE ===== */
        .btn-submit .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin-right: 8px;
            vertical-align: middle;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== FOOTER ===== */
        .page-footer {
            text-align: center;
            margin-top: 32px;
            font-size: .85rem;
            color: #6b7280;
        }
        .page-footer a { color: #1a3a8f; text-decoration: none; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 560px) {
            .form-card { padding: 24px 20px; }
            .event-card { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="../index.php" class="brand">🎟️ EventKu</a>
    <a href="list.php" class="back-link">← Kembali ke Daftar Event</a>
</nav>

<div class="page-wrapper">

    <!-- INFO EVENT -->
    <div class="event-card">
        <div class="icon">🎪</div>
        <div>
            <h1><?= htmlspecialchars($event['nama_event']) ?></h1>
            <div class="event-meta">
                <span>📅 <?= date('d F Y', strtotime($event['tanggal'])) ?></span>
                <span>📍 <?= htmlspecialchars($event['lokasi']) ?></span>
            </div>
        </div>
    </div>

    <!-- ALERT SUKSES / ERROR -->
    <?php if ($success_msg): ?>
        <div class="alert alert-success">✅ <?= htmlspecialchars($success_msg) ?></div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div class="alert alert-error">❌ <?= htmlspecialchars($error_msg) ?></div>
    <?php endif; ?>

    <!-- FORM REGISTRASI -->
    <div class="form-card">
        <h2>📝 Form Pendaftaran Peserta</h2>

        <form action="process_register.php" method="POST" id="regForm" novalidate>
            <!-- Hidden: kirim id_event -->
            <input type="hidden" name="id_event" value="<?= $id_event ?>">

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    placeholder="Contoh: Budi Santoso"
                    value="<?= htmlspecialchars($old_input['nama'] ?? '') ?>"
                    required
                    maxlength="100"
                >
                <p class="field-hint">Isi dengan nama lengkap sesuai KTP / kartu pelajar.</p>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Contoh: budi@email.com"
                    value="<?= htmlspecialchars($old_input['email'] ?? '') ?>"
                    required
                    maxlength="150"
                >
                <p class="field-hint">Email aktif untuk menerima konfirmasi pendaftaran.</p>
            </div>

            <!-- No HP -->
            <div class="form-group">
                <label for="no_hp">Nomor HP <span class="required">*</span></label>
                <input
                    type="tel"
                    id="no_hp"
                    name="no_hp"
                    placeholder="Contoh: 08123456789"
                    value="<?= htmlspecialchars($old_input['no_hp'] ?? '') ?>"
                    required
                    maxlength="20"
                >
                <p class="field-hint">Nomor WhatsApp yang bisa dihubungi.</p>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit" id="submitBtn">
                <span class="spinner" id="spinner"></span>
                Daftar Sekarang
            </button>
        </form>
    </div>

    <p class="page-footer">
        Sudah terdaftar? <a href="list.php">Lihat event lainnya →</a>
    </p>
</div>

<script>
    // Validasi sisi klien sebelum submit + loading state
    const form    = document.getElementById('regForm');
    const btn     = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', function(e) {
        const nama  = document.getElementById('nama').value.trim();
        const email = document.getElementById('email').value.trim();
        const no_hp = document.getElementById('no_hp').value.trim();

        // Reset error style
        document.querySelectorAll('.error-field').forEach(el => el.classList.remove('error-field'));

        let valid = true;

        if (!nama) {
            document.getElementById('nama').classList.add('error-field');
            valid = false;
        }
        if (!email || !email.includes('@')) {
            document.getElementById('email').classList.add('error-field');
            valid = false;
        }
        if (!no_hp || no_hp.length < 8) {
            document.getElementById('no_hp').classList.add('error-field');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            alert('Harap isi semua field dengan benar!');
            return;
        }

        // Loading state
        btn.disabled = true;
        spinner.style.display = 'inline-block';
        btn.innerHTML = '<span style="display:inline-block;width:18px;height:18px;border:3px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;margin-right:8px;vertical-align:middle;"></span> Mendaftar...';
    });
</script>

</body>
</html>
