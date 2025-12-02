<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Denúncias</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="hero">
        <div class="hero__content">
            <p class="eyebrow">Portal Público</p>
            <h1>Registre, acompanhe e responda denúncias com segurança.</h1>
            <p class="subtitle">Use o protocolo para acompanhar ou responder. Para gestão interna e múltiplos tipos de usuários, acesse o painel Filament em /admin.</p>
            <div class="hero__actions">
                <a class="btn btn--primary" href="#abrir-denuncia">Nova denúncia</a>
                <a class="btn btn--secondary" href="#consultar">Consultar protocolo</a>
            </div>
        </div>
        <div class="hero__stats">
            <div class="stat">
                <p class="stat__value">Admin</p>
                <p class="stat__label">Acesso em /admin via Filament</p>
            </div>
            <div class="stat">
                <p class="stat__value">Público</p>
                <p class="stat__label">Envio e respostas sem login</p>
            </div>
        </div>
    </header>

    <main class="container">
        <section id="abrir-denuncia" class="panel">
            <div class="panel__header">
                <div>
                    <p class="eyebrow">Nova denúncia</p>
                    <h2 class="section-title">Abertura pública</h2>
                    <p class="subtitle">Envie a descrição e receba um protocolo para acompanhar.</p>
                </div>
                <span class="badge">/api/denuncia</span>
            </div>
            <form id="nova-denuncia-form" class="form-grid" enctype="multipart/form-data">
                <label class="form-field">
                    Departamento (ID)
                    <input type="number" name="departamentos_id" placeholder="Ex: 1" required>
                </label>
                <label class="form-field">
                    Senha de consulta
                    <input type="password" name="senha" placeholder="Crie uma senha" required>
                </label>
                <label class="form-field" style="grid-column: 1 / -1;">
                    Descrição da denúncia
                    <textarea name="denuncia" placeholder="Inclua detalhes relevantes" required></textarea>
                </label>
                <label class="form-field" style="grid-column: 1 / -1;">
                    Anexos (opcional)
                    <input type="file" name="anexos[]" multiple>
                </label>
                <div class="form-inline" style="grid-column: 1 / -1;">
                    <button class="btn btn--primary" type="submit">Registrar denúncia</button>
                    <div id="nova-denuncia-feedback" class="feedback"></div>
                </div>
            </form>
        </section>

        <section id="consultar" class="panel">
            <div class="panel__header">
                <div>
                    <p class="eyebrow">Consulta</p>
                    <h2 class="section-title">Acompanhar protocolo</h2>
                    <p class="subtitle">Recupere o status e leia as respostas registradas.</p>
                </div>
                <span class="badge badge--muted">/api/denuncia & /api/respostas</span>
            </div>
            <form id="consulta-protocolo-form" class="form-inline">
                <label class="form-field">
                    Protocolo
                    <input type="text" name="protocolo" placeholder="Digite o protocolo" required>
                </label>
                <button class="btn btn--secondary" type="submit">Consultar</button>
                <div id="consulta-feedback" class="feedback"></div>
            </form>
            <div id="consulta-resultado" class="section-space"></div>
            <div id="respostas-list" class="section-space"></div>
        </section>

        <section id="responder" class="panel">
            <div class="panel__header">
                <div>
                    <p class="eyebrow">Resposta pública</p>
                    <h2 class="section-title">Responder denúncia</h2>
                    <p class="subtitle">Informe o protocolo e a senha definidos na abertura para enviar uma resposta.</p>
                </div>
                <span class="badge badge--accent">/api/resposta</span>
            </div>
            <form id="resposta-publica-form" class="form-grid">
                <label class="form-field">
                    Protocolo
                    <input type="text" name="protocolo" placeholder="Número do protocolo" required>
                </label>
                <label class="form-field">
                    Senha
                    <input type="password" name="senha" placeholder="Senha criada na abertura" required>
                </label>
                <label class="form-field" style="grid-column: 1 / -1;">
                    Resposta
                    <textarea name="resposta" placeholder="Sua mensagem" required></textarea>
                </label>
                <div class="form-inline" style="grid-column: 1 / -1;">
                    <button class="btn btn--primary" type="submit">Enviar resposta</button>
                    <div id="resposta-feedback" class="feedback"></div>
                </div>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>Administração e múltiplos perfis via Filament em <strong>/admin</strong>. Consulte o responsável pelo sistema para credenciais.</p>
    </footer>
</body>
</html>
