<?php
/**
 * @author    Tim Webster <twebster@reiss.com>
 * @date      3/7/2018
 * @copyright Copyright (c) Reiss Clothing Ltd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSecure\PaResponse;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Info3DSecure extends XmlNodeDefaults
{
    /**
     * @var PaResponse
     */
    private $paResponse;

    public function __construct(
        PaResponse $paResponse
    ) {
        $this->paResponse = $paResponse;
    }

    public function xmlChildren()
    {
        return [
            $this->paResponse
        ];
    }
}
