<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
                <i class='bx bx-store-alt nav__icon'></i>
                <span class="nav__logo-name">{{ config('app.name') }}</span>
            </a>

            <div class="nav__list">
                <div class="nav__items">
                    {{-- <h3 class="nav__subtitle">Home</h3> --}}

                    <a href="{{ route('home.index') }}" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Início</span>
                    </a>
                </div>

                <div class="nav__items">
                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                            <i class='bx bx-id-card nav__icon'></i>
                            <span class="nav__name">Cadastros</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="{{ route('customers.index') }}" class="nav__dropdown-item">Clientes</a>
                                <a href="{{ route('suppliers.index') }}" class="nav__dropdown-item">Fornecedores</a>
                                <a href="{{ route('products.index') }}" class="nav__dropdown-item">Produtos</a>
                                <a href="#" class="nav__dropdown-item">Marcas</a>
                                <a href="#" class="nav__dropdown-item">Categorias</a>
                                <a href="#" class="nav__dropdown-item">Cores</a>
                                <a href="#" class="nav__dropdown-item">Tamanhos</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav__items">
                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                            <i class='bx bx-shopping-bag nav__icon'></i>
                            <span class="nav__name">Vendas</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="{{ route('orders.index') }}" class="nav__dropdown-item">Pedidos</a>
                                <a href="#" class="nav__dropdown-item">Condicionais</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav__items">
                    <a href="#" class="nav__link">
                        <i class='bx bx-package nav__icon'></i>
                        <span class="nav__name">Estoque</span>
                    </a>
                </div>

                <div class="nav__items">
                    <a href="#" class="nav__link">
                        <i class='bx bx-printer nav__icon'></i>
                        <span class="nav__name">Relatórios</span>
                    </a>
                </div>

                <div class="nav__items">
                    <a href="#" class="nav__link">
                        <i class='bx bx-money-withdraw nav__icon'></i>
                        <span class="nav__name">Financeiro</span>
                    </a>
                </div>
            </div>
        </div>

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Log Out</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</div>