<?php

namespace App\Services;

use App\Entity\OrderPack;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Google\Service\CloudFunctions\Retry;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Subscription;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StripeService 
{
    const PRODUCT_ID = [
        'PLAN_COMPTE_AGENT' =>  'prod_planCompteAgent',
        'FRACTIONAL_PAYMENT' =>  'prod_fractionalPayment'
    ];

    /**
     * Clés disponibles
     * - ONE_SECTOR
     * - MANY_SECTOR
     */
    const ACCOUNT_SUBSCRIPTION_TYPE = [
        'ONE_SECTOR' =>  'Un secteur',
        'MANY_SECTOR' =>  'Plusieurs secteurs'
    ];

    /**
     * Clés disponibles
     * - ACTIVE
     */
    const PLAN_STATUS = [
        'ACTIVE' =>  'active'
    ];

    const STATUS_CHANGE = [
        'CHANGING' => 'En Changement',
        'ACTIVE' => 'Active'
    ];

    const INTERVAL_UNIT_TO_FRENCH = [
        self::INTERVAL_UNIT_DAY => 'Jour',
        self::INTERVAL_UNIT_WEEK => 'Semaine',
        self::INTERVAL_UNIT_MONTH => 'Mois',
        self::INTERVAL_UNIT_YEAR => 'An'
    ];
    
    const INTERVAL_UNIT_DAY = 'day';
    const INTERVAL_UNIT_WEEK = 'week';
    const INTERVAL_UNIT_MONTH = 'month';
    const INTERVAL_UNIT_YEAR = 'year';

    const INTERVAL_UNIT = [
        self::INTERVAL_UNIT_DAY => self::INTERVAL_UNIT_DAY,
        self::INTERVAL_UNIT_WEEK => self::INTERVAL_UNIT_WEEK,
        self::INTERVAL_UNIT_MONTH => self::INTERVAL_UNIT_MONTH,
        self::INTERVAL_UNIT_YEAR => self::INTERVAL_UNIT_YEAR
    ];

    private $params;
    private $secretKey;
    public $publishablaKey;
    private $session;
    private $repoUser;
    private $em;

    public function __construct(ParameterBagInterface $params, SessionInterface $session, UserRepository $repoUser, EntityManagerInterface $em)
    {
        $this->params = $params;
        Stripe::setApiKey($this->params->get('stripe_secret_key'));

        $this->secretKey = $_ENV['STRIPE_SECRET_KEY'];
        $this->publishablaKey = $_ENV['STRIPE_PUBLIC_KEY'];
        $this->session = $session;
        $this->repoUser = $repoUser;
        $this->em = $em;
    }

    public function getIntervalUnitToEnglish($FrenchIntervalUnit)
    {
        $interval_unit_to_english = [];
        foreach (self::INTERVAL_UNIT_TO_FRENCH as $key => $value) {
            $interval_unit_to_english[$value] = $key;
        }

        return $interval_unit_to_english[$FrenchIntervalUnit];
    }

    public function createCharge($token, $amount, $params): ?string
    {
        $params = array_merge([], $params);
        $params['amount'] = $amount * 100;
        $params['currency'] = $this->params->get('stripe_currency');
        $params['source'] = $token;
        $charge = Charge::create($params);
        return $charge->id;
    }

    
    /**
     * @return object
     */
    public function paymentIntent($amount)
    {
        \Stripe\Stripe::setApiKey($this->secretKey); 
        
        $intentStripe = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' =>  'eur',
            'payment_method_types' =>  ['card']
        ]);

        return $intentStripe;
    }


    public function intentSecret($amount)
    {
        $intent = $this->paymentIntent($amount);

        return $intent['client_secret'] ?? null;
    }

    /**
     * @return object
     */
    public function paymentIntentKarma($amount)
    {
        \Stripe\Stripe::setApiKey($this->secretKey); 
        
        $intentStripe = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' =>  'eur',
            'payment_method_types' =>  ['klarna'],
            

        ]);

        return $intentStripe;
    }

    public function intentSecretKlarna($amount)
    {
        $intent = $this->paymentIntentKarma($amount);

        return $intent['client_secret'] ?? null;
    }

    public function getPaymentMethods($paymentMethodId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $payment_method = $stripe->paymentMethods->retrieve(
            $paymentMethodId
        );

        return $payment_method;
    }
    
    /**
     * Permet de créer un client dans Stripe (souvent relié par un abonnement)
     */
    public function createCustomer($email, $name, $description)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $customer = $stripe->customers->create([
            'description' => $description,
            'email' => $email,
            'name' => $name
        ]);

        return $customer;
    }
    
    public function updateCustomer(string $customerId, $paymentMethodId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $stripe->customers->update(
            $customerId, 
            [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId
                ]
            ]
        );
    }

    public function getCustomer(string $customerId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $customer = $stripe->customers->retrieve(
            $customerId,
            [ ]
        );
        return $customer;
    }

    /**
     * Permet de créer un produit
     *
     * @param string $name
     */
    public function createProduct(string $name)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $product = $stripe->products->create([
            'name' => $name
        ]);

        return $product;
    }
    

    /**
     * Permet de récupérer un produit par son Id
     *
     * @param string $productId
     * @return object
     */
    public function getProduct(string $productId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        try {
            $product = $stripe->products->retrieve(
                $productId
            );
        
            return $product;
        } catch (\Throwable $th) {
            $product  = (object) ['product' => null, 'id' => 'not_found'] ;
            return $product;
        }
    }

    public function allPricesByProduct($productId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $prices = $stripe->prices->all([
            'limit' => 3,
            'product' => $productId
        ]);

        return $prices;
    }


    /**
     * Permet de créer un abonnement sans fin, mais peut être annulé
     *
     * @param [type] $customerId
     * @param [type] $priceId
     * @return void
     */
    public function createSubscription($customerId, $priceId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $subscription = $stripe->subscriptions->create([
            'customer' => $customerId,
            'items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ]
        ]);

        return $subscription;
    
    }

    public function createPrice($amount, $interval_unit, $priceName, string $productId, array $metadata = [])
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $price = $stripe->prices->create([
            'unit_amount' => $amount * 100,
            'currency' => 'eur',
            'recurring' => [
                'interval' => $interval_unit
            ],
            'nickname' => $priceName,
            'product' => $productId
        ]);

        
        if (count($metadata) > 0) {
            $this->updatePrice($price['id'], $metadata);
        }

        return $price;
    }

    public function getPrice(string $priceId)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $price = $stripe->prices->retrieve(
            $priceId,
            []
        );

        return $price;
    }

    public function updatePrice($priceId, object|array $metadata)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        return $stripe->prices->update(
            $priceId,
            [
                'metadata' => $metadata
            ]
        );
    }

    /**
     * Permet de plannifer un abonnement
     * 
     * $start_data : timestamp
     * 
     * $end_behavior 
     * - release : mettra fin au calendrier d'abonnement et conservera l'abonnement sous-jacent
     * - cancel : mettra fin au calendrier d'abonnement et annulera l'abonnement sous-jacent
     */
    public function createSubscriptionSchedule(string $customerId, $start_date, array $phase_sub_shed, string $end_behavior = 'release')
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        // dd($phase_sub_shed);
        // $phases ;
        return $stripe->subscriptionSchedules->create([
            'customer' => $customerId,
            'start_date' => $start_date,
            'end_behavior' => $end_behavior,
            'phases' => [$phase_sub_shed]
            ,
        ]);
    }


    public function updateSubscriptionSchedule(string $sub_sched_id, array $associativeArray)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        return $stripe->subscriptionSchedules->update(
            $sub_sched_id,
            $associativeArray
        );
    }

    /**
     * Permet de créer à la fois un Product et un Price (Qui conduit à un plan d'abonnement)
     * Un produit qui est à titre de "Abonnement compte Agent"
     */
    public function create_Subscription_ProductAndPrice($amount, $interval_unit, $productName, $productDescription, $priceName, $planDescription)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        $stripeDatas = [];

        $existingProduct = $this->getProduct(self::PRODUCT_ID['PLAN_COMPTE_AGENT']);
        if ($existingProduct->id === 'not_found') {
            $product = $stripe->products->create([
                'id' => self::PRODUCT_ID['PLAN_COMPTE_AGENT'],
                'name' => $productName,
                'description' => $productDescription
            ]);
        } else {
            $product = $existingProduct;
        }

        $productId = $product['id'];
        
        $price = $stripe->prices->create([
            'unit_amount' => $amount * 100,
            'currency' => 'eur',
            'recurring' => [
                'interval' => $interval_unit
            ],
            'nickname' => $priceName,
            'product' => $productId
        ]);

        $stripeDatas['productId'] = $productId; 
        $stripeDatas['priceId'] = $price->id; 
        $stripeDatas['priceName'] = $price->nickname; 
        $stripeDatas['description'] = $planDescription; 
        $stripeDatas['amount'] = $price->unit_amount / 100; 
        $stripeDatas['intervallUnit'] = self::INTERVAL_UNIT_TO_FRENCH[$price->recurring->interval]; 
        $stripeDatas['status'] = self::PLAN_STATUS['ACTIVE']; 

        return $stripeDatas;
    }

    /**
     * Normalement, cette fonction permet de plannifier un abonnement, mais ici on opte pour réaliser une facilité de paiement pour les clients
     */
    public function create_SubscriptionSchedule_ProductAndPrice($iteration_payment, $amount_TotalTtc, $interval_unit, $customer_email, $customer_name, $customer_desciption)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);
        
        // 1 => Création Product pour le Price (Stripe) 
        $productName = "Facilité de paiement / Paiement fractionné";
        $productDescription = "Ce produit permet au client d'effectuer une facilité de paiment";

        $existingProduct = $this->getProduct(StripeService::PRODUCT_ID['FRACTIONAL_PAYMENT']);
        if ($existingProduct->id === 'not_found') {
            $product = $stripe->products->create([
                'id' => StripeService::PRODUCT_ID['FRACTIONAL_PAYMENT'],
                'name' => $productName,
                'description' => $productDescription
            ]);
        } else {
            $product = $existingProduct;
        }

        $productId = $product['id'];

        // 2 =>  creation price
        $interval_unit = self::INTERVAL_UNIT_MONTH; // Provisoire
        $priceName = 'Paiement fractionné en '.$iteration_payment.' fois';

        $phase_sub_shed = [];

        $rest_amount_modulo = fmod($amount_TotalTtc, $iteration_payment);
        $isFloat__rest_amount_modulo = $rest_amount_modulo > 0;
        $amout_intval = intval($amount_TotalTtc / $iteration_payment);
        $amount_first_price = $amout_intval + round($rest_amount_modulo, 2);

        // On test si le paiement par tranche laisse des virgules (qui empêchera le calcul exacte du somme des tranches)
        if ($isFloat__rest_amount_modulo === true) {

            $price = $stripe->prices->create([
                'currency' => 'eur',
                'recurring' => [
                    'interval' => $interval_unit, 
                    // 'usage_type' => 'metered' // metered or licenced
                ],
                'nickname' => $priceName,
                'product' => $productId,

                'tiers' => [
                    ['unit_amount' => $amount_first_price * 100, 'up_to' => 1],
                    ['unit_amount' => $amout_intval * 100, 'up_to' => 'inf'],
                ],
                'tiers_mode' => 'graduated',
                'billing_scheme' => 'tiered',
                'expand' => ['tiers'],
            ]);
            
            $phase_sub_shed[] = [
                'items' =>  [[
                    'price' => $price->id,
                    'quantity' => 1
                ]],
                'iterations' => $iteration_payment
            ];

        }else{
            $price = $stripe->prices->create([
                'unit_amount' => $amout_intval * 100,
                'currency' => 'eur',
                'recurring' => [
                    'interval' => $interval_unit
                ],
                'nickname' => $priceName,
                'product' => $productId
            ]);
            $phase_sub_shed[] = [
                'items' =>  [[
                    'price' => $price->id,
                    'quantity' => 1
                ]],
                'iterations' => $iteration_payment
            ];

        }
        
        // On gère l'opération pour la tranche suivante

        // 4 =>  creation customer
        $customer = $this->createCustomer($customer_email, $customer_name, $customer_desciption);
        $subSched = $this->createSubscriptionSchedule($customer->id, 'now', $phase_sub_shed, 'cancel');

        $informations = [
            'customer_id' => $customer->id,
            'price_id' =>  $isFloat__rest_amount_modulo ? '(Price multiples)' : $price->id,
            'subSched_id' => $subSched->id
        ];
        return $informations ;
    }
    
    /**
     *
     * @param array $stripeParameter --- POST's result
     * @param Product $product
     */
    public function getDatasAfterPayment(array $stripeParameter)
    {
        \Stripe\Stripe::setApiKey($this->secretKey);

        // (1) => On récupère le IntentId        
        $stripeIntenId = $stripeParameter['id'];
        
        // (2) => On récupère le PaymentIntent via le IntentId        
        $payement_intent = null;
        if (isset($stripeIntenId)) {
            $payement_intent = \Stripe\PaymentIntent::retrieve($stripeIntenId);
        }

        // (3) => On gère les status du paiement        
        if ($stripeParameter['status'] === 'succeeded') {
            //TODO 
        } else {
            $payement_intent->cancel();
        }

        return $payement_intent;
    }

    
    public function getDatasAfterSubscriptionPlan($priceId, $paymentMethodId, $stripePriceName, User $user)
    {
        $paymentMethod = $this->getPaymentMethods($paymentMethodId);

        if ($user->getStripeCustomerId() == null) {
            $customer = $this->createCustomer($user->getEmail(), $user->getPrenom(), "Client abonnement $stripePriceName");
            $paymentMethod->attach([ 'customer' => $customer['id'] ]);;
            $this->updateCustomer($customer['id'], $paymentMethodId);
                    
            $user->setStripeCustomerId($customer['id']);
            $this->em->persist($user);
            $this->em->flush();
        }else{
            $bddCustomerId = $user->getStripeCustomerId();
            $customer = $this->getCustomer($bddCustomerId);
        }
 
        $subscription = $this->createSubscription($customer['id'], $priceId);
                
        return $subscription;
    }

    public function getSecretKey(){
        return $this->secretKey;
    }


    /**
     * Explication Prorata : https://stripe.com/docs/billing/subscriptions/prorations
     */
    public function updateSubscriptionByPrice($subscriptionId, $newPriceId, $oldPriceId)
    {
        \Stripe\Stripe::setApiKey($this->secretKey);

        $subscription = \Stripe\Subscription::retrieve($subscriptionId);
        \Stripe\Subscription::update(
            $subscriptionId, 
            [
                'payment_behavior' => 'pending_if_incomplete', // Attendre que la période de l'ancien abonnement se termine pour appliquer le nouveau changement
                'proration_behavior' => 'none', //désactiver le calcule du prorata
                // [
                //     'metadata' => [
                //         'description' => 'Migration vers un autre abonnement',
                //         'old_price_id' => $oldPriceId,
                //         'new_price_id' => $newPriceId
                //     ]
                // ],
                'items' => [
                    [
                        'id' => $subscription->items->data[0]->id,
                        'price' => $newPriceId,
                    ],
                ]
            ]
        );
    }

    /**
     * Permet de récupérer une facture à venir pour prévisualiser les modifications apportées à un abonnement
     *
     * @param string $subscriptionId
     * @param string $customerId
     * @param string $newPriceId
     */
    public function getProrationInfo(string $subscriptionId, string $customerId, string $newPriceId)
    {
        \Stripe\Stripe::setApiKey($this->secretKey);

        // Set proration date to this moment:
        // Explication Prorata : https://stripe.com/docs/billing/subscriptions/prorations
        $proration_date = time();

        $subscription = \Stripe\Subscription::retrieve($subscriptionId);

        // See what the next invoice would look like with a price switch
        // and proration set:
        $items = [
            [
                'id' => $subscription->items->data[0]->id,
                'price' => $newPriceId, # Switch to new price
            ],
        ];

        $invoice = \Stripe\Invoice::upcoming([
            'customer' => $customerId,
            'subscription' => $subscriptionId,
            'subscription_items' => $items,
            'subscription_proration_date' => $proration_date,
        ]);
    }

    public function intentSecretByPaymentIntentId($paymentIntentId)
    {
        $intent = $this->getPaymentIntent($paymentIntentId);

        return $intent['client_secret'] ?? null;
    }

    
    public function getPaymentIntent($id)
    {
        return \Stripe\PaymentIntent::retrieve($id, []);
    }

    /**
     * Permet de créer un nouveau Price ou (Plan) d'un produit 
     * Un produit qui est à titre de "Abonnement Aromaforest"
     */
    public function create_recurring_price($amount, $interval_unit, $productName)
    {
        $stripe = new \Stripe\StripeClient($this->secretKey);

        // $reccurringSubscription = $this->orderRepository->findOneBy( ['payment_type' => Order::PAYMENT_TYPE[1]]);
        $product = $this->createProduct($productName);
        $productId = $product['id'];

        $price = $stripe->prices->create([
            'unit_amount' => $amount * 100,
            'currency' => 'eur',
            'recurring' => [
                'interval' => $interval_unit
            ],
            'product' => $productId
        ]);

        return $price;
    }

    public function subscribe($paymentMethodId, $amountSubscription, $userDatas)
    {
        $interval_unit = OrderPack::SUBSCRIPTION_INTERVAL;
        //$iteration = OrderPack::SUBSCRIPTION_ITERATION;
        $productName = OrderPack::SUBSCRIPTION_LABEL;

        $paymentMethod = $this->getPaymentMethods($paymentMethodId);

        $customer = $this->createCustomer($userDatas['mail'], $userDatas['lastname'], $productName);
        $paymentMethod->attach([ 'customer' => $customer['id'] ]);
        $this->updateCustomer($customer['id'], $paymentMethodId);
 
        $price = $this->create_recurring_price($amountSubscription, $interval_unit, $productName);
        $subscription = $this->createSubscription($customer['id'], $price['id']);
        return $subscription;
    }
}