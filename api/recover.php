<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Content-Type: application/json');

require_once("../models/usuarios.php");
$base = new Base();
switch ($_GET["consulta"]) {
    case '':
        http_response_code(400);
        print_r(json_encode(array("status"=> "error","message"=>"Falta parametros")));
        break;
    case 'InformacionPersonal':
        $headers = getallheaders();
        $apikey = $headers["x-api-key"];
        if ($apikey == "87sgtY$$98yu7t6jIo9U6yTrcx4R5Tyf_") {
            if ($cedula = isset($_GET["cedula"])) {
                $cedula = ($_GET["cedula"]);
                $consult = $base->get_user($cedula);
                $rest=empty($consult);
                if($rest==true){
                    http_response_code(401);
                    echo json_encode(array("status"=> "error","message"=>"Sin resultados"));
                }else if($rest==false){
                    $consult = $base->get_user($cedula);
                    // get values
                    $ci= $consult[0]->cedulaCliente;
                    $email= $consult[0]->correoElectronico;
                    $cel = $consult[0]->telCelular;
                    $cel_trabajo = $consult[0]->telCelularTrabajo;
                    $telefono_domicilio= $consult[0]->telConvencionalDom;
                    $nombre=$consult[0]->nombreCliente;
                    $consult2 = $base->get_user2($cedula);                 
                    $data = array(
                        "apikey" => $apikey,
                        "ci" => $ci,
                        "email" => $email,
                        "cel" => $cel,
                        "cel_trabajo" => $cel_trabajo,
                        "telefono_domicilio" => $telefono_domicilio,
                        "nombre"=>$nombre,
                        "operaciones" => $consult2
                    ); //End $data ARRAY
                    http_response_code(200);
                    print_r(json_encode($data));
                }else{
                    http_response_code(400);
                    echo json_encode(array("status"=> "error","message"=>"Error en la peticion"));
                }

            } 
            else {
                http_response_code(401);
                echo json_encode(array("status"=> "error","message"=>"Falta parametros"));
            }
        } else {
            http_response_code(401);
            echo json_encode(array("status"=> "error","message"=>"Error de autenticacion"));
        }

        // 400 error interno
        // 200 OK

        // print_r(json_encode($headers["x-api-key"]));
        // die();
        break;
}
