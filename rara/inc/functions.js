function wechsle_art () {
	/*
  if (document.Searchform.list[0].checked == true) {
    var deaktiviert = false;
  } else {
    var deaktiviert = true;
  }
  for (var i = 0; i < document.Searchform.listitem[].length; i++) {
    document.Searchform.listitem[i].disabled = deaktiviert;
  }
	*/
	for (var i = 0; i < document.Searchform.listitem.length; i++){
		document.Searchform.listitem[i].disabled = false;
	}
}
