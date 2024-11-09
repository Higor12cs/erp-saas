@props(['id', 'title' => null, 'footer' => null, 'size' => 'md', 'closeButton' => true])

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label"
    aria-hidden="true" style="overflow:hidden;">
    <div {{ $attributes->merge(['class' => 'modal-dialog modal-' . $size]) }} role="document">
        <div class="modal-content">
            @if ($title || $closeButton)
                <div class="modal-header">
                    @if ($title)
                        <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                    @endif

                    @if ($closeButton)
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
