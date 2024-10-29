<x-app :title="__('sidebar.exams')">

    <x-page-nav :title="__('sidebar.exams')" icon='clipboard'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('sidebar.exams') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container">

            <div class="row">
                <div class="col-12">
                    @can('exam.create')
                        <button class="btn btn-primary" onclick="openCreateModal()">
                            <i class="fa fa-add"></i>
                        </button>
                    @endcan

                </div>


            </div>
            <div class="clearfix"></div>
            <hr>

            <x-table id='doctorTable'>
                <x-slot:tools>
                    <div class="container">

                    </div>
                </x-slot:tools>
                <thead>
                    <tr>
                        <th>{{ __('jamiat.no') }}</th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('jamiat.exam_grade') }}</th>
                        <th>{{ __('jamiat.campus') }}</th>
                        <th>{{ __('lang.province') }}</th>
                        <th>{{ __('lang.district') }}</th>
                        <th>{{ __('jamiat.address') }}</th>
                        <th>{{ __('jamiat.start_date') }}</th>
                        <th>{{ __('jamiat.end_date') }}</th>
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $exam->title }}
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $exam->grade?->name }}!</span>

                            </td>
                            <td>
                                {{ $exam->campus?->name }}
                            </td>
                            <td>
                                {{ $exam->province?->name }}
                            </td>
                            <td>{{ $exam->district?->name }}</td>
                            <td>{{ $exam->address }}</td>
                            <td>{{ Settings::change_to_hijri($exam->start_date) }}</td>
                            <td>{{ Settings::change_to_hijri($exam->end_date) }}</td>
                            <td>
                                <div class="dropdown open">
                                    @can('exam.delete')
                                        <x-buttons.delete :route="route('admin.exam.destroy', $exam->id)" />
                                    @endcan
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <x-slot:links>
                    {{ $exams->links() }}
                </x-slot:links>
            </x-table>
        </div>
    </x-page-container>
    <x-modal id='create-modal' :title="__('jamiat.add_exam')" size='lg'>
        <div class="container-fluid">
            <form id='create-form' class="row" method="POST">
                @csrf

                <x-input2 type='text' label="{{ __('lang.title') }}" id='title' name='title' col='col-sm-6' />

                <x-js-select2 col="col-6" :list="JamiaHelper::campuses()" :label="__('jamiat.campus')" :required="1" id='campus_id'
                name='campus_id' value='id' text='name' modal_id="create-modal" />

                <x-js-select2 col="col-6" :list="JamiaHelper::grades()" :label="__('jamiat.exam_grade')" :required="1" id='grade_id'
                    name='grade_id' value='id' text='name' modal_id="create-modal" />

                <x-js-select2 :list="old('country_id')
                    ? App\Models\Country::find(1)->provinces
                    : App\Models\Country::where('name', 'افغانستان')->first()->provinces" col="col-6" id='province_id' name="province_id" :label="__('lang.province')"
                    name='province_id' value='id' text='name' required modal_id="create-modal" />

                <x-js-select2 :options="old('province_id') ? App\Models\Province::find(old('province_id'))->districts : collect()" col="col-6" id='district_id' name="district_id" :label="__('lang.district')"
                    modal_id="create-modal" />
                <x-input2 type='text' col='col-sm-6' label="{{ __('jamiat.address') }}" id='address'
                    name='address' />
                <x-date-picker type='text' col='col-sm-6' label="{{ __('jamiat.start_date') }}" id='start_date'
                    name='start_date' />
                <x-date-picker type='text' col='col-sm-6' label="{{ __('jamiat.end_date') }}" id='end_date'
                    name='end_date' />

                <x-textarea type='textarea' label="{{ __('jamiat.description') }}" id='description'
                    name='description' />


                <div class="d-flex justify-content-between bg-light mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}</button>
                    <x-btn-save type='button' id='save-btn' />
                </div>
            </form>
        </div>
    </x-modal>
    @push('scripts')
        <script>
            const saveBtn = $('#save-btn');

            function openCreateModal() {
                $('#create-modal').modal('show');
            }



            $(document).ready(function() {



                $('#create-form').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);


                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.exam.store') }}",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            "Accept": "application/json"
                        },
                        success: function(response) {
                            console.log(response);


                            $('#create-form')[0].reset();
                            // $('#patient_id').val(null).trigger('change'); // Reset Select2
                            location.reload();


                            toastr["success"](response.message);
                            $("#create-modal").modal('hide');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON)

                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '-error').removeClass('d-none').text(
                                        value[0]);
                                });
                            } else if (xhr.status === 401) {
                                console.error('Unauthorized:', xhr);
                            } else {
                                console.error('XHR Error:', xhr);
                            }
                        }
                    });
                });

                $("#province_id").change(function() {
                    $.ajax({
                        url: "{{ route('load-districts') }}",
                        method: 'GET',
                        data: {
                            'province_id': $("#province_id").val(),
                        },
                        success: function(response) {
                            $("#district_id").html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app>
