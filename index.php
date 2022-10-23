<?php
require __DIR__ . "/inc/bootstrap.php";
require PROJECT_ROOT_PATH . "/Controller/Api/MaterialController.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

try {
    if ( (!isset($uri[2])) || (!isset($uri[3])) ) {
        throw new Exception("HTTP/1.1 404 Not Found");
    }

    switch ($uri[2]) {
        case "material":
            $objFeedController = new MaterialController();
            break;
        default:
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $strMethodName = $uri[3] . 'Action';
    $objFeedController->{$strMethodName}();
    } catch(Exception $e) {
                print $e->getMessage();
    }
?>