<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AcademyRequest;
use App\Http\Resources\AcademyResource;
use App\Models\Academy;
use App\OpenApi\Controllers\AcademyControllerDoc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @see AcademyControllerDoc for API documentation
 */
class AcademyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Academy::query();
        
        if ($request->has('active')) {
            $query->where('active', $request->boolean('active'));
        }
        if ($request->boolean('with_courses')) {
            $query->with(['courses' => function($courseQuery) {
                $courseQuery->where('active', true);
            }]);
        }
        
        if ($request->boolean('with_counts')) {
            $query->withCount(['courses' => function($courseQuery) {
                $courseQuery->where('active', true);
            }]);
        }
        
        $academies = $query->paginate($request->input('per_page', 15));
        
        return AcademyResource::collection($academies);
    }

    public function store(AcademyRequest $request): JsonResponse
    {
        $academy = Academy::create($request->validated());
        
        return (new AcademyResource($academy))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Academy $academy): AcademyResource
    {
        if ($request->boolean('with_courses')) {
            $academy->load(['courses' => function($query) {
                $query->where('active', true);
            }]);
        }
        
        if ($request->boolean('with_counts')) {
            $academy->loadCount(['courses' => function($query) {
                $query->where('active', true);
            }]);
        }
        
        return new AcademyResource($academy);
    }

    public function update(AcademyRequest $request, Academy $academy): AcademyResource
    {
        $academy->update($request->validated());
        
        return new AcademyResource($academy);
    }

    public function destroy(Academy $academy): JsonResponse
    {
        $academy->delete();
        
        return response()->json(null, 204);
    }
}
