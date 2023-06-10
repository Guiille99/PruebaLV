<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function saberEstadoPedido(){
        return view('support.saberEstadoPedido');
    }
    public function metodosDePagoSupport(){
        return view('support.metodos-pago');
    }
    public function cancelarPedidoSupport(){
        return view('support.cancelar-pedido');
    }
    public function devolverPedidoSupport(){
        return view('support.devolver-pedido');
    }
    public function anadirDireccionEnvioSupport(){
        return view('support.anadir-direccion-envio');
    }
    public function bajaDelNewsletterSupport(){
        return view('support.baja-newsletter');
    }
}
