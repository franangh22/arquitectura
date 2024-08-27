<?php
require_once 'usuario.php';
class Creator extends Usuario
{
    public $creator;
    public function setCreator($creator)
    {
        return $this->creator = $creator;
    }
    public function getCreator($creator)
    {
        return $this->creator = $creator;
    }
    public function Actualizar()
    {
        $sql = "UPDATE usuarios SET creator = '$this->creator' WHERE id = '$this->id'";
        $resultado = Database::execute($sql);
        var_dump($resultado);
    }
}