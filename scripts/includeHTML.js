function includeHTML() {
    var i, file, xhttp;
    elements = document.getElementsByTagName("div");
    for (i = 0; i < elements.length; i++) {
      file = elements[i].getAttribute("include-html");
      if (file) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {elements[i].innerHTML = this.responseText;}
            if (this.status == 404) {elements[i].innerHTML = "Page not found.";}
            elements[i].removeAttribute("include-html");
            includeHTML();
          }
        }
        xhttp.open("GET", file, true);
        xhttp.send();
        return;
      }
    }
  }

includeHTML();