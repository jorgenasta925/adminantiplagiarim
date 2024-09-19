<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/tabs/Tabs.php');
require_once($CFG->dirroot . '/local/adminantiplagiarim/classes/tabs/TabManager.php');
require_once(__DIR__ . '/lib/usersValidations.php');

$PAGE->requires->css(new moodle_url('./css/formUpdate.css'));
$PAGE->requires->js(new moodle_url('./js/script.js'));

checkSession('redirect', ['https://zajuna.sena.edu.co/']);

checkUserRole('redirect', ['https://zajuna.sena.edu.co/']);

use local_adminantiplag\tabs\TabManager;
      
  // Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_value_local = isset($_POST['threshold_local']) ? floatval($_POST['threshold_local']) : null;
    $selected_value_local2 = isset($_POST['threshold_local2']) ? floatval($_POST['threshold_local2']) : null;
    //$selected_value_local = isset($_POST['threshold_local']) ? $_POST['threshold_local'] : null;
    //$selected_value_local2 = isset($_POST['threshold_local2']) ? $_POST['threshold_local2'] : null;
    $url_internet = isset($_POST['url']) ? $_POST['url'] : null;
    $url_internet2 = isset($_POST['url2']) ? $_POST['url2'] : null;
  
    try {
        if (isset($_POST['save_local']) && $selected_value_local !== null) {
            // Convertir el valor a JSON para el perfil local
            $json_value_local = json_encode(['threshold' => $selected_value_local]);
            echo 'JSON Value Local: ' . $json_value_local;

            // Obtener el estado del checkbox
            $checkbox_state = isset($_POST['my_checkbox']) ? 1 : 0;

            // Preparar y ejecutar la consulta para guardar en la base de datos
            $record_local = new stdClass();
            $record_local->configuration = $json_value_local;
            $record_local->name = "perfil 1";
            $record_local->state = $checkbox_state;
            $record_local->description = "En este perfil se hace una busqueda de plagio entre archivos locales";
            $record_local->id = 1; // ID del perfil local en la base de datos
            $result_local = $DB->update_record('local_adminantiplag_perfiles', $record_local);

            if ($result_local) {
                echo '<div class="alert alert-success">El umbral del perfil 1 local ha sido guardado exitosamente.</div>';
            } else {
                echo '<div class="alert alert-danger">Error al guardar el umbral del perfil 1 local. Verifica la conexión a la base de datos o el ID del registro.</div>';
            }
        } elseif (isset($_POST['save_local2']) && $selected_value_local2 !== null) {
            // Convertir la URL a JSON para el perfil de Internet
            $json_value_local2 = json_encode(['threshold' => $selected_value_local2]);

            // Obtener el estado del checkbox
            $checkbox_state = isset($_POST['my_checkbox2']) ? 1 : 0;

            // Preparar y ejecutar la consulta para guardar en la base de datos
            $record_local2 = new stdClass();
            $record_local2->configuration = $json_value_local2;
            $record_local2->name = "perfil 2";
            $record_local2->state = $checkbox_state ;
            $record_local2->description = "En este perfil se hace una busqueda de plagio entre archivos locales";
            $record_local2->id = 2; // ID del perfil2  local en la base de datos

            $result_local2 = $DB->update_record('local_adminantiplag_perfiles', $record_local2);

            if ($result_local2) {
                echo '<div class="alert alert-success">El umbral del perfil 2 local ha sido guardado exitosamente.</div>';
            } else {
                echo '<div class="alert alert-danger">Error al guardar El umbral del perfil 2 local. Verifica la conexión a la base de datos o el ID del registro.</div>';
            }
        
        } elseif (isset($_POST['save_internet']) && $url_internet !== null) {
            // Convertir la URL a JSON para el perfil de Internet
            $json_value_internet = json_encode(['url' => $url_internet]);

             // Obtener el estado del checkbox
             $checkbox_state = isset($_POST['my_checkbox3']) ? 1 : 0;

            // Preparar y ejecutar la consulta para guardar en la base de datos
            $record_internet = new stdClass();
            $record_internet->configuration = $json_value_internet;
            $record_internet->name = "perfil 3";
            $record_internet->state = $checkbox_state ;
            $record_internet->description = "En este perfil se hace la busqueda de plagio de cada archivo directamente a internet";
            $record_internet->id = 3; // ID del perfil de Internet en la base de datos

            $result_internet = $DB->update_record('local_adminantiplag_perfiles', $record_internet);

            if ($result_internet) {
                echo '<div class="alert alert-success">La URL del perfil de Internet ha sido guardada exitosamente.</div>';
            } else {
                echo '<div class="alert alert-danger">Error al guardar la URL del perfil de Internet. Verifica la conexión a la base de datos o el ID del registro.</div>';
            }
        
        }  elseif (isset($_POST['save_internet2']) && $url_internet2 !== null) {
            // Convertir la URL a JSON para el perfil de Internet
            $json_value_internet2 = json_encode(['url' => $url_internet2]);

             // Obtener el estado del checkbox
             $checkbox_state = isset($_POST['my_checkbox4']) ? 1 : 0;

            // Preparar y ejecutar la consulta para guardar en la base de datos
            $record_internet2 = new stdClass();
            $record_internet2->configuration = $json_value_internet2;
            $record_internet2->name = "perfil 4";
            $record_internet2->state = $checkbox_state ;
            $record_internet2->description = "En este perfil se hace la busqueda de plagio de cada archivo directamente a internet";
            $record_internet2->id = 4; // ID del perfil de Internet en la base de datos

            $result_internet2 = $DB->update_record('local_adminantiplag_perfiles', $record_internet2);

            if ($result_internet2) {
                echo '<div class="alert alert-success">La URL del perfil de Internet ha sido guardada exitosamente.</div>';
            } else {
                echo '<div class="alert alert-danger">Error al guardar la URL del perfil de Internet. Verifica la conexión a la base de datos o el ID del registro.</div>';
            }
        
        
          }  else {
            echo '<div class="alert alert-danger">Por favor completa todos los campos necesarios.</div>';
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }


}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_internet5'])) {
    $url_internet5 = isset($_POST['url5']) ? $_POST['url5'] : null;

    if ($url_internet5 !== null) {
        $json_value_internet5 = json_encode(['url' => $url_internet5]);
        $checkbox_state = isset($_POST['my_checkbox5']) ? 1 : 0;

        $record_internet5 = new stdClass();
        $record_internet5->configuration = $json_value_internet5;
        $record_internet5->name = "perfil 5";
        $record_internet5->state = $checkbox_state;
        $record_internet5->description = "En este perfil se hace la búsqueda de plagio directamente en internet";
        $record_internet5->id = 5;

        $result_internet5 = $DB->update_record('local_adminantiplag_perfiles', $record_internet5);

        if ($result_internet5) {
            echo '<div class="alert alert-success">La URL del perfil 5 ha sido guardada exitosamente.</div>';
        } else {
            echo '<div class="alert alert-danger">Error al guardar la URL del perfil 5. Verifica la conexión a la base de datos o el ID del registro.</div>';
        }
    }
}

  
$url = new moodle_url('/local/adminantiplagiarim/index.php');
$tabManager = new TabManager($url);

$tabManager->addTab(1, 'Perfil local');
$tabManager->addTab(2, 'Perfil internet');

echo $OUTPUT->header();
echo '<h1 class="text-center font-weight-bold">Administración Módulo Antiplagio</h1><br><br>';

$tabManager->displayTabs();
echo $OUTPUT->footer();


