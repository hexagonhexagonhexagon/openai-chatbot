<?php

include 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourAPIKey = $_ENV['OPENAI_PHP_CHATBOT_API_KEY'];
$client = OpenAI::client($yourAPIKey);

$chatBotName = readline("Hello, friend. I'm your personal helpful chatbot. What would you like to call me? ");
$userName = readline("Okay, from now on you can call me $chatBotName. What is your name? ");
echo "Hello, $userName. It's nice to meet you. ";
$initialUserMessage = readline("Tell me, $userName, how are you feeling today? You can tell me anything you want.");

$chatBotSystemMessage = "You are a friendly chatbot named $chatBotName whose main objective is to help the user have encouraging but helpful conversations about themselves, their life, and any challengesthat might be in their life at the moment. Consider yourself to be a friend of the user, and you want to help them feel better about themselves.";

$response = $client->chat()->create([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => $chatBotSystemMessage],
        ['role' => 'user', 'content' => $initialUserMessage]
    ],
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
echo $response->choices[0]->message->content;

