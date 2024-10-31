@extends('layouts.app')
@section('title', 'Students')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/datatable.css') }}">
@endpush
@section('content')
    <div class="row">

        <div class="col-lg-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title"><i class="bi bi-list-ul"></i> {{ __('lang.students') }}</h3>
                    {{-- <a class="btn btn-primary" href="{{ route('students.create') }}"><i class='bi bi-plus'></i></a> --}}
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    {{-- <th>{{__('lang.image')}}</th> --}}
                                    <th>{{ __('lang.name') }}</th>
                                    <th>{{ __('lang.father_name') }}</th>
                                    <th>{{ __('lang.dob_qamari') }}</th>
                                    <th>{{ __('lang.current_address') }}</th>
                                    <th>{{ __('lang.permanent_address') }}</th>
                                    <th>{{ __('lang.phone') }}</th>
                                    <th>{{ __('lang.school') }}</th>
                                    <th>{{ __('lang.address_type') }}</th>
                                    <th>{{ __('lang.graduation_year') }}</th>
                                    <th>{{ __('jamiat.form_type') }}</th>
                                    <th>{{ __('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>
                                    <img src="{{$student->image_path}}" alt="Student image" height="70">
                                </td> --}}
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ $student->father_name }}</td>
                                        <td>{{ $student->dob_qamari }}</td>
                                        <td>{{ $student->currentDistrict?->name }}</td>
                                        <td>{{ $student->permanentDistrict?->name }}</td>
                                        <td dir="ltr">{{ $student->phone }}</td>
                                        <td>{{ $student->school?->name }}</td>
                                        <td>{{ $student->school?->addressType?->name }}</td>
                                        <td>{{ $student->graduation_year }}</td>
                                        <td>{{ $student->form_type}}</td>
                                        <td>
                                            <div class="btn-group" dir="ltr">
                                                <x-buttons.delete :route="route('students.destroy', $student)" />
                                                <x-buttons.show :route="route('students.show', $student)" />
                                                <x-buttons.edit :route="route('students.edit', $student)" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('admin/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        $('.data-table').DataTable();
    </script>
@endpush
