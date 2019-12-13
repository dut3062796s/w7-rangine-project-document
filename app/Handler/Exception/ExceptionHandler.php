<?php

namespace W7\App\Handler\Exception;

use Psr\Http\Message\ResponseInterface;
use W7\App;
use W7\Core\Exception\ResponseExceptionAbstract;
use W7\Core\Exception\RouteNotAllowException;
use W7\Core\Exception\RouteNotFoundException;
use W7\Core\Exception\ValidatorException;
use W7\Core\View\View;
use W7\Core\Exception\Handler\ExceptionHandler as ExceptionHandlerAbstract;

class ExceptionHandler extends ExceptionHandlerAbstract {
	public function handle(ResponseExceptionAbstract $e) : ResponseInterface {
		if ($e instanceof RouteNotFoundException || $e instanceof RouteNotAllowException) {
			$route = icontext()->getRequest()->getUri()->getPath();
			if ($route != '/admin/login' && substr($route, 0, 6) == '/admin') {
				if (!icontext()->getRequest()->session) {
					return icontext()->getResponse()->redirect('/admin/login');
				}
			}
			return App::getApp()->getContext()->getResponse()->html(iloader()->singleton(View::class)->render('@public/index'));
		}

		if ($e instanceof ValidatorException) {
			return (new App\Exception\ErrorHttpException($e->getMessage(), [], $e->getCode()))->render();
		}
		return parent::handle($e);
	}
}