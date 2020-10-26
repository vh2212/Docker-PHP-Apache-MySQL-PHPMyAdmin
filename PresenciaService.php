<?php



require 'PresenciaBL.php';

class PresenciaService
{
    private $presencia;
    private $PresenciaBL;

    public function __construct()
    {
        $this->PresenciaBL = new PresenciaBL();
    }

    public function create($direccion,$tiempoArea)
    {
        $this->presencia = $this->PresenciaBL->create($direccion,$tiempoArea);
        if($this->presencia > 0) {
            $response[] = array('response' => true);
            echo json_encode("response:true");
        }
        else {
            $response[] = array('response' => false);
            echo json_encode("response:false");
        }
    }

    public function read($presencia_id)
    {
        $this->presencia = $this->PresenciaBL->read($presencia_id);
        echo json_encode($this->presencia);
    }

    public function update($presencia_id,$direccion,$tiempoArea)
    {
        $this->presencia = $this->PresenciaBL->update($presencia_id,$direccion,$tiempoArea);
        echo json_encode($this->presencia);
    }

    public function delete($presencia_id)
    {
        $this->presencia = $this->PresenciaBL->delete($presencia_id);
        if($this->presencia > 0) {
            $response[] = array('response' => true);
            echo json_encode("response:true");
        }
        else {
            $response[] = array('response' => false);
            echo json_encode("response:false");
        }
    }
}

$service = new presenciaService();
switch ($_SERVER['REQUEST_METHOD']) 
{
    case 'GET':
        {
            if (empty($_GET['param'])) {
                $service->read($_GET['param']);
            } else {
                $service->read($_GET['param']);
            }
            
            
            break;
        }
        case 'POST':
        {
        //print_r($_POST);
        $data = json_decode(file_get_contents('php://input'), true);
            $service->create($data['direccion'],$data['tiempoArea']);
            break;
        }
        case 'PUT':
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $service->update($data['presencia_id'],$data['direccion'],$data['tiempoArea']);
            break;
        }
        case 'DELETE':
        {
            parse_str(file_get_contents('php://input'), $_DELETE);
            if (empty($_GET['param'])) {
                $service->delete($_GET['param']);
            } else {
                $service->delete($_GET['param']);
            }
            break;
        }
        
    
}

?>