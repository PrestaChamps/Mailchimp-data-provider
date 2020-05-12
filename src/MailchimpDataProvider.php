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
        $this->prepareModels();
    }

    protected function initClient()
    {
        $this->client = new MailChimp(
            $this->apiKey,
            $this->endpoint
        );
    }

    /**
     * Returns the total number of data models.
     * When [[getPagination|pagination]] is false, this is the same as [[getCount|count]].
     * @return int total number of possible data models.
     */
    public function prepareTotalCount()
    {
        return ArrayHelper::getValue($this->client->get($this->path), 'total_items');
    }


    public function prepareModels()
    {
        $pagination = $this->getPagination();

        if ($pagination !== false) {
            $pagination->totalCount = $this->getTotalCount();
            $limit = $pagination->getLimit();
            $page = $pagination->getPage();
        } else {
            $limit = 20;
            $page = 0;
        }

        $this->apiResponse = $this->client->get($this->path, ['count' => $limit, 'offset' => $limit * $page]);

        return ArrayHelper::getValue($this->apiResponse, $this->entity);

    }

    public function prepareKeys($models)
    {
        return ArrayHelper::getColumn($this->apiResponse[$this->entity], 'id');
    }
}

