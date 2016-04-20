<?php if ( ! $is_compact) {
  echo VP_View::instance()
              ->load('control/template_control_head', $head_info);
} ?>
<input <?php echo "data-vp-opt='" . $opt . "'"; ?> type="text"
                                                   name="<?php echo $name ?>"
                                                   class="vp-input vp-js-datepicker"/>
<?php
  $input_name = str_replace("[","_",$name);
  $script = '';
  $script .= '<script>';
  $script .= 'var vpJsDatepicker = "' . str_replace("]","",$input_name).'"';
  $script .= '</script>';
  echo $script;
?>
<?php if ( ! $is_compact) {
  echo VP_View::instance()
              ->load('control/template_control_foot');
} ?>
