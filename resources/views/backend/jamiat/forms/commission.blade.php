<x-app :title="__('sidebar.commission_form')">

    <x-page-nav :title="__('sidebar.commission_form')" icon='file'>
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
                        <button class="btn btn-primary" id="show-form-btn">
                            <i class="fa fa-add" id="add-icon"></i>
                        </button>
                        <button class="btn btn-danger" id="hide-form-btn" style="display: none">
                            <i class="fa fa-close" id="close-icon"></i>
                        </button>
                    @endcan

                </div>
            </div>
            <div class="row" style="display: none" id="form-generate-container">
                <form action="{{ route('admin.forms.commission.create') }}" class="row">
                    <x-input col='col-sm-4' type='number' id="start_range" name='start_range' :label="__('jamiat.start_range')" />
                    <x-input col='col-sm-4' type='number' id="end_range" name='end_range' :label="__('jamiat.end_range')" />

                    <div class="col-sm-2 mt-4">
                        <div class="btn-group">
                            <button class="btn btn-success">
                                {{ __('jamiat.generate') }}
                            </button>
                        </div>
                    </div>
                </form>
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
                        <th>{{ __('lang.form_id') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('jamiat.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentForms as $form)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $form->serial_number }}
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $form->status }}!</span>

                            </td>
                            <td>
                                <div class="dropdown open">
                                    @can('exam.delete')
                                        <x-buttons.delete :route="route('admin.forms.rajab.destroy', $form->id)" />
                                    @endcan
                                    @can('exam.edit')
                                        <button class="btn btn-sm btn-warning"
                                            onclick="openEditModal({{ $form }})">
                                            <i class="fa fa-edit"></i>
                                        </button>
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
    <x-modal id='create-modal' :title="__('jamiat.add_exam')" size='lg'>
        <div class="container-fluid">
            <form id='create-form' class="row" method="POST">
                @csrf



                <div class="d-flex justify-content-between bg-light mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}</button>
                    <x-btn-save type='button' id='save-btn' />
                </div>
            </form>
        </div>
    </x-modal>
    <x-modal id='edit-modal' :title="__('jamiat.add_exam')" size='lg'>
        <div class="container-fluid">
            <form id='edit-form' class="row" method="POST">
                @csrf



                <div class="d-flex justify-content-between bg-light mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ Settings::trans('Close', 'بند کړئ', 'لغوه') }}
                    </button>
                    <x-btn-save type='button' id='edit-btn' />
                </div>
            </form>
        </div>
    </x-modal>
    @push('scripts')
        <script>
            $("#show-form-btn").on('click', function(e){
                e.preventDefault();
                $("#form-generate-container").slideDown();
                $(this).hide();
                $("#hide-form-btn").show();
                
            });
            
            $("#hide-form-btn").on('click', function(e){
                e.preventDefault();
                $("#form-generate-container").slideUp();
                $("#show-form-btn").show();
                $(this).hide();
            });

        </script>
    @endpush
</x-app>
