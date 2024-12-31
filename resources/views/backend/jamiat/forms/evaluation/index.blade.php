<x-app :title="__('sidebar.evaluation_forms')">

    <x-page-nav :title="__('sidebar.evaluation_forms')" icon='file'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('sidebar.forms') }}</li>
    </x-page-nav>
    <x-page-container>
        <div class="container">

            <div class="row">
                <div class="col-12">
                    @can('form.evaluation.create')
                        <button class="btn btn-primary" id="show-form-btn">
                            <i class="fa fa-add" id="add-icon"></i>
                        </button>
                        <button class="btn btn-danger" id="hide-form-btn" style="display: none">
                            <i class="fa fa-close" id="close-icon"></i>
                        </button>
                    @endcan

                </div>
            </div>
            <div class="row" style="@if (!$errors->any()) display: none @endif"
                id="form-generate-container">
                @can('form.evaluation.create')
                    <form action="{{ route('admin.forms.evaluation.store') }}" method="POST" class="row"
                        target="_blank">
                        @csrf

                        <x-select2 name="shamsi_year" id="shamsi_year" value="year" text="year" :list="$shamsiYears"
                            col="col-sm-2" :selected_value="old('shamsi_year')" :label="__('jamiat.shamsi_year')" required="1" />

                        <x-select2 name="qamari_year" id="qamari_year" value="year" text="year" :list="$qamariYears"
                            col="col-sm-2" :selected_value="old('qamari_year')" :label="__('jamiat.qamari_year')" required="1" />

                        <x-select2 id="address_type_id" name="address_type_id" :list="\App\Models\AddressType::get()" text="name"
                            value="id" :label="__('lang.address_type')" col="col-sm-2" />

                        <x-select2 id="grade_id" name="grade_id" :list="JamiaHelper::grades()" text="name" value="id"
                            :label="__('jamiat.grade_name')" col="col-sm-2" />

                        <x-input col='col-sm-2' type='number' id="start_range" name='start_range' :label="__('jamiat.start_range')"
                            :min="$highestSerialNumber" :value="$highestSerialNumber" />
                        <x-input col='col-sm-2' type='number' id="end_range" name='end_range' :label="__('jamiat.end_range')"
                            :min="$highestSerialNumber" />

                        <div class="col-sm-2 mt-4">
                            <div class="btn-group">
                                <button class="btn btn-success">
                                    {{ __('jamiat.generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
            <div class="clearfix"></div>

            <hr>
            <x-table id='doctorTable'>
                <x-slot:tools>
                    <div></div>
                    @can('form.evaluation.print many')
                    <form action="{{ route('admin.forms.evaluation.print.many') }}" method="GET" id='print-many-form'
                        target="_blank">
                        <input type="hidden" id="stud_form_ids" name="stud_form_ids">
                        <button class="btn btn-info btn-sm" id="form-print-btn">
                            <i class="fa fa-print"></i>
                            {{ Settings::trans('Print', 'پرنټ', 'پرنت') }}
                        </button>
                    </form>
                    @endcan
                </x-slot:tools>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>{{ __('jamiat.no') }}</th>
                        <th>{{ __('jamiat.exam_grade') }}</th>
                        <th>{{ __('lang.address_type') }}</th>
                        <th>{{ __('lang.form_id') }}</th>
                        <th>{{ __('jamiat.shamsi_year') }}</th>
                        <th>{{ __('jamiat.qamari_year') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentForms as $form)
                        <tr>
                            <td>
                                <input type="checkbox" name="stu_form_ids[]" value="{{ $form->id }}"
                                    class="stud_form-checkbox">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $form->grade?->name }}
                            </td>
                            <td>
                                <span class="badge bg-secondary"> {{ $form->addressType?->name }}</span>

                            </td>
                            <td>
                                {{ $form->formatted_serial_number }}
                            </td>
                            <td>
                                {{ $form->shamsi_year }}
                            </td>
                            <td>
                                {{ $form->qamari_year }}
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    جدید
                                </span>

                            </td>
                            <td>
                                <div class="btn-group">
                                    @can('form.evaluation.delete')
                                        <x-buttons.delete :route="route('admin.forms.evaluation.destroy', $form->id)" />
                                    @endcan

                                    @can('form.evaluation.show')
                                        <x-btn-print route="admin.forms.evaluation.show" :params="[
                                            'evaluation' => $form->id,
                                            'locale' => app()->getLocale(),
                                        ]" />
                                    @endcan

                                    @can('form.evaluation.add student')
                                        <a href="{{ route('admin.forms.evaluation.create-student', $form->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-user"></i>
                                            فاضل اضافه کړئ
                                        </a>
                                    @endcan
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <x-slot:links>
                    {{ $studentForms->links() }}
                </x-slot:links>
            </x-table>

        </div>
    </x-page-container>
    @push('scripts')
        <script>
            function toggleGenerateButton() {
                const isAnyChecked = $('.stud_form-checkbox:checked').length > 1;
                $('#form-print-btn').toggle(isAnyChecked);
            }

            $("#form-print-btn").on('click', function() {
                const selectedIds = $('.stud_form-checkbox:checked').map(function() {
                    return this.value;
                }).get();

                $('#stud_form_ids').val(selectedIds);

                $("#print-many-form").submit();

            });

            $(document).ready(function() {
                toggleGenerateButton();
            });

            $('#select-all').on('change', function() {
                $('.stud_form-checkbox').prop('checked', $(this).is(':checked'));
                toggleGenerateButton();
            });

            $('.stud_form-checkbox').on('change', function() {
                toggleGenerateButton();
            });

            $("#show-form-btn").on('click', function(e) {
                e.preventDefault();
                $("#form-generate-container").slideDown();
                $(this).hide();
                $("#hide-form-btn").show();

            });

            $("#hide-form-btn").on('click', function(e) {
                e.preventDefault();
                $("#form-generate-container").slideUp();
                $("#show-form-btn").show();
                $(this).hide();
            });
        </script>
    @endpush
</x-app>
