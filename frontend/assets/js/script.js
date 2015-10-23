var app = angular.module("MyFirseModule",[]);
app.controller("FirseController",function ($scope,$http) {
	$scope.valor = function () {
		if ($scope.numero == '') {
			$scope.numero = 0;
		};

	}
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
    dias = fecha == undefined ? dias : dias + 1;
    fecha = fecha == undefined ? new Date() : new Date(fecha);
    fecha.setTime(fecha.getTime()+parseInt(dias*24*60*60*1000));
    return fecha.getFullYear() + "-" + (fecha.getMonth() < 10 ? '0' : '') + (fecha.getMonth()) + "-" + (fecha.getDate() < 10 ? '0' : '') + (fecha.getDate());
}