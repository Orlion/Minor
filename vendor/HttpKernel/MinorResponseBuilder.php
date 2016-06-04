<?php

namespace Minor\HttpKernel;

class MinorResponseBuilder
{
	public static function buildMinorResponse()
	{
		$minorResponse =  MinorResponse::getInstance();

		return $minorResponse;
	}
}