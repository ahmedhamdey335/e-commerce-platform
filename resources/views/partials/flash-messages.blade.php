@if(session('success'))
    <div class="mb-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-alert type="success" :message="session('success')" />
    </div>
@endif

@if(session('error'))
    <div class="mb-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-alert type="error" :message="session('error')" />
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div class="mb-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-alert type="error">
            <ul class="list-disc pl-5 space-y-1 text-sm text-rose-700 dark:text-rose-200">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    </div>
@endif
