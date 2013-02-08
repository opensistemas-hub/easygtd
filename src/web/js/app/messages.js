function renderMessages(text,className) {

//case className error
//case className success
//case className warning
//El div es el messages

  switch (className) {
    case 'error':   
      jq.jnotify(text, 'error');
      break;  
    case 'warning':   
      jq.jnotify(text, 'warning');
      break;  
    case 'success': 
      jq.jnotify(text, 3000);
      break;  
  }

}
