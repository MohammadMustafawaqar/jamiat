<x-app :title="__('lang.schools')">

    <x-page-nav :title="__('sidebar.exams')" icon='clipboard'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('lang.schools') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container">
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


            <div class="container-fluid">
                <div class="">
                    <div class="btn-group">
                        @can('schools.create')
                            <x-buttons.modal modal="myModal" text="<i class='bi bi-plus'></i>" />
                        @endcan
                        @can('schools.create')
                            <x-buttons.modal type='success' modal="import-modal" text="<i class='fa fa-file-excel'></i>" />
                        @endcan
                        <button class="btn btn-sm btn-info" id="btn-filter" title='filter'>
                            <i class="fa fa-search"></i>
                        </button>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <form class="row" action="{{ route('schools.index') }}" id='filter-container'
                        style="{{ isset($_GET['filter_name']) ? '' : 'display: none' }}">
                        <x-input2 type="text" name='filter_name' :label="__('jamiat.school_name')" col='col-sm-3' />

                        <x-select2 col="col-sm-3" :list="App\Models\AddressType::get()" id='filter_address_type_id' text="name"
                            value='id' name="filter_address_type_id" :label="__('lang.address_type')" />

                        <x-select2 col="col-sm-3" :list="App\Models\Country::get()" id='filter_country_id' text='name' value='id'
                            name="filter_country_id" :label="__('lang.country')" :required="1" />
                        <x-select2 :list="old('filter_country_id')
                            ? App\Models\Country::find(old('filter_country_id'))->provinces
                            : App\Models\Country::where('name', 'افغانستان')->first()->provinces" id='filter_province_id' name="filter_province_id" :label="__('lang.province')"
                            :required="1" col="col-sm-3" text='name' value='id' />

                        <x-select2 :list="App\Models\Province::find(14)->districts" id='filter_district_id' name="filter_district_id"
                            :label="__('lang.district')" :required="1" col="col-sm-3" text='name' value='id' />

                        <x-input type="text" name='filter_village' :label="__('jamiat.village')" col='col-sm-3' />

                        <div class="col-sm-4 mt-4">
                            <div class="btn-group">
                                <x-btn-filter type='submit' />
                                <x-btn-reset :route="route('schools.index')" />
                            </div>
                        </div>


                        <div class="form-group col-sm-9 mt-3">
                            <label for="">{{ __('jamiat.jamiat_grade') }}:</label>
                            @foreach (JamiaHelper::grades() as $grade)
                                <div class="form-check form-check-inline">
                                    <x-checkbox claases='form-check-input' name='filter_grades[]'
                                        value='{{ $grade->id }}' id='grade-{{ $grade->id }}'
                                        label='{{ $grade->name }}' :checked="isset($_GET['filter_grades']) &&
                                            in_array($grade->id, $_GET['filter_grades'])" />
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>

                <x-table>
                    <x-slot:tools>


                    </x-slot:tools>
                    @can('schools.read')
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{ __('lang.name') }}</th>
                                <th>{{ __('jamiat.jamiat_grade') }}</th>
                                <th>{{ __('lang.address_type') }}</th>
                                <th>{{ __('lang.country') }}</th>
                                <th>{{ __('lang.province') }}</th>
                                <th>{{ __('lang.district') }}</th>
                                <th>{{ __('lang.village') }}</th>
                                <th>{{ __('lang.details') }}</th>
                                <th>{{ __('lang.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $school)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $school->name }}</td>
                                    <td>
                                        @foreach ($school->grades as $grade)
                                            <span class="badge bg-primary">{{ $grade->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $school->addressType->name }}</td>
                                    <td>{{ $school->province?->country?->name }}</td>
                                    <td>{{ $school->province?->name }}</td>
                                    <td>{{ $school->district?->name }}</td>
                                    <td>{{ $school->village }}</td>
                                    <td>{{ $school->details }}</td>
                                    <td>
                                        <div class="btn-group" dir="ltr">
                                            @can('schools.edit')
                                                {{-- <x-buttons.edit :route="route('schools.edit', $school)" /> --}}
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="openEditModal({{ $school }})">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endcan
                                            @can('schools.delete')
                                                <x-buttons.delete :route="route('schools.destroy', $school)" />
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <x-slot:links>
                            {{ $schools->links() }}
                        </x-slot:links>
                    @endcan
                </x-table>

            </div>

            @can('schools.create')
                <!-- New Modal -->
                <x-modal id="myModal" title="<i class='bi bi-plus'></i>{{ __('lang.school') }}">
                    <form action="{{ route('schools.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="option">{{ __('lang.address_type') }}:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="address_type_id" id="interior"
                                    value="1" checked>
                                <label class="form-check-label" for="interior">
                                    {{ __('jamiat.interior') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="address_type_id" id="exterior"
                                    value="2">
                                <label class="form-check-label" for="exterior">
                                    {{ __('jamiat.exterior') }}
                                </label>
                            </div>
                        </div>
                        <x-input name="name" :label="__('lang.name')" :required="1" />

                        <div class="form-group">
                            <label for="" class="d-block">{{ __('jamiat.jamiat_grade') }}:</label>
                            @foreach (JamiaHelper::grades() as $grade)
                                <div class="form-check form-check-inline">
                                    <x-checkbox classes='form-check-input' name='grades[]' value='{{ $grade->id }}'
                                        id='grade-{{ $grade->id }}' label='{{ $grade->name }}' />
                                </div>
                            @endforeach
                            @error('grades')
                                <div class="text-danger" id="grades-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- <x-select col="col-6" :options="App\Models\AddressType::get()" :label="__('lang.address_type')" :required="1" id='type_id' class='select2' :selected='1' /> --}}
                            <div class="col-6" id='country_container' style="display: none">
                                <x-select col="col-12" class="select2" :options="App\Models\Country::get()" name="country_id"
                                    id='country_id' name="country_id" :label="__('lang.country')" :required="1" />
                            </div>
                            <x-select :options="old('country_id')
                                ? App\Models\Country::find(old('country_id'))->provinces
                                : App\Models\Country::where('name', 'افغانستان')->first()->provinces" col="col-6" id='province_id' name="province_id"
                                :label="__('lang.province')" :required="1" class="select2" />

                            <x-select :options="old('province_id')
                                ? App\Models\Province::find(old('province_id'))->districts
                                : collect()" col="col-6" id='district_id' name="district_id"
                                :label="__('lang.district')" :required="1" class="select2" />
                        </div>

                        <x-input type="text" name="village" id='village' :label="__('jamiat.village')" />

                        <x-input type="textarea" name="details" :label="__('lang.details')" />
                        <x-buttons.save />
                    </form>
                </x-modal>
            @endcan

            @can('schools.edit')
                <!-- New Modal -->
                <x-modal id="edit-modal" title="<i class='bi bi-plus'></i>{{ __('lang.school') }}">
                    <form action="{{ route('schools.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="option">{{ __('lang.address_type') }}:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_address_type_id"
                                    id="edit_interior" value="1" checked>
                                <label class="form-check-label" for="edit_interior">
                                    {{ __('jamiat.interior') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_address_type_id"
                                    id="edit_exterior" value="2">
                                <label class="form-check-label" for="edit_exterior">
                                    {{ __('jamiat.exterior') }}
                                </label>
                            </div>
                        </div>
                        <x-input name="name" id='edit_name' :label="__('lang.name')" :required="1" />

                        <div class="form-group">
                            <label class="d-block">{{ __('jamiat.jamiat_grade') }}:</label>
                            @foreach (JamiaHelper::grades() as $grade)
                                <div class="form-check form-check-inline">
                                    <x-checkbox classes='form-check-input' name='grades[]' value='{{ $grade->id }}'
                                        id='edit_grade-{{ $grade->id }}' label='{{ $grade->name }}' />
                                </div>
                            @endforeach
                            @error('grades')
                                <div class="text-danger" id="grades-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- <x-select col="col-6" :options="App\Models\AddressType::get()" :label="__('lang.address_type')" :required="1" id='type_id' class='select2' :selected='1' /> --}}
                            <div class="col-6" id='edit_country_container' style="display: none">
                                <x-js-select2 col="col-12" :list="App\Models\Country::get()" name="country_id"  text="name" value='id'
                                    id="edit_country_id" :label="__('lang.country')" :required="1" modal_id='edit-modal' />
                            </div>
                            <x-js-select2 :list="App\Models\Province::get()" col="col-6" id='edit_province_id' name="province_id" value='id' text='name'
                                :label="__('lang.province')" :required="1" modal_id='edit-modal' />

                            <x-js-select2 :list="App\Models\District::get()" col="col-6" id='edit_district_id' name="district_id"
                                value='id' text='name'
                                :label="__('lang.district')" :required="1" modal_id='edit-modal' />
                        </div>

                        <x-input type="text" name="village" id='edit_village' :label="__('jamiat.village')" />

                        <x-input type="textarea" name="details" id='edit_details' :label="__('lang.details')" />
                        <x-buttons.save />
                    </form>
                </x-modal>
            @endcan
            <x-modal id='import-modal' :title="__('jamiat.import_from_excel')" size='md'>
                <div class="container-fluid">
                    <form id='import-form' action="{{ route('admin.school.import.excel') }}" class="row"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-input type="file" name='excel_file' :label="__('jamiat.select_excel_file')" />


                        <div class="d-flex justify-content-between bg-light mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}</button>
                            <x-btn-save type='button' id='save-btn' />
                        </div>
                    </form>
                </div>
            </x-modal>
        </div>
    </x-page-container>




    @push('scripts')
        <script src="{{ asset('admin/select2/js/select2.full.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/js/plugins/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript">
            let school_id = null;

            function openEditModal(school) {
                school_id = school.id;
                $("#edit_name").val(school.name)
                if (school.address_type_id == 1) {
                    $("#edit_interior").prop('checked', true)
                    $("#edit_country_container").hide();

                } else {
                    $("#edit_country_container").show();
                    $("#edit_exterior").prop('checked', true);

                }
                school.grades.map((grade) => {
                    $("#edit_grade-" + grade.id).prop('checked', true);
                })
                $("#edit_country_id").val(school.province.country_id).trigger('change');
                console.log(school.province.country_id)

                $("#edit_province_id").val(school.province_id).trigger('change');
                $("#edit_district_id").val(school.district_id).trigger('change');
                $("#edit_village").val(school.village);
                $("#edit_details").val(school.details);
                $("#edit-modal").modal('show');
            }

            $(document).ready(function() {

                $("#btn-filter").click(function() {
                    $("#filter-container").toggle();
                });
                $("input[name='address_type_id']").change(function() {
                    if ($("#interior").is(":checked")) {
                        $("#country_container").hide();
                    } else if ($("#exterior").is(":checked")) {
                        $("#country_container").show();
                        $("#village").attr('col', 'col-sm-6')
                    }
                });
                $("input[name='edit_address_type_id']").change(function() {
                    if ($("#edit_interior").is(":checked")) {
                        $("#edit_country_container").hide();
                    } else if ($("#edit_exterior").is(":checked")) {
                        $("#edit_country_container").show();
                        $("#edit_village").attr('col', 'col-sm-6')
                    }
                });

            });


            $('.data-table').DataTable();
            $("th").addClass('text-end');
            $("#myModal").on("shown.bs.modal", function() {
                $("#name").focus();
            });
            @if ($errors->any())
                const myModal = new bootstrap.Modal("#myModal", {
                    keyboard: false
                });
                myModal.show();
            @endif
            $(".select2").select2({
                placeholder: "{{ __('lang.select_option') }}",
                theme: "bootstrap-5",
                dropdownParent: $("#myModal")
            });

            $("#country_id").change(function() {
                const country_id = $("#country_id").val()
                loadProvinces(country_id, 'province_id');
            });

            $("#province_id").change(function() {
                const province_id = $("#province_id").val()
                loadDistricts(province_id, 'district_id');
            });

            // Edit modal data fetch
            // $("#edit_country_id").change(function() {
            //     const country_id = $("#edit_country_id").val()
            //     loadProvinces(country_id, 'edit_province_id');
            // });

            // $("#edit_province_id").change(function() {
            //     const province_id = $("#edit_province_id").val()
            //     loadDistricts(province_id, 'edit_district_id');
            // });

            $("#filter_country_id").change(function() {
                const country_id = $("#filter_country_id").val()
                loadProvinces(country_id, 'filter_province_id');
            });

            $("#filter_province_id").change(function() {
                const province_id = $("#filter_province_id").val()
                loadDistricts(province_id, 'filter_district_id');
            });



            function loadProvinces(country_id, target_el_id) {
                $.ajax({
                    url: "{{ route('load-provinces') }}",
                    method: 'GET',
                    data: {
                        'country_id': country_id,
                    },
                    success: function(response) {
                        $("#" + target_el_id).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function loadDistricts(province_id, target_el_id) {
                $.ajax({
                    url: "{{ route('load-districts') }}",
                    method: 'GET',
                    data: {
                        'province_id': province_id,
                    },
                    success: function(response) {

                        $("#" + target_el_id).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        </script>
    @endpush

</x-app>
