<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportSellers;
use Illuminate\Support\Facades\App;

class LoadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $queue = App::make('queue.connection');
        $size = $queue->size('default');

        if ($size == 0) {
            ImportSellers::dispatch();
            return ['success' => true, 'message' => 'Start uploading data!'];
        }

        return ['success' => false, 'message' => 'Another upload is running or queue is down!'];
    }
}
