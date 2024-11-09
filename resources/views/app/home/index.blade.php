<x-app-layout title="Início">
    <x-header title="Início" />

    <div class="mb-3">
        <button type="button" class="btn btn-sm btn-primary"
            onclick="window.location.href = '{{ route('home.index') }}'">Início</button>
        <button type="button" class="btn btn-sm btn-primary"
            onclick="window.location.href = '{{ route('dashboard.index') }}'">Dashboard</button>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Acesso Rápido</h5>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center">
                            <i class='bx bx-id-card nav__icon'></i>
                            Cadastros
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <a href="#" class="nav__dropdown-item">Clientes</a>
                                <a href="#" class="nav__dropdown-item">Fornecedores</a>
                                <a href="#" class="nav__dropdown-item">Produtos</a>
                                <a href="#" class="nav__dropdown-item">Marcas</a>
                                <a href="#" class="nav__dropdown-item">Categorias</a>
                                <a href="#" class="nav__dropdown-item">Cores</a>
                                <a href="#" class="nav__dropdown-item">Tamanhos</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center">
                            <span>Vendas</span>
                        </div>
                        <div class="card-body">
                            //
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center">
                            <span>Estoque</span>
                        </div>
                        <div class="card-body">
                            //
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center">
                            <span>Relatórios</span>
                        </div>
                        <div class="card-body">
                            //
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-center">
                            <span>Financeiro</span>
                        </div>
                        <div class="card-body">
                            //
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
