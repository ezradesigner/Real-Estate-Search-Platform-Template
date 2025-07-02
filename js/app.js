let fuse;
const fuseOptions = {
    keys: ['titulo', 'endereco', 'tipo'],
    threshold: 0.2,
    includeScore: true,
    minMatchCharLength: 3,
    findAllMatches: true,
    ignoreLocation: true,
    shouldSort: true
};

function criarCardImovel(imovel) {
    return `
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <img src="${imovel.imagem}" alt="${imovel.titulo}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold mb-2">${imovel.titulo}</h4>
                    <p class="text-gray-600 mb-2">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        ${imovel.endereco}
                    </p>
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span><i class="fas fa-bed mr-1"></i>${imovel.quartos} quartos</span>
                        <span><i class="fas fa-bath mr-1"></i>${imovel.banheiros} banheiros</span>
                        <span><i class="fas fa-ruler-combined mr-1"></i>${imovel.area}m²</span>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        `;
}

async function buscarImoveis(filtros = {}) {
    try {
        const params = new URLSearchParams();

        if (filtros.destaque) params.append('destaque', '1');
        if (filtros.tipo) params.append('tipo', filtros.tipo);
        if (filtros.busca) params.append('busca', filtros.busca);

        const response = await fetch(`/api/imoveis.php?${params.toString()}`);
        const data = await response.json();

        if (data.success && data.data) {
            fuse = new Fuse(data.data, fuseOptions);
            return data.data;
        }
        return [];
    } catch (error) {
        console.error('Erro ao buscar imóveis:', error);
        return [];
    }
}

async function carregarImoveisDestaque() {
    const container = document.getElementById('imoveisDestaque');
    const loading = document.createElement('div');
    loading.innerHTML = '<p class="text-center py-4">Carregando destaques...</p>';
    container.innerHTML = '';
    container.appendChild(loading);

    try {
        const imoveis = await buscarImoveis({ destaque: true });

        if (imoveis.length === 0) {
            container.innerHTML = '<p class="text-center py-4">Nenhum imóvel em destaque no momento</p>';
            return;
        }

        container.innerHTML = imoveis.map(criarCardImovel).join('');
    } catch (error) {
        console.error('Erro ao carregar destaques:', error);
        container.innerHTML = '<p class="text-center text-red-500 py-4">Erro ao carregar imóveis em destaque</p>';
    }
}

function mostrarErro(mensagem) {
    const erroContainer = document.getElementById('erroContainer');
    if (erroContainer) {
        erroContainer.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    ${mensagem}
                </div>
            `;
        setTimeout(() => erroContainer.innerHTML = '', 5000);
    }
}

document.getElementById('searchForm')?.addEventListener('submit', async function (e) {
    e.preventDefault();

    const loading = document.getElementById('loading');
    const resultadosContainer = document.getElementById('resultados');
    const semResultados = document.getElementById('semResultados');
    const tipoImovel = document.getElementById('tipoImovel').value;
    const localBusca = document.getElementById('localBusca').value;

    loading.classList.remove('hidden');
    resultadosContainer.classList.add('hidden');
    semResultados.classList.add('hidden');

    try {
        let resultados;

        if (localBusca) {
            const todosImoveis = await buscarImoveis();
            resultados = fuse.search(localBusca).map(result => result.item);

            if (tipoImovel) {
                resultados = resultados.filter(imovel => imovel.tipo === tipoImovel);
            }
        } else {
            resultados = await buscarImoveis({ tipo: tipoImovel });
        }

        mostrarResultados(resultados);
    } catch (error) {
        console.error('Erro na busca:', error);
        mostrarResultados([]);
    } finally {
        loading.classList.add('hidden');
    }
});

function mostrarResultados(imoveis) {
    const listaImoveis = document.getElementById('listaImoveis');
    const resultados = document.getElementById('resultados');
    const totalResultados = document.getElementById('totalResultados');
    const semResultados = document.getElementById('semResultados');

    if (imoveis.length === 0) {
        resultados.classList.add('hidden');
        semResultados.classList.remove('hidden');
        return;
    }

    semResultados.classList.add('hidden');
    listaImoveis.innerHTML = imoveis.map(criarCardImovel).join('');
    totalResultados.textContent = `${imoveis.length} imóveis encontrados`;
    resultados.classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    carregarImoveisDestaque();

    if (!document.getElementById('erroContainer')) {
        const erroContainer = document.createElement('div');
        erroContainer.id = 'erroContainer';
        erroContainer.className = 'container mx-auto px-4';
        document.body.prepend(erroContainer);
    }
});
