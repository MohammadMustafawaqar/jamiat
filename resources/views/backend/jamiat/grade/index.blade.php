<x-app :title="__('jamiat.jamiat_grade')">

    <x-page-nav :title="__('jamiat.jamiat_grade')" icon='chart-simple'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item"><span>{{ __('lang.setting') }}</span></li>
        <li class="breadcrumb-item">{{ __('jamiat.jamiat_grade') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container">

            <div class="row">
                <div class="col-12">
                    @can('school_grade.create')

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
                        <th>{{ __('jamiat.grade_name') }}</th>
                        <th>{{ __('jamiat.equivalent') }}</th>
                        <th>{{ __('jamiat.description') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grades as $grade)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $grade->name }}
                            </td>
                            <td>
                                {{ $grade->equivalent }}
                            </td>
                            <td>{{ $grade->description }}</td>
                            <td>{{ $grade->status }}</td>
                            <td>
                                <div class="dropdown open">
                                    @can('school_grade.delete')

                                    <x-buttons.delete  :route="route('admin.settings.jamiat_grades.destroy', $grade->id)"
                                        title="{{ __('lang.delete') }}" />
                                        @endcan
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <x-slot:links>
                    {{ $grades->links() }}
                </x-slot:links>
            </x-table>
        </div>
    </x-page-container>
    <x-modal id='create-modal' title='Add New Doctor' size='md'>
        <div class="container-fluid">
            <form id='create-form' class="row" method="POST">
                @csrf

                <x-input2 type='text' label="{{ __('jamiat.grade_name') }}" id='name' name='name' />
                <x-input2 type='text' label="{{ __('jamiat.equivalent') }}" id='equivalent' name='equivalent' />

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
                        url: "{{ route('admin.settings.jamiat_grades.store') }}",
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
                            $('#patient_id').val(null).trigger('change'); // Reset Select2
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
            });
        </script>
    @endpush
</x-app>
