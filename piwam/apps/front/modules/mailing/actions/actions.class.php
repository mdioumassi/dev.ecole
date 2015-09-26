<?php

/**
 * mailing actions.
 *
 * @package    piwam
 * @subpackage mailing
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mailingActions extends sfActions
{
    /**
     * Executes Index action. Send email to each member if form has been
     * submit.
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->form = new MailingForm(array(), array('url' => $this->getController()->genUrl('membre/ajaxlist')));
        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('mailing'));
            if ($this->form->isValid())
            {
                $associationId = $this->getUser()->getAssociationId();
                $data   = $this->form->getValues();
                $sentOk = 0;    // these are 2 counters of
                $sentKo = 0;    // succeed/failed messages

                try
                {
                    $mailer   = MailerFactory::get($associationId, $this->getUser());
                    $message  = new Swift_Message($data['subject'], $data['mail_content'], 'text/html');
                    $from     = Configurator::get('address', $associationId, 'info-association@piwam.org');
                    $membres  = MembrePeer::doSelectWithEmailForAssociation($this->getUser()->getAssociationId());

                    foreach ($membres as $membre)
                    {
                        try
                        {
                            $mailer->send($message, $membre->getEmail(), $from);
                            $sentOk++;
                        }
                        catch(Swift_ConnectionException $e)
                        {
                            $sentKo++;
                        }
                    }

                    $mailer->disconnect();
                    sfContext::getInstance()->getConfiguration()->loadHelpers('Plural');
                    $this->getUser()->setFlash('notice', 'Votre message a été envoyé à ' . $sentOk . plural_word($sentOk, ' destinataire') . ' (' . $sentKo . plural_word($sentKo, ' erreur') . ')');
                    $this->content = $data['mail_content'];
                }
                catch (Exception $e)
                {
                    //
                }
            }
        }
    }
}
