<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="{{ asset('favicon.ico') }}">
<title>@yield('title', 'Cafe Dampog') — Inventory</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --bg:#f5f0e8;--surface:#fdfaf4;--border:#d6ccb4;
    --text:#1a1610;--muted:#6b6050;
    --accent:#8b4513;--accent-l:#c4722a;--accent-bg:#f9ece0;
    --danger:#8b2020;--success:#2a5c2a;--nav:220px;
}
body{font-family:'Source Sans 3',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex}

/* Sidebar */
.sidebar{width:var(--nav);background:var(--text);color:#e8dcc8;display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100}
.sb-brand{padding:28px 20px 20px;border-bottom:1px solid rgba(255,255,255,.1)}
.sb-brand h1{font-family:'Libre Baskerville',serif;font-size:1rem;font-weight:700;color:#f5e8d0;line-height:1.3}
.sb-brand p{font-size:.7rem;color:#a09070;margin-top:3px;text-transform:uppercase;letter-spacing:.1em}
.sb-nav{flex:1;padding:16px 0;overflow-y:auto}
.nav-sec{padding:10px 20px 4px;font-size:.62rem;text-transform:uppercase;letter-spacing:.12em;color:#5a5040}
.sb-nav a{display:block;padding:9px 20px;color:#b0a090;text-decoration:none;font-size:.85rem;transition:background .15s,color .15s;border-left:3px solid transparent}
.sb-nav a:hover{background:rgba(255,255,255,.05);color:#f0e8d8}
.sb-nav a.active{background:rgba(139,69,19,.25);color:#f5e8d0;border-left-color:var(--accent-l)}

/* Main */
.main{margin-left:var(--nav);flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:14px 32px;display:flex;align-items:center;justify-content:space-between}
.topbar h2{font-family:'Libre Baskerville',serif;font-size:1.1rem;font-weight:400;font-style:italic;color:var(--muted)}
.topbar .date{font-size:.8rem;color:var(--muted)}
.content{padding:28px 32px;flex:1}

/* Cards */
.card{background:var(--surface);border:1px solid var(--border);border-radius:4px;padding:24px;margin-bottom:20px}
.card-title{font-family:'Libre Baskerville',serif;font-size:.95rem;margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid var(--border)}

/* Stats */
.stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(155px,1fr));gap:16px;margin-bottom:24px}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:4px;padding:18px 20px}
.stat-label{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:6px}
.stat-value{font-family:'Libre Baskerville',serif;font-size:1.6rem;color:var(--text)}

/* Tables */
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse;font-size:.85rem}
th{text-align:left;padding:8px 12px;font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);border-bottom:2px solid var(--border);font-weight:600}
td{padding:10px 12px;border-bottom:1px solid var(--border);vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:var(--accent-bg)}

/* Buttons */
.btn{display:inline-block;padding:7px 16px;font-size:.82rem;border:1px solid transparent;border-radius:3px;cursor:pointer;text-decoration:none;font-family:'Source Sans 3',sans-serif;transition:background .15s,color .15s;line-height:1.4}
.btn-primary{background:var(--accent);color:#fff;border-color:var(--accent)}
.btn-primary:hover{background:var(--accent-l);border-color:var(--accent-l)}
.btn-secondary{background:transparent;color:var(--text);border-color:var(--border)}
.btn-secondary:hover{background:var(--border)}
.btn-danger{background:transparent;color:var(--danger);border-color:var(--danger)}
.btn-danger:hover{background:var(--danger);color:#fff}
.btn-sm{padding:4px 10px;font-size:.78rem}

/* Forms */
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}
.form-group{display:flex;flex-direction:column;gap:5px}
.form-group label{font-size:.78rem;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);font-weight:600}
.form-group input,.form-group select,.form-group textarea{padding:8px 10px;border:1px solid var(--border);border-radius:3px;font-size:.88rem;font-family:'Source Sans 3',sans-serif;background:var(--bg);color:var(--text);outline:none;transition:border-color .15s}
.form-group input:focus,.form-group select:focus{border-color:var(--accent-l)}
.form-actions{display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)}

/* Alerts */
.alert{padding:10px 14px;border-radius:3px;font-size:.85rem;margin-bottom:16px;border-left:3px solid}
.alert-success{background:#edf7ed;border-color:var(--success);color:var(--success)}
.alert-error{background:#fdeaea;border-color:var(--danger);color:var(--danger)}

/* Badges */
.badge{display:inline-block;padding:2px 8px;border-radius:2px;font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em}
.badge-low{background:#fdeaea;color:var(--danger)}
.badge-ok{background:#edf7ed;color:var(--success)}

/* Detail rows for stock in/out */
.detail-row{display:grid;grid-template-columns:1fr 120px 130px 30px;gap:10px;align-items:end;margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed var(--border)}
.detail-row-so{display:grid;grid-template-columns:1fr 120px 30px;gap:10px;align-items:end;margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed var(--border)}
.add-row-btn{background:none;border:1px dashed var(--border);padding:7px 14px;cursor:pointer;font-size:.82rem;color:var(--muted);border-radius:3px;margin-top:8px;font-family:'Source Sans 3',sans-serif}
.add-row-btn:hover{border-color:var(--accent);color:var(--accent)}
.remove-row{background:none;border:none;color:var(--danger);cursor:pointer;font-size:1rem;padding:0 4px;line-height:1}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="sb-brand">
        <h1>Cafe Dampog</h1>
        <p>Inventory System</p>
    </div>
    <nav class="sb-nav">
        <div class="nav-sec">Overview</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('stocks.index') }}" class="{{ request()->routeIs('stocks.*') ? 'active' : '' }}">Current Stock</a>

        <div class="nav-sec">Transactions</div>
        <a href="{{ route('stock-in.index') }}" class="{{ request()->routeIs('stock-in.*') ? 'active' : '' }}">Stock In</a>
        <a href="{{ route('stock-out.index') }}" class="{{ request()->routeIs('stock-out.*') ? 'active' : '' }}">Stock Out</a>

        <div class="nav-sec">Records</div>
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
        <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">Employees</a>

        <div class="nav-sec">Reports</div>
        <a href="{{ route('reports.stock-summary') }}" class="{{ request()->routeIs('reports.stock-summary') ? 'active' : '' }}">Stock Summary</a>
        <a href="{{ route('reports.stock-in-report') }}" class="{{ request()->routeIs('reports.stock-in-report') ? 'active' : '' }}">Stock In Report</a>
    </nav>
</aside>

<div class="main">
    <div class="topbar">
        <h2>@yield('title', 'Dashboard')</h2>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>