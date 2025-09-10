@extends('layouts.app')

@section('title', 'Export Data')

@section('content')
<div class="container">
    <h1 class="mb-4">Export Shlokas to JSON</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Export Options</h5>
            <p class="card-text text-muted">Select the fields you want to include in the JSON export.</p>

            <form action="{{ route('export.shlokas-json') }}" method="GET" id="export-form" class="mt-4">

                {{-- Shloka Fields --}}
                <fieldset class="mb-4">
                    <legend class="fs-5">Shloka Fields</legend>
                    <div class="d-flex gap-2 mb-2">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleAll('shloka-fields', true)">Select All</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleAll('shloka-fields', false)">Deselect All</button>
                    </div>
                    <div class="row" id="shloka-fields">
                        @php
                            $shlokaFields = ['shloka_id', 'sanskrit_shloka', 'unicode', 'transliteration', 'translations', 'source_text_name', 'source_section', 'source_chapter', 'source_verse', 'keywords', 'category', 'commentaries'];
                        @endphp
                        @foreach ($shlokaFields as $field)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[shloka][{{ $field }}]" id="field_shloka_{{ $field }}" value="1" checked>
                                <label class="form-check-label" for="field_shloka_{{ $field }}">
                                    {{ ucwords(str_replace('_', ' ', $field)) }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </fieldset>

                {{-- QA Pair Fields --}}
                <fieldset class="mb-4">
                    <legend class="fs-5">Q&A Pair Fields</legend>
                     <div class="d-flex gap-2 mb-2">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleAll('qa-fields', true)">Select All</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleAll('qa-fields', false)">Deselect All</button>
                    </div>
                    <div class="row" id="qa-fields">
                        @php
                            $qaFields = ['question', 'answer', 'keywords', 'context'];
                        @endphp
                        @foreach ($qaFields as $field)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[qa_pair][{{ $field }}]" id="field_qa_{{ $field }}" value="1" checked>
                                <label class="form-check-label" for="field_qa_{{ $field }}">
                                    {{ ucwords(str_replace('_', ' ', $field)) }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </fieldset>

                {{-- Other Options --}}
                <fieldset>
                    <legend class="fs-5">Other Options</legend>
                    <div class="form-check mt-3">
                        <input id="include_pending" name="include_pending" type="checkbox" value="1" class="form-check-input">
                        <label for="include_pending" class="form-check-label">Include Pending Shlokas</label>
                        <div class="form-text">Check this box to include shlokas that have not yet been approved.</div>
                    </div>
                </fieldset>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Export to JSON
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleAll(containerId, checked) {
    const container = document.getElementById(containerId);
    const checkboxes = container.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = checked;
    });
}
</script>
@endpush
