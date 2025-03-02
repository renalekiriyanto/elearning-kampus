@extends('layouts.adminlte.main')
@section('title', 'List Course')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('error')}}
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning" role="alert">
            {{Session::get('warning')}}
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            @can('create-courses')
                <a href="{{ route('courses.create') }}" class="btn btn-sm btn-primary">Create</a>
            @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Desc</th>
                        <th>Lecture</th>
                        <th style="width: 40px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr class="align-middle">
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td>{{ $item->lecturer->name ?? '-' }}</td>
                            <td class="d-flex align-content-around">
                                @can('delete-courses')
                                    <form action="{{ route('courses.delete', $item->id) }}" method="post" class="mr-3">
                                        @csrf
                                        @method('delete')
                                        <button class="badge bg-danger btn" type="submit">Delete</button>
                                    </form>
                                @endcan
                                @can('register-courses')
                                    <form action="{{ route('courses.enrolled', $item->id) }}" method="post" class="mr-3">
                                        @csrf
                                        <button class="badge bg-success btn" type="submit">Enroll</button>
                                    </form>
                                @endcan
                                @can('update-courses')
                                    <div>
                                        <a href="" class="badge bg-success btn">Edit</a>
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                @if ($data->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $data->previousPageUrl() }}">&laquo;</a>
                    </li>
                @endif

                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    @if ($page == $data->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($data->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $data->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </div>
    </div>
@endsection
