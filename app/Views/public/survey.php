<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Encuesta') ?></title>
    <style>
        :root {
            --bg-1: #f7f4ef;
            --bg-2: #efe8db;
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #d6d3d1;
            --card: #fffdf9;
            --brand: #0f766e;
            --brand-dark: #115e59;
            --accent: #b45309;
            --danger-bg: #fef2f2;
            --danger-ink: #991b1b;
            --ok-bg: #ecfdf5;
            --ok-ink: #065f46;
            --radius-lg: 18px;
            --radius-md: 12px;
            --shadow-soft: 0 18px 40px rgba(31, 41, 55, 0.09);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--ink);
            font-family: "Trebuchet MS", "Segoe UI", Tahoma, sans-serif;
            background:
                radial-gradient(circle at 15% 12%, rgba(15, 118, 110, 0.16) 0, transparent 28%),
                radial-gradient(circle at 88% 8%, rgba(180, 83, 9, 0.15) 0, transparent 24%),
                linear-gradient(145deg, var(--bg-1), var(--bg-2));
            min-height: 100vh;
        }

        .container {
            width: min(1060px, 100% - 24px);
            margin: 22px auto 34px;
        }

        .panel {
            background: linear-gradient(180deg, #fffefc 0%, #fff9f0 100%);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            overflow: hidden;
        }

        .panel-head {
            padding: 26px 24px 18px;
            background: linear-gradient(102deg, rgba(15, 118, 110, 0.12), rgba(180, 83, 9, 0.11));
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .eyebrow {
            margin: 0 0 6px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--brand-dark);
            font-size: 0.74rem;
            font-weight: 700;
        }

        h1 {
            margin: 0;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            font-size: clamp(1.6rem, 2.6vw, 2.2rem);
            line-height: 1.15;
        }

        .subtitle {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 0.96rem;
        }

        .content {
            padding: 22px;
        }

        .alert {
            border-radius: var(--radius-md);
            padding: 12px 14px;
            border: 1px solid transparent;
            margin-bottom: 14px;
            font-size: 0.95rem;
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger-ink);
            border-color: #fecaca;
        }

        .alert-success {
            background: var(--ok-bg);
            color: var(--ok-ink);
            border-color: #bbf7d0;
        }

        form {
            display: grid;
            gap: 18px;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 14px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .span-3 { grid-column: span 3; }
        .span-4 { grid-column: span 4; }
        .span-6 { grid-column: span 6; }
        .span-12 { grid-column: span 12; }

        .field label {
            font-weight: 700;
            font-size: 0.9rem;
            color: #334155;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 12px 13px;
            font-size: 1rem;
            color: #0f172a;
            background: #ffffff;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .field textarea {
            min-height: 116px;
            resize: vertical;
        }

        .info-chip {
            width: 100%;
            border: 1px dashed #b6b2aa;
            border-radius: 11px;
            padding: 12px 13px;
            font-size: 0.96rem;
            color: #475569;
            background: #f7f4ee;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: rgba(15, 118, 110, 0.85);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        .question-block {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: var(--radius-lg);
            padding: 16px 14px 15px;
            background: var(--card);
        }

        .question-title {
            margin: 0 0 12px;
            font-size: 1.03rem;
            line-height: 1.38;
            font-weight: 700;
        }

        .rating-group {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 9px;
        }

        .rating-group input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .rating-option {
            border: 1px solid #cbd5e1;
            border-radius: 13px;
            text-align: center;
            padding: 12px 6px;
            background: #fff;
            cursor: pointer;
            font-weight: 800;
            font-size: 1.06rem;
            transition: all .2s ease;
            user-select: none;
        }

        .rating-option:hover {
            border-color: var(--brand);
            transform: translateY(-1px);
        }

        .rating-group input[type="radio"]:checked + .rating-option {
            background: linear-gradient(180deg, #14b8a6, #0f766e);
            border-color: #0f766e;
            color: #fff;
            box-shadow: 0 9px 16px rgba(15, 118, 110, 0.3);
        }

        .rating-help {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .actions {
            position: sticky;
            bottom: 0;
            background: linear-gradient(180deg, rgba(255, 253, 249, 0.1), rgba(255, 253, 249, 0.98) 45%);
            padding: 8px 0 2px;
        }

        .submit-btn {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 1.06rem;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(90deg, var(--brand), var(--brand-dark));
            box-shadow: 0 12px 24px rgba(15, 118, 110, 0.28);
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(15, 118, 110, 0.35);
        }

        @media (max-width: 900px) {
            .span-3,
            .span-4,
            .span-6,
            .span-12 {
                grid-column: span 6;
            }
            .content {
                padding: 16px;
            }
            .panel-head {
                padding: 22px 16px 16px;
            }
            .rating-option {
                padding: 14px 4px;
                font-size: 1.12rem;
            }
        }

        @media (max-width: 620px) {
            .container {
                width: calc(100% - 14px);
                margin: 10px auto 20px;
            }
            .meta-grid {
                gap: 10px;
            }
            .span-3,
            .span-4,
            .span-6,
            .span-12 {
                grid-column: span 12;
            }
            .question-block {
                padding: 14px 12px;
            }
            .rating-group {
                gap: 7px;
            }
            .rating-help {
                line-height: 1.4;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="panel">
        <div class="panel-head">
            <p class="eyebrow">Restaurante | Calidad y Servicio</p>
            <h1>Encuesta de Satisfaccion</h1>
            <p class="subtitle">Tu opinion toma menos de 1 minuto y nos ayuda a mejorar tu experiencia.</p>
        </div>

        <div class="content">
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc((string) session('error')) ?></div>
            <?php endif; ?>

            <?php $validation = \Config\Services::validation(); ?>
            <?php if (!empty($validation->getErrors())): ?>
                <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['thanks']) && $_GET['thanks'] === '1'): ?>
                <div class="alert alert-success">
                    Gracias por tu opinion. La encuesta se reiniciara para el siguiente cliente.
                </div>
            <?php endif; ?>

            <form id="surveyForm" method="post" action="<?= site_url('/encuesta/enviar') ?>">
                <?= csrf_field() ?>

                <div class="meta-grid">
                    <div class="field span-12">
                        <label>Sucursal</label>
                        <select name="sucursal_id" required>
                            <option value="">Selecciona...</option>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?= esc((string) $branch['id']) ?>" <?= old('sucursal_id') == $branch['id'] ? 'selected' : '' ?>>
                                    <?= esc($branch['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field span-4">
                        <label>Primera visita</label>
                        <select name="primera_visita" required>
                            <option value="1" <?= old('primera_visita') === '1' ? 'selected' : '' ?>>Sí</option>
                            <option value="0" <?= old('primera_visita') === '0' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <div class="field span-4">
                        <label>Frecuencia de visita</label>
                        <select name="frecuencia_visita" required>
                            <?php foreach ($frequencies as $frequency): ?>
                                <option value="<?= esc($frequency) ?>" <?= old('frecuencia_visita') === $frequency ? 'selected' : '' ?>><?= esc($frequency) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field span-4">
                        <label>Numero de mesa (opcional)</label>
                        <input type="text" name="mesa_numero" value="<?= esc((string) old('mesa_numero')) ?>" maxlength="20">
                    </div>
                </div>

                <?php foreach ($questions as $question): ?>
                    <fieldset class="question-block">
                        <legend class="question-title"><?= esc($question['orden']) ?>. <?= esc($question['pregunta']) ?></legend>
                        <div class="rating-group">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label>
                                    <input type="radio" name="respuesta_<?= $question['id'] ?>" value="<?= $i ?>" required <?= old('respuesta_' . $question['id']) == (string) $i ? 'checked' : '' ?>>
                                    <span class="rating-option"><?= $i ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                        <p class="rating-help">1 Muy malo | 2 Malo | 3 Regular | 4 Bueno | 5 Excelente</p>
                    </fieldset>
                <?php endforeach; ?>

                <div class="field">
                    <label>Comentario final (opcional)</label>
                    <textarea name="comentario_final" maxlength="1000"><?= esc((string) old('comentario_final')) ?></textarea>
                </div>

                <div class="actions">
                    <button type="submit" class="submit-btn">Enviar Encuesta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if (window.location.search.includes('thanks=1')) {
        setTimeout(() => {
            window.location.href = '<?= site_url('/encuesta') ?>';
        }, 2500);
    }
</script>
</body>
</html>
