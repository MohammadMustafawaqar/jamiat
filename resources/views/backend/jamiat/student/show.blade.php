<x-app :title="__('lang.students')">

    <x-page-nav :title="__('lang.students')" icon='users'>
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        &nbsp;
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a></li>
        <li class="breadcrumb-item">{{ __('lang.students') }}</li>
        <li class="breadcrumb-item">{{ $student->full_name }}</li>
    </x-page-nav>

    <x-page-container>
        <div class="container py-4">
            <!-- Profile Header -->
            <div class="card shadow-sm mb-4">
                <div class="row align-items-center p-4">
                    <div class="col-md-3 text-center">
                        <img class="img-fluid rounded-circle border" src="{{ asset($student->image_path) }}"
                            alt="{{ $student->full_name }}" style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <h4 class="text-primary">{{ $student->full_name }}</h4>
                        <p class="mb-1"><strong>{{ __('lang.father_name') }}:</strong> {{ $student->father_name }}</p>
                        <p class="mb-1"><strong>{{ __('lang.grand_father_name') }}:</strong>
                            {{ $student->grand_father_name }}</p>
                        <p class="mb-1"><strong>{{ __('lang.phone') }}:</strong> {{ $student->phone }}</p>
                        <p class="mb-0"><strong>{{ __('jamiat.tazkira_no') }}:</strong>
                            {{ $student->tazkira?->tazkira_no }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal"
                        type="button" role="tab" aria-controls="personal" aria-selected="true">
                        {{ __('lang.personal_info') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="exam-info-tab" data-bs-toggle="tab" data-bs-target="#exam-info"
                        type="button" role="tab" aria-controls="exam-info" aria-selected="false">
                        {{ __('jamiat.exam_info') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="exam-result-tab" data-bs-toggle="tab" data-bs-target="#exam-result"
                        type="button" role="tab" aria-controls="exam-result" aria-selected="false">
                        {{ __('jamiat.exam_result') }}
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-4" id="profileTabContent">
                <!-- Personal Information -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="card shadow-sm p-4">
                        <h5 class="text-primary mb-3">{{ __('lang.personal_info') }}</h5>
                        <div class="row mb-3">
                            <label class="col-sm-4 fw-bold">{{ __('lang.form_id') }}:</label>
                            <div class="col-sm-8 text-muted">{{ $student->form_id }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 fw-bold">{{ __('lang.permanent_address') }}:</label>
                            <div class="col-sm-8 text-muted">{{ $student->permanent_address }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 fw-bold">{{ __('lang.current_address') }}:</label>
                            <div class="col-sm-8 text-muted">{{ $student->current_address }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 fw-bold">{{ __('lang.dob') }}:</label>
                            <div class="col-sm-8 text-muted">{{ $student->dob }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 fw-bold">{{ __('lang.dob_qamari') }}:</label>
                            <div class="col-sm-8 text-muted">{{ $student->dob_qamari }}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 fw-bold">{{ __('lang.dob_shamsi') }}:</label>
                            <div class="col-sm-8 text-muted">{{ $student->dob_shamsi }}</div>
                        </div>
                    </div>
                </div>

                <!-- Exam Info -->
                <div class="tab-pane fade" id="exam-info" role="tabpanel" aria-labelledby="exam-info-tab">
                    <div class="card shadow-sm p-4">
                        <h5 class="text-primary mb-3">{{ __('jamiat.exam_info') }}</h5>
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('jamiat.exam') }}</th>
                                    <th>{{ __('jamiat.campus') }}</th>
                                    <th>{{ __('lang.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->exams as $exam)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $exam->title }}</td>
                                        <td>{{ $exam->studentExams()->where('student_id', $student->id)->first()?->subClass?->address }}
                                        </td>
                                        <td>
                                            {!! JamiaHelper::studentExamStatus(
                                                $exam->studentExams()->where('student_id', $student->id)->first()?->status,
                                            ) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Exam Results -->
                <div class="tab-pane fade" id="exam-result" role="tabpanel" aria-labelledby="exam-result-tab">
                    <div class="card shadow-sm p-4">
                        <h5 class="text-primary mb-3">{{ __('jamiat.exam_result') }}</h5>
                        @foreach ($student->exams as $exam)
                            <div class="table-responsive mb-4">
                                <table class="table table-striped border">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="4" class="table-primary">
                                                <h4>
                                                    {{ $exam->title }}
                                                </h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">{{ __('jamiat.subject') }}</th>
                                            <th>{{ __('jamiat.score') }}</th>
                                            <th>{{ __('lang.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exam->studentExams()->where('student_id', $student->id)->first()->studentExamSubjects as $subject)
                                            <tr>
                                                <td colspan="2">{{ $subject->subject->name }}</td>
                                                <td>{{ $subject->score }}</td>
                                                <td>{!! JamiaHelper::resultBadge($subject->status) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-success">
                                            <td><strong>{{ __('jamiat.percentage') }}</strong></td>
                                            <td>{{ $exam->studentExams()->where('student_id', $student->id)->first()?->score_avg }}%
                                            </td>
                                            <td><strong>{{ __('lang.appreciation') }}</strong></td>
                                            <td>
                                                {!! JamiaHelper::studentResultBadge(
                                                    $exam->studentExams()->where('student_id', $student->id)->first()?->appreciation
                                                ) !!}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>

</x-app>
