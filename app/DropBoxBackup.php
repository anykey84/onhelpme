<?php

namespace App;


/**
 * DropBoxBackup - backup in DropBox.
 *
 * @author    Dmitry Mamontov <d.slonyara@gmail.com>
 * @copyright 2015 Dmitry Mamontov <d.slonyara@gmail.com>
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version   Release: 1.1.0
 * @link      https://github.com/dmamontov/davbackup
 * @since     Class available since Release 1.1.0
 * @todo      working through service dropdav.com
 */
class DropBoxBackup extends DavBackup
{
    /**
     * URL to the cloud
     */
    const URL = 'https://dav.dropdav.com/';

    /**
     * Sets variables
     * @param string $url
     * @param string $login
     * @return void
     * @access public
     */
    public function __construct($login, $password)
    {
        parent::__construct(self::URL, (string) $login, (string) $password);
    }
}