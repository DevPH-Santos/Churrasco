<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gemini\ChatChurrasco;

class ChurrascoController extends Controller
{
    public function chat(Request $request, ChatChurrasco $planner){

        $validate = $request->validate([

            'message' => 'required|string|max:2000',

        ]);

        try {

            $reply = $planner->plan($validate['message']);
            return response()->json(['reply' => $reply]);

        }catch (\Throwable $e) {

            return response()->json([
                'error' => 'Falha ao falar com o Gemini',
            ], 502);

        }

    }
}
