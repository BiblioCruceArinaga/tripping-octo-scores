<?php
    namespace Smartscores\Bundle\Controller;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Smartscores\Bundle\Entity\User;
    use Smartscores\Bundle\Entity\BonificacionesUsers;
    use Smartscores\Bundle\Entity\BetaTester;

    class IndexController extends Controller {

        //  Formulario de contacto
        public function indexAction(Request $request) {
            
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $name = $request->request->get('name',"");
            $email = $request->request->get('email',"");
            $message = $request->request->get('message',"");             

            if (strcmp($name,"") != 0) {
                try {
		    $subject = $this->get('translator')->trans('Rising Scores - Formulario de contacto', array(), 'mails');
                    $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($email)
                        ->setTo('info@rising.es')
                        ->setBody('Un usuario ha contactado con nosotros. ' .
                        'Nombre: ' . $name . '. Email: ' . $email . 
                        '. Mensaje: ' . $message);

                    //  Hemos recibido el correo
                    if ($this->get('mailer')->send($message) !== false) {
                        $message = $this->get('translator')->trans('Gracias por contactar con nosotros. Te responderemos en un plazo máximo de 48 horas.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                            'message' => $message,
                        ));
                    }

                    //  No hemos recibido el correo
                    else {
                        $message = $this->get('translator')->trans('No hemos podido recibir tu correo. Por favor, inténtalo de nuevo más tarde. Disculpa las molestias.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                            'message' => $message,
                        ));
                    }
                }
                catch (\Exception $e) {
                    $message = $this->get('translator')->trans('Hubo un problema que nos impidió recibir tu mensaje. Por favor, inténtalo de nuevo más tarde. Disculpa las molestias.', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                        'message' => $message,
                    ));
                }
            }

            //  Acceso normal
            else {
                return $this->render('SmartscoresBundle:Plantillas:index.html.twig');
            }
        }

	public function index_enAction(Request $request) {
            
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $name = $request->request->get('name',"");
            $email = $request->request->get('email',"");
            $message = $request->request->get('message',"");             

            if (strcmp($name,"") != 0) {
                try {
		    $subject = $this->get('translator')->trans('Rising Scores - Formulario de contacto', array(), 'mails');
                    $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($email)
                        ->setTo('info@rising.es')
                        ->setBody('Un usuario ha contactado con nosotros. ' .
                        'Nombre: ' . $name . '. Email: ' . $email . 
                        '. Mensaje: ' . $message);

                    //  Hemos recibido el correo
                    if ($this->get('mailer')->send($message) !== false) {
                        $message = $this->get('translator')->trans('Gracias por contactar con nosotros. Te responderemos en un plazo máximo de 48 horas.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:simple_info_en.html.twig', array(
                            'message' => $message,
                        ));
                    }

                    //  No hemos recibido el correo
                    else {
                        $message = $this->get('translator')->trans('No hemos podido recibir tu correo. Por favor, inténtalo de nuevo más tarde. Disculpa las molestias.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:simple_info_en.html.twig', array(
                            'message' => $message,
                        ));
                    }
                }
                catch (\Exception $e) {
                    $message = $this->get('translator')->trans('Hubo un problema que nos impidió recibir tu mensaje. Por favor, inténtalo de nuevo más tarde. Disculpa las molestias.', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:simple_info_en.html.twig', array(
                        'message' => $message,
                    ));
                }
            }

            //  Acceso normal
            else {
                return $this->render('SmartscoresBundle:Plantillas:index_en.html.twig');
            }
        }

        //  Beta testers
        /*public function betatesterAction(Request $request) {
            $email = $request->request->get('email',"");

            //  Un usuario se ha registrado como beta tester
            if (strcmp($email,"") != 0) {
                try {
                    $betaTester = new BetaTester();                
                    $betaTester->setEmail($email . "@gmail.com");

                    $um = $this->getDoctrine()->getManager();
                    $um->persist($betaTester);
                    $um->flush();

                    $message = $this->get('translator')->trans('Gracias por registrarte en Scores.', array(), 'mails');
                }
                catch (\Exception $e) {

                    //  Excepción SQL
                    if (strpos($e->getMessage(), "Duplicate entry") > 0) {
                        $message = $this->get('translator')->trans('Este email se encuentra en uso, por favor elige otro.', array(), 'mails');
                    }

                    //  Error desconocido
                    else {
                        $message = $this->get('translator')->trans('Hubo un error y no pudimos registrarte. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                    }
                }
            }

            //  Dar un 404
            else {
                $message = "404";                
            }

            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                'message' => $message,
            ));
        }

	public function betatester_enAction(Request $request) {
            $email = $request->request->get('email',"");

            //  Un usuario se ha registrado como beta tester
            if (strcmp($email,"") != 0) {
                try {
                    $betaTester = new BetaTester();                
                    $betaTester->setEmail($email . "@gmail.com");

                    $um = $this->getDoctrine()->getManager();
                    $um->persist($betaTester);
                    $um->flush();

                    $message = $this->get('translator')->trans('Gracias por registrarte en Scores.', array(), 'mails');
                }
                catch (\Exception $e) {

                    //  Excepción SQL
                    if (strpos($e->getMessage(), "Duplicate entry") > 0) {
                        $message = $this->get('translator')->trans('Este email se encuentra en uso, por favor elige otro.', array(), 'mails');
                    }

                    //  Error desconocido
                    else {
                        $message = $this->get('translator')->trans('Hubo un error y no pudimos registrarte. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                    }
                }
            }

            //  Dar un 404
            else {
                $message = "404";                
            }

            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                'message' => $message,
            ));
        }*/

        //  Invitar amigos
        public function invitarAction(Request $request) {
            $errors = array();
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $email1 = $request->request->get('email1',"");
            $email2 = $request->request->get('email2',"");
            $email3 = $request->request->get('email3',"");
            $email4 = $request->request->get('email4',"");
            $email5 = $request->request->get('email5',"");
            $usuario = $request->request->get('usuario',"");

            //  Un usuario ha enviado invitaciones
            if (strcmp($usuario,"") != 0) {
                try {

                    $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByName($usuario);

                    if ($user) {

                        $direcciones = array();
                        if (strcmp($email1,"") != 0) $direcciones[] = $email1; 
                        if (strcmp($email2,"") != 0) $direcciones[] = $email2; 
                        if (strcmp($email3,"") != 0) $direcciones[] = $email3; 
                        if (strcmp($email4,"") != 0) $direcciones[] = $email4; 
                        if (strcmp($email5,"") != 0) $direcciones[] = $email5; 

                        if (count($direcciones) > 0) {
			    $subject_invitation1 = $this->get('translator')->trans('Rising Scores', array(), 'mails');
			    $subject_invitation2 = $this->get('translator')->trans('te invita a probar Scores', array(), 'mails');
                            $message = \Swift_Message::newInstance()
                                ->setSubject($subject_invitation1. ' - ' . $usuario . ' ' .$subject_invitation2)
                                ->setFrom('info@rising.es')
                                ->setTo($direcciones)
                                ->addPart(
                                    $this->renderView(
                                        'SmartscoresBundle:Plantillas:mail-invitacion.html.twig',
                                        array('usuario' => $usuario, 'token' => $user->getToken())
                                    ), 'text/html'
                                )
                            ;

                            //  Se han enviado las invitaciones
                            if ($this->get('mailer')->send($message) !== false) {
                                $message = $this->get('translator')->trans('Has enviado con éxito las invitaciones. Gracias por contribuir al crecimiento de Scores.', array(), 'mails');
                                return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                    'message' => $message,
                                ));
                            }

                            //  No se han enviado las invitaciones
                            else {
                                $errors[] = $this->get('translator')->trans('No hemos podido enviar las invitaciones. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                                return $this->render('SmartscoresBundle:Plantillas:invitar.html.twig', array(
                                    'errors' => $errors,
                                ));
                            }
                        }

                        //  El usuario ha enviado el formulario sin poner ningún email
                        else {
                            $errors[] = $this->get('translator')->trans('Por favor, escribe al menos una dirección de correo válida.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:invitar.html.twig', array(
                                'errors' => $errors,
                            ));
                        }
                    }

                    //  El usuario no existe
                    else {
                        $errors[] = $this->get('translator')->trans('No hemos encontrado un usuario que coincida con el nombre que has puesto.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:invitar.html.twig', array(
                            'errors' => $errors,
                        ));
                    }
                }
                catch (\Exception $e) {

                    //  Error desconocido
                    $errors[] = $this->get('translator')->trans('Hubo un error y no pudimos enviar las invitaciones. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:invitar.html.twig', array(
                        'errors' => $errors,
                    ));
                }
            }

            //  Acceso normal a la página de invitaciones
            else {
                return $this->render('SmartscoresBundle:Plantillas:invitar.html.twig', array(
                    'errors' => $errors,
                ));
            }
        }

	public function invitar_enAction(Request $request) {
            $errors = array();
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $email1 = $request->request->get('email1',"");
            $email2 = $request->request->get('email2',"");
            $email3 = $request->request->get('email3',"");
            $email4 = $request->request->get('email4',"");
            $email5 = $request->request->get('email5',"");
            $usuario = $request->request->get('usuario',"");

            //  Un usuario ha enviado invitaciones
            if (strcmp($usuario,"") != 0) {
                try {

                    $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByName($usuario);

                    if ($user) {

                        $direcciones = array();
                        if (strcmp($email1,"") != 0) $direcciones[] = $email1; 
                        if (strcmp($email2,"") != 0) $direcciones[] = $email2; 
                        if (strcmp($email3,"") != 0) $direcciones[] = $email3; 
                        if (strcmp($email4,"") != 0) $direcciones[] = $email4; 
                        if (strcmp($email5,"") != 0) $direcciones[] = $email5; 

                        if (count($direcciones) > 0) {
			    $subject_invitation1 = $this->get('translator')->trans('Rising Scores', array(), 'mails');
			    $subject_invitation2 = $this->get('translator')->trans('te invita a probar Scores', array(), 'mails');
                            $message = \Swift_Message::newInstance()
                                ->setSubject($subject_invitation1. ' - ' . $usuario . ' ' .$subject_invitation2)
                                ->setFrom('info@rising.es')
                                ->setTo($direcciones)
                                ->addPart(
                                    $this->renderView(
                                        'SmartscoresBundle:Plantillas:mail-invitacion_en.html.twig',
                                        array('usuario' => $usuario, 'token' => $user->getToken())
                                    ), 'text/html'
                                )
                            ;

                            //  Se han enviado las invitaciones
                            if ($this->get('mailer')->send($message) !== false) {
                                $message = $this->get('translator')->trans('Has enviado con éxito las invitaciones. Gracias por contribuir al crecimiento de Scores.', array(), 'mails');
                                return $this->render('SmartscoresBundle:Plantillas:simple_info_en.html.twig', array(
                                    'message' => $message,
                                ));
                            }

                            //  No se han enviado las invitaciones
                            else {
                                $errors[] = $this->get('translator')->trans('No hemos podido enviar las invitaciones. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                                return $this->render('SmartscoresBundle:Plantillas:invitar_en.html.twig', array(
                                    'errors' => $errors,
                                ));
                            }
                        }

                        //  El usuario ha enviado el formulario sin poner ningún email
                        else {
                            $errors[] = $this->get('translator')->trans('Por favor, escribe al menos una dirección de correo válida.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:invitar_en.html.twig', array(
                                'errors' => $errors,
                            ));
                        }
                    }

                    //  El usuario no existe
                    else {
                        $errors[] = $this->get('translator')->trans('No hemos encontrado un usuario que coincida con el nombre que has puesto.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:invitar_en.html.twig', array(
                            'errors' => $errors,
                        ));
                    }
                }
                catch (\Exception $e) {

                    //  Error desconocido
                    $errors[] = $this->get('translator')->trans('Hubo un error y no pudimos enviar las invitaciones. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:invitar_en.html.twig', array(
                        'errors' => $errors,
                    ));
                }
            }

            //  Acceso normal a la página de invitaciones
            else {
                return $this->render('SmartscoresBundle:Plantillas:invitar_en.html.twig', array(
                    'errors' => $errors,
                ));
            }
        }

        //  Aceptar invitación
        public function aceptarinvitacionAction(Request $request) {

            $messages = array();

            $user = new User();
            $form = $this->createFormBuilder($user)
                ->add('mail','email', array('label' => false)) 
                ->add('name','text', array('label' => false)) 
                ->add('pass','repeated', array(
                    'type' => 'password',
                    'label' => false, 
                    'invalid_message' => 'Las contraseñas no coinciden',

                    'first_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'form-control textField margen-inf', 'placeholder' => 'Contraseña')
                    ),
                    'second_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'form-control textField', 'placeholder' => 'Repetir contraseña')
                    )
                )) 
                ->add('Guardar','submit')
                ->getForm();
            
            $form->handleRequest($request);

            //  Un usuario ha intentado registrarse y sus datos son válidos
            if ($form->isValid()) {
                $data = $form->getData();

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $date = date('Ymd');
                $password = $encoder->encodePassword($data->getPass(), $date);

                $token = $encoder->encodePassword(date('Ymdhis'), $date);
                $token = str_replace('/','',$token);

                $user->setMail($data->getMail());
                $user->setName($data->getName());
                $user->setPass($password);
                $user->setDate($date);
                $user->setToken($token);
                $user->setActive(1);
                $user->setMailSent(1);
                $user->setPasswordRequest(0);
                $user->setFid(-1);

                try {
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($user);
                    $um->flush();

                    //  Bonificación para el usuario recién registrado
                    $bonificacionesUsers = new BonificacionesUsers();
                    $bonificacionesUsers->setIdUser($user->getId());
                    $bonificacionesUsers->setIdBonificacion(1);
                    $bonificacionesUsers->setFecha(date('Ymd'));
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($bonificacionesUsers);
                    $um->flush();

                    //  Bonificación para el usuario que envió la invitación
                    $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByToken($request->get('token'));
                    $bonificacionesUsers = new BonificacionesUsers();
                    $bonificacionesUsers->setIdUser($user->getId());
                    $bonificacionesUsers->setIdBonificacion(2);
                    $bonificacionesUsers->setFecha(date('Ymd'));
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($bonificacionesUsers);
                    $um->flush();

                    $message = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. Ya puedes iniciar sesión en tu cuenta.', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                        'message' => $message,
                    ));
                }
                catch (\Exception $e) {

                    //  Excepción SQL
                    if (strpos($e->getMessage(), "Duplicate entry") > 0) {
                        $messages[] = $this->get('translator')->trans('Este email se encuentra en uso, por favor elige otro.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:register.html.twig', array(
                            'form' => $form->createView(),
                            'messages' => $messages,
                        ));
                    }

                    //  Error desconocido
                    else {
                        $messages[] = $this->get('translator')->trans('Hubo un error y no se pudo crear tu cuenta. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:register.html.twig', array(
                            'form' => $form->createView(),
                            'messages' => $messages,
                        ));
                    }
                }
            }

            //  Página de aceptar invitación
            else {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByToken($request->get('token'));

                if ($user) {
                    return $this->render('SmartscoresBundle:Plantillas:register.html.twig', array(
                        'form' => $form->createView(),
                        'messages' => $messages,
                    ));
                }

                //  Token inválido, en el futuro redirigir a 404
                else {
                    return $this->redirect($this->generateUrl('smartscores_homepage'));
                }
            }
        }

	public function aceptarinvitacion_enAction(Request $request) {

            $messages = array();
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $user = new User();
            $form = $this->createFormBuilder($user)
                ->add('mail','email', array('label' => false)) 
                ->add('name','text', array('label' => false)) 
                ->add('pass','repeated', array(
                    'type' => 'password',
                    'label' => false, 
                    'invalid_message' => 'Las contraseñas no coinciden',

                    'first_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'form-control textField margen-inf', 'placeholder' => 'Password')
                    ),
                    'second_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'form-control textField', 'placeholder' => 'Repeat password')
                    )
                )) 
                ->add('Guardar','submit')
                ->getForm();
            
            $form->handleRequest($request);

            //  Un usuario ha intentado registrarse y sus datos son válidos
            if ($form->isValid()) {
                $data = $form->getData();

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $date = date('Ymd');
                $password = $encoder->encodePassword($data->getPass(), $date);

                $token = $encoder->encodePassword(date('Ymdhis'), $date);
                $token = str_replace('/','',$token);

                $user->setMail($data->getMail());
                $user->setName($data->getName());
                $user->setPass($password);
                $user->setDate($date);
                $user->setToken($token);
                $user->setActive(1);
                $user->setMailSent(1);
                $user->setPasswordRequest(0);
                $user->setFid(-1);

                try {
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($user);
                    $um->flush();

                    //  Bonificación para el usuario recién registrado
                    $bonificacionesUsers = new BonificacionesUsers();
                    $bonificacionesUsers->setIdUser($user->getId_U());
                    $bonificacionesUsers->setIdBonificacion(1);
                    $bonificacionesUsers->setFecha(date('Ymd'));
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($bonificacionesUsers);
                    $um->flush();

                    //  Bonificación para el usuario que envió la invitación
                    $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByToken($request->get('token'));
                    $bonificacionesUsers = new BonificacionesUsers();
                    $bonificacionesUsers->setIdUser($user->getId_U());
                    $bonificacionesUsers->setIdBonificacion(2);
                    $bonificacionesUsers->setFecha(date('Ymd'));
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($bonificacionesUsers);
                    $um->flush();

                    $message = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. Ya puedes iniciar sesión en tu cuenta', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:simple_info_en.html.twig', array(
                        'message' => $message,
                    ));
                }
                catch (\Exception $e) {

                    //  Excepción SQL
                    if (strpos($e->getMessage(), "Duplicate entry") > 0) {
                        $messages[] = $this->get('translator')->trans('Este email se encuentra en uso, por favor elige otro.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:register_en.html.twig', array(
                            'form' => $form->createView(),
                            'messages' => $messages,
                        ));
                    }

                    //  Error desconocido
                    else {
                        $messages[] = $this->get('translator')->trans('Hubo un error y no se pudo crear tu cuenta. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:register_en.html.twig', array(
                            'form' => $form->createView(),
                            'messages' => $messages,
                        ));
                    }
                }
            }

            //  Página de aceptar invitación
            else {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByToken($request->get('token'));

                if ($user) {
                    return $this->render('SmartscoresBundle:Plantillas:register_en.html.twig', array(
                        'form' => $form->createView(),
                        'messages' => $messages,
                    ));
                }

                //  Token inválido, en el futuro redirigir a 404
                else {
                    return $this->redirect($this->generateUrl('smartscores_homepage_en'));
                }
            }
        }

        //  Publicar un post en Facebook
        public function facebookAction() {
            $appId = '1439111256308763';
            $secret = '4123c72fabba486a2c1337d8b8f23de2';
            $returnurl = 'http://scores.rising.es/';
            $permissions = 'publish_stream';

            $fb = new \Facebook(array('appId'=>$appId, 'secret'=>$secret));
            $fbuser = $fb->getUser();

            if($fbuser){

                try {
                    $ret_obj = $fb->api('/me/feed', 'POST',
                    array(
                        'link' => 'www.google.es',
                        'message' => 'Posting with the PHP SDK!'
                    ));

                    echo '<pre>Post ID: ' . $ret_obj['id'] . '</pre>';
                    echo '<br /><a href="' . $fb->getLogoutUrl(
                        array('next' => 'http://scores.rising.es/cerrar-sesion-facebook')
                    ) . '">logout</a>';
                }
                catch (\FacebookApiException $e) {
                    $login_url = $facebook->getLoginUrl( array(
                       'scope' => 'publish_stream'
                       )); 
                    echo 'Please <a href="' . $login_url . '">login.</a>';
                    error_log($e->getType());
                    error_log($e->getMessage());
                }

            }else{
                $fbloginurl = $fb->getLoginUrl(array('redirect-uri'=>$returnurl, 'scope'=>$permissions));
                echo '<a href="'.$fbloginurl.'">Login with Facebook</a>';
            }

            return new Response();
        }

        //  Cerrar sesión
        public function facebookdestroyAction() {
            session_start();
            session_destroy();
    
            $message = $this->get('translator')->trans('Gracias por hablar de nosotros en Facebook. Como agradecimiento, hemos añadido un poco de saldo a tu cuenta', array(), 'mails');
            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                'message' => $message,
            ));
        }

        //  Información sobre cómo ganar saldo
        public function bonificacionesAction(Request $request) {
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            return $this->render('SmartscoresBundle:Plantillas:bonificaciones-saldo.html.twig');
        }

	public function bonificaciones_enAction(Request $request) {
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            return $this->render('SmartscoresBundle:Plantillas:bonificaciones-saldo_en.html.twig');
        }

        //  Aviso legal
        public function avisolegalAction() {
            return $this->render('SmartscoresBundle:Plantillas:aviso-legal.html.twig');
        }

        public function avisolegal_enAction(Request $request) {
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            return $this->render('SmartscoresBundle:Plantillas:aviso-legal_en.html.twig');
        }

        //  Política de privacidad
        public function politicaprivacidadAction() {
            return $this->render('SmartscoresBundle:Plantillas:politica-privacidad.html.twig');
        }

	public function politicaprivacidad_enAction(Request $request) {
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            return $this->render('SmartscoresBundle:Plantillas:politica-privacidad_en.html.twig');
        }

        //  Copyright
        public function copyrightAction() {
            return $this->render('SmartscoresBundle:Plantillas:copyright.html.twig');
        }
	
	public function copyright_enAction(Request $request) {
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            return $this->render('SmartscoresBundle:Plantillas:copyright_en.html.twig');
        }

        /*
            ================================
            Controladores para la aplicación
            ================================
        */

        //  Un usuario nos envía Feedback
        public function enviarfeedbackmobileAction(Request $request) {
            $email = $request->request->get('mail',"");
            $message = $request->request->get('message',"");             

            if (strcmp($email,"") != 0) {
                try {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Rising Scores - Feedback')
                        ->setFrom($email)
                        ->setTo('info@rising.es')
                        ->setBody('Un usuario nos ha enviado Feedback. ' .
                        'Email: ' . $email . '. Mensaje: ' . $message);

                    //  Hemos recibido el correo
                    if ($this->get('mailer')->send($message) !== false) {
                        $resultado[]=array("feedbackSent"=>"1");
                        echo json_encode($resultado);
                    }

                    //  No hemos recibido el correo
                    else {
                        $resultado[]=array("feedbackSent"=>"-1");
                        echo json_encode($resultado);
                    }
                }
                catch (\Exception $e) {
                    $resultado[]=array("feedbackSent"=>"-1");
                    echo json_encode($resultado);
                }
            }

            else {
                $resultado[]=array("feedbackSent"=>"-1");
                echo json_encode($resultado);
            }

            return new Response();
        }

  //  Invitar amigos
        public function invitar_mobileAction(Request $request) {
            $errors = array();
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $email1 = $request->request->get('email1',"");
            $usuario = $request->request->get('usuario',"");

            //  Un usuario ha enviado una invitación
            if ($usuario != null) {/*0*/
                try {

                    $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByMail($usuario);

                    if ($user) {/*1*/

                        $direcciones = array();
                        if (strcmp($email1,"") != 0) $direcciones[] = $email1; 

                        if (count($direcciones) > 0) {/*2*/
			    $subject_invitation1 = $this->get('translator')->trans('Rising Scores', array(), 'mails');
			    $subject_invitation2 = $this->get('translator')->trans('te invita a probar Scores', array(), 'mails');
                            $message = \Swift_Message::newInstance()
                                ->setSubject($subject_invitation1. ' - ' . $usuario . ' ' .$subject_invitation2)
                                ->setFrom('info@rising.es')
                                ->setTo($direcciones)
                                ->addPart(
                                    $this->renderView(
                                        'SmartscoresBundle:Plantillas:mail-invitacion.html.twig',
                                        array('usuario' => $usuario, 'token' => $user->getToken())
                                    ), 'text/html'
                                )
                            ;

                            //  Se han enviado las invitaciones
                            if ($this->get('mailer')->send($message) !== false) {/*3*/
                                $message = [array("invitation" => $this->get('translator')->trans('Has enviado con éxito las invitaciones. Gracias por contribuir al crecimiento de Scores.'))];
                                echo json_encode($message);
                            }

                            //  No se han enviado las invitaciones
                            else {/*3*/
                                $errors[] = array("invitation" => $this->get('translator')->trans('No hemos podido enviar las invitaciones. Por favor, inténtalo de nuevo más tarde.'));
                                echo json_encode($errors);
                            }
                        }

                        //  El usuario ha enviado el formulario sin poner ningún email
                        else {/*2*/
                            $errors[] = array("invitation" => $this->get('translator')->trans('Por favor, escribe al menos una dirección de correo válida.'));
                            echo json_encode($errors);
                        }
                    }

                    //  El usuario no existe
                    else {/*1*/
                        $errors[] = array("invitation" => $this->get('translator')->trans('No hemos encontrado un usuario que coincida con el nombre que has puesto.'));
                        echo json_encode($errors);
                    }
                }
                catch (\Exception $e) {

                    //  Error desconocido
                    $errors[] = $this->get('translator')->trans('Hubo un error y no pudimos enviar las invitaciones. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                    echo json_encode($errors);
echo $e->getMessage();
                }
            }

            //  Acceso normal a la página de invitaciones
            else {/*0*/
                echo json_encode($errors);
            }

	    return new Response();
        }



	public function invitar_mobile_enAction(Request $request) {
            $errors = array();
	    $locale = $request->getLocale();
	    $request->setLocale($locale);

            $email1 = $request->request->get('email1',"");
            $usuario = $request->request->get('usuario',"");

            //  Un usuario ha enviado una invitación
            if ($usuario != null) {
                try {

                    $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByMail($usuario);

                    if ($user) {

                        if (strcmp($email1,"") != 0) {
			    $subject_invitation1 = $this->get('translator')->trans('Rising Scores', array(), 'mails');
			    $subject_invitation2 = $this->get('translator')->trans('te invita a probar Scores', array(), 'mails');
                            $message = \Swift_Message::newInstance()
                                ->setSubject($subject_invitation1. ' - ' . $usuario . ' ' .$subject_invitation2)
                                ->setFrom('info@rising.es')
                                ->setTo($email1)
                                ->addPart(
                                    $this->renderView(
                                        'SmartscoresBundle:Plantillas:mail-invitacion_en.html.twig',
                                        array('usuario' => $usuario, 'token' => $user->getToken())
                                    ), 'text/html'
                                );

                            //  Se han enviado las invitaciones
                            if ($this->get('mailer')->send($message) !== false) {
                                $confirm = [array("invitation" => "You have successfully sent invitations")];		
                                echo json_encode($confirm);
                            }
 
                            //  No se han enviado las invitaciones
                            else {
                                $errors[] = array("invitation" =>'We could not send the invitations. Try again later.');
                                echo json_encode($errors);
                            }
                        }

                        //  El usuario ha enviado el formulario sin poner ningún email
                        else {
                            $errors[] = array("invitation" => 'Please, write a valid email.');
                            echo json_encode($errors);
                        }
                    }

                    //  El usuario no existe
                    else {
                        $errors[] = array("invitation" => 'We could not find you in the database');
                        echo json_encode($errors);
                    }
                }
                catch (\Exception $e) {

                    //  Error desconocido
                    $errors[] = array("invitation" => 'We could not send the invitations. Try again later');
                    echo json_encode($errors);
                }
            }

            //  Acceso normal a la página de invitaciones
            else {
                echo json_encode($errors);
            }

	    return new Response();
        }

    }
?>
