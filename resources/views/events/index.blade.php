@extends('layouts.app', ['title' => 'Events'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h3 class="mb-0">Events</h3>
                            </div>
                            <!-- Button trigger modal -->
                            <div class="col-4 text-right">
                                <a href="{{ route('admin.events.create') }}"
                                class="btn btn-sm btn-primary">{{ __('Create Event') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col justify-content-right">
                            <activity-list class="row" article_type="event" target_url="/events"></activity-list>
                            <div class="row">
                                <div class="col pt-6">
                                    <nav class="d-flex justify-content-center" aria-label="...">
                                        {{ $events->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.footers.auth')
            </div>
        </div>
    </div>
@endsection
