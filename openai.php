<?php

include 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourAPIKey = $_ENV['OPENAI_PHP_CHATBOT_API_KEY'];
$client = OpenAI::client($yourAPIKey);

$chatBotSystemMessage = 
"You are a friendly chatbot who is here to help people with their problems.
Be kind, thoughtful, and ask simple questions for the purpose of helping the user identify why they
are not feeling well, and then kindly propose ideas and solutions to make them feel better,
or to fix their problems. Do not be rude, mean, or condescending. Allow the user to dictate when the conversation
is over. If the user says 'quit', then end the conversation. Inform the user that the conversation is over when
the user says 'quit' early in the conversation with the user.";

// initialize the user message to an empty string
$userMessage = "";

// initialize the messages array to contain the chatbot system message as the first message
$messages = [
    ['role' => 'system', 'content' => $chatBotSystemMessage]
];

# create a while loop that controls the chat conversation with the user and the chatbot
# the while loop should run as long as the userMessage is not equal to 'quit'
# inside the while loop, create a $response variable that calls the chat() method on the $client object
# change the 
while ($userMessage != 'quit') {
    $response = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages
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

    array_push($messages, ['role' => 'assistant', 'content' => $chatBotResponse]);
    array_push($messages, ['role' => 'user', 'content' => $userMessage]);
};

