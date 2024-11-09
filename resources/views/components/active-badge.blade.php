@props(['active'])

<span class="badge badge-{{ $active ? 'primary' : 'danger' }}">
    {{ $active ? 'Sim' : 'Não' }}
</span>
