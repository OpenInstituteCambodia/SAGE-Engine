<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function parseXML(Request $request) {

      $xmlfile = $request->file('xmlfile');
      $path = $request->file('xmlfile')->store('xml', 'public');

      $xml = new \DOMDocument('1.0', 'utf-8');
      $xml->load(storage_path('app/public/').$path);
      $xpath = new \DOMXPath($xml);

      return view('xml', compact('xpath'));

    }

      public function viewXML() {
      return view('xml');
    }
}
