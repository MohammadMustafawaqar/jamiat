<x-app :title="__('jamiat.classes')">

    <x-page-nav :title="__('jamiat.classes')" icon='house'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item"><span>{{ __('lang.setting') }}</span></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.campus.index') }}">{{ __('sidebar.campuses') }}</a></li>
        <li class="breadcrumb-item">{{ __('jamiat.classes') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container">

            <div class="row">
                <div class="col-12">
                    @can('exam_centers.create')
                        <button class="btn btn-primary" onclick="openCreateModal()">
                            <i class="fa fa-add"></i>
                        </button>
                    @endcan

                </div>


            </div>
            <div class="clearfix"></div>
            <hr>

            <x-table>
                <x-slot:tools>
                    <div class="container">

                    </div>
                </x-slot:tools>
                <thead>
                    <tr>
                        <th>{{ __('jamiat.no') }}</th>
                        <th>{{ __('jamiat.name') }}</th>
                        {{-- <th>{{ __('jamiat.capacity') }}</th> --}}
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $class->name }}
                            </td>
                            {{-- <td>
                                {{ $class->capacity }}
                            </td> --}}
                            <td>
                                <div class="btn-group">
                                    @can('exam_centers.delete')
                                        <x-buttons.delete :route="route('admin.settings.classes.destroy', [
                                            'class' => $class->id,
                                            'locale' => '',
                                            'campus_id' => $class->campus_id,
                                        ])" />
                                    @endcan
                                    @can('exam_centers.edit')
                                        <button class="btn btn-sm btn-warning"
                                            onclick="openEditModal({{ $class->id }})">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    @endcan
                                    @can('exam_centers.show')
                                        <a href="{{ route('admin.settings.sub-classes.index', $class->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endcan
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <x-slot:links>
                    {{ $classes->links() }}
                </x-slot:links>
            </x-table>
        </div>
    </x-page-container>
    <x-modal id='create-modal' :title="__('jamiat.add_class')" size='md'>
        <div class="container-fluid">
            <form id='create-form' class="row" method="POST">
                @csrf

                <x-input2 type='text' label="{{ __('jamiat.name') }}" id='name' name='name' />
                {{-- <x-input2 type='text' label="{{ __('jamiat.capacity') }}" id='capacity' name='capacity' /> --}}

                <div class="d-flex justify-content-between bg-light mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}</button>
                    <x-btn-save type='button' id='save-btn' />
                </div>
            </form>
        </div>
    </x-modal>
    <x-modal id='edit-modal' :title="__('jamiat.edit_class')" size='md'>
        <div class="container-fluid">
            <form id='edit-form' class="row" method="POST">
                @csrf

                <x-input2 type='text' label="{{ __('jamiat.name') }}" id='edit_name' name='name' />
                {{-- <x-input2 type='text' label="{{ __('jamiat.capacity') }}" id='edit_capacity' name='capacity' /> --}}

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
            let class_id;

            function openCreateModal() {
                $('#create-modal').modal('show');
            }


            function openEditModal(cl_id) {
                class_id = cl_id;

                $.ajax({
                    type: 'GET',
                    url: `{{ route('admin.settings.classes.edit', ['campus_id' => $campus->id, 'class' => ':class', 'locale' => '']) }}`
                        .replace(':class', class_id),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        "Accept": "application/json"
                    },
                    success: function(response) {
                        console.log(response);
                        console.log('called')
                        $("#edit_name").val(response.data.name);
                        $("#edit_capacity").val(response.data.capacity);
                        $("#edit-modal").modal('show');

                    },
                    error: function(xhr) {
                        console.log('called')

                        console.log(xhr)
                        console.log(xhr.responseJSON)
                    }
                });



            }


            $(document).ready(function() {
                $('#edit-form').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    formData.append("_method", 'PUT');


                    $.ajax({
                        type: 'POST',
                        url: `{{ route('admin.settings.classes.update', ['campus_id' => $campus->id, 'class' => ':class', 'locale' => '']) }}`
                            .replace(":class", class_id),
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            "Accept": "application/json"
                        },
                        success: function(response) {
                            console.log(response);

                            location.reload();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON)

                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    $('#edit_' + key).addClass('is-invalid');
                                    $('#edit_' + key + '-error').removeClass('d-none').text(
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


                $('#create-form').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);


                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.settings.classes.store', $campus->id) }}",
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
                            location.reload();


                            toastr.success(response.message, "{{ __('lang.success') }}")
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
