<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Org;

class OrgController extends Controller
{
    
    public function create()
    {
        return view('org.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_name' => ['required', 'string', 'max:255'],
            'org_address' => ['required', 'string', 'max:255'],
        ]);

        // dd($request);

        Org::create([
            'org_name' => $request->org_name,
            'org_address' => $request->org_address,
            'org_info' => '{}',
        ]);

        return view('org.create');
    }
}
