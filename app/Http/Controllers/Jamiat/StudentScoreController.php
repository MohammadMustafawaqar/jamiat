<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\Exam;
use App\Models\Jamiat\ExamSubject;
use App\Models\Jamiat\StudentExam;
use App\Models\Jamiat\StudentExamSubject;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentScoreController extends Controller
{
    public function createMany(Request $request, $locale)
    {

        $exam_id = $request->exam_id;
        $exam = Exam::find($exam_id);

        $students = Student::whereIn('id', $request->student_ids)
            ->whereHas('studentExams', function ($query) use ($exam_id) {
                $query->where('exam_id', $exam_id);
            })
            ->orderBy('name')
            ->get();

        // Correctly retrieve and group scores
        $scores = StudentExamSubject::whereIn('exam_subject_id', $exam->subjects->pluck('pivot.id'))
            ->get()
            ->keyBy(function ($item) {
                return $item->exam_subject_id . '-' . $item->student_exam_id;
            });

        return view('backend.jamiat.student.Scores.create-many', [
            'exam' => $exam,
            'students' => $students,
            'scores' => $scores
        ]);
    }


    public function storeMany(Request $request, $locale, $exam_id)
    {
        $validated = $request->validate([
            'scores' => 'required|array',
            'scores.*.*' => 'nullable|numeric|min:0',
        ], attributes: [
            'scores.*.*' => __('jamiat.score'),
        ]);

        $exam = Exam::find($exam_id);

        // Initialize an array to store scores and the data to upsert
        $examSubjects = [];
        $studentsScores = [];

        // Step 1: Collect all the data to be inserted/updated
        foreach ($validated['scores'] as $ExamSubjectId => $students) {
            foreach ($students as $studentId => $score) {
                if (!is_null($score)) {
                    $student_exam = $exam->studentExams()->where('student_id', $studentId)->first();
                    // dd($studentId, $student_exam);
                    $exam_subject = ExamSubject::find($ExamSubjectId);
                    $min_score =  $exam_subject->subject->min_score;
                    $percentage =  $score * 100 / $exam_subject->subject->score;

                    $status = $min_score <= $score ? 'passed' : 'failed';
                    StudentExamSubject::updateOrCreate([
                        'exam_subject_id' => $ExamSubjectId,
                        'student_exam_id' => $student_exam->id
                    ], [
                        'score' => $score,
                        'status' => $status,
                    ]);

                    // Store or accumulate score for the student
                    if (!isset($studentsScores[$studentId])) {
                        $studentsScores[$studentId] = [
                            'total' => 0,
                            'count' => 0,
                            'percentage' => 0,
                            'passed_count' => 0

                        ];
                    }

                    // Accumulate score and count of subjects
                    $studentsScores[$studentId]['total'] += $score;
                    $studentsScores[$studentId]['count']++;
                    $studentsScores[$studentId]['percentage'] += $percentage;
                    $studentsScores[$studentId]['passed_count'] += $status == 'passed' ? 1 : 0;
                }
            }
        }

        // Step 2: Calculate sums and averages for students
        $sums = [];
        $averages = [];


        // Step 5: Update StudentExam model and assign score_avg and appreciation_id   

        $appreciations = $exam->appreciations->sortByDesc(function ($appreciation) {
            return $appreciation->pivot->min_score;  // Sort by min_score in descending order
        });

        foreach ($studentsScores as $studentId => $data) {
            $sums[$studentId] = $data['total'];
            $averages[$studentId] = $data['count'] > 0 ? $data['total'] / $data['count'] : 0;
            $percentage = $data['percentage'] / $data['count'];
            $passed_count = $data['passed_count'];

            $avgScore = $data['count'] > 0 ? $data['total'] / $data['count'] : 0;

            $appreciation = $appreciations->first(function ($appreciation) use ($percentage) {
                return $percentage >= $appreciation->pivot->min_score;
            });

            // Assign appreciation_id if appreciation exists, otherwise null
            $appreciationId = $appreciation && $passed_count >= $data['count']  ? $appreciation->id : null;

            // Update or create the StudentExam record with the calculated average score and appreciation_id
            StudentExam::updateOrCreate(
                ['student_id' => $studentId],
                [
                    'score_avg' => $percentage,
                    'appreciation_id' => $appreciationId
                ]
            );
            // dd($appreciation);
        }

        // Redirect back with a success message
        return redirect()->back()->with('msg', __('messages.record_submitted'));
    }
}
