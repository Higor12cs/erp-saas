<div id="toast-container" class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div id="toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" style="width: 300px;">
        <div class="toast-header">
            <strong id="toast-title" class="me-auto"></strong>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="toast-message" class="text-white"></span>
        </div>
    </div>
</div>

<script>
    let toastTimeout;

    function showToast(message, type = 'primary', delay = 3000) {
        const toastElement = $('#toast');
        const toastTitle = $('#toast-title');
        const toastMessage = $('#toast-message');

        toastTitle.text("{{ config('app.name') }}");
        toastMessage.text(message);
        toastElement.removeClass('bg-primary bg-success bg-danger bg-warning');
        toastElement.addClass(`bg-${type}`);

        clearTimeout(toastTimeout);

        toastElement.toast({
            autohide: false
        });
        toastElement.toast('show');

        toastTimeout = setTimeout(() => {
            toastElement.toast('hide');
        }, delay);

        toastElement.hover(
            function() {
                clearTimeout(toastTimeout);
            },
            function() {
                toastTimeout = setTimeout(() => {
                    toastElement.toast('hide');
                }, delay);
            }
        );
    }
</script>

<style>
    .toast {
        position: relative;
    }
</style>
