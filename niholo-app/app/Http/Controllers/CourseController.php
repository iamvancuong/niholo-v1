<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('lessons')->get();
        
        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    public function show(Course $course)
    {
        return Inertia::render('Courses/Show', [
            'course' => $course
        ]);
    }
}
