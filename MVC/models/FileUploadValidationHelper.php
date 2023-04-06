<?php

class FileUploadValidationHelper{
    public function __construct(){
        
    }

    public function validateImage($file, $target_dir){
        $violations = array();
        if($file['error'] == 0){
            $file_name = $file['name'];
            $this->replacePolishLettersAndPrepare($file_name);
            $target_file = $target_dir.$file_name;
            $this->checkFileSize($file, $violations);
            $this->checkIfFileExists($target_file, $violations);
            if($this->checkAcceptableExtensions($file_name, $violations)){
                $this->checkImageSize($file['tmp_name'], $violations);
            }
            
        }
        else{
            array_push($violations, "Podczas przesyłania pliku wystąpił błąd.<br>");
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
        }
        return $target_file;
    }

    private function replacePolishLettersAndPrepare(&$file_name){
        $replace_array = array(
            'ą' => 'a',
            'ć' => 'c',
            'ę' => 'e',
            'ł' => 'l',
            'ń' => 'n',
            'ó' => 'o',
            'ś' => 's',
            'ź' => 'z',
            'ż' => 'z',
            ' ' => '_'
        );
        $file_name = str_replace(array_keys($replace_array), array_values($replace_array), $file_name);
        $file_name = strtolower($file_name);

        $file_name = (new DateTime())->format('Y-m-d-H-i-s')."_".$file_name;
    }

    private function checkAcceptableExtensions($file_name, &$violations){
        $tmp=explode('.', $file_name);
        $file_ext = strtolower(end($tmp));
        $extensions = array("png", "bmp", "jpg");
        if(in_array($file_ext, $extensions) === false){
            array_push($violations, "Błędne rozszerzenie. Akceptowalne rozszerzenia nazw plików to: ".implode(", ", $extensions).".<br>");
            return false;
        }
        else{
            return true;
        }
    }

    private function checkFileSize($file, &$violations){
        $MB=1048576;
        if($file['size'] > 2*$MB) {
            array_push($violations, "Plik jest za duży, max. rozmiar pliku wynosi 2MB.<br>");
        }
    }

    private function checkIfFileExists($targetFilePath, &$violations){
         if(file_exists($targetFilePath)) {
            array_push($violations,"Taki plik już istnieje.<br>");
        }
    }

    private function checkImageSize($tmp_name, &$violations){
        if($info = getimagesize($tmp_name)){
            list(0 => $width, 1 => $height) = $info;
            if($width>2000){
                array_push($violations, "Szerokość obrazu jest nieprawidłowa - wynosi $width px, a powinna wynosić maksymalnie 2000 px.<br>");
            }
            if($height>2000){
                array_push($violations, "Wysokość obrazu jest nieprawidłowa - wynosi $height px, a powinna wynosić maksymalnie 2000 px.<br>");
            }
        }
        else{
            array_push($violations, "Typ pliku jest nieprawidłowy.<br>");
        } 
    }
}