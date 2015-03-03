<?php

use Nette\Application\UI\Form;
use Nette\Application\UI;
class ContactForm extends UI\Control {

    const CAPTCHA_WORD = "knihovna";
    public $onEmailSend;   
    
    /** @var Nette\Mail\IMailer */
    private $mailer;
    
    public function __construct() {
        parent::__construct();
        //$this->mailer = $mailer;        
    }

     public function render() {
        $template = $this->template;
        $template->setFile(__DIR__ . '/contactForm.latte');

        $template->render();
    }

    /**
     * @return Form
     */
    protected function createComponentForm() {
      
        $form = new Form();
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = 'dl';
        $renderer->wrappers['pair']['container'] = NULL;
        $renderer->wrappers['label']['container'] = 'dt';
        $renderer->wrappers['control']['container'] = 'dd';
        $form->addText("name", "Vaše jméno", 20)
                ->addRule(UI\Form::FILLED, "Nevyplnili jste pole 'Jméno'")
                ->setEmptyValue($emptyValue = 'Vaše jméno');
        $form['name']->getControlPrototype()->onkeydown("if (this.value=='" . $emptyValue . "') this.value=''; this.style.color = '#000000'")->onblur("if (this.value=='') {this.value='" . $emptyValue ."'; this.style.color = '#a8a8a8'}");
             
        $form->addText("email2", "Váš e-mail", 45)
                ->setRequired("Nevyplnili jste pole 'E-mail'")
                ->addRule(UI\Form::EMAIL, "Zadali jsme špatný formát do pole 'E-mail'")
                ->setEmptyValue($emptyValue = 'E-mail');
        $form['email2']->getControlPrototype()->onkeydown("if (this.value=='" . $emptyValue . "') this.value=''; this.style.color = '#000000'")->onblur("if (this.value=='') {this.value='" . $emptyValue ."'; this.style.color = '#a8a8a8'}");
        
        $form->addTextArea("content", "Obsah", 45, 5)
                ->setRequired("Obsah je povinný")
                ->setEmptyValue($emptyValue = 'Text zprávy...');
        $form['content']->getControlPrototype()->onkeydown("if (this.value=='" . $emptyValue . "') this.value=''; this.style.color = '#000000'")->onblur("if (this.value=='') {this.value='" . $emptyValue ."'; this.style.color = '#a8a8a8'}");
       
        
        $form->addSubmit("send", "Odeslat");
        $form->onSuccess[] = $this->contactFormSubmit;

        return $form;
    }
    
    
    public function contactFormSubmit($form)
    {
        $values = $form->getValues();
        $this->onEmailSend($this, array(
            "email" => $values->email2, 
            "name" => $values->name, 
            "subject" => "Dotaz z webového formuláře - " . $values->name, 
            "content" => $values->content));
    }
}

interface IContactFormFactory {
    
    /** @return ContactForm */
    function create();
}

