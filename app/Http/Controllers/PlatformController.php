<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\View\View;

class PlatformController extends Controller
{
    public function index(): View
    {
        $platforms = Platform::query()
            ->orderBy('name')
            ->paginate(25);

        return view('platforms.index', [
            'platforms' => $platforms,
        ]);
    }
}
