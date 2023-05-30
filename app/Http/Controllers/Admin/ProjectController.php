<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types= Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
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
        $data['slug'] = Str::slug($data['title'],'-');

        if($request->hasFile('url')){
           $path = Storage::put('cover',$request->url);
           $data['url'] = $path;
        }

        $newProject = new Project();

        $newProject->fill($data);

        $newProject->save();

        if($request->has('technologies')){
            $newProject->technologies()->attach($request->technologies);

        }

       
        

        return redirect()->route('admin.projects.show',['project'=>$newProject->slug])->with('status', 'Progetto creato con successo!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit',compact('project','types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validate_data = $request->validated();
        $validate_data['slug'] = Str::slug($validate_data['title'],'-');

        if($request->hasFile('url')){

            if ($project->url) {
                Storage::delete($project->url);
            }
            $path = Storage::put('cover',$request->url);
            $data['url'] = $path;
        }

        $project->technologies()->sync($request->technologies);

        $project->update($validate_data);

       

        return redirect()->route('admin.projects.show',['project'=>$project->slug])->with('status', 'Progetto modificato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->url) {
            Storage::delete($project->url);
        }
        $project->delete();

        return redirect()->route('admin.projects.index');
    }

    public function deleteImage($slug) {

        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->url) {
            Storage::delete($project->url);
            $project->url = null;
            $project->save();
        }

        return redirect()->route('admin.projects.edit', $project->slug);

    }
}