var app = angular.module("MyFirseModule",[]);
app.controller("FirseController",function ($scope,$http) {
	$scope.valor = function () {
		if ($scope.numero == '') {
			$scope.numero = 0;
		};

	};
});
function justNumbers(e) {
	var keynum = window.event ? window.event.keyCode : e.which;
	if ( keynum == 8 ) return true;
	return /\d/.test(String.fromCharCode(keynum));
}
function getkey (event,objeto) {
	if (event.charCode == 0){
		if (event.target == objeto){
			return false;
		};
	};
}

function sumarDias(dias,fecha){
    dias = fecha == undefined ? 0 : dias;
    fecha = fecha == undefined ? new Date() : new Date(fecha);
    var zn = fecha.getTimezoneOffset() * 1000 * 60;
    fecha.setTime(fecha.getTime()+parseInt(dias*24*60*60*1000)+zn);
    return fecha;
}