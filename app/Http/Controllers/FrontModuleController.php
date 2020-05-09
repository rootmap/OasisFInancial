<?php

namespace App\Http\Controllers;

use App\FrontModule;
use Illuminate\Http\Request;

class FrontModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.pages.index');
    }

    public function howitworks()
    {
        return view('site.pages.how-it-works');
    }

    public function typesoffunding()
    {
        return view('site.pages.types-of-funding');
    }

    public function about()
    {
        return view('site.pages.about');
    }

    public function faq()
    {
        return view('site.pages.faq');
    }

    public function forattorneys()
    {
        return view('site.pages.for-attorneys');
    }

    public function resources()
    {
        return view('site.pages.resource');
    }

    public function contactus()
    {
        return view('site.pages.contactus');
    }

    public function careers()
    {
        return view('site.pages.careers');
    }

    public function forbrokers()
    {
        return view('site.pages.for-brokers');
    }

    public function completeapplication()
    {
        return view('site.pages.complete-application');
    }

    public function structuredsettlementapplicationform()
    {
        return view('site.pages.structured-settlement-application-form');
    }

    public function inheritancefunding()
    {
        return view('site.pages.inheritance-funding');
    }

    public function needanattorney()
    {
        return view('site.pages.need-an-attorney');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FrontModule  $frontModule
     * @return \Illuminate\Http\Response
     */
    public function show(FrontModule $frontModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FrontModule  $frontModule
     * @return \Illuminate\Http\Response
     */
    public function edit(FrontModule $frontModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FrontModule  $frontModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FrontModule $frontModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FrontModule  $frontModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrontModule $frontModule)
    {
        //
    }
}
