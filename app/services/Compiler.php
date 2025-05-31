<?php
 class Compiler{
    function runCode($language, $sourceCode) {
        $languageMap = [
            'c_cpp' => 54,     // C++ (G++)
            'csharp' => 51,    // C#
            'java' => 62,      // Java
            'python' => 71     // Python 3
        ];
    
        $langId = $languageMap[$language] ?? null;
        if (!$langId) return ['output' => 'Unsupported language.', 'error' => true];
    
        $postData = [
            'source_code' => $sourceCode,
            'language_id' => $langId,
            'stdin' => ''
        ];
    
        $ch = curl_init("https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=false&wait=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-RapidAPI-Key: YOUR_RAPIDAPI_KEY",
            "X-RapidAPI-Host: judge0-ce.p.rapidapi.com"
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $result = json_decode($response, true);
    
        return [
            'output' => $result['stdout'] ?? $result['compile_output'] ?? $result['stderr'] ?? 'Unknown error.',
            'error' => isset($result['stderr']) || isset($result['compile_output'])
        ];
    }
    
 }