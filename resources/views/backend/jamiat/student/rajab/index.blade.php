<x-app :title="__('sidebar.rajab_students')">

    <x-page-nav :title="__('sidebar.rajab_students')" icon='users-line'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('lang.students') }}</li>
        <li class="breadcrumb-item">{{ __('sidebar.rajab_students') }}</li>
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
            {{-- <div class="col-sm-4"><input type="text"></div>
            <div class="col-sm-4"><input type="text"></div>
            <div class="col-sm-4"><input type="text"></div> --}}
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row mt-2">

            <x-table>
                <x-slot:tools>
                    @can('students.import')
                        <button class="btn btn-success" onclick="openImportModal()">
                            {{ __('jamiat.excel_import_btn') }}
                            <i class="fa fa-file-excel"></i>
                        </button>
                    @endcan

                    <button type="submit" class="btn btn-primary" id="generate-id-cards-btn">Generate ID Cards</button>


                </x-slot:tools>
                <thead class="table-primary">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
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
                        <th>{{ __('jamiat.exam') }}</th>
                        <th>{{ __('lang.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                    class="student-checkbox"></td>
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
                            <td>{{ $student->school?->name }}</td>
                            <td>{{ $student->addressType?->name }}</td>
                            <td>{{ $student->exams()->first()?->title }}</td>
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
                    <form id='import-form' action="{{ route('admin.student.import.excel.rajab') }}" class="row"
                        method="POST" enctype="multipart/form-data">
                        @csrf
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

                        <x-js-select2 :list="$exams" :label="__('jamiat.select_exam')" value='id' text='title' id='exam_id'
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

        <x-modal id='card-modal' :title="__('jamiat.import_from_excel')" size='md'>
            <div class="container-fluid">

                <form action="{{ route('admin.student.generate.card') }}" method="POST" id='card-form'>
                    <x-js-select2 :list="$exams" :label="__('jamiat.exam')" value='id' text='title' id='card_exam_id'
                        name='exam_id' col='col-sm-12' modal_id='card-modal' />
                    @csrf
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i>
                    </button>
                </form>

            </div>
        </x-modal>

    </div>
    @push('scripts')
        <script>
            function openImportModal() {
                $("#import-modal").modal('show');
            }



            // Card Generation Handling Start

            function toggleGenerateButton() {
                const isAnyChecked = $('.student-checkbox:checked').length > 0;
                $('#generate-id-cards-btn').toggle(isAnyChecked);
            }

            // Call toggleGenerateButton on page load and on checkbox changes
            $(document).ready(function() {
                toggleGenerateButton();
            });

            $('#select-all').on('change', function() {
                $('.student-checkbox').prop('checked', $(this).is(':checked'));
                toggleGenerateButton();
            });

            $('.student-checkbox').on('change', function() {
                toggleGenerateButton();
            });

            // Open modal and gather selected IDs
            $('#generate-id-cards-btn').on('click', function() {
                const selectedIds = $('.student-checkbox:checked').map(function() {
                    return this.value;
                }).get();

                if (selectedIds.length === 0) {
                    alert("Please select at least one student.");
                    return;
                }

                selectedIds.forEach(function(id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'student_ids[]',
                        value: id
                    }).appendTo('#card-form');
                });

                $('#card-modal').data('selected-ids', selectedIds);
                $('#card-modal').modal('show');
            });
        </script>
    @endpush
</x-app>
