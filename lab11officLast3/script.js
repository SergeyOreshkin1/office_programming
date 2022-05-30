function show(id) {
	let table = document.getElementById('table');
	table.style.display = "none";

	let diagram = document.getElementById('diagram');
	diagram.style.display = "block";

	let date = new Date(); 
	
	let openImage = document.getElementById('openImage');
	openImage.src= 'diagram.php?numberOtdel=' + id+ "&time=" + date.getTime() / 1000;;
}

function Hide() {
	let diagram = document.getElementById('diagram');
	diagram.style.display = "none";

	let table = document.getElementById('table');
	table.style.display = "block";

}


function rebuild(id) {
	let image = document.getElementById(id);
	let date = new Date(); 
	image.src= 'diagram.php?numberOtdel=' + id + "&time=" + date.getTime() / 1000;
}