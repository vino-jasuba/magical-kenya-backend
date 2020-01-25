@extends('layouts.app', ['title' => 'Tourist Activities'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container-fluid mt--7">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row-align-items-center">
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.activities.create') }}"
                               class="btn btn-sm btn-primary">{{ __('Add Activity') }}</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <activity-list class="row" target_url="/activities"></activity-list>
                        <div class="row">
                            <div class="col pt-6">
                                <nav class="d-flex justify-content-center" aria-label="...">
                                    {{ $activities->links() }}
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