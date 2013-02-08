/*el template no se modifica automaticamente, asi que se usa jquery para modificar a los tamaños necesarios*/
function modificaAlto_depreaced(alternativeDiv) {
  
  if (alternativeDiv) {
   
    var alturaContenido = jq('.'+alternativeDiv).height();
    
  
  } else {
  
    var alturaContenido = jq('.content-with-shade').height();
  
  }
  


  var alturaBarraIzquierda = jq('#app-middle-top-left').height();
  var x = jq('#app-bottom').offset();
 
  var pixelAltura = 300;
 
  jq('#app-middle-top-left').height((alturaContenido+pixelAltura)+'px');
  jq('#app-middle-top-right').height((alturaContenido+pixelAltura)+'px');
  jq('#app-middle-top-center').height((alturaContenido+pixelAltura)+'px');
  jq('#app-bottom').css({'margin-top':(jq('#app-middle-top-center').height()-915)+'px'});

  

}




