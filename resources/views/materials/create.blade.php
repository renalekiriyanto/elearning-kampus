@extends('layouts.adminlte.main')
@section('title', 'Create Material')
@section('content')
    <!--begin::Quick Example-->
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <a href="{{route('materials')}}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{route('materials.store')}}" method="POST" enctype="multipart/form-data">
            <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="col mb-3">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select" id="course_id" name="course_id" required>
                      <option selected disabled value="">Choose your course</option>
                      @foreach ($courses as $item)
                          <option value="{{$item->id}}">{{$item->name}} - {{$item->description}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a valid state.</div>
                  </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title')
                        is-invalid
                    @enderror" id="title" name="title" required />
                    @error('title')
                        <div class="form-text text-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="file_path" name="file_path" />
                    <label class="input-group-text" for="file_path">Upload</label>
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
