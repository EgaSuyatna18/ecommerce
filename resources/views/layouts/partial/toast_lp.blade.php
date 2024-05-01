<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-header">
            @if ($errors->any())
                <strong class="me-auto text-danger">Failed</strong>
            @elseif(session()->get('success'))
                <strong class="me-auto text-success">Success</strong>
            @endif
        </div>
        <div class="toast-body">
            @if ($errors->any())
                @foreach ($errors->all() as $message)
                    <p class="text-danger">{{ $message }}</p>
                @endforeach
            @elseif(session()->get('success'))
                <p class="text-success">{{ session()->get('success') }}</p>
            @endif
        </div>
    </div>
</div>

@if ($errors->any() || session()->get('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>
@endif