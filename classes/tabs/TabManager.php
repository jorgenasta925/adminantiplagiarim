<?php

namespace local_adminantiplag\tabs;

class TabManager {
    private $tabs = [];
    private $activeTab;
    private $url;

    public function __construct($url) {
        $this->url = $url;
        $this->activeTab = isset($_GET['tab']) ? intval($_GET['tab']) : 1;
    }

    public function addTab($id, $title) {
        $this->tabs[$id] = $title;
    }

    public function displayTabs() {
        echo '<ul class="nav nav-tabs">';
        foreach ($this->tabs as $id => $title) {
            $activeClass = ($this->activeTab == $id) ? 'active' : '';
            echo '<li class="nav-item">';
            echo '<a class="nav-link ' . $activeClass . '" href="' . $this->url . '?tab=' . $id . '">' . $title . '</a>';
            echo '</li>';
        }
        echo '</ul>';
        $this->displayTabContent();
    }

    private function displayTabContent() {
        switch ($this->activeTab) {
            case 1:
                $this->displayPerfilLocal();
                break;
            case 2:
                $this->displayPerfilInternet();
                break;
            default:
                echo '<div class="alert alert-danger">Pestaña no válida seleccionada.</div>';
                break;
        }
    }
    

    private function displayPerfilLocal() {
        global $DB;
    
        // Recuperar el valor guardado del perfil 1
        $record_local = $DB->get_record('local_adminantiplag_perfiles', ['id' => 1]);
        $umbralGuardado = 0.1; // Valor por defecto
        $estadoGuardado = $DB->get_field('local_adminantiplag_perfiles', 'state', ['id' => 1]);
    
        if ($record_local) {
            $config_local = json_decode($record_local->configuration);
            if (isset($config_local->threshold)) {
                $umbralGuardado = $config_local->threshold;
            }
        }

         // Recuperar el valor guardado del perfil 2
    $record_local2 = $DB->get_record('local_adminantiplag_perfiles', ['id' => 2]);
    $umbralGuardado2 = 0.1; // Valor por defecto para Perfil 2
    $estadoGuardado2 = $DB->get_field('local_adminantiplag_perfiles', 'state', ['id' => 2]);

    if ($record_local2) {
        $config_local2 = json_decode($record_local2->configuration);
        if (isset($config_local2->threshold)) {
            $umbralGuardado2 = $config_local2->threshold;
        }
    }


        echo '<div class="tab-content"><br><br>';
        echo '<form method="POST">';
        echo '<label for="threshold_local" class="d-inline font-weight-bold">Perfil 1</label><br><br>';

        echo '<input type="checkbox" name="my_checkbox" id="my_checkbox" value="1" ' . ($estadoGuardado == 1 ? 'checked' : '') . '>';
        echo '<label for="my_checkbox" class="ml-2">Habilitar/Deshabilitar</label><br>';

        echo '<label for="threshold_local" class="mr-2">Seleccione Umbral de Similitud:</label>';
        echo '<input type="number" name=threshold_local id=threshold_local min=0.1 max=1 step=0.1 value="' .$umbralGuardado . '" required style="margin-right: 10px;">';
        echo '<button type="submit" class="btn btn-primary mr-1" name="save_local">Guardar</button>';
        echo '</form>';
        echo '<label  class="d-inline font-weight-bold">Umbral de Similitud Actual =' .$umbralGuardado . ' </label>';
        echo '</div><br><br>';

        
        echo '<div class="tab-content"><br>';
        echo '<form method="POST">';
        echo '<label for="threshold_local2" class="d-inline font-weight-bold">Perfil 2</label><br><br>';

        echo '<input type="checkbox" name="my_checkbox2" id="my_checkbox2" value="1" ' . ($estadoGuardado2 == 1 ? 'checked' : '') . '>';
        echo '<label for="my_checkbox" class="ml-2">Habilitar/Desabilitar</label><br>';

        echo '<label for="threshold_local2" class="mr-2">Seleccione Umbral de Similitud:</label>';
        echo '<input type="number" name="threshold_local2" id="threshold_local" min= 0.1 max= 1 step= 0.1 value="' .$umbralGuardado2 . '" required style="margin-right: 10px;">';
        echo '<button type="submit" class="btn btn-primary mr-1" name="save_local2">Guardar</button>';
        echo '</form>';
        echo '<label  class="d-inline font-weight-bold">Umbral de Similitud Actual =' .$umbralGuardado2 . ' </label>';
        echo '</div>';
    }
    
