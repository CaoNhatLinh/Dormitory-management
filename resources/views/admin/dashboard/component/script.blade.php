 <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('js/inspinia.js')}}"></script>

    <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    @foreach($config['js'] as $key => $value) 
    
      <script src="{{asset($value)}}"></script>
    
    @endforeach 

 
    @foreach($config['linkjs'] as $key => $value) 
      
    <script src={{$value}}></script>
  
  @endforeach 
  <?php

      foreach($config['script'] as $key => $value) 
      echo  "<script> $value  </script>"
  ?>
 
