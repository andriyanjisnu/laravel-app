<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    $student = new Student;
    //    $student->nama = $request->nama;
    //    $student->nrp = $request->nrp;
    //    $student->email = $request->email;
    //    $student->jurusan = $request->jurusan;

    //    $student->save();

    // Student::create([
    //     'nama' => $request->nama,
    //     'nrp' => $request->nrp,
    //     'email' => $request->email,
    //     'jurusan' => $request->jurusan
    // ]);

    $request->validate([
        'nama'=>'required',
        'nrp'=>'required|size:9',
        'email'=>'required|unique:students,email|email',
        'jurusan'=>'required'
        ],
        [
        'nama.required'=>'Nama harus diisi',
        'nrp.required'=>'NRP Harus diisi',
        'nrp.size'=>'NRP harus berjumlah 9 digit',
        'email.required'=>'Email harus diisi',
        'email.email'=>'Email tidak valid',
        'email.unique'=>'Email sudah terdaftar',
        'jurusan.required'=>'Jurusan harus diisi'
        ]
    );
    
    Student::create($request->all());
    return redirect('/students')->with('status','Data Mahasiswa Berhasil Ditambahkan!');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('students.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('students.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nama'=>'required',
            'nrp'=>'required|size:9',
            'email'=>'required|email',
            'jurusan'=>'required'
            ],
            [
            'nama.required'=>'Nama harus diisi',
            'nrp.required'=>'NRP Harus diisi',
            'nrp.size'=>'NRP harus berjumlah 9 digit',
            'email.required'=>'Email harus diisi',
            'email.email'=>'Email tidak valid',
            'jurusan.required'=>'Jurusan harus diisi'
            ]
        );
        
        Student::where('id', $student->id) 
                ->update([
                    'nama' => $request->nama,
                    'nrp' => $request->nrp,
                    'email' => $request->email,
                    'jurusan' => $request->jurusan
                ]);
        return redirect('/students')->with('status','Data Mahasiswa Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        Student::destroy($student->id);
        return redirect('/students')->with('status','Data Mahasiswa Berhasil Dihapus!');
    }
}
