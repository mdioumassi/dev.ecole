<?php
/**
 * Build a swift mailer object according to the configuration
 *
 * @author  Adrien Mogenet
 * @since   r154
 */
class MailerFactory
{
    /**
     * Build a swift mailer object according to the configuration.
     * The user is able to select the method he prefers to use
     * for sending emails. By default we use the mail() php function
     *
     * @param   integer                 $associationId
     * @param   sfUser                  $sfUser
     * @return  Swift_ConnectionBase
     */
    public static function get($associationId, $sfUser)
    {
        switch (Configurator::get('method', $associationId, 'mail'))
        {
            case 'gmail': // yes this is just a special case for smtp ;-)
                $methodObject = new Swift_Connection_SMTP('smtp.gmail.com', Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
                $methodObject->setUsername(Configurator::get('gmail_username', $associationId));
                $methodObject->setPassword(Configurator::get('gmail_password', $associationId));

                if (!extension_loaded('openssl'))
                {
                    $sfUser->setFlash('error', 'Le module "openssl" n\'est pas activé. Veuillez l\'activer ou changer la méthode d\'envoi d\' e-mails');
                }
                break;

            case 'smtp':
                $smtpServer = Configurator::get('smtp_server', $associationId);
                $smtpPort = null;
                $smtpEncryption = null;
                $smtpUsername = Configurator::get('smtp_username', $associationId);
                $smtpPassword = Configurator::get('smtp_password', $associationId);
                $methodObject = new Swift_Connection_SMTP($smtpServer, $smtpPort, $smtpEncryption);
                $methodObject->setUsername($smtpUsername);
                $methodObject->setPassword($smtpPassword);
                break;

            case 'sendmail':
                $sendmailPath = Configurator::get('sendmail_path', $associationId, '/usr/bin/sendmail');
                $methodObject = new Swift_Connection_Sendmail($sendmailPath);
                break;

            case 'mail':
                $methodObject = new Swift_Connection_NativeMail();
                break;

            default:
                $methodObject = new Swift_Connection_NativeMail();
                break;
        }

        return new Swift($methodObject);
    }
}
?>