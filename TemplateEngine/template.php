<?php 
  class Template {
    private $vars = array();
    
    public function assign($key, $value){
      $this->vars[$key] = $value;
    }
    
    public function render($template_name){
      $path = $template_name . '.html';
      
      if(file_exists($path)){
        $contents = file_get_contents($path);
        //we search for the key surrounded with brackets and replace it with value
        foreach($this->vars as $key => $value){
          $contents = preg_replace('/\['.$key.'\]/',$value,$contents);
        }
        //these statements search for if/else html comments and replace them with php if/else
        $contents = preg_replace('/\<\!\-\- if (.*) \-\-\>/', '<?php if ($1) : ?>', $contents);
        $contents = preg_replace('/\<\!\-\- else \-\-\>/', '<?php else : ?>', $contents);
        $contents = preg_replace('/\<\!\-\- endif \-\-\>/', '<?php endif; ?>', $contents);
        //eval will allow use to use php code, echo will not
        eval(' ?>'.$contents.'<?php ');
      } else {
        exit('<h1>Template error!</h1>');
      }
    }
  
  }
?>