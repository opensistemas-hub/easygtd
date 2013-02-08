/*
*Add new attachment fields
*/
  var upload_number = 2;
  function addFileInput(accepted, msg, moreUploads_div) {
  
 	 if(upload_number > 5) {
 	  // DO NOTHING               
 	 } else {
 	  var d = document.createElement("div");
 	  var file = document.createElement("input");
 	  file.setAttribute("type", "file");
 	  file.setAttribute("name", "attach_" + upload_number + "[file]");
          if (accepted.length > 0) {
   	    file.setAttribute("class","{required:false,accept: '" + accepted +"',messages:{accept: '" + msg + "'}}");
          } else {
            file.setAttribute("class","{required:false,accept:'docx|txt|pdf|html|png|jpeg|jpg|gif|doc|xml|ics|odt|rtf|ods|ots|xls|csv|sql|yml',messages:{accept:'*'}}");
          }
 	  d.appendChild(file);
 	  document.getElementById(moreUploads_div).appendChild(d);
 	  upload_number++;
  
	 if(upload_number > 5) {
             jq('#moreLink').hide();     
 	 }
 	  //modica el fancybox en caso de que exista para que crezca cuando se le agrege un nuevo att 
          jq.fancybox.resize()
  }
  }
  
  function addTextInput() {
 	
 	  var d = document.createElement("div");
 	  var file = document.createElement("input");
 	  file.setAttribute("type", "text");
 	  file.setAttribute("name", "text_"+upload_number);
 	  d.appendChild(file);
 	  document.getElementById("moreTextFields").appendChild(d);
 	   
  }

function setBlock() {
   document.getElementById('moreLink').style.display = 'block';
  }
  
function setBlockText() {
   document.getElementById('moreLinkText').style.display = 'block';
  }  


   
//add attachments fields

