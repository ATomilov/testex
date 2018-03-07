<?php
// If you want to ignore the uploaded files, 
// set $demo_mode to true;
session_start();
$demo_mode = false;
$upload_dir = 'uploads/';
$allowed_ext = array('jpg','jpeg','png');

if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    exit_status('Error! Wrong HTTP method!');
}

if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
    $pic = $_FILES['pic'];
    if(!in_array(get_extension($pic['name']),$allowed_ext)){
        exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
    }
    if($demo_mode){
        // File uploads are ignored. We only log them.
        $line = implode('       ', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
        file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
        exit_status('Uploads are ignored in demo mode.');
    }
    if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
        $_SESSION['last_uploaded_file'] = $pic['name'];
        ob_start();
        getColor($pic['name']);
        $color = ob_get_contents();
        ob_clean();
        echo json_encode(array('status'=>'File was uploaded successfuly!', 'color'=>$color));
        exit;
        exit_status('File was uploaded successfuly!');
    }
}
exit_status('Something went wrong with your upload!');

// Helper functions

function exit_status($str){
    echo json_encode(array('status'=>$str));
    exit;
}

function get_extension($file_name){
    $ext = explode('.', $file_name);
    $ext = array_pop($ext);
    return strtolower($ext);
}

function getColor($filename){
    if (exif_imagetype("uploads/".$filename) == IMAGETYPE_PNG) :
        $im = imagecreatefrompng("uploads/".$filename);
    elseif (exif_imagetype("uploads/".$filename) == IMAGETYPE_JPEG) :
        $im = imagecreatefromjpeg("uploads/".$filename);
    endif;
    
    $width = imagesx($im);
    $height = imagesy($im);

    $count = 0;

    for($i=0; $i < $width; $i++)
        for($j=0; $j < $height; $j++)
        {
            $rgb = imagecolorat($im, $i, $j);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            if($r==255 && $g==255 && $b==255)
            {
                $count++;
            }
        }
    echo "Размер изображения: " . $width ." x ". $height . "<br>";
    echo "Белых пикселей: ".$count;
    imagedestroy($im);
}
?>