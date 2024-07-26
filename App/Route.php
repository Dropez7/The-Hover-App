<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

    protected function initRoutes() {

        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );

        $routes['inscreverse'] = array(
            'route' => '/inscreverse',
            'controller' => 'IndexController',
            'action' => 'inscreverse'
        );

		$routes['registrar'] = array(
            'route' => '/registrar',
            'controller' => 'IndexController',
            'action' => 'registrar'
        );

        $routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'AuthController',
            'action' => 'autenticar'
        );

        $routes['timeline'] = array(
            'route' => '/timeline',
            'controller' => 'AppController',
            'action' => 'timeline'
        );

        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );

        $routes['tweet'] = array(
            'route' => '/tweet',
            'controller' => 'AppController',
            'action' => 'tweet'
        );

        $routes['quemseguir'] = array(
            'route' => '/quemseguir',
            'controller' => 'AppController',
            'action' => 'quemseguir'
        );

        $routes['acao'] = array(
            'route' => '/acao',
            'controller' => 'AppController',
            'action' => 'acao'
        );

        
        $routes['removertweet'] = array(
            'route' => '/removertweet',
            'controller' => 'AppController',
            'action' => 'removertweet'
        );

        $routes['perfilPrincipal'] = array(
            'route' => '/perfilPrincipal',
            'controller' => 'AppController',
            'action' => 'perfilPrincipal'
        );
        
        $routes['mudarTopo'] = array(
            'route' => '/mudarTopo',
            'controller' => 'AppController',
            'action' => 'mudarTopo'
        );

        $routes['atualizar_nome'] = array(
            'route' => '/atualizar_nome',
            'controller' => 'AppController',
            'action' => 'atualizar_nome'
        );

        
        $routes['pesquisaHovers'] = array(
            'route' => '/pesquisaHovers',
            'controller' => 'AppController',
            'action' => 'pesquisaHovers'
        );




        $this->setRoutes($routes);
    }

}
?>
