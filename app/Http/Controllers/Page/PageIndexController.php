<?php

namespace Omega\Http\Controllers\Page;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Omega\Http\Controllers\Controller;
use Omega\Http\Requests\Page\SortRequest;
use Omega\Models\Lang;
use Omega\Models\Page;
use Omega\Policies\OmegaGate;

class PageIndexController extends Controller
{

    #region index
    /**
     * The list of pages
     * @param null $lang If not null, filter by lang
     * @return Factory|View
     */
    public function index($lang = null)
    {
        if (OmegaGate::denies('page_read'))
            return OmegaGate::accessDeniedView();

        $enabledLang = lang_enabled();
        $defaultLang = lang_default();

        $currentLang = null;
        if ($enabledLang) {
            $currentLang = isset($lang) ? $lang : null;
            // if the lang is not given in the URL, then get the value from the session if it exists
            if (!isset($currentLang) && session()->has('backoffice_lang_pages')) {
                $currentLang = session('backoffice_lang_pages');
            }
        }

        $viewBag = [
            'enabledLang' => $enabledLang,
            'defaultLang' => $defaultLang,
            'currentLang' => $currentLang,
            'langs' => to_select(Lang::enabled()->get(), 'name', 'slug', [null => __('None')]),
        ];
        return view('pages.index')->with($viewBag);
    }

    /**
     * Change the selected lang
     * @param Request $request
     * @return RedirectResponse
     */
    public function chooseLang(Request $request)
    {
        // set the chosen lang in a session variable
        session(['backoffice_lang_pages' => $request->input('lang')]);
        // redirect back to the list of pages
        return redirect()->route('admin.pages', ['lang' => $request->input('lang')]);
    }

    /**
     * Sort the pages
     * @param SortRequest $request
     * @return JsonResponse
     */
    public function sort(SortRequest $request)
    {
        $orders = $request->input('order');
        foreach ($orders as $p) {
            $page = Page::find($p['id']);
            $page->order = $p['order'];
            $result = $page->save();
            if (!$result)
                break;
        }
        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Get the table with all the page filtered by lang
     * @param null|string $lang
     * @return Factory|View
     */
    public function table($lang = null)
    {
        if (OmegaGate::denies('page_read'))
            return OmegaGate::accessDeniedView();

        $enabledLang = lang_enabled();

        $query = Page::noParent();
        if($enabledLang) {
            $query->lang($lang);
        }
        $pages =$query
            ->ordered()
            ->paginate(config('omega.page.paginate'))
            ->withPath(route('admin.pages'));

        return view('pages.indextable')->with([
            'enabledLang' => $enabledLang,
            'currentLang' => $lang,
            'pages' => $pages,
        ]);
    }
    #endregion
}