    private function displayPerfilInternet() {

        global $DB;

        // Recuperar el valor guardado del perfil 3
        $record_internet = $DB->get_record('local_adminantiplag_perfiles', ['id' => 3]);
        $urlguardada = ""; // Valor por defecto para Perfil 3
        $estadoGuardado3 = $DB->get_field('local_adminantiplag_perfiles', 'state', ['id' => 3]);
    
        if ($record_internet) {
            $config_local3 = json_decode($record_internet->configuration);
            if (isset($config_local3->url)) {
                $urlguardada = $config_local3->url;
            }
        }  

         // Recuperar el valor guardado del perfil 4
         $record_internet2 = $DB->get_record('local_adminantiplag_perfiles', ['id' => 4]);
         $urlguardada2 = ""; // Valor por defecto para Perfil 4
         $estadoGuardado4 = $DB->get_field('local_adminantiplag_perfiles', 'state', ['id' => 4]);
     
         if ($record_internet2) {
             $config_local4 = json_decode($record_internet2->configuration);
             if (isset($config_local4->url)) {
                 $urlguardada2 = $config_local4->url;
             }
         } 

    

        echo '<div class="tab-content"><br><br>';
        echo '<form method="POST">';
        echo '<h2 class="d-inline font-weight-bold">Perfil 3</h2><br><br>';

        echo '<input type="checkbox" name="my_checkbox3" id="my_checkbox3" value="1" ' . ($estadoGuardado3 == 1 ? 'checked' : '') . '>';
        echo '<label for="my_checkbox" class="ml-2">Habilitar/Desabilitar</label><br>';

        echo '<label for="url" class="mr-2">Agregar URL:</label>';
        echo '<input type="text" name="url" id="url" required style="margin-right: 10px;" >';
        echo '<button type="submit" class="btn btn-primary mr-1" name="save_internet">Guardar</button>';
        echo '</form><br>';
        echo '<label  class="d-inline font-weight-bold"> URL Actual = ' .$urlguardada . ' </label>';
        echo '</div><br><br>';

        echo '<div class="tab-content"><br>';
        echo '<form method="POST">';
        echo '<h2 class="d-inline font-weight-bold">Perfil 4</h2><br><br>';

        echo '<input type="checkbox" name="my_checkbox4" id="my_checkbox4" value="1" ' . ($estadoGuardado4 == 1 ? 'checked' : '') . '>';
        echo '<label for="my_checkbox" class="ml-2">Habilitar/Desabilitar</label><br>';

        echo '<label for="url2" class="mr-2">Agregar URL:</label>';
        echo '<input type="text" name="url2" id="url" required style="margin-right: 10px;" >';
        echo '<button type="submit" class="btn btn-primary mr-1" name="save_internet2">Guardar</button>';
        echo '</form><br>';
        echo '<label  class="d-inline font-weight-bold"> URL Actual = ' .$urlguardada2 . ' </label>';
        echo '</div><br><br>';

    
      // Recuperar el valor guardado del perfil 4
      $record_internet5 = $DB->get_record('local_adminantiplag_perfiles', ['id' => 5]);
      $urlguardada2 = ""; // Valor por defecto para Perfil 5
      $estadoGuardado5 = $DB->get_field('local_adminantiplag_perfiles', 'state', ['id' => 5]);
  
      if ($record_internet5) {
          $config_local5 = json_decode($record_internet5->configuration);
          if (isset($config_local5->url)) {
              $urlguardada3 = $config_local5->url;
          }
      }
        echo '<form method="POST">';
        echo '<div class="text-right">';
        echo '<button type="submit" class="btn btn-primary mr-1" name="add_profile">Modificar Perfil</button>';
        echo '</div>';
        echo '</form><br>';

        echo '<h2 class="d-inline font-weight-bold">Perfil 5</h2><br><br>';
        
        echo '<input type="checkbox" name="my_checkbox4" id="my_checkbox4" value="1" ' . ($estadoGuardado5 == 1 ? 'checked' : '') . '>';
        echo '<label for="my_checkbox" class="ml-2">Habilitado/Desabilitado</label><br>';
        echo '<label  class="d-inline font-weight-bold"> URL Actual = ' .$urlguardada3 . ' </label><br><br>';


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_profile'])) {
            // Generar y mostrar el HTML del perfil 5
            echo '<div class="tab-content"><br>';
            echo '<form method="POST">';
            echo '<h2 class="d-inline font-weight-bold">Perfil</h2><br><br>';
        
            echo '<input type="checkbox" name="my_checkbox5" id="my_checkbox5" value="1">';
            echo '<label for="my_checkbox5" class="ml-2">Habilitar/Deshabilitar</label><br>';
        
            echo '<label for="url5" class="mr-2">Agregar URL:</label>';
            echo '<input type="text" name="url5" id="url5" required style="margin-right: 10px;">';
            echo '<button type="submit" class="btn btn-primary mr-1" name="save_internet5">Guardar</button>';
            echo '</form><br>';
            //echo '<label class="d-inline font-weight-bold"> URL Actual = </label>';
            echo '</div>';
        }
        

    }
   
}


