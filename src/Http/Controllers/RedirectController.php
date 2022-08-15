<?php

namespace PavelZanek\RedirectionsLaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PavelZanek\RedirectionsLaravel\Http\Requests\ImportRedirectsRequest;
use PavelZanek\RedirectionsLaravel\Http\Requests\StoreRedirectRequest;
use PavelZanek\RedirectionsLaravel\Http\Requests\UpdateRedirectRequest;
use PavelZanek\RedirectionsLaravel\Models\Redirect;
use PavelZanek\RedirectionsLaravel\Models\RedirectData;
use PavelZanek\RedirectionsLaravel\Services\ExportRedirectsService;
use PavelZanek\RedirectionsLaravel\Services\ImportRedirectsService;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = Redirect::withCount('redirectData')
                        ->when(request('search'), function ($query) {
                            $query->where('source_url', 'LIKE', '%' . request('search') . '%')
                                ->orWhere('target_url', 'LIKE', '%' . request('search') . '%');
                        })
                        ->paginate(20)
                        ->withQueryString();

        return view('redirections-views::redirects.' . config('redirections.css_framework') . '.index', compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('redirections-views::redirects.' . config('redirections.css_framework') . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \PavelZanek\RedirectionsLaravel\Http\Requests\StoreRedirectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedirectRequest $request)
    {
        Redirect::create($request->validated());
        return redirect()->route('redirects.index')->with('success', trans('redirections-translations::toastr.redirectCreated'));
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
        $redirectData = $redirect->redirectData()->select('id')->orderBy('used_at', 'desc')->take(10)->get()->groupBy(function ($val) {
            return Carbon::parse($val->used_at)->format('d. m. Y');
        });

        $redirectChartData = RedirectData::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(used_at) as month_name"))
                    ->where('redirect_id', $redirect->id)
                    ->whereYear('used_at', date('Y'))
                    ->groupBy(DB::raw("Month(used_at)"))
                    ->pluck('count', 'month_name');

        return view('redirections-views::redirects.' . config('redirections.css_framework') . '.show', [
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
        return view('redirections-views::redirects.' . config('redirections.css_framework') . '.edit', compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \PavelZanek\RedirectionsLaravel\Http\Requests\UpdateRedirectRequest $request
     * @param  Redirect $redirect
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedirectRequest $request, Redirect $redirect)
    {
        $redirect->update($request->validated());
        return redirect()->route('redirects.index')->with('success', trans('redirections-translations::toastr.redirectUpdated'));
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
        return redirect()->route('redirects.index')->with('success', trans('redirections-translations::toastr.redirectDeleted'));
    }

    /**
     * Export list of the resource from storage.
     *
     */
    public function export()
    {
        return (new ExportRedirectsService())->exportItems();
    }

    /**
     * Import & Store a newly created resource in storage.
     *
     * @param  \PavelZanek\RedirectionsLaravel\Http\Requests\ImportRedirectsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function import(ImportRedirectsRequest $request)
    {
        (new ImportRedirectsService($request->csv))->importItems();
        return redirect()->route('redirects.index')->with('success', trans('redirections-translations::toastr.redirectImported'));
    }
}
