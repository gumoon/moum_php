<?php

namespace moum\Http\Controllers\Admin;

use moum\Http\Requests\StoreProgramPost;
use moum\Models\Program;
use moum\Http\Controllers\Controller;


class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::all();

        return view('admin.programs.index', ['programs' => $programs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.programs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgramPost $request)
    {
        $program = new Program;

        $program->name = $request->input('name');
        $program->intro = $request->input('intro');
        $program->type = $request->input('type');
        $program->status = $request->input('status');

        $program->save();

        if( $request->expectsJson() )
        {
            $ret = array(
                'errno' => 0,
                'msg' => 'success',
                'data' => array()
            );

            return response()->json($ret);
        }
        else
        {
            return redirect('/houtai/programs');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = intval($id);

        $program = Program::findOrFail($id);

        return view('admin.programs.edit', ['program' => $program]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProgramPost $request, $id)
    {
        $id = intval($id);
        $program = Program::find($id);

        $program->name = $request->input('name');
        $program->intro = $request->input('intro');
        $program->type = $request->input('type');
        $program->status = $request->input('status');

        $program->save();

        if( $request->expectsJson() )
        {
            $ret = array(
                'errno' => 0,
                'msg' => 'success',
                'data' => array('')
            );

            return response()->json($ret);
        }
        else
        {
            return redirect('/houtai/programs');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
