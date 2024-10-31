<x-app :title="__('sidebar.campuses')">

    <x-page-nav :title="__('sidebar.campuses')" icon='school-flag'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item"><span>{{ __('lang.setting') }}</span></li>
        <li class="breadcrumb-item">{{ __('sidebar.campuses') }}</li>
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
                        <th>{{ __('lang.province') }}</th>
                        <th>{{ __('jamiat.address') }}</th>
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campuses as $campus)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $campus->name }}
                            </td>
                            <td>
                                {{ $campus->province?->name }}
                            </td>
                            <td>
                                {{ $campus->address }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    @can('exam_centers.delete')
                                        <x-buttons.delete :route="route('admin.settings.campus.destroy', $campus->id)" />
                                    @endcan
                                    @can('exam_centers.show')
                                        <a href="{{ route('admin.settings.campus.show', $campus->id) }}"
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
                    {{ $campuses->links() }}
                </x-slot:links>
            </x-table>
        </div>
    </x-page-container>
    <x-modal id='create-modal' :title="__('jamiat.add_campus')" size='md'>
        <div class="container-fluid">
            <form id='create-form' class="row" method="POST">
                @csrf

                <x-input2 type='text' label="{{ __('jamiat.name') }}" id='name' name='name' />

                <x-js-select2 :list="App\Models\Country::where('name', 'افغانستان')->first()->provinces" col="col-6" id='province_id' name="province_id" :label="__('lang.province')"
                    col='col-sm-12' name='province_id' value='id' text='name' required modal_id="create-modal" />


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
                        url: "{{ route('admin.settings.campus.store') }}",
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
