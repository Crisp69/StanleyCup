

function openWin(what,name,h,w) {
	new_window=window.open(what, name ,"toolbar=0, status=0, width="+w+", height="+h+", resizable=1, scrollbars=1") }




function windowOpener() {
   msgWindow=window.open("","displayWindow","menubar=yes")
   msgWindow.document.write
      ("<HEAD><TITLE>Message window</TITLE></HEAD>")
   msgWindow.document.write
      ("<CENTER><BIG><B>Hello, world!</B></BIG></CENTER>")
}

function clearSearchBar(obj) {
 if (obj.style.color = 'red') {
   obj.value = '';
   obj.style.color = 'silver';
 }
}

