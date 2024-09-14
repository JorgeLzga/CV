<?php

    class Validation
    {
        private $objMensajesError = array();

        public function __construct()
        {
            
        }

        public function limpiarVariable($variable)
        {
            $variable = trim($variable);
            $variable = stripslashes($variable);
            $variable = htmlspecialchars($variable);

            return $variable;
        }

        public function passwordConfirmation(string $password, string $confirmation) : bool
        {
            return $password == $confirmation;
        }

        public function campoVacio($variable, $nombreCampo)
        {
            if (empty($variable)) {
                $this->objMensajesError[] = "El campo ".$nombreCampo." es necesario.";
            }

            return $this->objMensajesError;
        }

        public function verificarEmail($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
                $this->objMensajesError[] = "No se ha indicado el email o el formato no es el correto.";
            }

            return $this->objMensajesError;
        }
    }

?>