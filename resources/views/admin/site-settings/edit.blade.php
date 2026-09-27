@extends('admin.layout')

@section('title', 'Site content')
@section('section', 'Site content')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Landing Page Settings</h1>
            <p class="text-muted mb-0">Manage homepage messages and section copy from admin.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">View site</a>
    </div>

    <form action="{{ route('admin.site-settings.update') }}" method="POST" class="card shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Hero Eyebrow</label>
                    <input type="text" class="form-control" name="landing.hero.eyebrow" value="{{ old('landing.hero.eyebrow', $settings['landing.hero.eyebrow'] ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hero Title</label>
                    <input type="text" class="form-control" name="landing.hero.title" value="{{ old('landing.hero.title', $settings['landing.hero.title'] ?? '') }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Hero Copy</label>
                    <textarea class="form-control" rows="3" name="landing.hero.copy">{{ old('landing.hero.copy', $settings['landing.hero.copy'] ?? '') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Visual Kicker</label>
                    <input type="text" class="form-control" name="landing.visual.kicker" value="{{ old('landing.visual.kicker', $settings['landing.visual.kicker'] ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Visual Title</label>
                    <input type="text" class="form-control" name="landing.visual.title" value="{{ old('landing.visual.title', $settings['landing.visual.title'] ?? '') }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Visual Copy</label>
                    <textarea class="form-control" rows="2" name="landing.visual.copy">{{ old('landing.visual.copy', $settings['landing.visual.copy'] ?? '') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Catalog Title</label>
                    <input type="text" class="form-control" name="landing.catalog.title" value="{{ old('landing.catalog.title', $settings['landing.catalog.title'] ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">CTA Title</label>
                    <input type="text" class="form-control" name="landing.cta.title" value="{{ old('landing.cta.title', $settings['landing.cta.title'] ?? '') }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Catalog Copy</label>
                    <textarea class="form-control" rows="2" name="landing.catalog.copy">{{ old('landing.catalog.copy', $settings['landing.catalog.copy'] ?? '') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">CTA Copy</label>
                    <textarea class="form-control" rows="3" name="landing.cta.copy">{{ old('landing.cta.copy', $settings['landing.cta.copy'] ?? '') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Footer Description</label>
                    <textarea class="form-control" rows="2" name="landing.footer.copy">{{ old('landing.footer.copy', $settings['landing.footer.copy'] ?? '') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Footer Note</label>
                    <input type="text" class="form-control" name="landing.footer.note" value="{{ old('landing.footer.note', $settings['landing.footer.note'] ?? '') }}">
                </div>

                <div class="col-12 mt-4"><h2 class="h5 mb-0">Header navigation</h2></div>
                @foreach(['products' => 'Products', 'catalog' => 'Catalog', 'about' => 'About'] as $linkKey => $linkLabel)
                    <div class="col-md-6">
                        <label class="form-label">{{ $linkLabel }} label</label>
                        <input type="text" class="form-control" name="header.{{ $linkKey }}.label" value="{{ old('header.' . $linkKey . '.label', $settings['header.' . $linkKey . '.label'] ?? $linkLabel) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ $linkLabel }} URL</label>
                        <input type="text" class="form-control" name="header.{{ $linkKey }}.url" value="{{ old('header.' . $linkKey . '.url', $settings['header.' . $linkKey . '.url'] ?? '#' . $linkKey) }}">
                    </div>
                @endforeach

                <div class="col-12 mt-4"><h2 class="h5 mb-0">Footer links</h2></div>
                @foreach(['collection' => 'Collection', 'legal' => 'Legal', 'contact' => 'Contact'] as $linkKey => $linkLabel)
                    <div class="col-md-6">
                        <label class="form-label">{{ $linkLabel }} label</label>
                        <input type="text" class="form-control" name="footer.{{ $linkKey }}.label" value="{{ old('footer.' . $linkKey . '.label', $settings['footer.' . $linkKey . '.label'] ?? $linkLabel) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ $linkLabel }} URL</label>
                        <input type="text" class="form-control" name="footer.{{ $linkKey }}.url" value="{{ old('footer.' . $linkKey . '.url', $settings['footer.' . $linkKey . '.url'] ?? '#products') }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-dark">Save Settings</button>
        </div>
    </form>
</div>
@endsection
