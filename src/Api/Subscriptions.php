<?php
/**
 * User: Joe Linn
 * Date: 3/21/2014
 * Time: 2:43 PM
 */

namespace Stripe\Api;


use Stripe\Request\Subscriptions\CreateSubscriptionRequest;
use Stripe\Request\Subscriptions\UpdateSubscriptionRequest;
use Stripe\Response\Subscriptions\ListSubscriptionsResponse;
use Stripe\Response\Subscriptions\SubscriptionResponse;

class Subscriptions extends AbstractApi
{
    const SUBSCRIPTION_RESPONSE_CLASS = 'Stripe\Response\Subscriptions\SubscriptionResponse';
    const LIST_SUBSCRIPTIONS_RESPONSE_CLASS = 'Stripe\Response\Subscriptions\ListSubscriptionsResponse';

    /**
     * @param string $customerId
     * @param CreateSubscriptionRequest $request
     * @return SubscriptionResponse
     * @link https://stripe.com/docs/api/curl#create_subscription
     */
    public function createSubscription($customerId, CreateSubscriptionRequest $request)
    {
        return $this->client->post($this->buildUrl($customerId), self::SUBSCRIPTION_RESPONSE_CLASS, $request);
    }

    /**
     * @param string $customerId
     * @param string $subscriptionId
     * @return SubscriptionResponse
     * @link https://stripe.com/docs/api/curl#retrieve_subscription
     */
    public function getSubscription($customerId, $subscriptionId)
    {
        return $this->client->get($this->buildUrl($customerId, $subscriptionId), self::SUBSCRIPTION_RESPONSE_CLASS);
    }

    /**
     * @param string $customerId
     * @param string $subscriptionId
     * @param UpdateSubscriptionRequest $request
     * @return SubscriptionResponse
     * @link https://stripe.com/docs/api/curl#update_subscription
     */
    public function updateSubscription($customerId, $subscriptionId, UpdateSubscriptionRequest $request)
    {
        return $this->client->post($this->buildUrl($customerId, $subscriptionId), self::SUBSCRIPTION_RESPONSE_CLASS, $request);
    }

    /**
     * @param string $customerId
     * @param string $subscriptionId
     * @param bool $atPeriodEnd
     * @return SubscriptionResponse
     * @link https://stripe.com/docs/api/curl#cancel_subscription
     */
    public function cancelSubscription($customerId, $subscriptionId, $atPeriodEnd = false)
    {
        return $this->client->delete($this->buildUrl($customerId, $subscriptionId), self::SUBSCRIPTION_RESPONSE_CLASS, null, array('at_period_end' => $atPeriodEnd));
    }

    /**
     * @param string $customerId
     * @param int $count
     * @param int $offset
     * @return ListSubscriptionsResponse
     * @link https://stripe.com/docs/api/curl#list_subscriptions
     */
    public function listSubscriptions($customerId, $count = 10, $offset = 0)
    {
        return $this->client->get($this->buildUrl($customerId), self::LIST_SUBSCRIPTIONS_RESPONSE_CLASS, null, array('count' => $count, 'offset' => $offset));
    }

    /**
     * @param string $plan
     * @return CreateSubscriptionRequest
     */
    public function createSubscriptionRequest($plan)
    {
        return new CreateSubscriptionRequest($plan);
    }

    /**
     * @return UpdateSubscriptionRequest
     */
    public function updateSubscriptionRequest()
    {
        return new UpdateSubscriptionRequest();
    }

    /**
     * @param string $customerId
     * @param string $subscriptionId
     * @return string
     */
    protected function buildUrl($customerId, $subscriptionId = null)
    {
        $url = 'customers/' . $customerId . '/subscriptions';
        if (!is_null($subscriptionId)) {
            $url .= '/' . $subscriptionId;
        }
        return $url;
    }
}
