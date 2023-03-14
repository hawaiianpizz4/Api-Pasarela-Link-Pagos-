<?php  
    class Conectar{
        protected $dbh;
        protected function Conexion(){
            try{
                $conectar=$this->dbh= new PDO("mysql:host=210.17.1.36;port=3317;dbname=dwh_icesa","userproy","userproy");
                return $conectar;
            }catch(Exception $e){
                print "!Error BD! : ". $e->getMessage()."<br/>";
                die();
            }
        }
        public function set_names(){
            return $this->dbh->query("Set Names 'utf8'");
        }
    }
?>