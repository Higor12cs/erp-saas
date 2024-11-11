<form wire:submit="submit">
    <div class="row">
        <div wire:ignore class="col-md-10 mb-3">
            <label for="form.customer_id" class="form-label">Cliente</label>
            <select wire:model="form.customer_id" class="form-select js-select @error('form.customer_id') is-invalid @enderror" name="form.customer_id">
                <option value="">-</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->first_name }}</option>
                @endforeach
            </select>
            @error('form.customer_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-2 mb-3">
            <label for="form.issue_date" class="form-label">Data</label>
            <input wire:model="form.issue_date" type="date" class="form-control @error('form.issue_date') is-invalid @enderror" name="form.issue_date">
            @error('form.issue_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

@script
<script>
    $(document).ready(function() {
        $('.js-select').select2();

        $('.js-select').on('change', function() {
            let data = $(this).val();
            $wire.set('form.customer_id', data, false);
        });
    });
</script>
@endscript