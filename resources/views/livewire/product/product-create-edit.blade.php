<form wire:submit="submit">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="form.name" class="form-label">Nome</label>
            <input wire:model="form.name" type="text" class="form-control @error('form.name') is-invalid @enderror" name="form.name">
            @error('form.name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="form.sku" class="form-label">SKU</label>
            <input wire:model="form.sku" type="text" class="form-control @error('form.sku') is-invalid @enderror" name="form.sku">
            @error('form.sku')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="form.cost" class="form-label">Custo</label>
            <input wire:model="form.cost" x-mask:dynamic="$money($input, ',', '.', 2)" type="text" class="form-control @error('form.cost') is-invalid @enderror" name="form.cost">
            @error('form.cost')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="form.price" class="form-label">Valor</label>
            <input wire:model="form.price" x-mask:dynamic="$money($input, ',', '.', 2)" type="text" class="form-control @error('form.price') is-invalid @enderror" name="form.price">
            @error('form.price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>