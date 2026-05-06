<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cafe Dampog — Login</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --bg:#f5f0e8;--surface:#fdfaf4;--border:#d6ccb4;
    --text:#1a1610;--muted:#6b6050;
    --accent:#8b4513;--accent-l:#c4722a;--accent-bg:#f9ece0;
    --danger:#8b2020;
}
body{font-family:'Source Sans 3',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center}

.login-wrap{width:100%;max-width:400px;padding:20px}

.brand{text-align:center;margin-bottom:32px}
.brand-icon{width:64px;height:64px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:1.8rem}
.brand h1{font-family:'Libre Baskerville',serif;font-size:1.6rem;font-weight:700;color:var(--text)}
.brand p{font-size:.8rem;text-transform:uppercase;letter-spacing:.15em;color:var(--muted);margin-top:4px}

.card{background:var(--surface);border:1px solid var(--border);border-radius:6px;padding:32px}

.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:18px}
.form-group label{font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);font-weight:600}
.form-group input{padding:10px 12px;border:1px solid var(--border);border-radius:4px;font-size:.9rem;font-family:'Source Sans 3',sans-serif;background:var(--bg);color:var(--text);outline:none;transition:border-color .15s}
.form-group input:focus{border-color:var(--accent-l)}

.remember{display:flex;align-items:center;gap:8px;font-size:.85rem;color:var(--muted);margin-bottom:20px;cursor:pointer}
.remember input{width:15px;height:15px;cursor:pointer;accent-color:var(--accent)}

.btn-login{width:100%;padding:11px;background:var(--accent);color:#fff;border:none;border-radius:4px;font-size:.9rem;font-family:'Source Sans 3',sans-serif;font-weight:600;cursor:pointer;letter-spacing:.04em;transition:background .15s}
.btn-login:hover{background:var(--accent-l)}

.alert-error{background:#fdeaea;border-left:3px solid var(--danger);color:var(--danger);padding:10px 12px;border-radius:3px;font-size:.85rem;margin-bottom:18px}

.divider{border:none;border-top:1px solid var(--border);margin:24px 0}
.hint{text-align:center;font-size:.78rem;color:var(--muted)}
.hint strong{color:var(--text)}
</style>
</head>
<body>

<div class="login-wrap">
    <div class="brand">
        <div class="brand-icon">☕</div>
        <h1>Cafe</h1>
        <p>Inventory System</p>
    </div>

    <div class="card">
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@cafedampog.com" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <label class="remember">
                <input type="checkbox" name="remember"> Keep me signed in
            </label>
            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <hr class="divider">
        <p class="hint">Contact your <strong>Admin</strong> if you don't have an account.</p>
    </div>
</div>

</body>
</html>