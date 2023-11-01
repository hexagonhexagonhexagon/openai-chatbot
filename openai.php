<?php

include 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourAPIKey = $_ENV['OPENAI_PHP_CHATBOT_API_KEY'];
$client = OpenAI::client($yourAPIKey);



while (true) {
    $chatBotSystemMessage = "You are a friendly chatbot who is here to help people with their problems. Be kind, thoughtful, and ask simple questions for the purpose of helping the user identify why they are not feeling well, and then kindly propose ideas and solutions to make them feel better, or to fix their problems.";
    $initialAssistantMessage = "Tell me, how are you feeling today? You can tell me anything you want.";
    $userMessage = readline($initialAssistantMessage);
    $response = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => $chatBotSystemMessage],
            ['role' => 'user', 'content' => $userMessage]
        ]
        ]);

    $response->id; // 'chatcmpl-6pMyfj1HF4QXnfvjtfzvufZSQq6Eq'
    $response->object; // 'chat.completion'
    $response->created; // 1677701073
    $response->model; // 'gpt-3.5-turbo-0301'

    foreach ($response->choices as $result) {
        $result->index; // 0
        $result->message->role; // 'assistant'
        $result->message->content; // '\n\nHello there! How can I assist you today?'
        $result->finishReason; // 'stop'
    }

    $response->usage->promptTokens; // 9,
    $response->usage->completionTokens; // 12,
    $response->usage->totalTokens; // 21

    $response->toArray(); // ['id' => 'chatcmpl-6pMyfj1HF4QXnfvjtfzvufZSQq6Eq', ...]
    
    $chatBotResponse = $response->choices[0]->message->content;
    $userMessage = readline($chatBotResponse);
};

