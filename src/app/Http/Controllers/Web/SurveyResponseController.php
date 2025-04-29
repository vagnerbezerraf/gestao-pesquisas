<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Answer;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyResponseController extends Controller
{
    /**
     * Exibe a pesquisa para resposta com base no token do convite
     */
    public function show($token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        
        // Verifica se o convite é válido e não foi usado
        if ($invite->status === 'responded') {
            return view('survey-response.already-answered');
        }
        
        $survey = $invite->survey;
        
        // Carrega as perguntas da pesquisa com seus grupos
        $questions = $survey->questions()
            ->with('questionCategory')
            ->orderBy('id')
            ->get();
            
        // Calcula o número de páginas (10 perguntas por página)
        $totalPages = ceil($questions->count() / 10);
        $chunkedQuestions = $questions->chunk(10);
        
        return view('survey-response.show', compact('survey', 'invite', 'questions', 'totalPages', 'chunkedQuestions'));
    }
    
    /**
     * Salva as respostas da pesquisa
     */
    public function store(Request $request, $token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        
        // Verifica se o convite é válido e não foi usado
        if ($invite->status === 'responded') {
            return redirect()->route('survey-response.already-answered');
        }
        
        $survey = $invite->survey;
        
         //Valida ao menos uma resposta (as demais serão opcionais)
         $data = $request->validate([
             'answers' => 'required|array',
         ], [
             'answers.required' => 'Por favor, responda pelo menos uma pergunta.',
         ]);
        
        // Log received answers for debugging
        Log::info('SurveyResponseController: received answers', ['answers' => $data['answers']]);

        DB::beginTransaction();
        
        try {
            // Log before saving answers
            Log::info('SurveyResponseController: starting to save answers', ['invite_id' => $invite->id]);
            // Salva as respostas
            foreach ($data['answers'] as $questionId => $value) {
                Answer::create([
                    'survey_id' => $survey->id,
                    'question_id' => $questionId,
                    'invite_id' => $invite->id,
                    'user_id' => auth()->id(), // Pode ser null para usuários não autenticados
                    'value' => $value,
                ]);
            }
            
            // Atualiza o status do convite
            $invite->update(['status' => 'responded']);
            
            // Log successful save
            Log::info('SurveyResponseController: saved answers successfully', ['invite_id' => $invite->id]);
            
            DB::commit();
            
            return redirect()->route('survey-response.thank-you', $token);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar respostas da pesquisa: ' . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao salvar suas respostas. Por favor, tente novamente.');
        }
    }
    
    /**
     * Exibe a página de agradecimento
     */
    public function thankYou($token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        $survey = $invite->survey;
        
        return view('survey-response.thank-you', compact('survey', 'invite'));
    }
    
    /**
     * Exibe a página de pesquisa já respondida
     */
    public function alreadyAnswered()
    {
        return view('survey-response.already-answered');
    }
}
