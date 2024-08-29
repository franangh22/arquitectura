<?php
class Usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $contrasena;
    public function getId($id)
    {
        return $this->id = $id;
    }
    public function setNombre($nombre)
    {
        return $this->nombre = $nombre;
    }
    public function getNombre($nombre)
    {
        return $this->nombre = $nombre;
    }
    public function setApellido($apellido)
    {
        return $this->apellido = $apellido;
    }
    public function getApellido($apellido)
    {
        return $this->apellido = $apellido;
    }
    public function setCorreo($correo)
    {
        return $this->correo = $correo;
    }
    public function getCorreo($correo)
    {
        return $this->correo = $correo;
    }
    public function setPass($contrasena)
    {
        return $this->contrasena = $contrasena;
    }
    public function getPass($contrasena)
    {
        return $this->contrasena = $contrasena;
    }
    public function Agregar()
    {
        $sql = "INSERT INTO usuarios (nombre,apellido,correo,contrasena) 
        VALUES ('$this->nombre', '$this->apellido', '$this->correo', '$this->contrasena')";
        $resultado = Database::execute($sql);
        var_dump($resultado);
    }
    public function Eliminar()
    {
        $sql = "DELETE FROM usuarios WHERE id = $this->id";
        $resultado = Database::execute($sql);
        var_dump($resultado);
    }
    public function Actualizar()
    {
        $sql = "UPDATE usuarios SET nombre='$this->nombre',apellido='$this->apellido',correo='$this->correo',contrasena='$this->contrasena' WHERE id = '$this->id'";
        $resultado = Database::execute($sql);
        var_dump($resultado);
    }
    public function BuscarID()
    {
        $sql = "SELECT * FROM usuarios WHERE id = '$this->id' ";
        $resultado = Database::getRecordsbyID($sql);
        var_dump($resultado);
    }
    public function BuscarTodos()
    {
        $sql = "SELECT * FROM usuarios";
        $resultado = Database::getRecords($sql);
        var_dump($resultado);
    }
    private function validate($campo, $campoNombre, $min, $max)
    {
        $msg = '';
        $error = false;
        $campo2 = '';
        if (!isset($_POST[$campo])) {
            $msg = $campoNombre . ' no existe!';
            $error = true;
        } else {
            $campo2 = trim($_POST[$campo]);
            if (empty($campo2)) {
                $msg = $campoNombre . ' no puede estar vacio!';
                $error = true;
            }
            if (strlen($campo2) < $min || strlen($campo2) > $max) {
                $msg = 'tiene que estar entre ' . $min . ' y ' . $max . ' caracteres';
                $error = true;
            }
        }
        $resultado['msg'] = $msg;
        $resultado['error'] = $error;
        $resultado['campo2'] = $campo2;
        return $resultado;
    }
    public function ValidName()
    {
        return $this->validate('nombre', 'nombre', 3, 60);
    }

    public function ValidSurname()
    {
        return $this->validate('apellido', 'apellido', 3, 60);
    }
    public function ValidPass()
    {
        return $this->validate('contrasena', 'contraseña', 3, 60);
    }
    public function ValidEmail()
    {
        $resultado = $this->validate('correo', 'correo', 3, 150);
        if ($resultado['error']) {
            return $resultado;
        }
        if (!filter_var($resultado['campo2'], FILTER_VALIDATE_EMAIL)) {
            $resultado['msg'] = 'formato de correo no valido';
            $resultado['error'] = true;
            return $resultado;
        }
        #duplicado?
        $sql = 'SELECT * FROM usuarios WHERE correo = :correo';
        $params = [':correo' => $resultado['campo2']];
        $rec = Database::getRecordsbyID($sql, $params);
        if ($rec) {
            $resultado['msg'] = 'correo ya existe';
            $resultado['error'] = true;
        }
        return $resultado;
    }
    public function ValidNumber()
    {
        $resultado = $this->validate('id', 'identificador', 1, 100);

        if ($resultado['error']) {
            return $resultado;
        }
        if (is_int($resultado['campo2'])) {
            $resultado['msg'] = 'No es un numero';
            $resultado['error'] = true;
        }
        return $resultado;
    }

    // private function checkvalidate($campo, $campoNombre, $array)
    // {
    //     $msg = '';
    //     $error = false;
    //     $campo2 = '';
    //     if (!isset($_POST[$campo])) {
    //         $msg = $campoNombre . ' no existe';
    //         $error = true;
    //     } else {
    //         $campo2 = trim($_POST[$campo]);
    //         $checkvalid = false;
    //         foreach ($array as $valid) {
    //             if ($campo2 === $valid) {
    //                 $checkvalid = true;
    //                 break;
    //             }
    //         }
    //         if (!$checkvalid) {
    //             $msg = 'tiene que elegir un ' . $campoNombre;
    //             $error = true;
    //         }
    //     }

    //     $resultado['msg'] = $msg;
    //     $resultado['error'] = $error;
    //     $resultado['campo2'] = $campo2;

    //     return $resultado;
    // }
}