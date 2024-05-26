<?php

namespace sistema\Controlador\Admin;

/**
 * Classe AdminDashboard
 *
 * @author Breno Mariano
 */
class AdminDashboard extends AdminControlador
{
    public function dashboard():void
    {
        echo $this->template->renderizar('dashboard.html', []);
    }
}
