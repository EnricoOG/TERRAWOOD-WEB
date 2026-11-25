<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(Request $request) {
        $customers = User::where('role','user')->when($request->q, fn($q,$term)=>$q->where(function($sub) use($term){$sub->where('name','like',"%$term%")->orWhere('email','like',"%$term%");}))->when($request->country, fn($q,$country)=>$q->where('country',$country))->latest()->paginate(25)->withQueryString();
        $countries = User::where('role','user')->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');
        return view('admin.customers.index', compact('customers','countries'));
    }
}
