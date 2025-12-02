import './bootstrap';

const api = axios.create({ baseURL: '/api' });

const notify = (elementId, message, tone = 'info') => {
    const el = document.getElementById(elementId);
    if (!el) return;
    const palette = { info: '#cbd5e1', success: '#34d399', danger: '#f87171', warn: '#fbbf24' };
    el.innerHTML = `<span style="color:${palette[tone] ?? palette.info}">${message}</span>`;
};

const renderDenuncia = (data) => {
    const target = document.getElementById('consulta-resultado');
    if (!target) return;

    if (!data) {
        target.innerHTML = '<p class="muted">Nenhuma denúncia localizada para o protocolo informado.</p>';
        document.getElementById('respostas-list')?.replaceChildren();
        return;
    }

    target.innerHTML = `
        <div class="card">
            <div class="card__header">
                <h3>Protocolo ${data.protocolo ?? '—'}</h3>
                <span class="badge">Status ${data.status_id ?? '—'}</span>
            </div>
            <p class="muted">Departamento: ${data.departamentos_id ?? '—'} • Criado em ${data.created_at ? new Date(data.created_at).toLocaleString() : '—'}</p>
            <p>${data.denuncia ?? ''}</p>
        </div>
    `;
};

const renderRespostas = (respostas = []) => {
    const listEl = document.getElementById('respostas-list');
    if (!listEl) return;

    if (!respostas.length) {
        listEl.innerHTML = '<p class="muted">Ainda não há respostas para este protocolo.</p>';
        return;
    }

    const list = document.createElement('ul');
    list.className = 'list';

    respostas.forEach((resp) => {
        const li = document.createElement('li');
        li.className = 'list__item';
        li.innerHTML = `
            <div class="card__header">
                <h4>Resposta #${resp.id}</h4>
                <span class="badge badge--muted">${resp.created_at ? new Date(resp.created_at).toLocaleString() : ''}</span>
            </div>
            <p>${resp.resposta ?? ''}</p>
        `;
        list.appendChild(li);
    });

    listEl.replaceChildren(list);
};

document.addEventListener('DOMContentLoaded', () => {
    const denunciaForm = document.getElementById('nova-denuncia-form');
    const consultaForm = document.getElementById('consulta-protocolo-form');
    const respostaForm = document.getElementById('resposta-publica-form');

    denunciaForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const payload = new FormData(event.target);
        notify('nova-denuncia-feedback', 'Enviando denúncia...', 'info');

        try {
            const { data } = await api.post('/denuncia', payload, { headers: { 'Content-Type': 'multipart/form-data' } });
            const protocolo = data?.data?.protocolo ?? '—';
            notify('nova-denuncia-feedback', `Protocolo gerado: <strong>${protocolo}</strong>. Guarde-o para acompanhar.`, 'success');
            event.target.reset();
        } catch (error) {
            const message = error?.response?.data?.message ?? 'Erro ao registrar a denúncia.';
            notify('nova-denuncia-feedback', message, 'danger');
        }
    });

    consultaForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const protocolo = event.target.protocolo.value;
        if (!protocolo) return;
        notify('consulta-feedback', 'Buscando dados do protocolo...', 'info');
        try {
            const [denunciaResp, respostasResp] = await Promise.all([
                api.get('/denuncia', { params: { protocolo } }),
                api.get('/respostas', { params: { protocolo } }),
            ]);
            renderDenuncia(denunciaResp.data?.data);
            renderRespostas(respostasResp.data?.data?.respostas || []);
            notify('consulta-feedback', 'Dados carregados com sucesso.', 'success');
        } catch (error) {
            notify('consulta-feedback', 'Protocolo não localizado. Confirme o número informado.', 'danger');
            renderDenuncia(null);
        }
    });

    respostaForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const payload = Object.fromEntries(new FormData(event.target).entries());
        notify('resposta-feedback', 'Enviando resposta...', 'info');
        try {
            await api.post('/resposta', payload);
            notify('resposta-feedback', 'Resposta registrada com sucesso.', 'success');
            event.target.reset();
        } catch (error) {
            const message = error?.response?.data?.message ?? 'Erro ao enviar resposta.';
            notify('resposta-feedback', message, 'danger');
        }
    });
});
