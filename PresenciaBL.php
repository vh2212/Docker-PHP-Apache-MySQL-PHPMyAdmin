  <?php
 require 'Conexion.php';
class presenciaBL
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conexion();
    }

    public function create($direccion, $tiempoArea)
    {
        $this->conn->OpenConection();
        $connSQL = $this->conn->getConection();
        $lastInsertId = 0;
        try {
            if ($connSQL) {
                $connSQL->beginTransaction();

                $sqlStatment = $connSQL->prepare(
                    "INSERT INTO presencia VALUES(
                        default,
                        :direccion,
                        :tiempoArea,
                        current_timestamp
                    )"
                );
                
                $sqlStatment->bindParam(':direccion', $direccion);
                $sqlStatment->bindParam('tiempoArea', $tiempoArea);

                $sqlStatment->execute();
                $lastInsertId = $connSQL->lastInsertId();

                $connSQL->commit();
            }
            
        } catch (PDOException $e) {
            $connSQL->rollBack();
        }

        return $lastInsertId;


    }
    public function read($presencia_id)
    {
     $this->conn->OpenConection();
     $connSQL = $this->conn->getConection();
     $arraypresencia =  Array();
     if ($presencia_id > 0) {
        
        $sqlQuery = "SELECT * FROM presencia WHERE presencia_id = ".$presencia_id;
     } else {
        $sqlQuery = "SELECT * FROM presencia";
     }
     foreach ($connSQL->query($sqlQuery) as $row ) 
     {
         $arraypresencia[] = array(
             'presencia_id' => $row['presencia_id'],
             'direccion' => $row['direccion'],
             'tiempo'   => $row['tiempoArea'],
             'last_update' => $row['last_update']
         );
     }

     return $arraypresencia;

    }
    public function update($presencia_id,$direccion,$tiempoArea)
    {
        $this->conn->OpenConection();
        $connSQL = $this->conn->getConection();
        try {
            if ($connSQL) {
                $connSQL->beginTransaction();

                $sqlStatment = $connSQL->prepare(
                    "UPDATE presencia
                        set direccion = :direccion,
                        tiempoArea = :tiempoArea
                        where presencia_id = :presencia_id
                        ");
                $sqlStatment->bindParam(':direccion', $direccion);
                $sqlStatment->bindParam(':presencia_id', $presencia_id);
                

                $sqlStatment->execute();

                $connSQL->commit();
            }
            else {
                $presencia_id = 0;
            }
            
        } catch (PDOException $e) {
            $connSQL->rollBack();
            $presencia_id = 0;
        }

        return $presencia_id;
    }
    public function delete($presencia_id)
    {
        $this->conn->OpenConection();
        $connSQL = $this->conn->getConection();
        try {
            
            if ($connSQL) {
                $connSQL->beginTransaction();
                $sqlStatment = $connSQL->prepare(
                    "DELETE FROM presencia
                    WHERE presencia_id = :presencia_id"
                );
                $sqlStatment->bindParam(':presencia_id', $presencia_id);
                $sqlStatment->execute();

                $connSQL->commit();

            }
        } catch (PDOException $e) {

            $connSQL->rollBack();
            $presencia_id = 0;
         
        }
        return $presencia_id;
        
    }
}






?>