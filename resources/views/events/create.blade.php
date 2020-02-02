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
                                <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createEventModal">Create Event</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col justify-content-right">
                            <event-crud></event-crud>
                        </div>
                    </div>
                </div>
                @include('layouts.footers.auth')
            </div>
        </div>
    </div>
@endsection
