<script src="{{ asset('js/app.js') }}"></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v7.0"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
  document.querySelectorAll('.delete').forEach(e => e.onclick = () => confirm("{{ __('interface.confirm') }}"))
</script>
