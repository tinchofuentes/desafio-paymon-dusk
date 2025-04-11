<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\OpenApi\Controllers\CourseControllerDoc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @see CourseControllerDoc for API documentation
 */
class CourseController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Course::query();
        
        if ($request->has('academy_id')) {
            $query->where('academy_id', $request->input('academy_id'));
        }
        
        if ($request->has('active')) {
            $query->where('active', (bool) $request->active);
        }
        
        if ($request->boolean('with_academy')) {
            $query->with('academy');
        }
        
        if ($request->boolean('with_counts')) {
            $query->withCount('enrollments');
        }
        
        $courses = $query->paginate($request->input('per_page', 15));
        
        return CourseResource::collection($courses);
    }

    public function store(CourseRequest $request): JsonResponse
    {
        $course = Course::create($request->validated());
        
        return (new CourseResource($course))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Course $course): CourseResource
    {
        if ($request->boolean('with_academy')) {
            $course->load('academy');
        }
        
        if ($request->boolean('with_counts')) {
            $course->loadCount('enrollments');
        }
        
        return new CourseResource($course);
    }

    public function update(CourseRequest $request, Course $course): CourseResource
    {
        $course->update($request->validated());
        
        return new CourseResource($course);
    }

    public function destroy(Course $course): JsonResponse
    {
        $course->delete();
        
        return response()->json(null, 204);
    }
}
