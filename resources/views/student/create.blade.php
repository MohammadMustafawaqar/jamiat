<x-app :title="__('sidebar.add_students')">
    <x-page-nav :title="__('sidebar.add_students')" icon='add'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>

        <li class="breadcrumb-item"><a href="{{ route('admin.student.form.commission') }}">{{ __('lang.students') }}</a></li>
        <li class="breadcrumb-item"><span>{{ __('lang.first_form') }}</span></li>
    </x-page-nav>

    <div class="container-fluid" style="min-height: 70vh">
        <div class="pre-student-form-card" id='pre-form'>
            <div class="pre-student-form-card-header">
                <h2 class="pre-student-form-card-title">{{ __('jamiat.pre_form_title') }}</h2>
            </div>
            <form action="{{ route('admin.student.form.second') }}" method="GET">

                <div class="pre-student-form-card-body">
                    <div class="form-group mt-3">
                        <label class='form-label fs-5'>{{ __('jamiat.form_type') }}:</label>
                        <div class="">
                            {{-- <input class="btn-check" type="radio" name="form_type" id="commission" value="commission"
                                checked>
                            <label class="btn btn-outline-primary" for="commission">
                                {{ __('jamiat.commission') }}
                            </label>

                            <input class="btn-check" type="radio" name="form_type" id="evaluation" value="evaluation">
                            <label class="btn btn-outline-primary" for="evaluation">
                                {{ __('jamiat.evaluation') }}
                            </label>

                            <input class="btn-check" type="radio" name="form_type" id="rajab" value="rajab">
                            <label class="btn btn-outline-primary" for="rajab">
                                {{ __('jamiat.rajab') }}
                            </label> --}}
                            @foreach ($forms as $form)
                                @if($form->id == 1)
                                @canany(['students.create', 'students.create.commission'])  
                                <span class="" id='form-{{ $form->id }}-container'>
                                    <input class="btn-check" type="radio" name="form_type"
                                        id="form-{{ $form->id }}" value="{{ $form->id }}"
                                        @checked(auth()->user()->can('students.create.commission') || auth()->user()->can('students.create'))>
                                    <label class="btn btn-outline-primary" for="form-{{ $form->id }}">
                                        {{ __('jamiat.'.$form->form_type ) }}
                                    </label>
                                </span>
                                @endcanany
                                @elseif ($form->id == 2)
                                @canany(['students.create', 'students.create.evaluation'])  
                                <span class="" id='form-{{ $form->id }}-container'>
                                    <input class="btn-check" type="radio" name="form_type"
                                        id="form-{{ $form->id }}" value="{{ $form->id }}"
                                        @checked(auth()->user()->can('students.create.evaluation') && auth()->user()->cannot('students.create'))>
                                    <label class="btn btn-outline-primary" for="form-{{ $form->id }}">
                                        {{ __('jamiat.'.$form->form_type ) }}
                                    </label>
                                </span>
                                @endcanany
                                @elseif ($form->id == 3)
                                @canany(['students.create', 'students.create.rajab'])  

                                <span class="" id='form-{{ $form->id }}-container'>
                                    <input class="btn-check" type="radio" name="form_type"
                                        id="form-{{ $form->id }}" value="{{ $form->id }}"
                                        @checked(auth()->user()->can('students.create.rajab') && auth()->user()->cannot('students.create'))>
                                    <label class="btn btn-outline-primary" for="form-{{ $form->id }}">
                                        {{ __('jamiat.'.$form->form_type ) }}
                                    </label>
                                </span>
                                @endcanany
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class='form-label fs-5 '>{{ __('lang.address_type') }}:</label>
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

                    <div class="form-group mt-3">
                        <label class="form-label fs-5">{{ __('jamiat.exam_grade') }}:</label>
                        <div>
                            @foreach (JamiaHelper::grades() as $grade)
                                <span class="" id='grade-{{ $grade->id }}-container'>
                                    <input class="btn-check" type="radio" name="exam_grade"
                                        id="grade-{{ $grade->id }}" value="{{ $grade->id }}"
                                        @checked($grade->id == 1)>
                                    <label class="btn btn-outline-primary" for="grade-{{ $grade->id }}">
                                        {{ $grade->name }} ({{ $grade->equivalent }})
                                    </label>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    {{-- <x-select :options="$exams" :label="__('sidebar.exams')" value='id' display='title' id='exam_id'
                        name='exam_id' col='col-sm-4 mt-3 fs-5' class="select2" /> --}}
                </div>
                <div class="row">
                </div>

                <div class="pre-student-form-card-footer d-flex justify-content-between bg-light p-2 mb-2">
                    <x-btn-back route="students.index" />
                    <button class="btn btn-info">
                        {{ Settings::trans('Next', 'وروستې پاڼه', 'صفحه بعدي') }}
                        <i class="fa fa-arrow-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('admin/select2/js/select2.full.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {



                $(document).ready(function() {
                    $("input[name='form_type']").on("change", function(e) {
                        value = $('input[name="form_type"]:checked').val();
                        if (value == 3) {
                            $("#grade-3-container").hide();
                        } else {
                            $("#grade-3-container").show();
                        }

                    })
                });
            });
            $(".select2").select2({
                placeholder: "{{ __('lang.select_option') }}",
                theme: "bootstrap-5"
            });
        </script>
    @endpush
</x-app>
