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

/**
 * Stripe Settings Model
 *
 * This is a model used to define the plugin's settings.
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
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $stripePublishableApiKey = '';

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $stripeSectetApiKey = '';

    // Public Methods
    // =========================================================================

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
            ['stripePublishableApiKey', 'string'],
            ['stripePublishableApiKey', 'default', 'value' => ''],
            ['stripeSecretApiKey', 'string'],
            ['stripeSecretApiKey', 'default', 'value' => ''],
        ];
    }
}
