<x-app :title="__('lang.students')">

    <x-page-nav :title="__('lang.students')" icon='users'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('lang.students') }}</li>
        <li class="breadcrumb-item">{{ __('lang.students') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong> {{ session('error') }}</strong>
                    <a
                        href="{{ route('admin.school.download.invalid.excel', [
                            'file_name' => session('download_link'),
                            'locale' => '',
                        ]) }}">
                        {{ __('jamiat.invalid_file_download') }}
                    </a>
                </div>
            @endif
            <x-table>
                <x-slot:tools>
                    @can('students.import')
                        <button class="btn btn-success" onclick="openImportModal()">
                            <i class="fa fa-file-excel"></i>
                            {{ __('jamiat.excel_import_btn') }}
                        </button>
                    @endcan
                </x-slot:tools>
                <thead>
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
                        <th>{{ __('jamiat.exam') }}</th>
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
                            <td>{{ $student->currentDistrict->name }}</td>
                            <td>{{ $student->permanentDistrict->name }}</td>
                            <td dir="ltr">{{ $student->phone }}</td>
                            <td>{{ $student->school->name }}</td>
                            <td>{{ $student->graduation_year }}</td>
                            <td>{{ $student->addressType?->name }}</td>
                            <td>{{ $student->exams->first()->title }}</td>
                            <td>
                                <div class="btn-group" dir="ltr">
                                    @can('students.delete')
                                        <x-buttons.delete :route="route('students.destroy', $student)" />
                                    @endcan
                                    @can('students.show')
                                        <x-buttons.show :route="route('students.show', $student)" />
                                    @endcan
                                    @can('students.edit')
                                        <x-buttons.edit :route="route('students.edit', $student)" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <x-slot:links>
                    {{ $students->links() }}
                </x-slot:links>
            </x-table>
        </div>
        </div>
    </x-page-container>
    <div class="modal-containers">
        @can('students.import')
            <x-modal id='import-modal' :title="__('jamiat.import_from_excel')" size='md'>
                <div class="container-fluid">
                    <form id='import-form' action="{{ route('admin.student.import.excel') }}" class="row" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="form_type"
                            value="{{ Route::currentRouteName() == route('admin.student.form.evaluation') ? 'evaluation' : 'commission' }}">

                        <div class="form-group ">
                            <label class='form-label fs-6 '>{{ __('lang.address_type') }}:</label>
                            <div class="">
                                <input class="btn-check" type="radio" name="address_type_id" id="interior" value="1"
                                    checked>
                                <label class="btn btn-outline-primary" for="interior">
                                    {{ __('jamiat.interior') }}
                                </label>

                                <input class="btn-check" type="radio" name="address_type_id" id="exterior"
                                    value="2">
                                <label class="btn btn-outline-primary" for="exterior">
                                    {{ __('jamiat.exterior') }}
                                </label>
                            </div>
                        </div>

                        <x-js-select2 :list="JamiaHelper::exams()" :label="__('jamiat.select_exam')" value='id' text='title' id='exam_id'
                            modal_id='import-modal' name='exam_id' col='col-sm-12 fs-6' class="select2" :required="1" />
                        <x-input type="file" name='excel_file' col='col-12 fs-6' :label="__('jamiat.select_excel_file')" :required="1" />

                        <div class="d-flex justify-content-between bg-light mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}</button>
                            <x-btn-save type='button' id='save-btn' />
                        </div>
                    </form>
                </div>
            </x-modal>
        @endcan

    </div>
    @push('scripts')
        <script>
            function openImportModal() {
                $("#import-modal").modal('show');
            }
        </script>
    @endpush
</x-app>
