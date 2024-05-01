<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            @if ($errors->any())
                <strong class="me-auto text-danger">Failed</strong>
            @elseif(session()->get('success'))
                <strong class="me-auto text-success">Success</strong>
            @endif
            <small>now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
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
        const toastLiveExample = document.getElementById('liveToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
    </script>
@endif