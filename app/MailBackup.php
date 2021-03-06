<?php
/**
 * Created by PhpStorm.
 * User: all
 * Date: 05.02.2016
 * Time: 14:05
 */

namespace App;


/**
 * MailBackup - backup in Mail Disc.
 *
 * @author    Dmitry Mamontov <d.slonyara@gmail.com>
 * @copyright 2015 Dmitry Mamontov <d.slonyara@gmail.com>
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version   Release: 1.1.0
 * @link      https://github.com/dmamontov/davbackup
 * @since     Class available since Release 1.1.0
 * @todo      mail.ru temporarily disable access to WebDAV
 */
class MailBackup extends DavBackup
{
    /**
     * URL to the cloud
     */
    const URL = 'https://webdav.cloud.mail.ru/';

    /**
     * Sets variables
     * @param string $url
     * @param string $login
     * @return void
     * @access public
     */
    public function __construct($login, $password)
    {
        throw new RuntimeException('Mail.ru temporarily disable access to WebDAV');
        //parent::__construct(self::URL, (string) $login, (string) $password);
    }
}
