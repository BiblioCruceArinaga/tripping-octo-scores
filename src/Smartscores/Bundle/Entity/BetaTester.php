<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="beta_testers")
    */
    class BetaTester {

        /**
        * @ORM\Column(type="string", length=100)
        * @ORM\Id
        */
        private $email;
    
        /**
         * Set mail
         *
         * @param string $email
         * @return User
         */
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        /**
         * Get email
         *
         * @return string 
         */
        public function getEmail()
        {
            return $this->email;
        }
    }

?>
