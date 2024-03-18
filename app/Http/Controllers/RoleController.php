<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $roles = Role::paginate(2);

        return view('role.index', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * $roles->perPage());
    }

    public function search(Request $request)
    {
        $output= ""; // The output variable is defined and initialized
        $roles = Role::where('name', 'LIKE', '%'.$request -> search.'%')->get(); // We make the query through the Rol name

        // We use the loop foreach to iterate the aggregation of records
        foreach($roles as $rol){
            $output .= 
            '<tr>
                <td>' . $rol->id . '</td>
                <td>' . $rol->name . '</td>
                <td>
                    <a href="' . url('/roles/' . $rol->id) . '" class="btn btn-sm btn-primary">
                        <i class="fa fa-fw fa-eye"></i> Show
                    </a>
                    <a href="' . url('/roles/' . $rol->id . '/edit') . '" class="btn btn-sm btn-success">
                        <i class="fa fa-fw fa-edit"></i> Edit
                    </a>
                </td>
            </tr>';
        }

        return response($output); // We return the response by sending as parameter the output variable
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new Role();
        return view('role.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['guard_name' => 'web']); // Set the default guard_name to 'web'.

        request()->validate(Role::$rules);

        $role = Role::create($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->merge(['guard_name' => 'web']); // Set the default guard_name to 'web'.

        request()->validate(Role::$rules);

        $role->update($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $role = Role::find($id)->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
