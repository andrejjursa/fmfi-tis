<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Config editing handler model.
 * 
 * @author Andrej Jursa
 * @version 1.0
 * @package AppModels
 */
class Configurator extends CI_Model {
    
    /**
     * Returns configuration array for given config file.
     * 
     * @param string $config name of config file without extension.
     * @return array<mixed> values of config file.
     */
    public function getConfigArray($config) {
        if (file_exists(APPPATH . 'config/' . $config . '.php')) {
            $this->config->load($config, TRUE);
            return $this->config->config[$config];    
        }
        return NULL;
    }
    
    /**
     * Saves new data array to given config file.
     * 
     * @param string $config name of config file without extension.
     * @param array<mixed> $data new values for config items.
     * @return boolean returns TRUE if file is writen, FALSE otherwise.
     */
    public function setConfigArray($config, $data) {
        $file = APPPATH . 'config/' . $config . '.php';
        if (file_exists($file)) {
            $this->config->load($config, TRUE);
            $this->config->config[$config] = $this->mergeArray($this->config->config[$config], $data);
            
            $tokens = $this->getConfigFileTokens($file);
            if (is_null($tokens)) { return FALSE; }
            $arangement = $this->getConfigFileArangementFromTokens($tokens);
            
            try {
                $content = $this->makeConfigFileContent($this->config->config[$config], $arangement);
                $f = fopen($file, 'w');
                fputs($f, $content);
                fclose($f);
                return TRUE;
            } catch (exception $e) {
                return FALSE;
            }
        }
        return FALSE;
    }   
    
    /**
     * Recursively merge two arrays.
     * 
     * @param array<mixed> $array1 first array.
     * @param array<mixed> $array2 second array.
     * @return array<mixed> merged array.
     */
    public function mergeArray($array1, $array2) {
        $output = array();
        if (count($array1)) {
            foreach($array1 as $key => $value) {
                if (isset($array2[$key])) {
                    if (is_array($value) && is_array($array2[$key])) {
                        $output[$key] = $this->mergeArray($value, $array2[$key]);
                    } else {
                        $output[$key] = $array2[$key];
                    }
                } else {
                    $output[$key] = $value;
                }
            }
        }
        if (count($array2)) {
            foreach($array2 as $key => $value) {
                if (!isset($output[$key])) {
                    $output[$key] = $value;
                }
            }
        }
        return $output;
    }
    
    /**
     * For given data and arangement creates content of config file.
     * 
     * @param array<mixed> $data values of config.
     * @param array<mixed> $arangement arangement of config file content.
     * @return string config file content.
     */
    private function makeConfigFileContent($data, $arangement) {
        $content = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');' . "\n\n";
        foreach($arangement as $item) {
            if ($item['type'] == 'comment') {
                $content .= $item['value'] . "\n";
            } elseif ($item['type'] == 'config') {
                $content .= $this->configItemByPath($item['value']) . ' = ' . var_export($this->configItemValueByPath($data, $item['value']), TRUE) . ';' . "\n";
            }
        }
        $content .= "\n\n?>";
        return $content;
    }
    
    /**
     * Returns php parser tokens for given config file.
     * 
     * @param string $file path to config file.
     * @return array<mixed>|NULL array of tokens or NULL if file not found.
     */
    private function getConfigFileTokens($file) {
        if (file_exists($file)) {
            $f = fopen($file, 'r');
            ob_start();
            fpassthru($f);
            $filecontent = ob_get_clean();
            fclose($f);
            
            $tokens = token_get_all($filecontent);
            
            return $tokens;
        } else {
            return NULL;
        }
    }
    
    /**
     * Parses tokens to produce arangement array.
     * 
     * @param array<mixed> $tokens php parser tokens.
     * @return array<mixed> arangement of config file content.
     */
    private function getConfigFileArangementFromTokens($tokens) {
        $arangement = array();
        for($i=0;$i<count($tokens);$i++) {
            $token = $tokens[$i];
            if (is_array($token)) {
                $type = $token[0];
                $value = $token[1];
                if ($type == T_COMMENT || $type == T_DOC_COMMENT) {
                    $arangement[] = array('type' => 'comment', 'value' => trim($value));
                } elseif ($type == T_VARIABLE) {
                    if ($value = '$config') {
                        $path = $this->getConfigVariablePath($tokens, $i);
                        if (count($path)) {
                            $arangement[] = array('type' => 'config', 'value' => $path);
                        }
                    }
                }
            }
        }
        return $arangement;
    }
    
    /**
     * Returns the path of found config variable at given token position in tokens array.
     * 
     * @param array<mixed> $tokens php parser tokens.
     * @param integer $at position where config variable is found.
     * @return array<string> path for array segments.
     */
    private function getConfigVariablePath($tokens, $at) {
        $path = array();
        $pos = $at + 1;
        $good = TRUE;
        while ($good) {
            if ($tokens[$pos] == '[') {
                $pos++;
                if (is_array($tokens[$pos]) && $tokens[$pos][0] == T_CONSTANT_ENCAPSED_STRING) {
                    if ($tokens[$pos+1] == ']') {
                        $path[] = trim($tokens[$pos][1], '\'"');
                        $pos++;
                    } else {
                        $good = FALSE;
                    }
                } else {
                    $good = FALSE;
                }
            } else {
                $good = FALSE;
            }
            $pos++;
        }
        
        return $path;
    }
    
    /**
     * Creates $config variable for config file content.
     * 
     * @param array<string> $path path of array segments.
     * @return string config variable like array.
     */
    private function configItemByPath($path) {
        $output = '$config';
        if (count($path)) {
            foreach($path as $segment) {
                $output .= '[' . var_export($segment, TRUE) . ']';
            }
        }
        return $output;
    }
    
    /**
     * Returns value of config item by path.
     * 
     * @param array<mixed> $data configuration data.
     * @param array<string> $path path of array segments.
     * @return mixed value of config item defined by path.
     */
    private function configItemValueByPath($data, $path) {
        if (count($path) == 1) {
            if (!isset($data[$path[0]])) { throw new exception('NO SUCH PATH IN DATA ARRAY'); }
            return $data[$path[0]];
        } else {
            if (!isset($data[$path[0]])) { throw new exception('NO SUCH PATH IN DATA ARRAY'); }
            $new_path = array();
            for($i=1;$i<count($path);$i++) {
                $new_path[] = $path[$i];
            }
            return $this->configItemValueByPath($data[$path[0]], $new_path);
        }
    }
}
?>