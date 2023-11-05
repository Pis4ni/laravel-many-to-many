<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::orderBy('label')->get();
        return view('admin.projects.create', compact('types','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $project = new Project;
        $project->fill($data);
        $project->slug = Str::slug($project->title);
        $project->save();
        if(Arr::exists($data,'cover_image')){
            $project->cover_image = Storage::put("uploads/projects/{$project->id}/cover_image",$data['cover_image']);
        }
        $project->save();
        if(Arr::exists($data, "technologies")) $project->technologies()->attach($data["technologies"]);

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     ** @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * *@return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::orderBy('label')->get();
        $project_technology = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * *@return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {   
        
        $data = $request->validated();
        // dd($data);
        $project->slug = Str::slug($project->title);
        
        
        if(Arr::exists($data, 'cover_image')){
            if($request->hasFile('cover_image')){
                Storage::delete($project->cover_image);
            }
            $project->cover_image = Storage::put("uploads/projects/{$project->id}/cover_image",$data['cover_image']);
            $data['cover_image']=$project->cover_image;
        };
        $project->fill($data);
        
        $project->save();
        
        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->detach();
        }


        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Project $project)
    {
        $project->technologies()->detach();
        if($request->hasFile('cover_image')){
            Storage::delete($project->cover_image);
        }
        $project->delete();
        
        return redirect()->route('admin.projects.index');
    }
}
