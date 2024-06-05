<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<div id="snap-container text-center"></div>

<script>
    window.snap.embed('{{ $midtrans_token }}', {
        embedId: 'snap-container'
    });
</script>