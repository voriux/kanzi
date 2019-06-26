<?php

$json = json_decode(file_get_contents('speech_assets/IntentSchema.json'));
$utterances = file_get_contents('speech_assets/SampleUtterances.en.txt');
$mappedUtterances = [];
foreach (explode("\n", $utterances) as $line) {
    $lineSpacePosition = strpos($line, ' ');
    $key = substr($line, 0, $lineSpacePosition);
    $mappedUtterances[$key][] = substr($line, $lineSpacePosition+1);
}
foreach ($json->interactionModel->languageModel->intents as $intent) {
    $name = $intent->name;
    if (isset($mappedUtterances[$name])) {
        $intent->samples = $mappedUtterances[$name];
    }
}

file_put_contents('speech_assets/IntentSchemaV2.json', print_r(json_encode($json, JSON_PRETTY_PRINT), true));
