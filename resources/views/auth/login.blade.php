<x-guest-layout>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center p-2">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <span class="text-muted">{{ config('app.name') }}</span>
                        <h3>Bem-vindo!</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login.attempt') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <x-input label="Email" name="email" type="email" autofocus value="admin@admin.com"
                                    additionalClasses="mb-3" />
                                <x-input label="Senha" name="password" type="password" value="password"
                                    additionalClasses="mb-3" />
                            </div>

                            <div class="d-grid col-12 mx-auto">
                                <button class="btn btn-block btn-primary" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
