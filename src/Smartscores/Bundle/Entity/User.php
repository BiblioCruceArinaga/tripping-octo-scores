<?php

    namespace Smartscores\Bundle\Entity;
	
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="users")
    */
    class User {

        /**
        * @ORM\Column(type="decimal", length=10)
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        private $id_u;

        /**
        * @ORM\Column(type="string", length=100)
	*
        */
        private $mail;

        /**
        * @ORM\Column(type="string", length=100)
        */
        private $name;

        /**
        * @ORM\Column(type="string", length=100)
        */
        private $pass;

        /**
        * @ORM\Column(type="decimal", length=8)
        */
        private $date;

        /**
        * @ORM\Column(type="decimal", length=1)
        */
        private $active;

        /**
        * @ORM\Column(type="string", length=100)
        */
        private $token;

        /**
        * @ORM\Column(type="decimal", length=1)
        */
        private $mail_sent;

        /**
        * @ORM\Column(type="decimal", length=1)
        */
        private $password_request;

        /**
        * @ORM\Column(type="decimal", length=30)
        */
        private $fid;

        /**
         * Get id_u
         *
         * @return string 
         */
        public function getId_U()
        {
            return $this->id_u;
        }

        /**
         * Set mail
         *
         * @param string $mail
         * @return User
         */
        public function setMail($mail)
        {
            $this->mail = $mail;

            return $this;
        }

        /**
         * Get mail
         *
         * @return string 
         */
        public function getMail()
        {
            return $this->mail;
        }

        /**
         * Set name
         *
         * @param string $name
         * @return User
         */
        public function setName($name)
        {
            $this->name = $name;

            return $this;
        }

        /**
         * Get name
         *
         * @return string 
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Set pass
         *
         * @param string $pass
         * @return User
         */
        public function setPass($pass)
        {
            $this->pass = $pass;

            return $this;
        }

        /**
         * Get pass
         *
         * @return string 
         */
        public function getPass()
        {
            return $this->pass;
        }

        /**
         * Set date
         *
         * @param string $date
         * @return User
         */
        public function setDate($date)
        {
            $this->date = $date;

            return $this;
        }

        /**
         * Get date
         *
         * @return string 
         */
        public function getDate()
        {
            return $this->date;
        }

        /**
         * Set active
         *
         * @param string $active
         * @return User
         */
        public function setActive($active)
        {
            $this->active = $active;

            return $this;
        }

        /**
         * Get active
         *
         * @return string 
         */
        public function getActive()
        {
            return $this->active;
        }

        /**
         * Set token
         *
         * @param string $token
         * @return User
         */
        public function setToken($token)
        {
            $this->token = $token;

            return $this;
        }

        /**
         * Get token
         *
         * @return string 
         */
        public function getToken()
        {
            return $this->token;
        }

        /**
         * Set mail_sent
         *
         * @param string $mail_sent
         * @return User
         */
        public function setMailSent($mail_sent)
        {
            $this->mail_sent = $mail_sent;

            return $this;
        }

        /**
         * Get mail_sent
         *
         * @return string 
         */
        public function getMailSent()
        {
            return $this->mail_sent;
        }

        /**
         * Set password_request
         *
         * @param string $password_request
         * @return User
         */
        public function setPasswordRequest($password_request)
        {
            $this->password_request = $password_request;

            return $this;
        }

        /**
         * Get password_request
         *
         * @return string 
         */
        public function getPasswordRequest()
        {
            return $this->password_request;
        }

        /**
         * Set fid
         *
         * @param string $fid
         * @return User
         */
        public function setFid($fid)
        {
            $this->fid = $fid;

            return $this;
        }

        /**
         * Get fid
         *
         * @return string 
         */
        public function getFid()
        {
            return $this->fid;
        }
    }
?>
