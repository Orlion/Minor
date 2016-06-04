<?php

namespace Minor\HttpKernel;

use Minor\Framework\Context;

class MinorRequestBuilder
{
    public static function buildMinorRequest()
    {

        $minorRequest = MinorRequest::getInstance();

        $minorRequest->setUrl(self::getUrl());

        $minorRequest->setMethod(self::getMethod());

        $minorRequest->setParams(self::getParams());

        $minorRequest->setMinorCookie(self::getMinorCookie());

        $appConfig = Context::getConfig()->getApp();
        !empty($appConfig['SESSION_START']) && $minorRequest->setMinorSession(self::getMinorSession());

        return $minorRequest;
    }

    private static function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    private static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function getMinorCookie()
    {
        return MinorCookie::getInstance();
    }

    private static function getMinorSession()
    {
        return MinorSession::getInstance();
    }

    private static function getParams()
    {
        return array_merge($_GET , $_POST);
    }
}