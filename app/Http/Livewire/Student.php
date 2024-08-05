<?php

namespace App\Http\Livewire;

use App\Models\Exam;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class Student extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $q = null;
    public $selectedStudent = [];
    public $selectedClass = null;

    public function mount($selectedExam = null)
    {
        if (is_null($selectedExam)) {
            $this->selectedStudent = [];
        } else {
            $this->selectedStudent = Exam::findOrFail($selectedExam)->users()->pluck('user_id')->toArray();
        }
       
    }

    public function deselectStudent($userId)
    {
        if (($key = array_search($userId, $this->selectedStudent)) !== false) {
            unset($this->selectedStudent[$key]);
        }
    }

    public function render()
    {
        $currentYear = now()->year; // Mendapatkan tahun saat ini

        // Mendapatkan kelas pengguna yang sedang login
        $userClass = auth()->user()->kelas;

        // Query untuk siswa
        $studentsQuery = User::role('student')
            ->whereYear('created_at', $currentYear) // Filter berdasarkan tahun saat ini
            ->where('kelas', $userClass) // Filter berdasarkan kelas pengguna yang login
            ->latest();

        if ($this->q != null) {
            $studentsQuery = $studentsQuery->where('name', 'like', '%' . $this->q . '%');
        }

        if ($this->selectedClass != null) {
            $studentsQuery = $studentsQuery->where('kelas', $this->selectedClass);
        }

        if (empty($this->selectedStudent)) {
            $students = $studentsQuery->paginate(5);
        } else {
            $students = $studentsQuery->whereNotIn('id', $this->selectedStudent)->paginate(5);
            $studentsAll = User::role('student')
                ->whereYear('created_at', $currentYear) // Filter berdasarkan tahun saat ini
                ->where('kelas', $userClass) // Filter berdasarkan kelas pengguna yang login
                ->latest()
                ->whereIn('id', $this->selectedStudent)
                ->get();
        }

        return view('livewire.student', [
            'students' => $students,
            'studentsAll' => $studentsAll ?? null,
        ]);
    }

    public function filter_kls(Request $request)
    {
              $kelas = $request->input('kelas');

              if(!empty($kelas)){
                $siswa_filter = User::role('student')->where('kelas', $kelas)->select(
                    'user.nama',
                    'user.kelas',
                )
                ->get();

                return view('livewire.student', compact('siswa_filter'));
              }
    }

}
