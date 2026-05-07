<?php
// ── Lógica tipo de cambio (lado servidor) ────────────────────
$resultado  = null;
$cantidad   = '';
$tasa       = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad'] ?? '';
    $tasa     = $_POST['tasa']     ?? '';

    if ($cantidad === '' || $tasa === '') {
        $resultado = 'error';
    } else {
        $c = (float)$cantidad;
        $t = (float)$tasa;
        $resultado = number_format($c * $t, 2);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gonzalez Humo · Ejercicio 34 — Tipo de Cambio</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --bg:#f7f5f2; --border:#e8e2db;
      --accent:#a8d8b9; --accent2:#f7c5a0;
      --accent3:#c5b8f0; --accent4:#a8d4f0;
      --accent-dk:#5aaa7a; --accent2-dk:#d4804a;
      --accent3-dk:#7a60c8; --accent4-dk:#4a9cc8;
      --text:#2d2a26; --muted:#9e9890; --card:#fff;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{
      background:var(--bg);color:var(--text);
      font-family:'Nunito',sans-serif;min-height:100vh;
      display:flex;align-items:center;justify-content:center;
      padding:40px 20px;
    }
    body::before{
      content:'';position:fixed;inset:0;pointer-events:none;z-index:0;
      background-image:
        linear-gradient(rgba(168,216,185,.15) 1px,transparent 1px),
        linear-gradient(90deg,rgba(168,216,185,.15) 1px,transparent 1px);
      background-size:40px 40px;
    }
    .wrap{max-width:520px;width:100%;position:relative;z-index:1;}

    /* ── Header ── */
    .header{text-align:center;margin-bottom:36px;animation:fadeDown .7s ease both;}
    .badge{
      display:inline-block;font-size:.65rem;letter-spacing:.18em;text-transform:uppercase;
      color:var(--accent3-dk);border:1.5px solid var(--accent3);background:#fff;
      padding:4px 16px;border-radius:999px;margin-bottom:14px;
    }
    .header h1{
      font-family:'Playfair Display',serif;
      font-size:clamp(1.8rem,5vw,2.8rem);font-weight:800;line-height:1.1;
    }
    .header h1 span{color:var(--accent3-dk);}
    .header p{margin-top:10px;color:var(--muted);font-size:.82rem;line-height:1.8;}

    /* ── Form card ── */
    .card{
      background:var(--card);border:1.5px solid var(--border);
      border-radius:18px;padding:32px;margin-bottom:24px;
      position:relative;overflow:hidden;
      box-shadow:0 4px 20px rgba(0,0,0,.05);
      animation:fadeUp .6s .15s ease both;
    }
    .card::before{
      content:'';position:absolute;top:0;left:0;right:0;height:4px;
      background:linear-gradient(90deg,var(--accent3),var(--accent),var(--accent2));
    }
    .card h2{
      font-size:.78rem;font-weight:800;text-transform:uppercase;
      letter-spacing:.12em;color:var(--muted);margin-bottom:22px;
    }

    /* ── Inputs ── */
    .inputs-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:26px;}
    @media(max-width:440px){.inputs-row{grid-template-columns:1fr;}}
    .ig{display:flex;flex-direction:column;gap:7px;}
    .ig label{font-size:.68rem;text-transform:uppercase;letter-spacing:.12em;color:var(--muted);font-weight:700;}
    .ig .hint{font-size:.65rem;color:var(--muted);margin-top:-3px;}
    .ig input{
      background:var(--bg);border:1.5px solid var(--border);border-radius:10px;
      padding:13px 14px;font-family:'Nunito',sans-serif;
      font-size:1.4rem;font-weight:800;color:var(--text);
      text-align:center;outline:none;width:100%;
      transition:border-color .2s,box-shadow .2s;
    }
    .ig input:focus{
      border-color:var(--accent3);
      box-shadow:0 0 0 3px rgba(197,184,240,.3);
    }
    .ig input::placeholder{color:#ccc;font-size:1rem;font-weight:400;}

    /* ── Botón ── */
    .main-btn{
      width:100%;
      background:linear-gradient(135deg,var(--accent3),var(--accent));
      color:#fff;border:none;border-radius:12px;padding:15px;
      font-family:'Nunito',sans-serif;font-size:1rem;font-weight:800;
      cursor:pointer;letter-spacing:.04em;
      transition:transform .15s,opacity .15s,box-shadow .15s;
    }
    .main-btn:hover{transform:translateY(-2px);opacity:.92;box-shadow:0 8px 20px rgba(197,184,240,.4);}
    .main-btn:active{transform:translateY(0);}

    /* ── Alerta error ── */
    .alert{
      background:#fff4f4;border:1.5px solid #f0c0c0;border-radius:12px;
      padding:13px 18px;color:#a04040;font-size:.82rem;font-weight:600;
      margin-bottom:20px;animation:fadeIn .3s ease;
    }

    /* ── Resultado ── */
    .result-card{
      background:#edf9f4;border:2px solid #a8d8b9;
      border-radius:18px;overflow:hidden;
      box-shadow:0 6px 28px rgba(0,0,0,.07);
      margin-bottom:24px;animation:popIn .45s ease;
    }
    .result-card .rc-header{
      background:#d4f0e0;padding:13px 24px;
      font-size:.68rem;text-transform:uppercase;
      letter-spacing:.12em;font-weight:700;color:#2d7a50;
    }
    .result-card .rc-body{
      padding:28px;text-align:center;
    }
    .result-label{
      font-size:.72rem;text-transform:uppercase;letter-spacing:.12em;
      color:var(--muted);font-weight:700;margin-bottom:10px;
    }
    .result-value{
      font-family:'Playfair Display',serif;
      font-size:1.6rem;font-weight:800;color:#2d7a50;
    }

    @keyframes fadeDown{from{opacity:0;transform:translateY(-18px)}to{opacity:1;transform:none}}
    @keyframes fadeUp  {from{opacity:0;transform:translateY(18px) }to{opacity:1;transform:none}}
    @keyframes fadeIn  {from{opacity:0}to{opacity:1}}
    @keyframes popIn   {from{opacity:0;transform:scale(.87)}to{opacity:1;transform:scale(1)}}
  </style>
</head>
<body>
<div class="wrap">

  <!-- Header -->
  <div class="header">
    <div class="badge">Ejercicio 34</div>
    <h1>Calculadora de<br><span>Tipo de Cambio</span></h1>
    <p>Ingresa una cantidad y una tasa para obtener el resultado.</p>
  </div>

  <!-- Error -->
  <?php if ($resultado === 'error'): ?>
    <div class="alert">Por favor ingresa ambos valores.</div>
  <?php endif; ?>

  <!-- Resultado -->
  <?php if ($resultado !== null && $resultado !== 'error'): ?>
    <div class="result-card">
      <div class="rc-header">Resultado</div>
      <div class="rc-body">
        <div class="result-label"><?= htmlspecialchars($cantidad) ?> × <?= htmlspecialchars($tasa) ?></div>
        <div class="result-value">El resultado es <?= $resultado ?></div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Formulario -->
  <form method="POST" action="">
    <div class="card">
      <h2>Ingresa los valores</h2>
      <div class="inputs-row">
        <div class="ig">
          <label>Cantidad</label>
          <span class="hint">ej. 100</span>
          <input type="number" name="cantidad" step="any" placeholder=""
                 value="<?= htmlspecialchars($cantidad) ?>"/>
        </div>
        <div class="ig">
          <label>Tipo de cambio</label>
          <span class="hint">ej. 0.85</span>
          <input type="number" name="tasa" step="any" placeholder=""
                 value="<?= htmlspecialchars($tasa) ?>"/>
        </div>
      </div>
      <button type="submit" class="main-btn">Calcular</button>
    </div>
  </form>

</div>
</body>
</html>
