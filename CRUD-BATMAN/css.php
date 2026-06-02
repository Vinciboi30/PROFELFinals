<link href="https://fonts.googleapis.com/css2?family=Bangers&family=Anton&family=Russo+One&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root {
        --bat-yellow: #fdff00;
        --bat-gold:   #988829;
        --bat-dark:   #0d0d0d;
        --bat-navy:   #282e3c;
        --bat-slate:  #505c7c;
        --bat-card:   rgba(30, 34, 46, 0.97);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Russo One', sans-serif;
        background: url('../img/batcave2.jpg') center/cover no-repeat fixed;
    }

    nav {
        background-color: var(--bat-navy);
        padding: 1rem 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.6), 0 0 30px rgba(253,255,0,0.05);
        position: sticky; top: 0; z-index: 1000;
        border-bottom: 2px solid rgba(253,255,0,0.2);
    }
    .nav-inner {
        max-width: 1200px; margin: 0 auto;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nav-brand { display: flex; align-items: center; gap: 1rem; }
    .bat-logo-svg {
        width: 48px; height: 30px; fill: var(--bat-yellow);
        filter: drop-shadow(0 0 8px rgba(253,255,0,0.5));
        transition: filter 0.3s;
    }
    .bat-logo-svg:hover { filter: drop-shadow(0 0 16px rgba(253,255,0,0.9)); }
    .nav-title {
        font-family: 'Bangers', cursive; font-size: 1.6rem;
        color: var(--bat-yellow); letter-spacing: 2px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.8); line-height: 1.1;
    }
    .nav-title span { display: block; font-size: 0.75rem; letter-spacing: 4px; color: var(--bat-gold); }
    .nav-user { display: flex; align-items: center; gap: 1rem; font-size: 0.85rem; color: var(--bat-gold); }
    .nav-user .username-badge {
        background: rgba(253,255,0,0.1); border: 1px solid rgba(253,255,0,0.3);
        padding: 0.3rem 0.8rem; border-radius: 4px;
        font-family: 'Anton', sans-serif; letter-spacing: 1px;
    }

    .main-wrap { max-width: 1200px; margin: 0 auto; padding: 2rem; }

    .page-header { text-align: center; margin-bottom: 2rem; }
    .page-header h1 {
        font-family: 'Bangers', cursive; font-size: 3.5rem;
        color: var(--bat-yellow); letter-spacing: 4px;
        text-shadow: 3px 3px 8px rgba(0,0,0,0.9), 0 0 20px rgba(253,255,0,0.2);
    }
    .page-header .sub {
        font-family: 'Anton', sans-serif; color: var(--bat-gold);
        letter-spacing: 3px; font-size: 0.9rem; margin-top: 0.3rem;
    }
    .divider {
        width: 120px; height: 3px;
        background: linear-gradient(90deg, transparent, var(--bat-yellow), transparent);
        margin: 0.8rem auto 0;
    }

    .btn-bat {
        font-family: 'Anton', sans-serif; letter-spacing: 1px; font-size: 0.9rem;
        padding: 0.55rem 1.3rem; border: 2px solid var(--bat-yellow);
        background: transparent; color: var(--bat-yellow); border-radius: 3px;
        cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 0.5rem;
        text-decoration: none;
    }
    .btn-bat:hover {
        background: var(--bat-yellow); color: var(--bat-dark);
        box-shadow: 0 0 15px rgba(253,255,0,0.3); color: var(--bat-dark);
    }
    .btn-bat.danger { border-color: #ff4444; color: #ff4444; }
    .btn-bat.danger:hover { background: #ff4444; color: #fff; box-shadow: 0 0 15px rgba(255,68,68,0.3); }
    .btn-bat.success { border-color: #44ff88; color: #44ff88; }
    .btn-bat.success:hover { background: #44ff88; color: var(--bat-dark); }

    .action-bar { display: flex; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; }
    .search-group { display: flex; gap: 0; flex: 1; max-width: 380px; margin-left: auto; }
    .search-group input {
        flex: 1; background: rgba(40,46,60,0.9);
        border: 2px solid rgba(253,255,0,0.3); border-right: none;
        color: var(--bat-yellow); padding: 0.5rem 1rem;
        font-family: 'Russo One', sans-serif; font-size: 0.85rem;
        border-radius: 3px 0 0 3px; outline: none; transition: border-color 0.2s;
    }
    .search-group input:focus { border-color: var(--bat-yellow); }
    .search-group input::placeholder { color: var(--bat-gold); opacity: 0.7; }
    .search-group .btn-bat { border-radius: 0 3px 3px 0; padding: 0.5rem 1rem; }

    .table-wrapper {
        background: var(--bat-card); border: 1px solid rgba(253,255,0,0.15);
        border-radius: 6px; overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5), 0 0 0 1px rgba(253,255,0,0.05);
    }
    table { width: 100%; border-collapse: collapse; }
    thead tr {
        background: linear-gradient(90deg, var(--bat-navy) 0%, #1e2436 100%);
        border-bottom: 2px solid var(--bat-yellow);
    }
    thead th {
        font-family: 'Anton', sans-serif; font-size: 0.85rem;
        letter-spacing: 2px; color: var(--bat-yellow);
        padding: 1rem 1.2rem; text-align: left; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid rgba(253,255,0,0.06); transition: background 0.15s; }
    tbody tr:hover { background: rgba(253,255,0,0.04); }
    tbody tr:last-child { border-bottom: none; }
    tbody td { padding: 0.85rem 1.2rem; font-size: 0.9rem; color: #d0d8e8; }
    td.id-col { color: var(--bat-gold); font-family: 'Anton', sans-serif; }
    .course-badge {
        background: rgba(40,46,60,0.8); border: 1px solid rgba(253,255,0,0.2);
        color: var(--bat-yellow); padding: 0.2rem 0.6rem; border-radius: 3px;
        font-family: 'Anton', sans-serif; font-size: 0.8rem; letter-spacing: 1px;
    }
    .actions-cell { display: flex; gap: 0.5rem; }
    .action-btn {
        font-family: 'Anton', sans-serif; font-size: 0.75rem;
        letter-spacing: 1px; padding: 0.3rem 0.7rem;
        border: 1px solid; border-radius: 3px; cursor: pointer;
        background: transparent; transition: all 0.15s; text-decoration: none;
        display: inline-block;
    }
    .action-btn.edit { border-color: var(--bat-gold); color: var(--bat-gold); }
    .action-btn.edit:hover { background: var(--bat-gold); color: var(--bat-dark); }
    .action-btn.del  { border-color: #ff4444; color: #ff4444; }
    .action-btn.del:hover  { background: #ff4444; color: #fff; }
    .empty-state { text-align: center; padding: 3rem; color: var(--bat-gold); font-family: 'Anton', sans-serif; letter-spacing: 2px; opacity: 0.6; }

    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.8rem; }
    .stat-card {
        background: var(--bat-card); border: 1px solid rgba(253,255,0,0.1);
        border-left: 3px solid var(--bat-yellow); border-radius: 4px; padding: 1rem 1.2rem; text-align: center;
    }
    .stat-card .num { font-family: 'Bangers', cursive; font-size: 2.2rem; color: var(--bat-yellow); letter-spacing: 2px; }
    .stat-card .lbl { font-family: 'Anton', sans-serif; font-size: 0.7rem; letter-spacing: 2px; color: var(--bat-gold); }

    .form-card {
        max-width: 560px; margin: 0 auto;
        background: var(--bat-card); border: 1px solid rgba(253,255,0,0.15);
        border-top: 3px solid var(--bat-yellow); border-radius: 0 0 8px 8px;
        padding: 2.5rem; box-shadow: 0 16px 48px rgba(0,0,0,0.6);
    }
    .form-group { margin-bottom: 1.4rem; }
    .form-group label {
        display: block; font-family: 'Anton', sans-serif;
        font-size: 0.8rem; letter-spacing: 2px; color: var(--bat-gold); margin-bottom: 0.4rem;
    }
    .form-group input,
    .form-group select {
        width: 100%; background: rgba(20,24,36,0.9);
        border: 1px solid rgba(253,255,0,0.2); color: var(--bat-yellow);
        padding: 0.7rem 1rem; font-family: 'Russo One', sans-serif;
        font-size: 0.9rem; border-radius: 3px; outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus { border-color: var(--bat-yellow); box-shadow: 0 0 10px rgba(253,255,0,0.15); }
    .form-group select option { background: var(--bat-navy); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-actions { display: flex; gap: 1rem; margin-top: 1.8rem; }
    .form-actions .btn-bat { flex: 1; justify-content: center; padding: 0.8rem; font-size: 1rem; }

    .auth-wrap {
        min-height: 100vh; display: flex; align-items: center; justify-content: center;
         background: url('../img/batcave1.jpg') center/cover no-repeat;
    }
    .auth-card {
        width: 420px; background: var(--bat-card);
        border: 1px solid rgba(253,255,0,0.15); border-top: 4px solid var(--bat-yellow);
        border-radius: 0 0 8px 8px; padding: 2.5rem;
        box-shadow: 0 24px 64px rgba(0,0,0,0.8), 0 0 60px rgba(253,255,0,0.04);
    }
    .auth-logo { text-align: center; margin-bottom: 2rem; }
    .auth-logo svg { width: 72px; height: 44px; fill: var(--bat-yellow); filter: drop-shadow(0 0 12px rgba(253,255,0,0.4)); }
    .auth-logo h2 { font-family: 'Bangers', cursive; font-size: 2rem; letter-spacing: 3px; color: var(--bat-yellow); margin-top: 0.5rem; }
    .auth-logo p  { font-family: 'Anton', sans-serif; font-size: 0.7rem; letter-spacing: 4px; color: var(--bat-gold); margin-top: 0.2rem; }
    .auth-link { color: var(--bat-gold); text-decoration: none; font-family: 'Anton', sans-serif; font-size: 0.8rem; letter-spacing: 1px; transition: color 0.2s; }
    .auth-link:hover { color: var(--bat-yellow); }

    .alert { padding: 0.8rem 1.2rem; border-radius: 3px; margin-bottom: 1.2rem; font-family: 'Anton', sans-serif; font-size: 0.85rem; letter-spacing: 1px; }
    .alert-success { background: rgba(68,255,136,0.1); border: 1px solid rgba(68,255,136,0.3); color: #44ff88; }
    .alert-danger  { background: rgba(255,68,68,0.1);  border: 1px solid rgba(255,68,68,0.3);  color: #ff4444; }
    .alert-info    { background: rgba(253,255,0,0.06); border: 1px solid rgba(253,255,0,0.2);  color: var(--bat-yellow); }

    .bat-svg-inline { fill: var(--bat-yellow); }

    @media (max-width: 768px) {
        .stats-row { grid-template-columns: repeat(2,1fr); }
        .form-row  { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 2.2rem; }
        .search-group { max-width: 100%; }
    }

    .img-picker-box {
        display: flex;
        gap: 1.2rem;
        align-items: flex-start;
        background: rgba(20,24,36,0.7);
        border: 1px solid rgba(253,255,0,0.15);
        border-radius: 6px;
        padding: 1rem;
        margin-top: 0.4rem;
    }
    .img-preview-wrap {
        width: 130px;
        height: 130px;
        flex-shrink: 0;
        border: 2px dashed rgba(253,255,0,0.25);
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(10,12,20,0.8);
    }
    .img-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .img-preview-placeholder {
        text-align: center;
        color: #505870;
        font-size: 0.7rem;
        letter-spacing: 1px;
        padding: 0.5rem;
    }
    .img-preview-placeholder span { font-size: 2rem; display: block; margin-bottom: 0.3rem; }
    .img-picker-controls {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        justify-content: center;
    }
    .img-current-name {
        font-size: 0.78rem;
        color: #8090b0;
        word-break: break-all;
        letter-spacing: 0.5px;
        margin: 0;
    }
    .img-upload-btn { font-size: 0.82rem !important; align-self: flex-start; }
    @media (max-width: 480px) {
        .img-picker-box { flex-direction: column; }
        .img-preview-wrap { width: 100%; height: 160px; }
    }
</style>
