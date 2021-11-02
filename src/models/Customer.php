<?php

/**
 * Stripe plugin for Craft CMS 3.x
 *
 * A plugin to add stripe checkout and billing portal support to Craft CMS.
 *
 * @link      https://danieldarrenjones.com
 * @copyright Copyright (c) 2021 Daniel Jones
 */

namespace modn\stripe\models;

use modn\stripe\Stripe;

use Craft;
use craft\base\Model;
use craft\elements\User;

/**
 * Customer Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Daniel Jones
 * @package   Stripe
 * @since     1.0.0
 */
class Customer extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var int|null Customer ID
     */
    public $id;

    /**
     * @var int The user ID
     */
    public $userId;

    /**
     * @var string The Stripe Customer ID
     */
    public $stripeCustomerId;

    /**
     * @var User $_user
     */
    private $_user;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'user',
        ];
    }

    /**
     * Returns the user element associated with this customer.
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user !== null) {
            return $this->_user;
        }

        if (!$this->userId) {
            return null;
        }

        $this->_user = Craft::$app->getUsers()->getUserById($this->userId);

        return $this->_user;
    }

    /**
     * Sets the user this customer is related to.
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->_user = $user;
        $this->userId = $user->id;
    }

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
