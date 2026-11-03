@extends('layouts.admin')

@section('title', '301 / 302 / 404 URL Redirects - Advanced Dental Clinic')
@section('page_title', 'URL Redirects & Traffic Route Manager')
@section('page_subtitle', 'Manage 301 permanent redirects, 302 temporary redirects, and 404/410 gone status codes for SEO integrity')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- New Redirect Rule Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <span class="fs-6 fw-bold text-dark"><i class="bi bi-signpost-split text-primary me-2"></i>Create Redirect Rule</span>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/seo-redirects/store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Source Relative URL</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted">/</span>
                                <input type="text" class="form-control" name="source_url" placeholder="old-page or old-service" required>
                            </div>
                            <small class="text-muted">Relative incoming path (e.g. <code>/services/teeth-cleaning</code>)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Target Destination URL</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted">/</span>
                                <input type="text" class="form-control" name="target_url" placeholder="treatments/deep-cleaning-scaling" required>
                            </div>
                            <small class="text-muted">New destination path on the website</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">HTTP Redirect Status Code</label>
                            <select class="form-select form-select-sm" name="status_code" required>
                                <option value="301" selected>301 Moved Permanently (SEO Standard)</option>
                                <option value="302">302 Found / Temporary Redirect</option>
                                <option value="307">307 Temporary Redirect</option>
                                <option value="308">308 Permanent Redirect</option>
                                <option value="404">404 Not Found (Track broken links)</option>
                                <option value="410">410 Gone (Permanently removed page)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold py-2">
                            <i class="bi bi-plus-circle me-1"></i> Add Redirection Rule
                        </button>
                    </form>
                </div>
            </div>

            <!-- SEO Redirection Guidance Note -->
            <div class="card shadow-sm bg-light border">
                <div class="card-body p-3">
                    <h6 class="small fw-bold text-primary mb-2"><i class="bi bi-info-circle me-1"></i> Best Practice Guidelines</h6>
                    <ul class="small text-muted ps-3 mb-0">
                        <li class="mb-1"><strong>301 Permanent:</strong> Passes 95-99% of link equity (ranking power) to the target page.</li>
                        <li class="mb-1"><strong>302 Temporary:</strong> Use during brief maintenance without transferring search index authority.</li>
                        <li><strong>410 Gone:</strong> Explicitly informs Googlebot to purge discontinued clinical procedures from SERP indices.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Active Redirects Table -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="fs-6 fw-bold text-dark"><i class="bi bi-table text-primary me-2"></i>Active Redirection Rules ({{ $redirects->count() }})</span>
                    <span class="badge bg-secondary-subtle text-secondary border">Synchronized via API</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Source URL</th>
                                    <th>Target Destination</th>
                                    <th>Status Code</th>
                                    <th>Hits</th>
                                    <th>Created</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($redirects as $rule)
                                <tr>
                                    <td class="ps-3 font-monospace text-danger fw-bold">{{ $rule->source_url }}</td>
                                    <td class="font-monospace text-success fw-bold">{{ $rule->target_url }}</td>
                                    <td>
                                        @if($rule->status_code == 301)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">301 Permanent</span>
                                        @elseif($rule->status_code == 302)
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">302 Temporary</span>
                                        @elseif($rule->status_code == 410)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">410 Gone</span>
                                        @else
                                        <span class="badge bg-secondary">{{ $rule->status_code }}</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $rule->hit_count }}</span></td>
                                    <td class="text-muted">{{ $rule->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-3">
                                        <form action="{{ url('/admin/seo-redirects/' . $rule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this redirect?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" title="Delete Rule">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No URL redirects configured yet. Add one from the form on the left.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
