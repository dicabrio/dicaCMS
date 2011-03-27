<?php


class ContactformHandler implements FormHandler {

	/**
	 * @var FormMapper
	 */
	private $formmapper;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 *
	 * @var string
	 */
	private $email;

	private $thnxpageid;

	/**
	 * @param FormMapper $formmapper
	 * @param Page $page
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Page $page, $email, $thnxpageid) {
		$this->formmapper = $formmapper;
		$this->page = $page;
		$this->email = $email;
		$this->thnxpageid = $thnxpageid;
	}

	/**
	 * define the formmapping.
	 */
	private function defineMapping() {

		$this->formmapper->addFormElementToDomainEntityMapping('naam', 'RequiredTextLine');
		$this->formmapper->addFormElementToDomainEntityMapping('email', 'RequiredEmail');
		$this->formmapper->addFormElementToDomainEntityMapping('telefoon', 'TextLine');
		$this->formmapper->addFormElementToDomainEntityMapping('bericht', 'RequiredText');

	}


	/**
	 * Handle the actual action
	 * @param Form $form
	 */
	public function handleForm(Form $form) {

		$this->defineMapping();

		try {

			$this->formmapper->constructModelsFromForm($form);

			include_once('Swift/Events/Listener.php');
			include_once('Swift/Connection/NativeMail.php');
			include_once('Swift/Connection/Sendmail.php');
			include_once('Swift/Connection/SMTP.php');
			include_once('Swift/RecipientList.php');

			$email = $this->formmapper->getModel('email');

			$message = 'Name: '.$this->formmapper->getModel('naam')."\n";
			$message .= 'Email: '.$this->formmapper->getModel('email')."\n";
			$message .= 'Phone: '.$this->formmapper->getModel('telefoon')."\n";
			$message .= 'Message: '.$this->formmapper->getModel('bericht')."\n";

			//$oSwift = new Swift(new Swift_Connection_NativeMail());
			//$oSwift = new Swift(new Swift_Connection_Sendmail());
			
			$con = new Swift_Connection_SMTP('smtp.transip.nl');
			//$con = new Swift_Connection_SMTP('smtp.gmail.com');
			//$con->setUsername('robert.cabri@gmail.com');
			//$con->setPassword('DCrob18');
			
			$oSwift = new Swift($con);
			
			$oRecipients = new Swift_RecipientList();
			$oRecipients->addTo($this->email); //We can give a name along with the address

			$oMessage = new Swift_Message(Lang::get('contact.emailsubject', $_SERVER['HTTP_HOST']));
			$oMessage->attach(new Swift_Message_Part($message, 'text/plain', null, 'UTF-8'));

			$number_sent = $oSwift->send($oMessage, $oRecipients, $email->getValue());

			$page = new Page($this->thnxpageid);

			Util::gotoPage(Conf::get('general.url.www').'/'.$page->getName());

		} catch (FormMapperException $e) {

		}
	}

}
