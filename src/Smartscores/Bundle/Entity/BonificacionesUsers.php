<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="bonificaciones_users")
    */
    class BonificacionesUsers {

        /**
        * @ORM\Column(type="decimal", length=11)
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        private $id;

        /**
        * @ORM\Column(type="decimal", length=11)
        */
        private $Id_U;

        /**
        * @ORM\Column(type="decimal", length=11)
        */
        private $id_bonificacion;

        /**
        * @ORM\Column(type="decimal", length=8)
        */
        private $fecha;

        /**
         * Get id
         *
         * @return string 
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set Id_U
         *
         * @param decimal $Id_U
         * @return User
         */
        public function setIdUser($id_user)
        {
            $this->Id_U = $id_user;

            return $this;
        }

        /**
         * Get Id_U
         *
         * @return decimal 
         */
        public function getIdUser()
        {
            return $this->Id_U;
        }

        /**
         * Set id_bonificacion
         *
         * @param decimal $id_bonificacion
         * @return User
         */
        public function setIdBonificacion($id_bonificacion)
        {
            $this->id_bonificacion = $id_bonificacion;

            return $this;
        }

        /**
         * Get id_bonificacion
         *
         * @return decimal
         */
        public function getIdBonificacion($id_bonificacion)
        {
            return $this->id_bonificacion;
        }

        /**
         * Set fecha
         *
         * @param string $fecha
         * @return User
         */
        public function setFecha($fecha)
        {
            $this->fecha = $fecha;

            return $this;
        }

        /**
         * Get fecha
         *
         * @return string
         */
        public function getFecha($fecha)
        {
            return $this->fecha;
        }
    }
?>
