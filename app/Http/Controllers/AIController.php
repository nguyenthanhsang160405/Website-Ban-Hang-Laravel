<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\type;

class AIController extends Controller
{
    //
    public function index()
    {
        return view('aichat');
    }

    public function sendMessage(Request $request)
    {
        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user', 
                        'content' => $request->message
                    ]  
                ],
            ]);
        return response()->json([
            'reply' => $response['choices'][0]['message']['content'] ?? 'Không thể phản hồi.'
        ]);
    }
    
}
