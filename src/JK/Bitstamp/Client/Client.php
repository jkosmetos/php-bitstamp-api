<?php

namespace JK\Bitstamp\Client;


use JK\Bitstamp\Exception\InvalidCurrencyPairException;


/**
 * Class Client
 * @package JK\Bitstamp\Client
 */
class Client extends BaseClient
{

    /**
     * @param string $currencyPair
     * @return array|mixed
     * @throws InvalidCurrencyPairException
     */
    public function getTicker($currencyPair = self::CURRENCY_PAIR_DEFAULT)
    {
        if(!in_array($currencyPair, $this->supportedPairs)) {
            throw new InvalidCurrencyPairException();
        }

        return parent::get("ticker/{$currencyPair}");
    }

    /**
     * @param string $currencyPair
     * @return array|mixed
     * @throws InvalidCurrencyPairException
     */
    public function getHourlyTicker($currencyPair = self::CURRENCY_PAIR_DEFAULT)
    {
        if(!in_array($currencyPair, $this->supportedPairs)) {
            throw new InvalidCurrencyPairException();
        }

        return parent::get("ticker_hour/{$currencyPair}");
    }

    /**
     * @param string $currencyPair
     * @return array|mixed
     * @throws InvalidCurrencyPairException
     */
    public function getOrderBook($currencyPair = self::CURRENCY_PAIR_DEFAULT)
    {
        if(!in_array($currencyPair, $this->supportedPairs)) {
            throw new InvalidCurrencyPairException();
        }

        return parent::get("order_book/{$currencyPair}");
    }

    /**
     * @param string $currencyPair
     * @return array|mixed
     * @throws InvalidCurrencyPairException
     */
    public function getTransactions($currencyPair = self::CURRENCY_PAIR_DEFAULT)
    {
        if(!in_array($currencyPair, $this->supportedPairs)) {
            throw new InvalidCurrencyPairException();
        }

        return parent::get("order_book/{$currencyPair}");
    }

    /**
     * @return array|mixed
     */
    public function getTradingPairsInfo()
    {
        return parent::get("trading-pairs-info");
    }

}