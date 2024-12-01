<x-app :title="__('lang.students')">
    <!-- Breadcrumb Navigation -->
    <x-page-nav :title="__('lang.students')" icon="users">
        <li class="breadcrumb-item">
            <i class="bi bi-house-door fs-6"></i>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">{{ __('lang.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('lang.students') }}</li>
    </x-page-nav>
    <link rel="stylesheet" href="{{ asset('admin/css/exam.css') }}">
    <!-- Main Page Content -->
    <x-page-container>
        <div class="container-fluid">
            <form method="POST" action="{{ route('admin.student.scores.many.store', $exam->id) }}">
                @csrf
                <div class="card shadow mb-4 border-0">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('jamiat.assign_scores') }}</h5>
                        <x-btn-save class="btn btn-light" />
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        @foreach ($students as $student)
                            <div class="student-section p-4 border rounded mb-4 bg-light d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="student-avatar me-4">
                                    @if ($student->profile_pic)
                                        <!-- If profile picture exists -->
                                        <img src="{{ $student->profile_pic }}" alt="{{ $student->full_name }}"
                                            class="rounded-circle shadow"
                                            style="width: 70px; height: 70px; object-fit: cover;">
                                    @else
                                        <!-- Placeholder Avatar with Initials -->
                                        <div class="placeholder-avatar rounded-circle shadow d-flex align-items-center justify-content-center bg-primary text-white"
                                            style="width: 70px; height: 70px; font-size: 0.65rem; font-weight: bold;">
                                            {{ $student->full_name }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Student Details -->
                                <div class="student-details flex-grow-1">
                                    <h4 class="fs-5 fw-bold text-primary mb-1">
                                        {{ $student->full_name }}
                                        <span class="text-muted">({{ $student->form_id }})</span>
                                    </h4>
                                    <p class="mb-0 text-secondary">
                                        {{ __('lang.father_name') }}: {{ $student->father_name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Subjects and Scores -->
                            <div class="row">
                                @foreach ($exam->subjects as $subject)
                                    @php
                                        $scoreKey = $subject->pivot->id . '-' . $student->id;
                                        $student_exam = $student
                                            ->studentExams()
                                            ->where('exam_id', $exam->id)
                                            ->first();
                                        $existingScore = $scores[$scoreKey]->score ?? null;
                                        $inputName = "scores[{$subject->pivot->id}][{$student_exam->id}]";
                                        $inputId = "score-{$subject->pivot->id}-{$student_exam->id}";
                                        dd($scoreKey, $existingScore, $inputName, $inputId);
                                    @endphp
                                    <div class="col-sm-4 col-md-3 col-lg-2 mb-3">
                                        <x-input type="number" label="{{ $subject->name }}"
                                            name="{{ $inputName }}" id="{{ $inputId }}"
                                            value="{{ $existingScore }}" col="col-12" required="1" />
                                        @error("scores.{$subject->pivot->id}.{$student_exam->id}")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </x-page-container>
</x-app>
