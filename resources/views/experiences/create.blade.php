@extends('layouts.app', ['title' => __('Experiences')])

@section('content')
    @include('users.partials.header', ['title' => __('Add Experience')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Create An Experience</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('admin.experiences.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="pl-lg-4">
                        <activities-crud type="experience"></activities-crud>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection