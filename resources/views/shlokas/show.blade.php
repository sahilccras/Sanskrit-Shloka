@extends('layouts.app')

@section('title', "Shloka " . $shloka->shloka_id)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Shloka Details: {{ $shloka->shloka_id }}</h1>
        <div>
            @can('update', $shloka)
                <a href="{{ route('shlokas.edit', $shloka) }}" class="btn btn-secondary btn-sm">Edit</a>
            @endcan
            @can('delete', $shloka)
                <form action="{{ route('shlokas.destroy', $shloka) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this shloka?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <blockquote class="blockquote">
            <p class="fs-4">{{ $shloka->sanskrit_shloka }}</p>
            <footer class="blockquote-footer">{{ $shloka->getFullSourceAttribute() }}</footer>
        </blockquote>

        <hr>

        <h5 class="card-title mt-4">Transliteration (IAST)</h5>
        <p class="card-text text-muted">{{ $shloka->transliteration }}</p>

        <h5 class="card-title mt-4">Translations</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>Hindi:</strong> {{ $shloka->translations['hindi'] ?? 'N/A' }}
            </li>
            <li class="list-group-item">
                <strong>English:</strong> {{ $shloka->translations['english'] ?? 'N/A' }}
            </li>
        </ul>

        <h5 class="card-title mt-4">Details</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>Category:</strong> {{ $shloka->category ?? 'N/A' }}
            </li>
            <li class="list-group-item">
                <strong>Keywords:</strong>
                @if($shloka->keywords)
                    @foreach($shloka->keywords as $keyword)
                        <span class="badge bg-primary">{{ $keyword }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </li>
            <li class="list-group-item">
                <strong>Commentaries:</strong>
                @if($shloka->commentaries)
                    {{ implode(', ', $shloka->commentaries) }}
                @else
                    N/A
                @endif
            </li>
             <li class="list-group-item">
                <strong>Unicode (for developers):</strong> <code>{{ $shloka->unicode }}</code>
            </li>
        </ul>
    </div>
    <div class="card-footer text-muted">
        Created by: {{ $shloka->creator->name ?? 'Unknown' }} on {{ $shloka->created_at->format('M d, Y') }} |
        Status:
        @if($shloka->isApproved())
            <span class="badge bg-success">Approved</span> by {{ $shloka->approver->name ?? 'N/A' }} on {{ $shloka->approved_at ? $shloka->approved_at->format('M d, Y') : 'N/A' }}
        @else
            <span class="badge bg-warning text-dark">Pending Approval</span>
        @endif
    </div>
</div>

<div class="mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="h4">Questions & Answers</h2>
        @can('create', App\Models\QAPair::class)
            <a href="{{ route('qa-pairs.create', ['shloka_id' => $shloka->id]) }}" class="btn btn-primary btn-sm">Add Q&A</a>
        @endcan
    </div>
    <hr>
    @if($shloka->qaPairs->count() > 0)
        @foreach($shloka->qaPairs as $qaPair)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text"><strong>Question:</strong> {{ $qaPair->question }}</p>
                    <p class="card-text"><strong>Answer:</strong> {{ $qaPair->answer }}</p>
                </div>
                <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Keywords:</strong>
                        @if($qaPair->keywords)
                            @foreach($qaPair->keywords as $keyword)
                                <span class="badge bg-secondary">{{ $keyword }}</span>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </div>
                    <div>
                        <small>
                            Added by: {{ $qaPair->creator->name ?? 'Unknown' }} |
                            Status:
                            @if($qaPair->isApproved())
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No questions and answers have been added for this shloka yet.</p>
    @endif
</div>

@endsection
