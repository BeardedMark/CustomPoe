<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;
use Illuminate\Support\Facades\Response;
use App\Services\ItemFilter;
use App\Services\Parser;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Filter $filter, Request $request)
    {
        $settings = $filter->getSettings();

        // $itemFilter = new ItemFilter($filter->filter);

        // $groups = $itemFilter->getGroups();

        // usort($groups, function ($a, $b) {
        //     return strcmp($a->name, $b->name);
        // });

        // foreach ($groups as $group) {
        //     usort($group->sections, function ($a, $b) {
        //         return strcmp($a->getName(), $b->getName());
        //     });
        // }

        $parser = new Parser();
        $lines = explode("\n", $filter->filter);
        $parser->parse($lines);
        $parser->removeEmptySectionsAndGroups();
        $groups = $parser->getGroups();
        $uncownCommands = $parser->getUniqueCommandNames();

        if (isset($request['sort'])) {
            usort($groups, function ($a, $b) {
                return strcmp($a->name, $b->name);
            });

            foreach ($groups as $group) {
                usort($group->sections, function ($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                });
            }
        }


        return view('resources.filters.settings', compact('filter', 'settings', 'groups', 'uncownCommands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filter $filter)
    {
        $filter->setSettings($request->all());

        return redirect()->back()->withSuccess('Настройки успешно сохранены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filter $filter)
    {
        session()->forget($filter->id);

        return redirect()->back()->withSuccess('Настройки успешно удалены');
    }

    public function download(Filter $filter, Request $request)
    {
        $filter = Filter::find($filter->id);

        $fileName = $filter->name . '.cp.filter';
        $fileContent = $filter->text();

        $filter->incrementDownloads();

        return Response::make($fileContent, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
