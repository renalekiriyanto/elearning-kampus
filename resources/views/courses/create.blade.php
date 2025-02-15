@extends('layouts.adminlte.main')
@section('title', 'Create Course')
@section('content')
    <!--begin::Quick Example-->
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <a href="{{route('courses')}}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{route('courses.store')}}" method="POST">
            <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name')
                        is-invalid
                    @enderror" id="name" name="name" required />
                    @error('name')
                        <div class="form-text text-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control @error('description')
                        is-invalid
                    @enderror" id="description" name="description" />
                    @error('description')
                        <div class="form-text text-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Quick Example-->
@endsection
