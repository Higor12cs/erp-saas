<x-app-layout title="Dashboard">
    <x-header title="Dashboard" />

    <div class="mb-3">
        <button type="button" class="btn btn-sm btn-primary"
            onclick="window.location.href = '{{ route('home.index') }}'">Início</button>
        <button type="button" class="btn btn-sm btn-primary"
            onclick="window.location.href = '{{ route('dashboard.index') }}'">Dashboard</button>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Card 1</h5>
                    <p class="card-text">Some fake data for card 1</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Card 2</h5>
                    <p class="card-text">Some fake data for card 2</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Card 3</h5>
                    <p class="card-text">Some fake data for card 3</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Card 4</h5>
                    <p class="card-text">Some fake data for card 4</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
