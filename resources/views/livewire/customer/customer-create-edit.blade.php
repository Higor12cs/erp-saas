<form wire:submit="submit">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="form.first_name" class="form-label">Primeiro Nome</label>
            <input wire:model="form.first_name" type="text"
                class="form-control @error('form.first_name') is-invalid @enderror" name="form.first_name">
            @error('form.first_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="form.last_name @error('form.last_name') is-invalid @enderror"
                class="form-label">Sobrenome</label>
            <input wire:model="form.last_name" type="text" class="form-control" name="form.last_name">
            @error('form.last_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
