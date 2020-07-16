<?php

class Persona{
    
    private $cedula;
    private $nombres;
    private $apellido;
    private $pin;
    private $foto;
    private $eliminado;

}

class Encargado extends Persona{

    private $email;

    function __construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado, $email)

}

class Transportista extends Persona{

    private $direccion;
    private $telefono;

    function __construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado, $direccion, $telefono)

}


?>