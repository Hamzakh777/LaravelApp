{{-- here we have to list all the errors, looks like $errors is an object --}}
<div class="row">
    {{-- we can also use --}}
    @if ($errors->any())
        
    @endif
    @if ( count($errors) > 0 )
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger w-100">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (session('success'))
        <div class="alert alert-success w-100">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger w-100">
            {{ session('error') }}
        </div>
    @endif
</div>