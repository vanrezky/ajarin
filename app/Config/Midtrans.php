<?php

/**
 * @see       https://github.com/codenomdev/codeigniter4-midtrans for the canonical source repository
 *
 * @copyright 2020 - Codenom Dev (https://codenom.com).
 * @license   https://github.com/codenomdev/codeigniter4-midtrans/blob/main/LICENSE MIT License
 */

namespace Config;

use Codenom\Midtrans\Config\Midtrans as MidtransConfig;

class Midtrans extends MidtransConfig
{
    /**
     * Your merchant's server key.
     */
    public $serverKey = 'Mid-server-0_mw4Oa6y9TaaizjuMjVXy7s';
    /**
     * Your merchant's client key.
     */
    public $clientKey = 'Mid-client-izT-CTgO1EUqSZVD';
    /**
     * Your ID merchant's key.
     */
    public $idMerchant = 'G312906574';
    /**
     * True for production
     * false for sandbox mode.
     */
    public $isProduction = true;
    /**
     * Set it true to enable 3D Secure by default.
     */
    public $is3ds = false;
    /**
     *  Set Append URL notification.
     */
    public $appendNotifUrl = '';
    /**
     *  Set Override URL notification.
     */
    public $overrideNotifUrl = '';
    /**
     * Enable request params sanitizer (validate and modify charge request params).
     * See Midtrans_Sanitizer for more details.
     */
    public $isSanitized = false;
    /**
     * Default options for every request.
     */
    public $curlOptions = [];
}
