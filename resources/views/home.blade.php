<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <img src="https://img.icons8.com/?size=100&id=4A8ObomuuPJ3&format=png&color=000000" alt="logo" width="50">
            <a class="navbar-brand" href="/">AnyFood</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrar-se</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">Olá, {{ auth()->user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Produtos -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Nosso Cardápio</h2>
        @if ($produtos->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                Nenhum produto cadastrado no momento.
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($produtos as $produto)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <img src="{{ asset('storage/' . $produto->foto) }}" class="card-img-top" alt="{{ $produto->nome }}" style="width: 100%; height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $produto->nome }}</h5>
                                <p class="card-text">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                            </div>
                            <div class="card-footer">
                                <!-- Botão para abrir o modal -->
                                <a href="#" class="btn btn-primary btn-detalhes" 
                                data-nome="{{ $produto->nome }}" 
                                data-descricao="{{ $produto->descricao }}" 
                                data-valor="{{ number_format($produto->valor, 2, ',', '.') }}">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


    <!-- Modal de Detalhes -->
    <div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produtoModalLabel">Detalhes do Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo do modal (será preenchido dinamicamente) -->
                    <h5 id="produtoNome"></h5>
                    <p id="produtoDescricao"></p>
                    <p><strong>Valor: R$ <span id="produtoValor"></span></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Adicionando o JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Seleciona todos os botões "Ver Detalhes"
            const detalhesButtons = document.querySelectorAll('.btn-detalhes');

            detalhesButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Obtém as informações do produto
                    const produtoNome = this.getAttribute('data-nome');
                    const produtoDescricao = this.getAttribute('data-descricao');
                    const produtoValor = this.getAttribute('data-valor');

                    // Preenche o modal com as informações
                    document.getElementById('produtoNome').textContent = produtoNome;
                    document.getElementById('produtoDescricao').textContent = produtoDescricao;
                    document.getElementById('produtoValor').textContent = produtoValor;

                    const modal = new bootstrap.Modal(document.getElementById('produtoModal'));
                    modal.show();
                });
            });
        });
    </script>

</body>
</html>