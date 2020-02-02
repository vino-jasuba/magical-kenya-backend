@extends('layouts.app', ['title' => 'Tourist Travel Experiences'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container-fluid mt--7">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h3 class="mb-0">Experiences</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('admin.experiences.create') }}"
                               class="btn btn-sm btn-primary">{{ __('Add Experience') }}</a>
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="col">
                        <activity-list class="row" article_type="experience" target_url="/experiences"></activity-list>
                        <div class="row">
                            <div class="col pt-6">
                                <nav class="d-flex justify-content-center" aria-label="...">
                                    {{ $experiences->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footers.auth')
        </div>
    </div>
@endsection
