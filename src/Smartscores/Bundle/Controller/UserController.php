<?php
    namespace Smartscores\Bundle\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Serializer\Serializer;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
    use Smartscores\Bundle\Entity\User;
    use Smartscores\Bundle\Entity\Scores;
    use Smartscores\Bundle\Entity\Buy_Scores;
    use Smartscores\Bundle\Entity\Buy_Money;
    use Smartscores\Bundle\Entity\BonificacionesUsers;
    use Smartscores\Bundle\Entity\Bonificaciones;

    class UserController extends Controller {

        //  Registro (falta añadir que se pueda registrar
        //  un usuario con un mail que no esté pillado
        //  por un usuario normal, es decir, que puede
        //  estar pillado por un usuario registrado
        //  mediante Facebook)
        public function indexAction(Request $request) {

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
                $user->setActive(0);
                $user->setMailSent(0);
                $user->setPasswordRequest(0);
                $user->setFid(-1);

                try {
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($user);
                    $um->flush();
		    $subject = $this->get('translator')->trans('Rising Scores - Confirmar registro.', array(), 'mails');
                    $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom('info@rising.es')
                        ->setTo($user->getMail())
                        ->addPart(
                            $this->renderView(
                                'SmartscoresBundle:Plantillas:complete_register.html.twig',
                                array('token' => $token)
                            ), 'text/html'
                        )
                    ;

                    //  El usuario se registró y el correo se envió bien
                    if ($this->get('mailer')->send($message) !== false) {
                        $user->setMailSent(1);

                        $um = $this->getDoctrine()->getManager();
                        $um->persist($user);
                        $um->flush();
            		
			$translated = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. En breves instantes recibirás un email con instrucciones para activar tu cuenta.', array(), 'mails');		

                        return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                            'message' => $translated,
                        ));
                    }

                    //  No se pudo enviar el correo
                    else {
			$translated = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. Tu cuenta fue creada, pero no pudimos enviarte el email de activación. Te lo enviaremos en un plazo máximo de 48 horas. Por favor, disculpa las molestias.', array(), 'mails');	

                        return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                            'form' => $form->createView(),
                            'message' => $translated,
                        ));
                    }

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
                        $messages[] = $this->get('translator')->trans('Hubo un error y no se pudo crear tu cuenta. Por favor, inténtalo de nuevo más tarde', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:register.html.twig', array(
                            'form' => $form->createView(),
                            'messages' => $messages,
                        ));
                    }
                }
            }

            //  Página de registro
            else {
                return $this->render('SmartscoresBundle:Plantillas:register.html.twig', array(
                    'form' => $form->createView(),
                    'messages' => $messages,
                ));
            }
        }

	public function index_enAction(Request $request) {

	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $messages = array();

            $user = new User();
            $form = $this->createFormBuilder($user)
                ->add('mail','email', array('label' => false)) 
                ->add('name','text', array('label' => false)) 
                ->add('pass','repeated', array(
                    'type' => 'password',
                    'label' => false, 
                    'invalid_message' => 'Passwords did not match',

                    'first_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'form-control textField margen-inf', 'placeholder' => 'Password')
                    ),
                    'second_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'form-control textField', 'placeholder' => 'Repeat password')
                    )
                )) 
                ->add('Save','submit')
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
                $user->setActive(0);
                $user->setMailSent(0);
                $user->setPasswordRequest(0);
                $user->setFid(-1);

                try {
                    $um = $this->getDoctrine()->getManager();
                    $um->persist($user);
                    $um->flush();
		    $subject = $this->get('translator')->trans('Rising Scores - Confirm register.', array(), 'mails');
                    $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom('info@rising.es')
                        ->setTo($user->getMail())
                        ->addPart(
                            $this->renderView(
                                'SmartscoresBundle:Plantillas:complete_register_en.html.twig',
                                array('token' => $token)
                            ), 'text/html'
                        )
                    ;

                    //  El usuario se registró y el correo se envió bien
                    if ($this->get('mailer')->send($message) !== false) {
                        $user->setMailSent(1);

                        $um = $this->getDoctrine()->getManager();
                        $um->persist($user);
                        $um->flush();
            		
			$translated = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. En breves instantes recibirás un email con instrucciones para activar tu cuenta.', array(), 'mails');		

                        return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                            'message' => $translated,
                        ));
                    }

                    //  No se pudo enviar el correo
                    else {
			$translated = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. Tu cuenta fue creada, pero no pudimos enviarte el email de activación. Te lo enviaremos en un plazo máximo de 48 horas. Por favor, disculpa las molestias.', array(), 'mails');	

                        return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                            'form' => $form->createView(),
                            'message' => $translated,
                        ));
                    }

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
                        $messages[] = $this->get('translator')->trans('Hubo un error y no se pudo crear tu cuenta. Por favor, inténtalo de nuevo más tarde', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:register_en.html.twig', array(
                            'form' => $form->createView(),
                            'messages' => $messages,
                        ));
                    }
                }
            }

            //  Página de registro
            else {
                return $this->render('SmartscoresBundle:Plantillas:register_en.html.twig', array(
                    'form' => $form->createView(),
                    'messages' => $messages,
                ));
            }
        }

        //  Confirmar registro
        public function registerconfirmAction($token) {
            $user = $this->getDoctrine()
                ->getRepository('SmartscoresBundle:User')
                ->findOneByToken($token);

            if (!$user) {
                $message = $this->get('translator')->trans('Token inválido: ' . $token, array(), 'mails');
                return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                    'message' => $message,
                ));
            }
            else {

                //  Un posible atacante acertó con un token: le "engañamos" diciéndole que este token es inválido
                if ($user->getActive() == 1) {
                    $message = $this->get('translator')->trans('Token inválido: ' . $token, array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                        'message' => $message,
                    ));
                }

                else {

                    //  Caducidad del token: 2 días
                    $fechaRegistro = strtotime($user->getDate());
                    $fechaHoy = strtotime('now');
                    $diasTranscurridos = intval( ($fechaHoy - $fechaRegistro) /60/60/24);

                    if ($diasTranscurridos > 2) {
                        try {
                            $um = $this->getDoctrine()->getManager();
                            $um->remove($user);
                            $um->flush();

                            $message = $this->get('translator')->trans('Han pasado más de 48 horas y no se pudo completar el proceso de registro.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                        catch (\Exception $e) {
                            $message = $this->get('translator')->trans('No existe ningún usuario asociado a este token.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                    }

                    //  Confirmar registro
                    else {
                        $user->setActive(1);
                        
                        try {
                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();

                            //  Conceder la bonificación al usuario por registrarse
                            $bonificacionesUsers = new BonificacionesUsers();
                            $bonificacionesUsers->setIdUser($user->getId_U());
                            $bonificacionesUsers->setIdBonificacion(1);
                            $bonificacionesUsers->setFecha(date('Ymd'));
                            $um = $this->getDoctrine()->getManager();
                            $um->persist($bonificacionesUsers);
                            $um->flush();                            

                            $message = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. Ya puedes iniciar sesión en tu cuenta', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                        catch (\Exception $e) {
                            $message = $this->get('translator')->trans('Ocurrió un error que impidió activar tu cuenta. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                    }
                }
            }

            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig');
        }

      public function registerconfirm_enAction($token) {
            $user = $this->getDoctrine()
                ->getRepository('SmartscoresBundle:User')
                ->findOneByToken($token);

            if (!$user) {
                $message = $this->get('translator')->trans('Token inválido: ' . $token, array(), 'mails');
                return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                    'message' => $message,
                ));
            }
            else {

                //  Un posible atacante acertó con un token: le "engañamos" diciéndole que este token es inválido
                if ($user->getActive() == 1) {
                    $message = $this->get('translator')->trans('Token inválido: ' . $token, array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                        'message' => $message,
                    ));
                }

                else {

                    //  Caducidad del token: 2 días
                    $fechaRegistro = strtotime($user->getDate());
                    $fechaHoy = strtotime('now');
                    $diasTranscurridos = intval( ($fechaHoy - $fechaRegistro) /60/60/24);

                    if ($diasTranscurridos > 2) {
                        try {
                            $um = $this->getDoctrine()->getManager();
                            $um->remove($user);
                            $um->flush();

                            $message = $this->get('translator')->trans('Han pasado más de 48 horas y no se pudo completar el proceso de registro.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                        catch (\Exception $e) {
                            $message = $this->get('translator')->trans('No existe ningún usuario asociado a este token.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                    }

                    //  Confirmar registro
                    else {
                        $user->setActive(1);
                        
                        try {
                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();

                            //  Conceder la bonificación al usuario por registrarse
                            $bonificacionesUsers = new BonificacionesUsers();
                            $bonificacionesUsers->setIdUser($user->getId_U());
                            $bonificacionesUsers->setIdBonificacion(1);
                            $bonificacionesUsers->setFecha(date('Ymd'));
                            $um = $this->getDoctrine()->getManager();
                            $um->persist($bonificacionesUsers);
                            $um->flush();                            

                            $message = $this->get('translator')->trans('Gracias por registrarte en Rising Scores. Ya puedes iniciar sesión en tu cuenta', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                        catch (\Exception $e) {
                            $message = $this->get('translator')->trans('Ocurrió un error que impidió activar tu cuenta. Por favor, inténtalo de nuevo más tarde.', array(), 'mails');
                            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                                'message' => $message,
                            ));
                        }
                    }
                }
            }

            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig');
        }

        //  Cambiar clave
        public function newpasswordAction(Request $request, $token) {
            $errors = array();

            $user = $this->getDoctrine()
                ->getRepository('SmartscoresBundle:User')
                ->findOneByToken($token);

            if ($user) {
                if ($user->getPasswordRequest() == 1) {
                    if ($user->getActive() == 1) {

                        $newPass = $request->request->get('newPass',"");
                        $newPassRepeat = $request->request->get('newPassRepeat',"");

                        //  Un usuario ha intentado cambiar su contraseña y sus datos son válidos
                        if (strcmp($newPass,"") != 0) {
                            try {
                                $factory = $this->get('security.encoder_factory');
                                $encoder = $factory->getEncoder($user);
                                $password = $encoder->encodePassword($newPass, $user->getDate());

                                $user->setPass($password);
                                $user->setPasswordRequest(0);

                                $um = $this->getDoctrine()->getManager();
                                $um->persist($user);
                                $um->flush();

                                return $this->redirect($this->generateUrl('smartscores_password_changed'));
                            }
                            catch (\Exception $e) {
                                $errors[] = $this->get('translator')->trans('No se pudo cambiar tu contraseña. Por favor, inténtalo de nuevo.', array(), 'mails');
                                return $this->render('SmartscoresBundle:Plantillas:new_password.html.twig', array(
                                    'errors' => $errors, 'token' => $token
                                ));
                            }
                        }

                        //  Página de nueva contraseña
                        else {
                            return $this->render('SmartscoresBundle:Plantillas:new_password.html.twig', array(
                                'errors' => $errors, 'token' => $token
                            ));
                        }
                    }
//  DE AQUÍ PARA ABAJO, REDIRIGIR A 404 EN EL FUTURO
                    else {
                        $errors[] = $this->get('translator')->trans('Esta cuenta está pendiente de activación', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:new_password.html.twig', array(
                            'errors' => $errors, 'token' => $token
                        ));
                    }
                }

                else {
                    $errors[] = $this->get('translator')->trans('Esta cuenta no tiene pendiente ninguna solicitud de cambio de contraseña', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:new_password.html.twig', array(
                        'errors' => $errors, 'token' => $token
                    ));
                }
            }

            else {
                $errors[] = $this->get('translator')->trans('Token inválido', array(), 'mails');;
                return $this->render('SmartscoresBundle:Plantillas:new_password.html.twig', array(
                    'errors' => $errors, 'token' => $token
                ));
            }
        }
        
	public function newpassword_enAction(Request $request, $token) {
            $errors = array();
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $user = $this->getDoctrine()
                ->getRepository('SmartscoresBundle:User')
                ->findOneByToken($token);

            if ($user) {
                if ($user->getPasswordRequest() == 1) {
                    if ($user->getActive() == 1) {

                        $newPass = $request->request->get('newPass',"");
                        $newPassRepeat = $request->request->get('newPassRepeat',"");

                        //  Un usuario ha intentado cambiar su contraseña y sus datos son válidos
                        if (strcmp($newPass,"") != 0) {
                            try {
                                $factory = $this->get('security.encoder_factory');
                                $encoder = $factory->getEncoder($user);
                                $password = $encoder->encodePassword($newPass, $user->getDate());

                                $user->setPass($password);
                                $user->setPasswordRequest(0);

                                $um = $this->getDoctrine()->getManager();
                                $um->persist($user);
                                $um->flush();

                                return $this->redirect($this->generateUrl('smartscores_password_changed'));
                            }
                            catch (\Exception $e) {
                                $errors[] = $this->get('translator')->trans('No se pudo cambiar tu contraseña. Por favor, inténtalo de nuevo.', array(), 'mails');
                                return $this->render('SmartscoresBundle:Plantillas:new_password_en.html.twig', array(
                                    'errors' => $errors, 'token' => $token
                                ));
                            }
                        }

                        //  Página de nueva contraseña
                        else {
                            return $this->render('SmartscoresBundle:Plantillas:new_password_en.html.twig', array(
                                'errors' => $errors, 'token' => $token
                            ));
                        }
                    }
//  DE AQUÍ PARA ABAJO, REDIRIGIR A 404 EN EL FUTURO
                    else {
                        $errors[] = $this->get('translator')->trans('Esta cuenta está pendiente de activación', array(), 'mails');
                        return $this->render('SmartscoresBundle:Plantillas:new_password_en.html.twig', array(
                            'errors' => $errors, 'token' => $token
                        ));
                    }
                }

                else {
                    $errors[] = $this->get('translator')->trans('Esta cuenta no tiene pendiente ninguna solicitud de cambio de contraseña', array(), 'mails');
                    return $this->render('SmartscoresBundle:Plantillas:new_password_en.html.twig', array(
                        'errors' => $errors, 'token' => $token
                    ));
                }
            }

            else {
                $errors[] = $this->get('translator')->trans('Token inválido', array(), 'mails');;
                return $this->render('SmartscoresBundle:Plantillas:new_password_en.html.twig', array(
                    'errors' => $errors, 'token' => $token
                ));
            }
        }

        //  Contraseña cambiada correctamente
        public function passwordchangedAction() {
            $message = $this->get('translator')->trans('Has cambiado tu contraseña con éxito. Ya puedes usarla para iniciar sesión en Rising Scores.', array(), 'mails');
            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                'message' => $message,
            ));
        }
	
	public function passwordchanged_enAction(Request $request) {
	    $locale = $request->getLocale();
	    $request->setLocale($locale);
            $message = $this->get('translator')->trans('Has cambiado tu contraseña con éxito. Ya puedes usarla para iniciar sesión en Rising Scores.', array(), 'mails');
            return $this->render('SmartscoresBundle:Plantillas:simple_info.html.twig', array(
                'message' => $message,
            ));
        }

        /*

            =========================================================
            Controladores para el registro desde dispositivos móviles
            =========================================================

        */

        //  Registro
        public function indexmobileAction(Request $request) {
            
            //  El método request devuelve variables $_POST (el método query devuelve $_GET)
            $mail = $request->request->get('mail',"");
            $name = $request->request->get('name',"");
            $pass = $request->request->get('pass',"");

            //  Un usuario ha intentado registrarse y sus datos son válidos
            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                //  No hay ningún usuario con ese mail, o el
                //  mail se corresponde con un usuario de Facebook
                if ( (!$user) || ($user->getFid() != -1) ) {

                    $user = new User();

                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $date = date('Ymd');
                    $password = $encoder->encodePassword($pass, $date);

                    $token = $encoder->encodePassword(date('Ymdhis'), $date);
                    $token = str_replace('/','',$token);

                    $user->setMail($mail);
                    $user->setName($name);
                    $user->setPass($password);
                    $user->setDate($date);
                    $user->setToken($token);
                    $user->setActive(0);
                    $user->setMailSent(0);
                    $user->setPasswordRequest(0);
                    $user->setFid(-1);

                    try {
                        $um = $this->getDoctrine()->getManager();
                        $um->persist($user);
                        $um->flush();
			$subject = $this->get('translator')->trans('Rising Scores - Confirmar registro.', array(), 'mails');
                        $message = \Swift_Message::newInstance()
                            ->setSubject($subject)
                            ->setFrom('info@rising.es')
                            ->setTo($mail)
                            ->addPart(
                                $this->renderView(
                                    'SmartscoresBundle:Plantillas:complete_register.html.twig',
                                    array('token' => $token)
                                ), 'text/html'
                            )
                        ;

                        //  El usuario se registró y el correo se envió bien
                        if ($this->get('mailer')->send($message) !== false) {
                            $user->setMailSent(1);

                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();

                            $resultado[] = array("regstatus" => "1");
                            echo json_encode($resultado);
                        }

                        //  No se pudo enviar el correo
                        else {
                            $resultado[] = array("regstatus" => "3");
                            echo json_encode($resultado);
                        }
                    }
                    catch (\Exception $e) {
                        //$resultado[] = array("regstatus" => "4");
                        //echo json_encode($resultado);

                        echo $e->getMessage();
                        return new Response();
                    }
                }

                //  Hay un usuario normal (no Facebook)
                //  con este email en nuestra plataforma
                else {
                    $resultado[] = array("regstatus" => "2");
                    echo json_encode($resultado);
                }
            }

            //  Página de registro
            else {
                $resultado[] = array("regstatus" => "0");
                echo json_encode($resultado);
            }

            return new Response();
        }

	public function indexmobile_enAction(Request $request) {
            
            //  El método request devuelve variables $_POST (el método query devuelve $_GET)
            $mail = $request->request->get('mail',"");
            $name = $request->request->get('name',"");
            $pass = $request->request->get('pass',"");

            //  Un usuario ha intentado registrarse y sus datos son válidos
            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                //  No hay ningún usuario con ese mail, o el
                //  mail se corresponde con un usuario de Facebook
                if ( (!$user) || ($user->getFid() != -1) ) {

                    $user = new User();

                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $date = date('Ymd');
                    $password = $encoder->encodePassword($pass, $date);

                    $token = $encoder->encodePassword(date('Ymdhis'), $date);
                    $token = str_replace('/','',$token);

                    $user->setMail($mail);
                    $user->setName($name);
                    $user->setPass($password);
                    $user->setDate($date);
                    $user->setToken($token);
                    $user->setActive(0);
                    $user->setMailSent(0);
                    $user->setPasswordRequest(0);
                    $user->setFid(-1);

                    try {
                        $um = $this->getDoctrine()->getManager();
                        $um->persist($user);
                        $um->flush();
			$subject = $this->get('translator')->trans('Rising Scores - Confirm register.', array(), 'mails');
                        $message = \Swift_Message::newInstance()
                            ->setSubject($subject)
                            ->setFrom('info@rising.es')
                            ->setTo($mail)
                            ->addPart(
                                $this->renderView(
                                    'SmartscoresBundle:Plantillas:complete_register_en.html.twig',
                                    array('token' => $token)
                                ), 'text/html'
                            )
                        ;

                        //  El usuario se registró y el correo se envió bien
                        if ($this->get('mailer')->send($message) !== false) {
                            $user->setMailSent(1);

                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();

                            $resultado[] = array("regstatus" => "1");
                            echo json_encode($resultado);
                        }

                        //  No se pudo enviar el correo
                        else {
                            $resultado[] = array("regstatus" => "3");
                            echo json_encode($resultado);
                        }
                    }
                    catch (\Exception $e) {
                        //$resultado[] = array("regstatus" => "4");
                        //echo json_encode($resultado);

                        echo $e->getMessage();
                        return new Response();
                    }
                }

                //  Hay un usuario normal (no Facebook)
                //  con este email en nuestra plataforma
                else {
                    $resultado[] = array("regstatus" => "2");
                    echo json_encode($resultado);
                }
            }

            //  Página de registro
            else {
                $resultado[] = array("regstatus" => "0");
                echo json_encode($resultado);
            }

            return new Response();
        }

        //  Login
        public function loginmobileAction(Request $request) {
            $mail = $request->request->get('usuario',"");
            $pass = $request->request->get('password',"");

            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                if ($user && ($user->getFid() == -1)) {

                    if ($user->getActive() == 1) {
                        $factory = $this->get('security.encoder_factory');
                        $encoder = $factory->getEncoder($user);
                        $passwordEncrypted = $encoder->encodePassword($pass, $user->getDate());

                        if (strcmp($user->getPass(),$passwordEncrypted) == 0) {
                            $resultado[]=array("logstatus"=>"1");
                            echo json_encode($resultado);
                        }
                        else {
                            $resultado[]=array("logstatus"=>"2");
                            echo json_encode($resultado);
                        }
                    }
                    else {
                        $resultado[]=array("logstatus"=>"3");
                        echo json_encode($resultado);
                    }
                }
                else {
                    $resultado[]=array("logstatus"=>"2");
                    echo json_encode($resultado);
                }
            }
            else {
                $resultado[]=array("logstatus"=>"-1");
                echo json_encode($resultado);
            }
        
            return new Response();
        }

        //  Olvidó contraseña
        public function forgotpassmobileAction(Request $request) {
            $mail = $request->request->get('mail',"");
            
            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                if ($user && ($user->getFid() == -1)) {
                    if ($user->getActive() == 1) {

                        try {
                            $user->setPasswordRequest(1);

                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();
		    	    $subject_pass = $this->get('translator')->trans('Rising Scores - Recuperar contraseña', array(), 'mails');
                            $message = \Swift_Message::newInstance()
                                ->setSubject($subject_pass)
                                ->setFrom('info@rising.es')
                                ->setTo($mail)
                                ->addPart(
                                    $this->renderView(
                                        'SmartscoresBundle:Plantillas:retrieve_password.html.twig',
                                        array('token' => $user->getToken())
                                    ), 'text/html'
                                )
                            ;

                            //  El correo se envió bien
                            if ($this->get('mailer')->send($message) !== false) {
                                $resultado[]=array("mailstatus"=>"1");
                                echo json_encode($resultado);
                            }

                            //  El correo no se pudo enviar
                            else {
                                $resultado[]=array("mailstatus"=>"4");
                                echo json_encode($resultado);
                            }
                        }
                        catch (\Exception $e) {
                            $resultado[] = array("mailstatus"=>"-1");
                            echo json_encode($resultado);

                            //echo $e->getMessage();
                            return new Response();
                        }
                    }
                    else {
                        $resultado[]=array("mailstatus"=>"3");
                        echo json_encode($resultado);
                    }
                }
                else {
                    $resultado[]=array("mailstatus"=>"2");
                    echo json_encode($resultado);
                }
            }
            else {
                $resultado[]=array("mailstatus"=>"-1");
                echo json_encode($resultado);
            }
    
            return new Response();
        }

 	public function forgotpassmobile_enAction(Request $request) {
            $mail = $request->request->get('mail',"");
            
            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                if ($user && ($user->getFid() == -1)) {
                    if ($user->getActive() == 1) {

                        try {
                            $user->setPasswordRequest(1);

                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();
		    	    $subject_pass = $this->get('translator')->trans('Rising Scores - Password recover', array(), 'mails');
                            $message = \Swift_Message::newInstance()
                                ->setSubject($subject_pass)
                                ->setFrom('info@rising.es')
                                ->setTo($mail)
                                ->addPart(
                                    $this->renderView(
                                        'SmartscoresBundle:Plantillas:retrieve_password.html.twig',
                                        array('token' => $user->getToken())
                                    ), 'text/html'
                                )
                            ;

                            //  El correo se envió bien
                            if ($this->get('mailer')->send($message) !== false) {
                                $resultado[]=array("mailstatus"=>"1");
                                echo json_encode($resultado);
                            }

                            //  El correo no se pudo enviar
                            else {
                                $resultado[]=array("mailstatus"=>"4");
                                echo json_encode($resultado);
                            }
                        }
                        catch (\Exception $e) {
                            $resultado[] = array("mailstatus"=>"-1");
                            echo json_encode($resultado);

                            //echo $e->getMessage();
                            return new Response();
                        }
                    }
                    else {
                        $resultado[]=array("mailstatus"=>"3");
                        echo json_encode($resultado);
                    }
                }
                else {
                    $resultado[]=array("mailstatus"=>"2");
                    echo json_encode($resultado);
                }
            }
            else {
                $resultado[]=array("mailstatus"=>"-1");
                echo json_encode($resultado);
            }
    
            return new Response();
        }

        //  Login mediante Facebook. Si no se encuentra 
        //  un usuario, se le registra
        public function loginfacebookmobileAction(Request $request) {
            $mail = $request->request->get('mail',"");
            $name = $request->request->get('name',"");
            $pass = $request->request->get('pass',"");

            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                //  Se ha encontrado un usuario con este 
                //  email registrado mediante Facebook
                if ( ($user) && ($user->getFid() != -1) ) {

                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $passwordEncrypted = $encoder->encodePassword($pass, $user->getDate());

                    if (strcmp($user->getPass(),$passwordEncrypted) == 0) {
                        $resultado[]=array("facebookStatus"=>"1");
                        echo json_encode($resultado);
                    }

                    //  Contraseña incorrecta
                    else {
                        $resultado[]=array("facebookStatus"=>"2");
                        echo json_encode($resultado);
                    }
                }

                //  No se encontró ningún usuario, de modo que
                //  procedemos al registro mediante Facebook
                else {
                    $user = new User();

                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $date = date('Ymd');
                    $password = $encoder->encodePassword($pass, $date);

                    $token = $encoder->encodePassword(date('Ymdhis'), $date);
                    $token = str_replace('/','',$token);

                    $user->setMail($mail);
                    $user->setName($name);
                    $user->setPass($password);
                    $user->setDate($date);
                    $user->setToken($token);
                    $user->setActive(1);
                    $user->setMailSent(1);
                    $user->setPasswordRequest(0);
                    $user->setFid($pass);

                    try {
                        $um = $this->getDoctrine()->getManager();
                        $um->persist($user);
                        $um->flush();
						
			//  Conceder la bonificación al usuario por registrarse
                        $bonificacionesUsers = new BonificacionesUsers();
                        $bonificacionesUsers->setIdUser($user->getId_U());
                        $bonificacionesUsers->setIdBonificacion(1);
                        $bonificacionesUsers->setFecha(date('Ymd'));
                        $um = $this->getDoctrine()->getManager();
                        $um->persist($bonificacionesUsers);
                        $um->flush(); 

                        $resultado[] = array("facebookStatus" => "3");
                        echo json_encode($resultado);
                    }

                    //  Hubo algún problema durante el proceso de registro
                    catch (\Exception $e) {
                        $resultado[] = array("facebookStatus" => "4");
                        echo json_encode($resultado);

                        return new Response();
                    }
					
                }
            }

            //  No se enviaron datos válidos
            else {
                $resultado[]=array("facebookStatus"=>"-1");
                echo json_encode($resultado);
            }
        
            return new Response();
        }

        //  Un usuario ha intentado eliminar su cuenta
        public function eliminarcuentamobileAction(Request $request) {
            $mail = $request->request->get('mail',"");
            $pass = $request->request->get('pass',"");

            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                if ($user) {
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $passwordEncrypted = $encoder->encodePassword($pass, $user->getDate());

                    if (strcmp($user->getPass(),$passwordEncrypted) == 0) {

                        //  Borrar toda la información asociada a este usuario
                        $userId = $user->getId_U();
                        $um = $this->getDoctrine()->getManager();

                        $sql = "DELETE FROM buy_money WHERE Id_U = '".$userId."'";
                        $stmt = $um->getConnection()->prepare($sql);
                        $stmt->execute();

                        $sql = "DELETE FROM buy_scores WHERE Id_U = '".$userId."'";
                        $stmt = $um->getConnection()->prepare($sql);
                        $stmt->execute();

                        $sql = "DELETE FROM bonificaciones_users WHERE Id_U = '".$userId."'";
                        $stmt = $um->getConnection()->prepare($sql);
                        $stmt->execute();

                        $um->remove($user);
                        $um->flush();

                        $resultado[]=array("eraseAccount"=>"1");
                        echo json_encode($resultado);
                    }
                    else {
                        $resultado[]=array("eraseAccount"=>"3");
                        echo json_encode($resultado);
                    }
                }
                else {
                    $resultado[]=array("eraseAccount"=>"2");
                    echo json_encode($resultado);
                }
            }
            else {
                $resultado[]=array("eraseAccount"=>"-1");
                echo json_encode($resultado);
            }
        
            return new Response();
        }

        //  Un usuario quiere cambiar su contraseña
        public function cambiarclavemobileAction(Request $request) {
            $mail = $request->request->get('mail',"");
            $passOld = $request->request->get('passOld',"");
            $passNew = $request->request->get('passNew',"");

            if ($mail != "") {
                $user = $this->getDoctrine()
                    ->getRepository('SmartscoresBundle:User')
                    ->findOneByMail($mail);

                if ($user) {
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($passOld, $user->getDate());

                    if (strcmp($user->getPass(),$password) == 0) {

                        try {
                            $password = $encoder->encodePassword($passNew, $user->getDate());
                            $user->setPass($password);

                            $um = $this->getDoctrine()->getManager();
                            $um->persist($user);
                            $um->flush();

                            $resultado[]=array("passwordChange"=>"1");
                            echo json_encode($resultado);
                        }
                        catch (\Exception $e) {
                            $resultado[]=array("passwordChange"=>"4");
                            echo json_encode($resultado);

                            return new Response();
                        }
                    }

                    //  Contraseña incorrecta
                    else {
                        $resultado[]=array("passwordChange"=>"3");
                        echo json_encode($resultado);
                    }
                }

                //  No es un usuario válido o es de Facebook
                else {
                    $resultado[]=array("passwordChange"=>"2");
                    echo json_encode($resultado);
                }
            }

            //  Datos inválidos
            else {
                $resultado[]=array("passwordChange"=>"-1");
                echo json_encode($resultado);
            }
            return new Response();
        }

        //  Devuelve la información del usuario
        public function getuserinfoAction(Request $request){
            $user = new User();
            $encoder = new JsonEncoder();
            $normalizer = new GetSetMethodNormalizer();
            $serializer = new Serializer(array($normalizer), array($encoder));
            
            $mail = $request->request->get('mail');	
            
            $user = $this->getDoctrine()
                        ->getRepository('SmartscoresBundle:User')
                        ->findOneByMail($mail);

            $em = $this->getDoctrine()->getManager();
            $query1 = $em -> createQuery("
                SELECT SUM(bm.Money) 
                FROM SmartscoresBundle:User u, SmartscoresBundle:BuyMoney bm 
                WHERE u.id_u = bm.Id_U AND u.mail = '$mail'"); 

            $money1 = $query1->getSingleResult();
            $buy_money = $money1['1'];

            $query2 = $em ->createQuery("
                SELECT SUM(b.cuantia) 
                FROM SmartscoresBundle:User u, SmartscoresBundle:BonificacionesUsers bu, SmartscoresBundle:Bonificaciones b 
                WHERE u.id_u = bu.Id_U AND b.id = bu.id_bonificacion AND u.mail = '$mail'
                "); 
            $money2 = $query2->getSingleResult();
            $bonificaciones = $money2['1'];

            $query3 = $em ->createQuery("
                SELECT SUM(s.Price) 
                FROM SmartscoresBundle:BuyScores bs, SmartscoresBundle:Scores s, SmartscoresBundle:User u 
                WHERE bs.Id_S = s.Id_S AND bs.Id_U = u.id_u AND u.mail = '$mail' 
                ");   
            $money3 = $query3->getSingleResult();
            $buy_scores = $money3['1'];

            $money = $buy_money + $bonificaciones - $buy_scores;

            $userdata['Id_U'] = $user->getId_U();
            $userdata['Mail'] = $user->getMail();
            $userdata['Name'] = $user->getName();
            $userdata['Money'] = $money;	
            $userdatas[0] = $userdata;
            $jsonContent = $serializer->serialize($userdatas, 'json');
            echo $jsonContent;
            
            //  Nombre, Id, Mail, money ((Buy_Money+Bonificaciones) - Buy_Scores)
            return new Response();
        }

    }
?>
