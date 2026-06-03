if (window.location.hostname === 'grupoeuroandino.com') {
	window.lugarApi = 'https://grupoeuroandino.com/app/api/'
}else{
	window.lugarApi = 'http://localhost/appTours/api/'
}
console.log('servir en '+window.lugarApi);
