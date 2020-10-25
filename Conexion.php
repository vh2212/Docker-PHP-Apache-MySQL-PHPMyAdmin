<?php
class Conexion
{
    private $Host="";
    private $User="";
    private $Password="";
    private $Database="";
    private $Conection;

    public function __construct()
    {
        $this->Host = "BaseDatos:3306";
        $this->User = "root";
        $this->Password = "123";
        $this->Database = "labsol";
    }

    public function OpenConection()
    {
        try
        {
            $this->Conection = new PDO("mysql:host={$this->Host};dbname={$this->Database}",$this->User, $this->Password
         );
    
         $this->Conection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $e)
        {
            $this->Conection = false;
        }
       
    }
    public function getConection()
    {
    return $this->Conection;
    }
}
$obj = new Conexion();
$obj->Openconection();
if($obj->getConection())
echo "OK";
else {
    echo "no";
}
?>