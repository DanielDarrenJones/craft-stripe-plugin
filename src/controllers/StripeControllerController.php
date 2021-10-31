<?php

/**
 * Stripe plugin for Craft CMS 3.x
 *
 * A plugin to add stripe checkout and billing portal support to Craft CMS.
 *
 * @link      https://danieldarrenjones.com
 * @copyright Copyright (c) 2021 Daniel Jones
 */

namespace modn\stripe\controllers;

use modn\stripe\Stripe;

use Craft;
use craft\web\Controller;

/**
 * StripeController Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Daniel Jones
 * @package   Stripe
 * @since     1.0.0
 */
class StripeControllerController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/stripe/stripe-controller
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the StripeControllerController actionIndex() method';

        return $result;
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/stripe/stripe-controller/redirect-checkout
     *
     * @return mixed
     */
    public function actionRedirectCheckout()
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51IFNMKLV5v81FPSLTCyqbZ3h7beOB0klgt4wY1jIUp7ozYJomh1q6mlNvnL1Xku0pG34pFQCWEfOMuIbw9kVVg5m00EEpzOAoE');

        // The price ID passed from the front end.
        //   $priceId = $_POST['priceId'];
        $priceId = '{{PRICE_ID}}';
        $name = Craft::$app->request->getQueryParam('price_id');

        $session = \Stripe\Checkout\Session::create([
            'success_url' => Craft::$app->request->getQueryParam('redirect') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => Craft::$app->request->getQueryParam('cancel_redirect'),
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $priceId,
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        // Redirect to the URL returned on the Checkout Session.
        // With vanilla PHP, you can redirect with:
        header("HTTP/1.1 303 See Other");
        header("Location: " . $session->url);
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/stripe/stripe-controller/redirect-customer-portal
     *
     * @return mixed
     */
    public function actionRedirectCustomerPortal()
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51IFNMKLV5v81FPSLTCyqbZ3h7beOB0klgt4wY1jIUp7ozYJomh1q6mlNvnL1Xku0pG34pFQCWEfOMuIbw9kVVg5m00EEpzOAoE');

        // This is the URL to which the user will be redirected after they have
        // finished managing their billing in the portal.
        $stripe_customer_id = '{{CUSTOMER_ID}}';

        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $stripe_customer_id,
            'return_url' => Craft::$app->request->getQueryParam('redirect'),
        ]);

        // Redirect to the URL for the session
        header("HTTP/1.1 303 See Other");
        header("Location: " . $session->url);
    }
}
