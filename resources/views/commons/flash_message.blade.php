@if(session('flash_message'))
<div class="row mt-2">
    <h2 class="text-center col-sm-12">{{ session('flash_message') }}</h2>
</div>
@endif