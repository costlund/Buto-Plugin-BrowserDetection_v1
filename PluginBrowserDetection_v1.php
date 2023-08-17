<?php
class PluginBrowserDetection_v1{
  public $stat = array('os' => array(), 'browser' => array());
  function __construct() {
    wfPlugin::includeonce('wf/yml');
  }
  public function sort(){
    ksort($this->stat['os']);
    ksort($this->stat['browser']);
    return null;
  }
  public function get_browser($HTTP_USER_AGENT, $object = false){
    $data = new PluginWfYml(__DIR__.'/data.yml');
    $data->set('HTTP_USER_AGENT', $HTTP_USER_AGENT);
    /**
     * Browser Find
     */
    foreach ($data->get('browser_find') as $key => $value) {
      foreach ($value['find'] as $str) {
        if(wfPhpfunc::strstr($data->get('HTTP_USER_AGENT'), $str)){
          $data->set("browser_find/$key/success", true);
          break;
        }
      }
    }
    /**
     * OS Find
     */
    foreach ($data->get('os_find') as $key => $value) {
      foreach ($value['find'] as $str) {
        if(wfPhpfunc::strstr($data->get('HTTP_USER_AGENT'), $str)){
          $data->set("os_find/$key/success", true);
          break;
        }
      }
    }
    /**
     * Browser Solve
     */
    foreach ($data->get('browser_solve') as $key => $value) {
      $all_true = true;
      foreach ($value['success'] as $value2) {
        if(!$data->get("browser_find/$value2/success")){
          $all_true = false;
          break;
        }
      }
      if($all_true){
        $data->set('browser_name', $value['name']);
      }
      if($data->get('browser_name')){
        break;
      }
    }
    /**
     * OS Solve
     */
    foreach ($data->get('os_solve') as $key => $value) {
      $all_true = true;
      foreach ($value['success'] as $value2) {
        if(!$data->get("os_find/$value2/success")){
          $all_true = false;
          break;
        }
      }
      if($all_true){
        $data->set('os_name', $value['name']);
      }
      if($data->get('os_name')){
        break;
      }
    }
    /**
     * Stat
     */
    if(!isset($this->stat['os'][$data->get('os_name')])){
      $this->stat['os'][$data->get('os_name')] = 1;
    }else{
      $this->stat['os'][$data->get('os_name')] = $this->stat['os'][$data->get('os_name')]+1;
    }
    if(!isset($this->stat['browser'][$data->get('browser_name')])){
      $this->stat['browser'][$data->get('browser_name')] = 1;
    }else{
      $this->stat['browser'][$data->get('browser_name')] = $this->stat['browser'][$data->get('browser_name')]+1;
    }
    /**
     * 
     */
    if(!$object){
      return $data->get();
    }else{
      return $data;
    }
  }
}
