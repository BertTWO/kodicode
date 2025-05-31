<?php
require_once(BASE_PATH . 'core/Controller.php');
require_once(BASE_PATH . 'app/services/Compiler.php');
class CompilerController extends Controller{

    private function getFileExtension($language) {
        return match ($language) {
            'c_cpp' => 'cpp',
            'csharp' => 'cs',
            'java' => 'java',
            'python' => 'py',
            default => 'txt'
        };
    }

    public function runCode(){
        $code = $_POST['code'] ?? '';
        $language = $_POST['language'] ?? '';
        $user = $_SESSION['user'] ?? '';
        
        $problemId = "testing";
        $ex = $this->getFileExtension($language);

        $folderPath = BASE_PATH."submissions/user_".$user['user_id']."/$problemId";

        if(!is_dir($folderPath)){
            mkdir($folderPath, 0777, true);
        }
        $filePath = "$folderPath/$language.$ex";

        file_put_contents($filePath, $code);

        $compiler = new Compiler();

        $response = $compiler->runCode($language,$filePath);

        if ($response['error']) {
            unlink($filePath); // Clean up if there's an error
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        return;
    }
  
}