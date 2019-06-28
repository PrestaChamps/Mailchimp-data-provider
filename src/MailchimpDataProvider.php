<?php
/**
 * @author    Zoltan Szanto <zoli@prestachamps.com>
 * @copyright Prestachamps
 * @license   MIT
 */

namespace PrestaChamps;

use DrewM\MailChimp\MailChimp;
use yii\data\BaseDataProvider;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;

class MailchimpDataProvider extends BaseDataProvider implements DataProviderInterface
{
    /**
     * @var $client MailChimp
     */
    protected $client;
    protected $apiResponse;
    public $apiKey;
    public $endpoint;
    public $path;
    public $entity;

    public function init()
    {
        parent::init();
        $this->initClient();
    }

    protected function initClient()
    {
        $this->client = new MailChimp(
            $this->apiKey,
            $this->endpoint
        );
    }

    public function prepareTotalCount()
    {
        return ArrayHelper::getValue($this->apiResponse, 'total_items');
    }

    public function prepareModels()
    {
        $this->apiResponse = $this->client->get($this->path);

        return ArrayHelper::getValue($this->apiResponse, $this->entity);
    }

    public function prepareKeys($models)
    {
        return array_keys($this->apiResponse[$this->entity]);
    }
}

