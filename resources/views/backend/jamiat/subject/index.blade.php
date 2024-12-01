<x-app :title="__('sidebar.subjects')">

    <x-page-nav :title="__('sidebar.subjects')" icon='book'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item"><span>{{ __('lang.setting') }}</span></li>
        <li class="breadcrumb-item">{{ __('sidebar.subjects') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container">

            <div class="row">
                <div class="col-12">
                    {{-- @can('exams.create') --}}

                    <button class="btn btn-primary" onclick="openCreateModal()">
                        <i class="fa fa-add"></i>
                    </button>
                    {{-- @endcan --}}

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
                        <th>{{ __('jamiat.subject_name') }}</th>
                        <th>{{ __('jamiat.score') }}</th>
                        <th>{{ __('jamiat.min_score') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $subject->name }}
                            </td>
                            <td>
                                {{ $subject->score }}
                            </td>
                            <td>{{ $subject->min_score }}</td>
                            <td>{{ $subject->status }}</td>
                            <td>
                                <div class="dropdown open">

                                    <x-buttons.delete  :route="route('admin.settings.subjects.destroy', $subject->id)"
                                        title="{{ __('lang.delete') }}" />
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <x-slot:links>
                    {{ $subjects->links() }}
                </x-slot:links>
            </x-table>
        </div>
    </x-page-container>
    <x-modal id='create-modal' :title="__('jamiat.add_subject')" size='md'>
        <div class="container-fluid">
            <form id='create-form' class="row" method="POST">
                @csrf

                <x-input2 type='text' label="{{ __('jamiat.ar_subject') }}" id='ar_name' name='ar_name' />
                <x-input2 type='text' label="{{ __('jamiat.pa_subject') }}" id='pa_name' name='pa_name' />
                <x-input2 type='text' label="{{ __('jamiat.da_subject') }}" id='da_name' name='da_name' />
                <x-input2 type='text' label="{{ __('jamiat.en_subject') }}" id='en_name' name='en_name' />
                <x-input2 type='text' label="{{ __('jamiat.score') }}" id='score' name='score' />
                <x-input2 type='text' label="{{ __('jamiat.min_score') }}" id='min_score' name='min_score' />

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
                        url: "{{ route('admin.settings.subjects.store') }}",
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
