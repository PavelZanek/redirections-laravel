<?php

namespace PavelZanek\RedirectionsLaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PavelZanek\RedirectionsLaravel\Http\Requests\StoreRedirectRequest;
use PavelZanek\RedirectionsLaravel\Http\Requests\UpdateRedirectRequest;
use PavelZanek\RedirectionsLaravel\Models\Redirect;
use PavelZanek\RedirectionsLaravel\Models\RedirectData;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = Redirect::withCount('redirectData')->get();
        return view('redirections-views::redirects.index', compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('redirections-views::redirects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedirectRequest $request)
    {
        Redirect::create($request->validated());
        return redirect()->route('redirects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Redirect $redirect
     * @return \Illuminate\Http\Response
     */
    public function show(Redirect $redirect)
    {
        $redirect->load('redirectData');
        $redirectData = $redirect->redirectData()->orderBy('used_at', 'desc')->take(10)->get()->groupBy(function ($val) {
            return Carbon::parse($val->used_at)->format('d. m. Y');
        });
        // dd($redirectData);
        $redirectChartData = RedirectData::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(used_at) as month_name"))
                    ->whereYear('used_at', date('Y'))
                    ->groupBy(DB::raw("Month(used_at)"))
                    ->pluck('count', 'month_name');

        return view('redirections-views::redirects.show', [
            'redirect' => $redirect,
            'redirectData' => $redirectData,
            'labels' => $redirectChartData->keys(),
            'data' => $redirectChartData->values(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Redirect $redirect
     * @return \Illuminate\Http\Response
     */
    public function edit(Redirect $redirect)
    {
        return view('redirections-views::redirects.edit', compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Redirect $redirect
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedirectRequest $request, Redirect $redirect)
    {
        $redirect->update($request->validated());
        return redirect()->route('redirects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Redirect $redirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return redirect()->route('redirects.index');
    }
}
