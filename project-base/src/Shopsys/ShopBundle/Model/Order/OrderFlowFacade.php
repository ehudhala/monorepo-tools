<?php

namespace Shopsys\ShopBundle\Model\Order;

use Shopsys\ShopBundle\Form\Front\Order\DomainAwareOrderFlowFactory;

class OrderFlowFacade
{
    /**
     * @var \Shopsys\ShopBundle\Form\Front\Order\DomainAwareOrderFlowFactory
     */
    private $domainAwareOrderFlowFactory;

    /**
     * @param \Shopsys\ShopBundle\Form\Front\Order\DomainAwareOrderFlowFactory $domainAwareOrderFlowFactory
     */
    public function __construct(DomainAwareOrderFlowFactory $domainAwareOrderFlowFactory)
    {
        $this->domainAwareOrderFlowFactory = $domainAwareOrderFlowFactory;
    }

    public function resetOrderForm()
    {
        $orderFlow = $this->domainAwareOrderFlowFactory->create();
        $orderFlow->reset();
    }
}