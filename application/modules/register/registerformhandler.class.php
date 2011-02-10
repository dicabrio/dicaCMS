<?php


class RegisterformHandler implements FormHandler {

	/**
	 * @var FormMapper
	 */
	private $formmapper;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @param FormMapper $formmapper
	 * @param Page $page
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Page $page) {
		$this->formmapper = $formmapper;
		$this->page = $page;
	}

	/**
	 * define the formmapping.
	 */
	private function defineMapping() {

		$this->formmapper->addFormElementToDomainEntityMapping('name', 'RequiredTextLine');
		$this->formmapper->addFormElementToDomainEntityMapping('email', 'RequiredEmail');
		$this->formmapper->addFormElementToDomainEntityMapping('password', 'Password');

	}


	/**
	 * Handle the actual action
	 * @param Form $form
	 */
	public function handleForm(Form $form) {

		$this->defineMapping();

		$data = DataFactory::getInstance();

		try {

			$data->beginTransaction();

			$userGroup = UserGroup::findByName('User');

			$this->formmapper->constructModelsFromForm($form);

			$name = $this->formmapper->getModel('name');
			$email = $this->formmapper->getModel('email');
			$password = $this->formmapper->getModel('password');

			$user = new User();
			$user->setActive(FALSE);
			$user->setEmail($email);
			$user->setName($name);
			$user->setUsername(new Username($email->getValue()));
			$user->setPassword($password);
			$user->addUserGroup($userGroup);
			$user->save();

			$activationKey = sha1($user->getID().Conf::get('secure.salt'));

			$user->setActivationkey($activationKey);
			$user->save();

			include_once('Swift/Events/Listener.php');
			include_once('Swift/Connection/NativeMail.php');
			include_once('Swift/RecipientList.php');


			$view = new View(Conf::get('general.dir.templates').'/register/email-registered.php');
			$view->assign('activateurl', Conf::get('general.url.www').'/'.$this->page->getName().'?activate='.$activationKey);
			$view->assign('name', $name);
			$view->assign('email', $email);
			$view->assign('password', $password);

			$oSwift = new Swift(new Swift_Connection_NativeMail());
			$oRecipients = new Swift_RecipientList();
			$oRecipients->addTo($email->getValue()); //We can give a name along with the address
//
			$oMessage = new Swift_Message(Lang::get('register.emailsubject', $_SERVER['HTTP_HOST']));
			$oMessage->attach(new Swift_Message_Part($view->getContents(), 'text/html', null, 'UTF-8'));
//
			$number_sent = $oSwift->send($oMessage, $oRecipients, $email->getValue());
//
			$data->commit();

			Util::gotoPage(Conf::get('general.url.www').'/'.$this->page->getName().'?registered=1');

		} catch (FormMapperException $e) {
			
		} catch (Exception $e) {
			$this->formmapper->addMappingError('email', 'email-in-use');
			$data->rollBack();
		}
	}

}
