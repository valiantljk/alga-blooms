function initArray() {
 this.length = initArray.arguments.length
 for (var i = 0; i < this.length; i++)
 this[i+1] = initArray.arguments[i]
}
function modDate() {
var MOYArray = new initArray("Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec");
var LastModDate = new Date(document.lastModified);
yr=1900;
var y = LastModDate.getYear();
if (y < 97)     theModDate="";
else {
 if (y >= 97 && y <= 99 || (y > 104 && y < 2000)) {y = 1900 + y}
 var theModDate=MOYArray[(LastModDate.getMonth()+1)]+" "+LastModDate.getDate()+", "+ y;
}
return theModDate;
}

function printYear() {
	var now_year = new Date();
	var y = now_year.getYear();
	if (y >= 97 && y <= 99 || (y > 104 && y < 2000)) {y = 1900 + y}
	return y;
}