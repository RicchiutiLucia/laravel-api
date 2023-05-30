<?php

namespace App\Http\Controllers\Admin;

use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::all();
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.technologies.create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name,'-');

        $checkTechnology = Technology::where('slug', $data['slug'])->first();

        if($checkTechnology){
            return back()->withInput()->withErrors(['slug' => 'Con questo nome crei uno slug doppiato,perfavore cambia titolo']);
        }

        $newTechnology = Technology::create($data);

        return redirect()->route('admin.technologies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit',compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technology $technology)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name,'-');

        $checkTechnology = Technology::where('slug',$data['slug'])->where('id','<>',$technology->id)->first();

        if($checkTechnology){
            return back()->withInput()->withErrors(['slug' => 'Con questo nome crei uno slug doppiato,perfavore cambia titolo']);
        }

        $technology->update($data);

        return redirect()->route('admin.technologies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();

        return redirect()->route('admin.technologies.index');
    }
}
