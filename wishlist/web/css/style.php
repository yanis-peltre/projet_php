/*  COULEURS
	ROUGE : #FF4655
	NOIR : #111111
	BLANC : #ECE9E3
  	GRIS : #D3CDC3
*/

@font-face {
	font-family: "Oswald";
	src: url(../polices/Oswald.ttf);
}

@font-face {
	font-family: "josefin sans";
	src: url(../polices/josefinsans.ttf);
}

div{
	width:600px;
	height:50px;
	background-color:#00CCFF;
	text-align:center;
}

html { 
	scroll-behavior: smooth;
}

a {
	color: #111111;
	text-decoration: none;
}

body {
	margin: 0;
	background-color: #ECE9E3;
}

img {
	width: 80%;
	grid-column-start: 1;
  	grid-column-end: 2;
	grid-row-start: 1;
  	grid-row-end: 2;
}

li {
	list-style: none;
	font-family: "josefin sans";
}

li{
	color: #FF4655;
	transition: color 300ms;
	padding: 10px;
	font-family: "josefin sans";
}

p {
	grid-column-start: 1;
	grid-column-end: 3;
	grid-row-start: 2;
	grid-row-end: 3;
	font-size: 1em;
	text-align: justify;
	font-family: "josefin sans";
}

@media screen and (max-width: 1200px) and (min-width: 600px) {
	section {
		display: grid;
		grid-template-columns: 0.5fr 1fr 1fr;
		grid-template-rows: 0.3fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr;
		grid-gap: 1em;
	}
	
	aside {
		grid-column-start: 1;
		grid-column-end: 2;
		grid-row-start: 2;
		grid-row-end: 7;
	}
	
	h2 {
		background-color: #ECE9E3;
		color: #111111;
		font-size: 2rem;
		margin-left: 2%;
		font-family: "Oswald", sans-serif;
		margin-bottom: 0;
		grid-column-start: 1;
		grid-column-end: 4;
		grid-row-start: 1;
		grid-row-end: 2;
	}
}


@media screen and (max-width: 600px) {
	section {
		display: grid;
		grid-template-columns: 0.3fr 1fr;
		grid-template-rows: 0.2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
		grid-gap: 1em;
	}
	
	aside {
		grid-column-start: 1;
		grid-column-end: 2;
		grid-row-start: 2;
		grid-row-end: 11;
	}
	
	h2 {
		background-color: #ECE9E3;
		color: #111111;
		font-size: 1.5em;
		margin-left: 2%;
		font-family: "Oswald", sans-serif;
		margin-bottom: 0;
		grid-column-start: 1;
		grid-column-end: 3;
		grid-row-start: 1;
		grid-row-end: 2;
	}
}

@media handheld and (max-width: 500px) {
	section {
		display: grid;
		grid-template-columns: 0.3fr 1fr;
		grid-template-rows: 0.3fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
		grid-gap: 5%;
	}
	
	aside {
		grid-column-start: 1;
		grid-column-end: 2;
		grid-row-start: 2;
		grid-row-end: 11;
	}
	
	h1 {
		font-size: 4em;
	}
	
	h2 {
		background-color: #ECE9E3;
		color: #111111;
		font-size: 1.5em;
		margin-left: 2%;
		font-family: "Oswald", sans-serif;
		margin-bottom: 0;
		grid-column-start: 1;
		grid-column-end: 3;
		grid-row-start: 1;
		grid-row-end: 2;
	}
	
	h3 {
		font-size: 2.5em;
	}
	
	p {
		font-size: 2em;
	}
	
	a {
		margin: 1em;
	}

	a + section {
		display: block;
  	}

  	aside {
  		max-width: 100vw;
  	}
}