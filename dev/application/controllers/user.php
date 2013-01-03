﻿<?php 
    
    if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */

    class User extends Abstract_backend_controller {
        private $user_id = -1;
        
        /*
        * Display Form for changing email and password
        * 
        * @param string $form
        * @retrun;
        */
        public function changeForm($param1 = NULL, $param2 = NULL) {
            $this->parser->disable_caching();
            
            switch ($param1) {
                case "email":
                case "password":
                case "success":
                case "failure":
                    $name = $param1;
                    break;
                default:
                    $name = NULL;
                    break;
            }
            if (!is_null($name)) {
                $this->parser->assign("param1", $name);
            }
            
            switch ($param2) {
                case "password-short":
                case "password-mismatch":
                case "invalid-email":
                case "email":
                case "email2":
                case "password";
                    $msg = $param2;
                    break;
                default:
                    $msg = NULL;
                    break;
            }
            
            if (!is_null($msg)) {
                $this->parser->assign("param2", $msg);
            }

            $this->parser->parse('backend/user_changeForm.tpl');
        }
        
        /*
        * Procces(check and change) submited Form to change email/password
        * 
        * @param string $form
        * @retrun;
        */
        public function proccesForm($form = NULL) {
            //var_dump($form);
            //var_dump($_POST);
            
            $this->load->library('session');
            $data = $this->session->userdata("logged_in_admin");
            $this->user_id = $data["id"];
            
            $param1 = NULL;
            $param2 = NULL;
            if ($form === "email") {
                $this->load->helper('email');
                $email = $this->input->post("email");
                if (valid_email($email)) {
                    $param1 = "success";
                    $param2 = "email";
                    
                    $this->_sendVerificationEmail($email);
                    
                } else {
                    $param1 = "email";
                    $param2 = "invalid-email";
                }
            }
            
            if ($form === "password") {
                $pwd1 = $this->input->post("password1");
                $pwd2 = $this->input->post("password2");
                $pwd_len = 4;
                
                if (strlen($pwd1) < $pwd_len || strlen($pwd2) < $pwd_len) {
                    $param1 = "password";
                    $param2 = "password-short";
                } else {
                    if ($pwd1 === $pwd2) {
                        $param1 = "success";
                        $param2 = "password";                        
                        
                        if ($this->user_id > 0) {
                            $this->Admins->updatePassword($this->user_id ,$pwd1);
                        } else {
                            $param1 = "password";
                        }
                    } else {
                        $param1 = "password";
                        $param2 = "password-mismatch";
                    }
                }
            }
            
            $this->load->helper('url');
            redirect(createUri("user", "changeForm", array($param1, $param2) ));
        }
        
        public function validateEmail($uid = NULL, $verification = "") {
		
			$this->load->model('Logs');
            
            $admin = $this->load->table_row("admins");
            $admin->load(intval($uid));

            if ($verification != "" && $admin->data("validation_token") == $verification && intval($uid) != 0)  {
                
                if ($this->Admins->updateEmail($uid)) {
					$this->Logs->addLog('Administrator e-mail verification', array('type' => 'e-mail verification', 'result' => 'OK', 'ID' => $uid, 'validation_token' => $verification));
                    $this->changeForm("success", "email2");
                } else {
					$this->Logs->addLog('Administrator e-mail verification', array('type' => 'e-mail verification', 'result' => 'FAILED', 'ID' => $uid, 'validation_token' => $verification));
                    $this->changeForm("failure", "email");
                }
                
            } else {
				$this->Logs->addLog('Administrator e-mail verification', array('type' => 'e-mail verification', 'result' => 'FAILED', 'ID' => $uid, 'validation_token' => $verification));
                $this->changeForm("failure", "email2");				
            }
            
        }
        
        private function _sendVerificationEmail($email) {
            $config = self::getConfigItem('application', 'email');
            
            $this->load->library('email', $config);

            $this->email->initialize($config);
            
            $from = self::getConfigItem('application', 'email_from');
            $from_name = self::getConfigItem('application', 'email_from_name');
            
            $this->email->from($from, $from_name);
            $this->email->to($email); 
            $this->email->subject('Fyzikalna databaza - Zmena emailu');
            
            $token = generateToken();
            $url = createUri("user", "validateEmail", array($this->user_id, $token));
            
            $sprava = "Vžiadali ste si zmenu email-u <br /><br />";
            $sprava .= "Pre dokončenie zmeny klilnite na: \n<a href='$url'>$url</a><br /><br />";
            $sprava .= "Pre dokončenie validácie emailu musíte byť prihlásený so starým emailom.<br /><br />";
            $sprava .= "V prípade, že ste si tento email nevyžiadali ignorujte ho.";
                
            $this->email->message($sprava); 
            
            $this->email->send();
            
            //echo $this->email->print_debugger();
            
            //mail($email, "sprava", $sprava);
            
            $this->Admins->updateNewEmail($this->user_id, $email, $token);
            
        }
        
        
    }