<?php

namespace App\Services\Gemini;

use Gemini;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\ResponseMimeType;

/**
 * Responsável por toda a comunicação com a API do Google Gemini.
 *
 * O controller (ChurrascoController) NÃO conhece detalhes do SDK do Gemini:
 * ele apenas chama plan() e recebe o texto pronto para exibir.
 * Assim, se um dia trocarmos de provedor de IA, só este arquivo muda.
 */
class ChatChurrasco
{
    /**
     * Instrução de sistema: define a "personalidade" do modelo.
     * Tudo o que o usuário digitar será tratado DENTRO desta regra.
     */
    private const SYSTEM_INSTRUCTION = <<<'TXT'
        Você é o "Churras SOS", um mestre churrasqueiro assistente.
        Seu trabalho é planejar o churrasco ideal a partir do que o usuário descrever.

        Regras:
        1. Responda SEMPRE em português do Brasil, de forma clara e divertida.
        2. Baseado nas informações do usuário, entregue:
           - Quantidade estimada de carne, carvão e bebidas (por pessoa);
           - Sugestões de cortes e acompanhamentos;
           - Uma receita simples relacionada ao pedido;
           - Boas práticas de fogo, higiene e segurança alimentar.
        3. Faça estimativas razoáveis quando o usuário não informar um dado.
        4. Se o pedido não tiver relação com comida, churrasco ou eventos,
           responda educadamente que você só cuida de churrasco.
        TXT;

    /**
     * Envia a mensagem do usuário ao Gemini e devolve a resposta em texto.
     *
     * @param  string  $message  Texto digitado pelo usuário no chat.
     * @return string Resposta do modelo pronta para exibir na interface.
     */
    public function plan(string $message): string
    {
        // 1) Cria o cliente autenticado com a chave do .env
        $client = Gemini::client(config('services.gemini.key'));

        // 2) Configura como o modelo deve se comportar (criatividade, formato, etc.)
        $config = new GenerationConfig(
            temperature: 0.9,
            topP: 0.9,
            responseMimeType: ResponseMimeType::TEXT_PLAIN,
        );

        // 3) Seleciona o modelo e anexa a configuração + instrução de sistema
        $model = $client->generativeModel('gemini-3.5-flash-lite')
            ->withGenerationConfig($config)
            ->withSystemInstruction(Content::parse(self::SYSTEM_INSTRUCTION));

        // 4) Chamada à API — este é o ponto que faz a requisição HTTP ao Google
        $response = $model->generateContent($message);

        return trim($response->text());
    }
}