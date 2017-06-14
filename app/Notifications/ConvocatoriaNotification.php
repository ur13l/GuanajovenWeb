<?php

namespace App\Notifications;

use App\Convocatoria;
use App\DatosUsuario;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use ReflectionProperty;

class ConvocatoriaNotification extends Notification
{
    use Queueable;

    protected $convocatoria;
    protected $datos_usuario;

    public function __construct(Convocatoria $convocatoria, DatosUsuario $datos_usuario)
    {
        $this->convocatoria = $convocatoria;
        $this->datos_usuario = $datos_usuario;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->datos_usuario->getAttributeValue('nombre').'.')
                    ->line('Hemos visto que estas interesado en la convocatoria: '.$this->convocatoria->getAttributeValue('titulo').'.')
                    ->line('Con fechas de: '.$this->convocatoria->getAttributeValue('fecha_inicio').' a '.$this->convocatoria->getAttributeValue('fecha_cierre').'.')
                    ->line('Si estas de acuerdo con ello, favor de oprimir el boton de aceptar, caso contrario has caso omiso a este mensaje.')
            //ingresamos a la url correspondiente con los parametros
                    ->action('Aceptar', url('/api/notificaciones/correoguanajoven/'.$this->datos_usuario->getAttributeValue('curp').'/'.$this->convocatoria->getAttributeValue('titulo')))
                    ->line('Gracias por usar nuestra aplicación!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
